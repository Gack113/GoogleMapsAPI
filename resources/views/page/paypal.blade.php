@if(Session::has('cart'))
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="upload" value="1">
<input type="hidden" name="currency_code" value="VND">
<input type="hidden" name="business" value="luvanhieu96@gmail.com">

@php $i = 1 @endphp
@foreach(Session('cart')->items as $item)
    <input type="hidden" name="item_name_{{$i}}" value="{{str_slug($item['item']->name,'-')}}">
    <input type="hidden" name="item_number_{{$i}}" value="{{$item['item']->id}}">
    <input type="hidden" name="quantity_{{$i}}" value="{{$item['qty']}}">
    <input type="hidden" name="amount_{{$i}}" value="{{$item['item']->promotion_price == 0 ?$item['item']->unit_price:$item['item']->promotion_price}}">
    @php $i++ @endphp
@endforeach
@endif
<input type="hidden" name="return" value="https://fakefoody.000webhostapp.com/dat-hang/dat" />
<input type="hidden" name="cancel_return" value="https://fakefoody.000webhostapp.com/dat-hang/dat" />
<div class="text-center"><input name="submit" type="image" src="https://www.paypalobjects.com/webstatic/en_US/i/buttons/PP_logo_h_100x26.png" value="Check out" formaction="https://www.paypal.com/cgi-bin/webscr"></div>
