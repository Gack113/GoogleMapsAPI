<?php

namespace App\Http\Controllers;
use Auth;
use App\Bill;
use App\Customer;
use App\UserType;
use App\BillDetail;
use App\Marker;
use App\BillState;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function  __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $role_id = Auth::user()->type; //Lấy ra user đag đăng nhập rồi lấy luôn cột type => lấy đc id của type_users
        if($role_id == 1) // Nếu type = 1 là admin thì show ra hết
            $bills = Bill::all(); // Lấy hết bill ra nếu là admin
        else{ // Ngược lại
            $role = UserType::where('id',$role_id)->first(); // Dựa vào type bên user lấy ra thằng type_user trong bảng type_users
            $bills = Bill::where('id_marker',$role->shop)->get(); // Lấy ra tất cả các bill trong bảng bill nếu id_marker trùng với thằng vừa lấy ra đc -> shop
        }
        $states = BillState::all();
        return view('admin.bills',compact('bills','states'));
    }

    public function show(Request $req){
        $bill = Bill::where('id',$req->id)->first();
        $customer = Customer::where('id',$bill->id_customer)->first();
        $billDetails = BillDetail::join('products','bill_detail.id_product','=','products.id')
                                    ->select('bill_detail.*','products.name')
                                    ->where('id_bill','=',$bill->id)
                                    ->get();
        $shop = Marker::where('id',$bill->id_marker)->first();
        return view('admin.show_bill',compact('bill','customer','billDetails','shop'));
    }

    public function delete(Request $req){
        $bill = Bill::where('id',$req->id)->first();
        BillDetail::where('id_bill',$bill->id)->delete();
        $bill->delete();
        return redirect()->route('list-bill')->with('message','Xóa thành công');
    }

    public function updateState(Request $req){
        $bill = Bill::where('id',$req->idBill)->first();
        $bill->id_state = $req->state;
        $bill->save();
        return redirect()->route('list-bill')->with('message','Cập nhật thành công');
    }
}
