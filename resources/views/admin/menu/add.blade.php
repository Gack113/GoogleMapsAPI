@extends('../admin/dashdoard')
@section('content')
<div class="container">
	<form action="{{route('add-menu')}}" method="post">
		<input name="_token" type="hidden" value="{{ csrf_token() }}"/>
		<div class="row">
			<div class="col-sm-3"></div>
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
			<div class="col-sm-6">
				<h2>Thêm Offer</h2>
				<div class="space20">&nbsp;</div>
				<div class="form-group">
					<label for="name">Tiêu Đề</label>
					<input class="form-control" type="text" id="name" name="name" required>
				</div>
				<div class="form-group row">
					<label class="col-md-3 col-form-label" for="sp1">Món Ăn 1</label>
					<div class="col-md-9">
						<select class="form-control" id="sp1" name="sp1">
							@foreach($products as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
                <div class="form-group row">
					<label class="col-md-3 col-form-label" for="sp2">Món Ăn 2</label>
					<div class="col-md-9">
						<select class="form-control" id="sp2" name="sp2">
							@foreach($products as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
                <div class="form-group row">
					<label class="col-md-3 col-form-label" for="sp3">Món Ăn 3</label>
					<div class="col-md-9">
						<select class="form-control" id="sp3" name="sp3">
							@foreach($products as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
                <div class="form-group row">
					<label class="col-md-3 col-form-label" for="sp4">Món Ăn 4</label>
					<div class="col-md-9">
						<select class="form-control" id="sp4" name="sp4">
							@foreach($products as $item)
								<option value="{{$item->id}}">{{$item->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
                <div class="form-group">
					<label for="email">Mô Tả</label>
					<input class="form-control" id="description" name="description" required>
				</div>
				<input type="submit" class="btn btn-primary" value="Thêm">
			</div>
			<div class="col-sm-3"></div>
		</div>
	</form>
</div> <!-- .container -->
@endsection