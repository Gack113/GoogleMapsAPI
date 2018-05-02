@extends('../admin/dashdoard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <h2 style="text-align:center">Danh Sách Menu</h2>
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
                    <th>Tiêu Đề</th>
                    <th>Mô Tả</th>
                    <th>Ngày Diễn Ra</th>
                    <th>Quản Lí</th>
                </tr>
                @foreach($menus as $item)
                <tr>
                    <td>{{$item->title}}</td>
                    <td>{{substr($item->description,0,50)}}..</td>
                    <td>{{$item->date_offer}}</td>
                    <td>
                        <a class="delete" href="{{route('delete-menu',$item->id)}}">
                            <button class="btn btn-danger">Xóa</button>
                        </a>
                        <a href="{{route('update-menu',$item->id)}}" class="update">
                            <button class="btn btn-warning">Sửa</button>
                        </a>
                        <a href="{{route('show-menu',$item->id)}}" class="update">
                            <button class="btn btn-info">Chi tiết</button>
                        </a>
                    </td>
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
