google.maps.event.addDomListener(window, 'load', function () {
    var places = new google.maps.places.Autocomplete(document.getElementById('address'));
    google.maps.event.addListener(places, 'place_changed', function () {
        var place = places.getPlace();
        var address = place.formatted_address;
        var latitude = place.geometry.location.lat();
        var longitude = place.geometry.location.lng();
        document.getElementById('lat').value = latitude;
        document.getElementById('lng').value = longitude;
    });
});

function initialize(lat,lng) {
    var map;
    var directionsDisplay = new google.maps.DirectionsRenderer();
    var directionsService = new google.maps.DirectionsService();

    var center = new google.maps.LatLng(lat, lng);

    var myOptions = {
        zoom: 14,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: center
    };

    map = new google.maps.Map(document.getElementById("map"), myOptions);

    var rendererOptions = {
        map: map,
        suppressMarkers: true
    };

    directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);

    directionsDisplay.setMap(map);

    var start = new google.maps.LatLng(Number($('#lat').val()),Number($('#lng').val()));
    var end = new google.maps.LatLng(lat, lng);

    var request = {
        origin: start,
        destination: end,
        travelMode: google.maps.DirectionsTravelMode.DRIVING
    };

    directionsService.route(request, function (response, status) {
        if (status == google.maps.DirectionsStatus.OK) {
            
            var route = response.routes[0].legs[0];

            createMarker(route.start_location,'A','Vị trí của bạn',map);
            createMarker(route.end_location,'B','Vị trí cửa hàng',map);

            directionsDisplay.setDirections(response);
        }
    });
}

function createMarker(position,label,title,map) {
    var marker = new google.maps.Marker({
        position,
        label,
        title,
        map: map,
        icon: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
    });
}


$('#dathang').on('click',(e)=>{
    e.preventDefault();
    var name = $('#name').val();
    var gender = $('input[name=gender]').val();
    var email = $('#email').val();
    var address = $('#address').val();
    var lat = $('#lat').val();
    var lng = $('#lng').val();
    var note = $('#note').val();
    var phone = $('#phone').val();
    var payment_method = $('input[name=payment_method]').val();
    var _token = $('#_token').val();
    var data = {
        name,gender,email,address,lat,lng,note,phone,payment_method
    };
    $.ajax({
        type: 'POST',
        url: 'dat-hang/checkout',
        data: {data,_token},
        beforeSend: (xhr)=>{xhr.setRequestHeader('X-CSRF-TOKEN', _token)},
        success: (res)=>{
            $('#content').find("input[type=text], textarea").not('#_token,#lat,#lng').val('');
            if(res.status === 0)
                $('#myModal #message').html('<h5>' + res.message + '</br>' + res.error + '</h5>');
            else{
                $('#myModal #message').html(
                    '<h6>' +
                        res.message + '</br>' +
                        'Chi nhánh giao hàng: ' + res.shop.name + '</br>' +
                        'Số điện thoại hỗ trợ: ' + res.shop.phone + '</br>' +
                        'Địa chỉ chi nhánh: ' + res.shop.address + '</br>' +
                    '</h6>'
                );
                $('#myModal .modal-body').append('<div id="map"></div>');
                initialize(res.shop.lat,res.shop.lng);
            }
            $('#myModal').css('display','block');
        }
    });
});

 $('.close,#closeModal').on('click',()=>{
     $('#myModal').css('display','none');
     window.location.reload();
 })




$('#curLocation').on('click',()=>{
    if(navigator.geolocation)
        navigator.geolocation.getCurrentPosition(setPosition);
    else
        alert('Trình duyệt này không hỗ trợ lấy vị trí');
});

var setPosition = pos =>{
    document.getElementById('lat').value = pos.coords.latitude;
    document.getElementById('lng').value = pos.coords.longitude;
    currgeocoder = new google.maps.Geocoder();
    var myLatlng = new google.maps.LatLng(pos.coords.latitude, pos.coords.longitude);
    return getCurrentAddress(myLatlng);
}

var getCurrentAddress = location => {
    currgeocoder.geocode({
        'location': location
    },
    (results, status) => {
        if (status == google.maps.GeocoderStatus.OK) {
            document.getElementById('address').value = results[0].formatted_address
        } else {
            alert('Geocode was not successful for the following reason: ' + status)
        }
    })
 }