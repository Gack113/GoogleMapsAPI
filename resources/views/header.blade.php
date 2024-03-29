<div class="h-product" id="header">
		<div class="header-top">
			<div class="container">
				<div class="pull-left auto-width-left">
					<ul class="top-menu menu-beta l-inline">
						<li><a href=""><i class="fa fa-home"></i> 21 Lê Lợi, Phường 4, Quận Gò Vấp, TP.Hồ Chí Minh</a></li>
						<li><a href=""><i class="fa fa-phone"></i> 0169 204 7938</a></li>
					</ul>
				</div>
				<div class="pull-right auto-width-right">
					<!-- <ul class="top-details menu-beta l-inline">
						<li><a href="#"><i class="fa fa-user"></i>Tài khoản</a></li>
						<li><a href="#">Đăng kí</a></li>
						<li><a href="#">Đăng nhập</a></li>
					</ul> -->
				</div>
				<div class="clearfix"></div>
			</div> <!-- .container -->
		</div> <!-- .header-top -->
		<div class="header-body">
			<div class="container beta-relative">
				<div class="pull-left">
					<a class="u-photo" href="{{route('home')}}" id="logo"><img src="source/assets/dest/images/logo-cake.png" width="200px" alt=""></a>
				</div>
				<div class="pull-right beta-components space-left ov">
					<div class="space10">&nbsp;</div>
					<div class="beta-comp">
						<form role="search" method="get" id="searchform" action="{{route('tim-kiem')}}">
					        <input type="text" value="" name="tu-khoa" id="s" placeholder="Nhập từ khóa..." />
					        <button class="fa fa-search" type="submit" id="searchsubmit"></button>
						</form>
					</div>

					<div class="beta-comp">
						<div class="cart">
							<div class="beta-select"><i class="fa fa-shopping-cart"></i>
							 Giỏ hàng &nbsp;
							 	@if(Session::has('cart'))
							 		<span class="cart-total-value">({{Session('cart')->totalQty}})</span>
							 	@else
									(Trống)
								@endif
								<i class="fa fa-chevron-down"></i></div>
							@if(Session::has('cart'))
							<div class="beta-dropdown cart-body">
									@foreach($product_cart as $item)
										<div class="cart-item">
											<a href="{{route('reducecartbyone',$item['item']['id'])}}" class="cart-item-delete"><i style="line-height:1.5" class="fa fa-times" area-hidden="true"></i></a>
											<div class="media">
												<a class="pull-left" href="#"><img src="source/image/product/{{$item['item']->image}}" alt=""></a>
												<div class="media-body">
													<span class="cart-item-title">{{$item['item']->name}}</span>
													<!-- <span class="cart-item-options">Size: XS; Colar: Navy</span> -->
													<span class="cart-item-amount"><span>
														@if($item['item']->promotion_price == 0)
															{{number_format($item['item']->unit_price)}}
														@else
															{{number_format($item['item']->promotion_price)}}
														@endif
														&nbsp;x&nbsp;{{$item['qty']}}
														</span>
													</span>
												</div>

											</div>
										</div>
									@endforeach
								<div class="cart-caption">
									<div class="cart-total text-right">Total: <span class="cart-total-value">{{Session('cart')->totalPrice}}</span></div>
									<div class="clearfix"></div>

									<div class="center">
										<div class="space10">&nbsp;</div>
										<a href="{{route('dat-hang')}}" class="beta-btn primary text-center">Đặt hàng <i class="fa fa-chevron-right"></i></a>
									</div>
								</div>
							</div>
						</div> <!-- .cart -->
					@endif
					</div>
				</div>
				<div class="clearfix"></div>
			</div> <!-- .container -->
		</div> <!-- .header-body -->
		<br>
		<div class="header-bottom" style="background-color: #0277b8;">
			<div class="container">
				<a class="visible-xs beta-menu-toggle pull-right" href="#"><span class='beta-menu-toggle-text'>Menu</span> <i class="fa fa-bars"></i></a>
				<div class="visible-xs clearfix"></div>
				<nav class="main-menu">
					<ul class="l-inline ov">
						<li><a href="{{route('home')}}">Trang Chủ</a></li>
						<li>
							<a data-toggle="dropdown">Loại Bánh<span class="caret"></span></a>
							<ul class="dropdown-menu">
								@foreach($type as $item)
								<li><a href="{{route('loai-banh',$item->id)}}">{{$item->name}}</a></li>
								@endforeach
							</ul>
						</li>
						<li><a href="{{route('cua-hang')}}">Cửa Hàng</a></li>
						<li><a href="{{route('offer')}}">Ưu Đãi</a></li>
						<li><a href="{{route('lien-he')}}">Liên Hệ</a></li>
					</ul>
					<div class="clearfix"></div>
				</nav>
			</div> <!-- .container -->
		</div> <!-- .header-bottom -->
	</div> <!-- #header -->
	