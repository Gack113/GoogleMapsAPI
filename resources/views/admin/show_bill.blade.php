@extends('admin/dashdoard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="profile-card">
            <header>
                <p>
                    <h4>Mã Hóa Đơn:&nbsp;&nbsp;{{$bill->id}}</h4>
                </p>
                <p>
                    <h4>Người Mua:&nbsp;&nbsp;{{$customer->name}}</h4>
                </p>
                <p>
                    <h4>Tổng Tiền: {{number_format($bill->total)}}</h4>
                </p>
                <p>
                    <h4>Hình Thức Thanh Toán: {{$bill->payment}}</h4>
                </p>
                <p>
                    <h4>Địa chỉ giao hàng: {{$customer->address}}</h4>
                </p>
                <p>
                    <h4>Liên hệ người mua: {{$customer->phone_number}}</h4>
                </p>
                <p>
                    <h4>Chú Thích: {{$bill->note}}</h4>
                </p>
                <p>
                    <h4>Chi nhánh giao hàng: {{$shop->name}}</h4>
                </p>
                <p>
                    <h4>Chi Tiết Hóa Đơn: {{Count($billDetails)}}</h4>
                </p>
            </header>
            </div>
            <br><br>
            <table class="table table-bordered table-hover table-responsive">
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Số Lượng</th>
                    <th>Giá</th>
                </tr>
                @foreach($billDetails as $item)
                <tr>
                    <td>{{$item->name}}</td>
                    <td>{{$item->quantity}}</td>
                    <td>{{number_format($item->unit_price)}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="col-md-4">
            <aside class="profile-card">
                <header>
                    <a href="source/image/product/admin.png" class="image-link">
                        <img src="source/image/product/admin.png" width="150px" class="hoverZoomLink">
                    </a>
                    <h4>Tạo Bởi: Admin</h4>
                    <h4>Ngày Lập Bill: &nbsp;&nbsp;{{$bill->date_order}}</h1>
                </header>
                <div class="profile-bio">
                    <a href="{{route('delete-bill',$bill->id)}}"><button class="delete btn btn-primary">Xóa</button></a>
                </div>
            </aside>
        </div>
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
