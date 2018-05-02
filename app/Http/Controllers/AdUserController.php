<?php

namespace App\Http\Controllers;
use Auth;
use Hash;
use Response;
use Session;
use App\User;
use App\UserType;
use Illuminate\Http\Request;

class AdUserController extends Controller
{

    public function  __construct(){
        $this->middleware('auth', ['except' => ['login', 'login_submit']]);
    }

    public function index(){
        $users = User::all();
        return view('admin.users',compact('users'));
    }

    public function login(){
        return view('admin.login');
    }

    public function login_submit(Request $req){
        $this->validate($req,
        [
            
            'username'=>'required',
            'password'=>'required',
            // 'g-recaptcha-response' => 'required|captcha'
        ],
        [
            'username.required'=>'Vui lòng nhập tên tài khoản',
            'password.required'=>'Vui lòng nhập mật khẩu'
        ]);
        
        $credentials = array('username'=>$req->username,'password'=>$req->password); // tạo mảng truyền vào tài khoản mật khẩu
        if(Auth::attempt($credentials)) // sử dụng auth để đăng nhập truyền vào mảng vừa tạo
            return redirect()->route('list-product'); // nếu đăng nhập thành công trả về route tương ứng
        else
            return redirect()->back()->with(['flag'=>'danger','message'=>'Tài khoản hoặc mật khẩu không đúng']); //ngược lại thông báo trả về trang trước
    }

    public function add(){
        $type = UserType::all();
        return view('admin.add-user',compact('type'));
    }

    public function add_submit(Request $req){
        // start kiểm tra
        $this->validate($req,
        [
            'name'=>'required',
            'username'=>'required|unique:users',
            'password'=>'required',
            'email'=>'required|unique:users'
        ],
        [
            'name.required'=>'Vui lòng nhập tên hiển thị',
            'username.required'=>'Vui lòng nhập tên tài khoản',
            'username.unique'=>'Tên tài khoản đã tồn tại',
            'password.required'=>'Vui lòng nhập mật khẩu',
            'email.required'=>'Vui lòng nhập email',
            'email.unique'=>'Email đã tồn tại'
        ]);
        //end kiểm tra

        $user = new User();
        $user->name = $req->name;
        $user->username = $req->username;
        $user->email = $req->email;
        $user->password = Hash::make($req->password); // mã hóa password từ người dùng nhập rồi gán password cho user vừa tạo

        $user->save();

        return redirect()->back()->with(['message'=>'Thêm thành công']); // trả về trang trước kèm thông báo
    }


    public function logout(){
        Auth::logout(); // sử dụng hàm Auth để đăng xuất
        return redirect()->route('home');
    }

    public function update(Request $req){
        $user = User::where('id',$req->id)->first();
        return view('admin.update_user',compact('user'));
    }

    public function update_submit(Request $req){
        $user = User::where('id',$req->id)->first(); // lấy ra tài khoản theo id truyền vô
        $user->name = $req->name;
        $user->email = $req->email;
        $user->password = Hash::make($req->password); // má hóa hõa mật khẩu mới rồi cập nhật lại mật khẩu
        $user->save();
        return redirect()->route('list-user')->with(['message'=>'Cập nhật thành công']);
    }

    public function delete(Request $req){
        $user = User::where('id',$req->id)->first(); // lấy ra tài khoản theo id
        $user->delete(); // gọi hàm xóa
        return redirect()->back()->with(['message'=>'Xóa thành công']);
    }

    public function profile(){
        $type = UserType::where('id',Auth::user()->type)->first();
        return view('admin.profile',compact('type'));
    }

}
