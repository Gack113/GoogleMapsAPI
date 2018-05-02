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
			<form  class="beta-form-checkout">
                <input type="text" id="_token" name="_token" value="{{csrf_token()}}" hidden>
				<div class="row">
					<div class="col-sm-6">
						<h4>Đặt hàng</h4>
						<div class="space20">&nbsp;</div>

						<div class="form-block">
							<label for="name">Họ tên:*</label>
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
					</div>
					<div class="col-sm-6">
						<div class="your-order">
							<div class="your-order-head"><h5>Đơn hàng của bạn</h5></div>
							<div class="your-order-body" style="padding: 0px 10px">
								<div class="your-order-item">
									<div>
                                    @if(Session::has('cart'))
                                        @foreach(Session('cart')->items as $item)
                                        <!--  one item	 -->
                                            <div class="media">
                                                <img width="25%" src="source/image/product/{{$item['item']->image}}" alt="" class="pull-left">
                                                <div class="media-body">
                                                    <p class="font-large">{{$item['item']->name}}</p>
                                                    <span class="color-gray your-order-info">{{$item['item']['promotion_price']==0?$item['item']['unit_price']:$item['item']['promotion_price']}}</span>
                                                    <span class="color-gray your-order-info">{{$item['qty']}}</span>
                                                </div>
                                            </div>
                                        <!-- end one item -->
                                        @endforeach
                                    @endif;
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="your-order-item">
									<div class="pull-left"><p class="your-order-f18">Tổng tiền:</p></div>
									<div class="pull-right">
                                        <h5 class="color-black">
                                        @if(Session::has('cart'))
                                            {{number_format(Session('cart')->totalPrice)}} đồng
                                        @else
                                            0 đồng
                                        @endif
                                        </h5>
                                    </div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="your-order-head"><h5>Hình thức thanh toán</h5></div>
							
							<div class="your-order-body">
								<ul class="payment_methods methods">
									<li class="payment_method_bacs">
										<input id="payment_method_bacs" type="radio" class="input-radio" name="payment_method" value="COD" checked="checked" data-order_button_text="">
										<label for="payment_method_bacs">Thanh toán khi nhận hàng </label>
										<div class="payment_box payment_method_bacs" style="display: block;">
											Cửa hàng sẽ gửi hàng đến địa chỉ của bạn, bạn xem hàng rồi thanh toán tiền cho nhân viên giao hàng
											<br><br>
											<div class="text-center"><button class="beta-btn primary" type="submit" id="dathang">Đặt hàng <i class="fa fa-chevron-right"></i></button></div>
										</div>						
									</li>

									<li class="payment_method_cheque">
										<input id="payment_method_cheque" type="radio" class="input-radio" name="payment_method" value="ATM" data-order_button_text="">
										<label for="payment_method_cheque">Thanh qua ngân lượng </label>
										<div class="payment_box payment_method_cheque" style="display: none;">
											
										</div>						
									</li>

									<li class="payment_method_paypal">
										<input id="payment_method_paypal" type="radio" class="input-radio" name="payment_method" value="PayPal" data-order_button_text="">
										<label for="payment_method_paypal">PayPal</label>
										<div class="payment_box payment_method_paypal" style="display: none;">
											<p>Dịch vụ thanh toán online an toàn, nhanh chóng, đáng tin cậy</p>
											<br><br>
											@include('page.paypal')
										</div>	
									</li>
									
								</ul>
							</div>
						</div> <!-- .your-order -->
					</div>
				</div>
			</form>

		</div> <!-- #content -->
	</div> <!-- .container -->
	<!-- The Modal -->
	<div id="myModal" class="modal">
		<!-- Modal content -->
		<div class="modal-content">
			<div class="modal-header">
				<span class="close">&times;</span>
				<h2>Thông Tin Đặt Hàng</h2>
			</div>
			<div class="modal-body">
				<div id="message"></div>
			</div>
			<div class="modal-footer">
				<button id="closeModal" class="btn btn-info">OK</button>
			</div>
		</div>
	</div>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBLd-xhlDXOKMsmMPyv9kLA8ZXLTIH0wgE&libraries=places"
  	type="text/javascript"></script>
	<script src="js/order.js"></script>
@endsection