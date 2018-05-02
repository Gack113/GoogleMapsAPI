@extends('../admin/dashdoard')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <br><br>
            <h4>Danh Sách Món Ăn</h4>
            <table class="table table-bordered table-hover table-responsive">
                <tr>
                    <th>Sản Phẩm</th>
                    <th>Giá</th>
                </tr>
                @foreach($menuDetails as $item)
                <tr>
                    <td>{{$item->product->name}}</td>
                    <td>
                    {{	
                        number_format(
                        $item->product->promotion_price != 0?
                        $item->product->promotion_price:
                        $item->product->unit_price)
                        .'đ'
					}}
                    </td>
                </tr>
                @endforeach
            </table>
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
