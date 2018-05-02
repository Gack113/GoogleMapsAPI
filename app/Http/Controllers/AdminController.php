<?php

namespace App\Http\Controllers;
use App\Product;
use App\ProductImage;
use App\ProductView;
use App\ProductType;
use Image;
use Storage;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('admin.dashdoard');
    }

    public function list_product(){
        $product = Product::all();
        return view('admin.products',compact('product'));
    }

    public function add_product(){
        $type = ProductType::all();
        return view('admin.add_product',compact('type'));
    }

    public function add_product_submit(Request $req){
        $this->validate($req,
        [   
            'ten'=>'required',
            'loai'=>'required',
            'gia'=>'required|numeric',
            'giakm'=>'numeric',
            'tinhtrang'=>'required',
            'mota'=>'required',
            'feature_image'=>'required'
        ],
        [
            'ten.required'=>'Vui lòng nhập tên',
            'loai.required'=>'Chọn loại sản phẩm',
            'gia.required'=>'Vui lòng nhập giá',
            'gia.numeric'=>'Giá vui lòng là số',
            'giakm.numeric'=>'Giá khuyến mãi vui lòng là số',
            'tinhtrang.required'=>'Vui lòng nhập tình trạng',
            'mota.required'=>'Chưa nhập mô tả',
            'feature_image.required'=>'Chọn ít nhất 1 hình ảnh'
            
        ]);
        $product = new Product;
        $product->name = $req->ten;
        $product->id_type = $req->tinhtrang;
        $product->unit = $req->donvi;
        $product->unit_price = $req->gia;
        $product->promotion_price = $req->giakm;
        $product->new = $req->tinhtrang;
        $product->description = $req->mota;
        if($hasLast = Product::all()->last()) // lấy ra sp cuối cùng
            $last = $hasLast->id; // lấy ra id cuối cùng
        else
            $last = 0; // nếu chưa có sp nào trong database mặc định last = 0
        $slug = $req->ten.'-'.++$last; // tạo slug = tên và biến last + lại và tăng lên 1
        $product->slug = str_slug($slug,'-'); // format thành slug và lưu vào cột slug
        if($req->hasFile('feature_image')){ // Nếu người dùng có chèn ảnh đại diện cho sp
            $image = $req->file('feature_image'); // tạo biến image với thông tin nhập tương ứng
            $filename = time() . '.' . $image->getClientOriginalExtension(); // Tạo tên hình ảnh là thời gian hiện tại và lấy đuôi của ảnh đc nhập 
            $location = public_path('source/image/product/'.$filename); // tạo đường dẫn với filename vừa tạo
            Image::make($image)->save($location); //Tạo hình ảnh và lưu lại
            $product->image = $filename; // Gán hình ảnh trong database là tên hình ảnh vừa tạo
        }
        $product->save(); // Lưu sản phẩm vào database
        if($req->hasFile('images')){
            $count = 0;
            foreach($req->file('images') as $image){
                $filename = time() .'_'.$count++. '.' . $image->getClientOriginalExtension();
                $location = public_path('source/image/product/'.$filename);
                Image::make($image)->save($location);
                $newImage = new ProductImage();
                $newImage->id_product = $product->id; // gán khóa ngoại của hình ảnh tương ứng với id của sp vừa tạo
                $newImage->new = 1; //ảnh mới
                $newImage->image = $filename;
                $newImage->save();
            }
        }
        return redirect()->route('list-product')->with('message','Thêm thành công');
    }

    public function update_product(Request $req){
        $prdct = Product::where('id',$req->id)->first(); // lấy sản phẩm với id tương ứng
        $type = ProductType::all();// lấy danh sách loại sản phẩm
        return view('admin.update_product',compact('prdct','type'));
    }
//Check update sản phẩm
    public function update_product_submit(Request $req){
        $this->validate($req,
        [   
            'ten'=>'required',
            'loai'=>'required',
            'gia'=>'required|numeric',
            'giakm'=>'numeric',
            'tinhtrang'=>'required',
            'mota'=>'required',
        ],
        [
            'ten.required'=>'Vui lòng nhập tiêu đề',
            'loai.required'=>'Vui lòng chọn loại sản phẩm',
            'gia.required'=>'Vui lòng nhập giá',
            'gia.numeric'=>'Giá vui lòng là số',
            'giakm.numeric'=>'Vui lòng nhập giá khuyến mãi là số',
            'tinhtrang.required'=>'Vui lòng nhập tình trạng',
            'mota.required'=>'Chưa nhập mô tả',
        ]);
        $product = Product::where('id',$req->id)->first();
        $product->name = $req->ten;
        $product->id_type = $req->loai;
        $product->unit_price = $req->gia;
        $product->promotion_price = $req->giakm;
        $product->new = $req->tinhtrang;
        $product->unit = $req->donvi;
        $product->description = $req->mota;
        $slug = $req->ten.'-'.$product->id; // Tạo slug mới với tên mới và id của sản phẩm
        $product->slug = str_slug($slug,'-'); // Format slug và gán slug mới cho sản phẩm
        
        if($req->hasFile('feature_image')){
            $image = $req->file('feature_image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $location = public_path('source/image/product/'.$filename);
            Image::make($image)->save($location);
            $product->image = $filename;
            $oldFileName = $product->image; // Lấy hình ảnh cũ
            Storage::delete('product/'.$oldFileName); // Xóa ảnh cũ
        }

        if($req->hasFile('images')){
            $count = 0;
            foreach($req->file('images') as $image){
                $filename = time() .'_'.$count++. '.' . $image->getClientOriginalExtension();
                $location = public_path('source/image/product/'.$filename);
                Image::make($image)->save($location);
                $newImage = new ProductImage();
                $newImage->id_product = $product->id;
                $newImage->new = 1;
                $newImage->image = $filename;
                $newImage->save();
            }
            $oldPhotos = ProductImage::where('new','<>',1)
                                        ->where('id_product',$product->id)
                                        ->get();
            foreach($oldPhotos as $oldImage){
                Storage::delete('product/'.$oldImage->image);
                $oldImage->delete();
            }
        }

        $product->save();
        return redirect()->back()->with('message','Cập nhật thành công');
    }
// end check update
    public function delete_product(Request $req){
        $product = Product::where('id',$req->id)->first();
        $productImage = ProductImage::where('id_product',$product->id)->get();
        Storage::delete('product/'.$product->image); // Xóa hình ảnh đại diện
        foreach($productImage as $oldimage){ // VÒNg lặp xóa hình ảnh khác của sản phẩm
            Storage::delete('product/'.$oldimage->image);
            $oldimage->delete();
        }
        $product->delete(); // Xóa sản phẩm khỏi database
        return redirect()->route('list-product')->with('message','Xóa thành công');
    }

    public function show_product(Request $req){
        $product = Product::find($req->id); //Lấy ra sản phẩm theo id
        $typename = ProductType::where('id',$product->id_type)->value('name'); // lấy ra tên loại của sản phẩm đó
        $photos =  ProductImage::where('id_product',$product->id)->get(); // lấy ra hình ảnh khác của sp đó
        return view('admin.show_product',compact('product','photos','typename'));
    }


}