@extends('admin/dashdoard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <p>
                <h1>{{$product->name}}</h1>
            </p>
            <p>
                <h2>Giá: {{number_format($product->unit_price)}}</h2>
            </p>
            <p>
                <h2>Giá khuyến mãi: {{number_format($product->promotion_price)}}</h2>
            </p>
            <p>
                <h3>Loại: {{$typename}}</h3>
            </p>
            <p>
                <h3>Mô tả: {!!$product->description!!}</h3>
            </p>
            <p>
                <h3>Hình ảnh: {{Count($photos)}}</h3>
            </p>
            @foreach($photos as $photo)
                <a href="source/image/product/{{$photo->image}}" class="image-link">
                    <img src="source/image/product/{{$photo->image}}" alt="" height="250px">
                </a>
                <br><br>
            @endforeach
        </div>
        <div class="col-md-4"   style="padding:15% 5%;">
            <aside class="profile-card">
                <header>
                    <a href="source/image/product/{{$product->image}}" class="image-link">
                    <img src="source/image/product/{{$product->image}}" width="200px" class="hoverZoomLink">
                    </a>
                    <h3>Tổng lượt xem: {{$product->view}}</h3>
                    <h3>Lần xem cuối cùng: {{$product->last_visited}}</h3>
                    <h4>Tạo Ngày: <p>{{$product->created_at}}</p></h1>
                    <h4>Lần cập nhật cuối cùng: <p>{{$product->updated_at}}</p></h2>
                </header>
                <div class="profile-bio row">
                    <a class="col-md-6 col-sm-6" href="{{route('update-product',$product->id)}}"><button class="btn btn-primary">Sửa</button></a>
                    <a class="col-md-6 col-sm-6" href="{{route('delete-product',$product->id)}}"><button class="delete btn btn-primary">Xóa</button></a>
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