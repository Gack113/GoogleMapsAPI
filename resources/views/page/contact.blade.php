@extends('master')
@section('content')
<div class="inner-header">
		<div class="container">
			<div class="pull-left">
				<h6 class="inner-title">Liên Hệ</h6>
			</div>
			<div class="pull-right">
				<div class="beta-breadcrumb font-large">
					<a href="index.html">Trang Chủ</a> / <span>Liên Hệ</span>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="beta-map">
		
		<div class="abs-fullwidth beta-map wow flipInX">
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3918.8802921903543!2d106.68373931435089!3d10.82047199229163!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317528e50f92376b%3A0xa92c90752392b55!2zMjEgTMOqIEzhu6NpLCBQaMaw4budbmcgMywgR8OyIFbhuqVwLCBI4buTIENow60gTWluaCwgVmnhu4d0IE5hbQ!5e0!3m2!1svi!2s!4v1520320465658" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
		</div>
	</div>
	<div class="container">
		<div id="content" class="space-top-none">
			
			<div class="space50">&nbsp;</div>
			<div class="row">
				<div class="col-sm-8">
					<h2>Mẫu Liên Lạc</h2>
					<div class="space20">&nbsp;</div>
					<p>Bạn muốn làm CTV?</p>
					<div class="space20">&nbsp;</div>
					<form action="#" method="post" class="contact-form">	
						<div class="form-block">
							<input class="form-control" name="your-name" type="text" placeholder="Tên của bạn (Bắt buộc)">
						</div>
						<div class="form-block">
							<input class="form-control" name="your-email" type="email" placeholder="Email (Bắt buộc)">
						</div>
						<div class="form-block">
							<input  class="form-control" name="your-subject" type="text" placeholder="Chuyên môn">
						</div>
						<div class="form-block">
							<textarea  class="form-control" name="your-message" placeholder="Tin nhắn"></textarea>
						</div>
					</form>
					<button type="submit" class="beta-btn primary">Gửi tin nhắn <i class="fa fa-chevron-right"></i></button>
				</div>
				<div class="col-sm-4">
					<h2>Thông Tin Liên Lạc</h2>
					<div class="space20">&nbsp;</div>

					<h6 class="contact-title">Địa Chỉ</h6>
					<p>
						21, Lê Lợi, Phường 4, Quận Gò Vấp, TP.HCM
					</p>
					<div class="space20">&nbsp;</div>
					<h6 class="contact-title">Số Điện Thoại</h6>
					<p>
						0169 204 7938
					</p>
					<div class="space20">&nbsp;</div>
					<h6 class="contact-title">Email</h6>
					<p>
						Luvanhieu96@gmail.com
					</p>
				</div>
			</div>
		</div> <!-- #content -->
	</div> <!-- .container -->

@endsection