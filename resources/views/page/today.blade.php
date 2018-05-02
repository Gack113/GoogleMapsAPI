@extends('../master')
@section('content')
<div class="inner-header">
	<div class="container">
		<div class="pull-left">
			<h6 class="inner-title">Ưu Đãi Hôm Nay</h6>
		</div>
		<div class="pull-right">
			<div class="beta-breadcrumb font-large">
				<a href="index.html">Home</a> / <span>Today Offer</span>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="container">
    <div id="content">
        <h2 class="text-center wow fadeInDown">{{!empty($newToday) ? $newToday->title:"Hôm Nay Chưa Có Ưu Đãi"}}</h2>
        <div class="space20">&nbsp;</div>
        <h4 class="text-center wow fadeInLeft">
            {{!empty($newToday) ? $newToday->description:""}}
        </h4>
        <div class="space35">&nbsp;</div>

        <div class="row">
            @if(!empty($meals))
                @foreach($meals as $item)
                <div class="col-sm-2 col-sm-push-2">
                    <div class="beta-counter">
                        <a class="u-photo" href="{{route('chi-tiet',$item->product->slug)}}" target="_blank">
                            <p class="beta-counter-icon">
                                <img src="source/image/product/{{$item->product->image}}" width="200" height="150" />
                            </p>
                        </a>
                        <p class="beta-counter-value numbers">
                            {{	number_format(
                                $item->product->promotion_price != 0?
                                $item->product->promotion_price:
                                $item->product->unit_price)
                                .'đ'
                            }}
                        </p>
                        <p class="beta-counter-title">{{$item->product->name}}</p>
                    </div>
                </div>
                @endforeach
            @endif
        </div> <!-- .beta-counter block end -->
    </div>
</div>
@endSection