$('#region').on('change',()=>{
    var id = $('#region').val();
    $.ajax({
         type: 'get',
         url: 'api/province',
         data: {id},
         success: (res)=> {
             if(res.provinces != undefined){
                $('#province').html('<option value="">--Tỉnh/Thành Phố--</option>');
                 $.each(res.provinces,(index,item) =>{
                     $('#province').append(
                         '<option value="'+ item.id +'">'+ item.name +'</option>'
                     );
                 });
                 updateDistrict();
             }
         }
    });
});
 
$('#province').on('change',()=>{
    updateDistrict();
});

$('#district').on('change',()=>{
    loadFilterMarker();
})

$('#searchFilter').on('click',(e)=>{
    e.preventDefault();
    loadFilterMarker();
})

$('#showNearMap').on('click',()=>{
    $('#nearMapHolder').show();
    $('html, body').animate({
        scrollTop: ($('#nearMapHolder').offset().top)
    },500);
})

$('#hideNearMap').on('click',()=>{
    $('#nearMapHolder').hide();
})
 
var updateDistrict = ()=>{
    var region = $('#province').val();
    var province = $('#province').val();
    $.ajax({
        type: 'get',
        url: 'api/district/',
        data: {region,province},
        success: (res)=> {
            if(res.districts != undefined){
                $('#district').html('<option value="">--Quận--</option>');
                $.each(res.districts,(index,item) =>{
                    $('#district').append(
                        '<option value="'+ item.id +'">'+ item.name +'</option>'
                    );
                });
                updateMap();
            }
        }
    });
}
  
var nearMarker = pos =>{
    var curLocation = 'My Location';
    currgeocoder = new google.maps.Geocoder();
    var myLatlng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
    return currgeocoder.geocode({
        'location': myLatlng
    },
    (results, status) => {
        curLocation = [results[0].formatted_address];
        $.ajax({
            url:'thong-tin/near-location',
            data:{'lat':pos.coords.latitude,'lng':pos.coords.longitude},
            success: (res)=>{
                if(res.status == '1'){
                    $('#nearMap').prop('src',`https://maps.google.com?saddr=${curLocation}&daddr=${res.marker.address}&hl=en&z=13&amp&output=embed`);
                    $('#nearMapHolder > .row > h4').html('Cửa Hàng Gần Bạn <br>' +res.marker.name);
                }
                else{
                    $('#nearMapHolder > .row > h4').html('Không xác định được vị trí của bạn');
                }
            }
        });
    });
    
}

var loadNearMarker = ()=>{
    if(navigator.geolocation)
        navigator.geolocation.getCurrentPosition(nearMarker);
    else
        alert('Vui lòng cho phép website lấy vị trí của bạn');
}

var updateMap = (curLocation)=>{
    var region = $('#region').val();
    var province = $('#province').val();
    var district = $('#district').val();
    $.ajax({
        type: 'get',
        url: 'thong-tin/shop-filter',
        data:{region,province,district},
        success: (res)=>{
            $('.maps > .row').html('');
            $.each(res.shop,(i,item)=>{
                $('.maps > .row').append(
                    '<div class="col-lg-3 col-md-3">'+
                        `<p class="text-center wow fadeInDown">${item.name}</p>`+
                        `<p class="text-center wow fadeInDown">${item.address}</p>`+
                        `<iframe src="https://maps.google.com?saddr=${curLocation}&daddr=${item.address}&hl=en&z=13&amp&output=embed" frameborder="0" width="100%" height="350px"></iframe>`+
                    '</div>'
                        
                );
            });
            $('.maps').append('<br><br>');
        }
    });
}

var setPosition = (pos) =>{
    var curLocation = 'My Location';
    currgeocoder = new google.maps.Geocoder();
    var myLatlng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
    return currgeocoder.geocode({
        'location': myLatlng
    },
    (results, status) => {
        curLocation = [results[0].formatted_address];
        updateMap(curLocation);
    });
}

var loadFilterMarker = ()=>{
    if(navigator.geolocation)
        navigator.geolocation.getCurrentPosition(setPosition);   
    else
        alert('Vui lòng cho phép website lấy vị trí của bạn');
}

loadFilterMarker();
loadNearMarker();