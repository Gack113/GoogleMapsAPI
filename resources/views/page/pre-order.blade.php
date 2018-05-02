@extends('master')
@section('content')
<div class="inner-header">
		<div class="container">
			<div class="pull-right">
				<div class="beta-breadcrumb">
                    <a href="index.html">Trang chủ</a> / <span>Đặt hàng</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	
	<div class="container">
		<div id="content">	
			<form  class="beta-form-checkout" action="{{route('pre-order')}}">
                <input type="text" id="_token" name="_token" value="{{csrf_token()}}" hidden>
				<div class="row">
					<div class="col-sm-6">
						<h4>Đặt hàng</h4>
						<div class="space20">&nbsp;</div>

						<div class="form-block">
							<label for="name">Họ tên*</label>
							<input class="form-control" type="text" id="name" name="name" placeholder="Họ tên" required>
						</div>
						<div class="form-block">
							<label>Giới tính </label>
							<input id="gender" type="radio" class="input-radio" name="gender" value="nam" checked="checked" style="width: 10%"><span style="margin-right: 10%">Nam</span>
							<input id="gender" type="radio" class="input-radio" name="gender" value="nữ" style="width: 10%"><span>Nữ</span>
										
						</div>

						<div class="form-block">
							<label for="email">Email*</label>
							<input class="form-control" type="email" id="email" name="email" required placeholder="luvanhieu96@gmail.com">
						</div>

						<div class="form-block">
							<label for="adress">Địa chỉ*</label>
							<input width="350px" class="form-control" type="text" id="address" name="address" placeholder="Địa chỉ" required>
							<input type="text" name="lat" id="lat" hidden>
							<input type="text" name="lng" id="lng" hidden>
						</div>

						<div class="form-block">
							<label for="currentLocation">Vị trí hiện tại</label>
							<button id="curLocation" class="btn btn-info btn-xs" type="button">
								*
							</button>
						</div>

						<div class="form-block">
							<label for="phone">Điện thoại*</label>
							<input class="form-control" type="text" id="phone" name="phone" required>
						</div>
						
						<div class="form-block">
							<label for="notes">Ghi chú</label>
							<textarea class="form-control" id="note" name="note"></textarea>
						</div>

						<div class="text-center"><button class="beta-btn primary" type="submit">Bước Tiếp Theo <i class="fa fa-chevron-right"></i></button></div>
					</div>
				</div>
			</form>

		</div> <!-- #content -->
	</div> <!-- .container -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLd-xhlDXOKMsmMPyv9kLA8ZXLTIH0wgE&libraries=places"
  	type="text/javascript"></script>
	<script src="js/order.js"></script>
@endsection