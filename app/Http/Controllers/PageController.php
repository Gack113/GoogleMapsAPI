<?php
namespace App\Http\Controllers;
use App\Slide;
use App\Product;
use App\ProductType;
use App\Cart;
use App\Customer;
use App\Bill;
use App\BillDetail;
use App\User;
use App\ProductImage;
use App\ProductView;
use App\Region;
use App\Province;
use App\District;
use App\Marker;
use App\Location;
use App\NewOffer;
use App\NewDetail;
use Hash;
use Auth;
use Session;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        $slide = Slide::all();
        $newprdct = Product::where('new',1)->paginate(6);
        $saleprdct = Product::where('promotion_price','<>',0)->paginate(6);
        return view('page.home',compact('slide','newprdct','saleprdct'));
    }

    public function ProductType(Request $req){
        $prdctType = Product::where('id_type',$req->id)->paginate(6);
        $otherPrdct = Product::where('id_type','<>',$req->id)->paginate(6);
        $listType = ProductType::all();
        $typeName = ProductType::find($req->id);
        return view('page.product_type',compact('prdctType','otherPrdct','listType','typeName'));
    }

    public function preLoadDetail(Request $req){
        $prdct = Product::where('slug',$req->slug)->first();
        if(!$prdct):
            if($has = Product::where('slug','like',$req->slug.'%')->get()->last()):
                return redirect()->route('chi-tiet',$has->slug);
            else:
                return redirect()->route('home');
            endif;
        endif;
        $prdct->view++;
        $prdct->last_visited = now();
        return $this->ProductDetail($prdct->slug);
    }

    public function ProductDetail($slug){
        $prdct = Product::where('slug',$slug)->first();
        $relatePrdct = Product::where('id_type',$prdct->id_type)->paginate(3);
        $highestProducts = Product::orderBy('view', 'desc')
                                    ->take(5)
                                    ->get();
        $prdctImage = ProductImage::where('id_product',$prdct->id)->get();
        return view('page.detail',compact('prdct','prdctImage','relatePrdct','highestProducts'));
    }

    public function Contact(){
        return view('page.contact');
    }

    public function getProvince(Request $req){
        $provinces = Province::where('id_region',$req->id)->get();
        return response()->json(['provinces'=>$provinces]);
    }

    public function getDistrict(Request $req){
        $districts = District::where('id_region',$req->region)->where('id_province',$req->province)->get();
        return response()->json(['districts'=>$districts]);
    }

    public function About(Request $req){
        $regions = Region::all();
        $provinces = Province::where('id_region',$req->region)->get();
        $districts = District::where('id_region',$req->region)->where('id_province',$req->province)->get();
        $markers = Marker::where('id_region',$req->input('region'))
                            ->where('id_province',$req->input('province'))
                            ->where('id_district',$req->input('district'))
                            ->get();
        return view('page.about',compact('regions','provinces','districts','markers','req'));
    }

    public function MenuToday(){
        $newToday = NewOffer::where('date_offer',today())->orderBy('created_at','desc')->first();
        if($newToday){
            $meals = NewDetail::where('id_new',$newToday->id)->limit(4)->get();
            return view('page.today',compact('newToday','meals'));
        }
        return view('page.today');
    }

    public function AddCart(Request $req, $id){
        $prdct = Product::find($id);
        $oldCart = Session('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->add($prdct,$id);
        $req->Session()->put('cart',$cart);
        return redirect()->back();
    }
//Xóa hết sản phẩm
    public function ReduceCart($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->removeItem($id);
        if(count($cart->items) > 0)
            Session::put('cart',$cart);
        else
            Session::forget('cart');
        return redirect()->back();
    }
//Xóa 1 số lượng
    public function ReduceCartByOne($id){
        $oldCart = Session::has('cart')?Session::get('cart'):null;
        $cart = new Cart($oldCart);
        $cart->reduceByOne($id);
        if(count($cart->items) > 0)
            Session::put('cart',$cart);
        else
            Session::forget('cart');
        return redirect()->back();
    }

    public function Order(){
        return view('page.order');
    }

    public function preOrder(Request $req){
        if(Session::has('customer'))
            Session::forget('customer');
        $customer = new Customer;
        $customer->name = $req->name;
        $customer->gender = $req->gender;
        $customer->email = $req->email;
        $customer->address = $req->address;
        $customer->phone_number = $req->phone;
        $customer->lat = $req->lat;
        $customer->lng = $req->lng;
        $customer->note = $req->note;
        Session::put('customer',$customer);
        return view('page.order',compact('customer'));
    }


    public function Checkout(){
        if(!Session::has('cart'))
            return response()->json(['status'=> 0,'message'=>'Đặt hàng thất bại','error'=>'Không có sản phẩm nào trong giỏ hàng']);
        $customer = new Customer;
        $req = request()->all()['data'];
        $customer->name = $req['name'];
        $customer->gender = $req['gender'];
        $customer->email = $req['email'];
        $customer->address = $req['address'];
        $customer->phone_number = $req['phone'];
        $customer->lat = $req['lat'];
        $customer->lng = $req['lng'];
        $customer->note = $req['note'];
        $customer->save();

        $bill = new Bill;
        $bill->id_customer = $customer->id;
        $bill->date_order = date('Y-m-d');
        $bill->total = Session::get('cart')->totalPrice;
        $bill->payment = $req['payment_method'];
        $bill->note = $req['note'];
        
        $markers = Marker::all();
        $min = 99999999;
        $shop = new Marker;
        foreach($markers as $marker){
            $location = new Location;
            $km = $location->Distance($customer->lat,$customer->lng,$marker->lat,$marker->lng);
            if($km < $min){
                $min = $km;
                $bill->id_marker = $marker->id;
                $shop = $marker;
            }
        }
        $bill->save();

        foreach (Session::get('cart')->items as $key => $value) {
            $bill_detail = new BillDetail;
            $bill_detail->id_bill = $bill->id;
            $bill_detail->id_product = $key;
            $bill_detail->quantity = $value['qty'];
            $bill_detail->unit_price = $value['price']/$value['qty'];
            $bill_detail->save();
        }
        Session::forget('cart');
        return response()->json(['status'=> 1,'message'=>'Đặt hàng thành công!','shop'=>$shop]);
    }

    public function Search(Request $req){
        $products = Product::where('name','like','%'.$req->input('tu-khoa').'%')
                            ->orwhere('unit_price',$req->input('tu-khoa'))
                            ->orwhere('promotion_price',$req->input('tu-khoa'))
                            ->orwhere('unit','like',$req->input('tu-khoa'))
                            ->paginate(6);
        return view('page.search',compact('products'));
    }

    public function nearMarker(Request $req){
        $markers = Marker::all();
        $min = 99999999;
        $shop = new Marker;
        foreach($markers as $marker){
            $location = new Location;
            $km = $location->Distance($req->lat,$req->lng,$marker->lat,$marker->lng);
            if($km < $min){
                $min = $km;
                $shop = $marker;
            }
        }
        return response()->json(['status'=>1,'marker'=>$shop]);
    }

    public function findShop(Request $req){
        $region = $req->region;
        $province = $req->province;
        $district = $req->district;
        $marker = NULL;
        if($region != NULL && $province != NULL && $district != NULL)
            $marker = Marker::where('id_region',$region)
                            ->where('id_province',$province)
                            ->where('id_district',$district)
                            ->get();
        elseif($region != NULL && $province != NULL)
            $marker = Marker::where('id_region',$region)
                            ->where('id_province',$province)->get();
        elseif($region != NULL)
            $marker = Marker::where('id_region',$region)->get();
        else
            $marker = Marker::all();
        return response()->json(['shop'=>$marker]);
    }
}
