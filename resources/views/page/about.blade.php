@extends('master')
@section('content')
<div class="inner-header">
	<div class="container">
		<div class="pull-left">
			<h6 class="inner-title">Cửa Hàng</h6>
		</div>
		<div class="pull-right">
			<div class="beta-breadcrumb font-large">
				<a href="index.html">Home</a> / <span>Cửa Hàng</span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
	<div class="container">
		<div id="content">
			<div class="space50">&nbsp;</div>
			<h4 class="text-center wow fadeInDown">Nhanh Chân Tới Những Cửa Hàng Gần Bạn Để Được Hưởng Ưu Đãi Nào!!</h4>
			<hr>
			<form class="form-inline" action="{{route('cua-hang')}}">
				<div class="form-group">
					<label for="region">Chọn Khu Vực</label>
					<select name="region" id="region" class="form-control">
						<option value="">--Miền--</option>
						@foreach($regions as $item)
							<option value="{{$item->id}}">{{$item->name}}</option>
						@endforeach
					</select>
				</div>
				<div class="form-group">
					<label for="province">Chọn Tỉnh/Thành Phố</label>
					<select name="province" id="province" class="form-control">
						<option value="">--Tỉnh/Thành Phố--</option>
						@if(Request::has('region'))
							@foreach($provinces as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="form-group">
					<label for="district">Chọn Quận</label>
					<select name="district" id="district" class="form-control">
						<option value="">--Quận--</option>
						@if(Request::has('province'))
							@foreach($districts as $item)
								@if(Request::has('district') && $item->id == $req->input('district'))
									<option value="{{$item->id}}">{{$item->name}}</option>
								@endif
							@endforeach
						@endif
					</select>
				</div>
			</form>
			<button class="btn btn-primary" id="showNearMap">Cửa Hàng Gần Nhất</button>
			<br><br><br><br><br>
			<div class="maps">
				<h4 class="text-center wow fadeInDown"></h4>
				<div class="space35">&nbsp;</div>
				<div class="row">

				</div>
			</div>
			<div id="nearMapHolder" style="display:none">
				<div class="row">
					<h4 class="text-center wow fadeInDown">Cửa Hàng Gần Bạn Nhất</h4>
					<div class="col-md-12 text-right">
						<button class="btn btn-warning wow fadeInDown" id="hideNearMap">X</button>
						<br><br>
						<div class="mapInfo">
							<iframe id="nearMap" src="" frameborder="0" width="100%" height="500px"></iframe>
						</div>
					</div>
				</div> 
			</div>
		</div> <!-- #content -->
	</div> <!-- .container -->
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLd-xhlDXOKMsmMPyv9kLA8ZXLTIH0wgE&libraries=places"
  	type="text/javascript"></script>
	<script src="js/about.js"></script>
@endsection
