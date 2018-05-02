@extends('admin/dashdoard')
@section('content')
<div class="container" style="clearfix">
     <div class="col">
       
        <div class="col">
            <h2 style="text-align:center">Danh Sách Hóa Đơn</h2>
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
                    <th>Mã Hóa Đơn</th>
                    <th>Tên Khách Hàng</th>
                    <th>Địa Chỉ</th>
                    <th>Tổng Tiền</th>
                    <th>Hình Thức Thanh Toán</th>
                    <th>Trạng Thái</th>
                    <th>Quản Lý</th>
                </tr>
                @foreach($bills as $bill)
                <tr>
                    <td>{{$bill->id}}</td>
                    <td>{{$bill->customer->name}}</td>
                    <td>{{$bill->customer->address}}</td>
                    <td>{{number_format($bill->total)}}</td>
                    <td>{{$bill->payment}}</td>
                    <td>
                        <a data-file="{{$bill->id}}" data-state="{{$bill->bill_state->id}}" href="#" class="btn btn-warning openModal">
                            {{$bill->bill_state->name}}
                        </a>
                    </td>
                    <td>
                        <a href="{{route('show-bill',$bill->id)}}">
                            <button class="btn btn-info">Xem </button>
                        </a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>

<div class="modal fade" id="stateModal" tabindex="-1" role="dialog" aria-labelledby="stateModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Cập Nhật Tình Trạng</h4>
      </div>
      <form action="{{route('update-bill')}}" method="post">
        <div class="modal-body">
            <input type="hidden" name="idBill" id="idBill">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            <div class="form-group">
                <select name="state" id="state" class="form-control">
                    @foreach($states as $item)
                        <option value="{{$item->id}}">{{$item->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
    $('.openModal').on('click',function(e){
        e.preventDefault();
        $this = $(this);
        var fileName = $(this).data("file");
        $("#stateModal").data("fileName", fileName).modal("toggle", $this);
    });

    $("#stateModal").on("shown.bs.modal", function(e){
        $('#idBill').val($(this).data("fileName"));
    })
</script>

@endsection
