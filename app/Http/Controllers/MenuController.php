<?php

namespace App\Http\Controllers;
use App\Product;
use App\NewOffer;
use App\NewDetail;
use Auth;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $menus = NewOffer::all();
        return view('admin.menu.index',compact('menus'));
    }

    public function Delete(){
        $menu = NewOffer::find($req->id);
        $menu->delete();
        return redirect()->back()->with('message','Xóa thành công');
    }

    public function Add(){
        $products = Product::all();
        return view('admin.menu.add',compact('products'));
    }

    public function SubmitAdd(Request $req){
        $this->validate($req,
        [   
            'name'=>'required',
            'description'=>'required',
            'sp1'=>'required',
            'sp2'=>'required',
            'sp3'=>'required',
            'sp4'=>'required',
        ],
        [
            'name.required'=>'Vui lòng nhập tiêu đề',
            'description.required'=>'Vui lòng thêm mô tả',
            'sp1.required'=>'Vui lòng chọn sản phẩm 1',
            'sp2.required'=>'Vui lòng chọn sản phẩm 2',
            'sp3.required'=>'Vui lòng chọn sản phẩm 3',
            'sp4.required'=>'Vui lòng chọn sản phẩm 4',
        ]);
        
        $menu = new NewOffer;
        $menu->title = $req->name;
        $menu->description = $req->description;
        $menu->date_offer = today();
        $menu->save();

        for($i = 1;$i <= 4; $i++){
            $newDetail = new NewDetail;
            $newDetail->id_new = $menu->id;
            $newDetail->id_product = $req->{"sp${i}"};
            $newDetail->save();
        }
        return redirect()->route('list-menu')->with('message','Thêm thành công');
    }

    public function Update(Request $req){
        $menu = NewOffer::find($req->id);
        return view('admin.menu.update',compact('menu'));
    }

    public function SubmitUpdate(Request $req){
        return redirect()->back()->with('message','Xóa thành công');
    }

    public function Show(Request $req){
        $menu = NewOffer::find($req->id);
        $menuDetails = NewDetail::where('id_new',$menu->id)->get();
        return view('admin.menu.show',compact('menu','menuDetails'));
    }

}