@extends('admin/dashdoard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h2 style="text-align:center">Danh Sách Tài Khoản</h2>
            @if(count($errors) > 0)
                <div class="alert alert-danger">
                @foreach($errors->all() as $err)
                    {{$err}}&nbsp;&nbsp;&nbsp;
                @endforeach
                </div>
            @endif
            @if(Session::has('message'))
            <h5 class="alert alert-success">{{Session::get('message')}}</h5>
            @endif
            <table class="table table-bordered table-hover table-responsive">
                <tr>
                    <th>ID</th>
                    <th>Họ Tên</th>
                    <th>Tên Tài Khoản</th>
                    <th>Email</th>
                    <th>Ngày Tạo</th>
                    <th>Ngày Cập Nhật</th>
                    <th colspan="2" style="text-align:center">Quản lý</th>
                </tr>
                @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>{{$user->updated_at}}</td>
                    @if(Auth::user()->type == 1)
                        <td><a href="{{route('update-user',$user->id)}}"><button class="btn btn-warning btn-xs">Sửa</button></a></td>
                        <td><a class="delete" href="{{route('delete-user',$user->id)}}"><button class="btn btn-danger btn-xs">Xóa</button></a></td>
                    @else
                        <td><a href="{{route('update-user',$user->id)}}"><button disabled class="btn btn-warning btn-xs">Sửa</button></a></td>
                        <td><a class="delete"><button disabled class="btn btn-danger btn-xs">Xóa</button></a></a></td>
                    @endif
                </tr>
                @endforeach
            </table>
        </div>
        <div class="col-md-1"></div>
    </div>
</div>
<script>
    $('.delete').on('click',function(e){
        if(confirm('Bạn có chắc muốn xóa? Những dữ liệu liên quan có thể bị xóa theo!!!'))
            return true;
        return false;
    })
</script>
@endsection
