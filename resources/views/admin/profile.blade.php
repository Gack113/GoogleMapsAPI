@extends('admin/dashdoard')
@section('content')
<div class="container">
<aside class="profile-card">
  <header>
    <a href="source/image/product/admin.png" class="image-link">
      <img src="source/image/product/admin.png" class="hoverZoomLink">
    </a>
    <br>
    <br>
    <br>
    <h1>{{Auth::user()->name}}</h1>
    <h2>{{$type->name}}</h2>
  </header>

  <!-- bit of a bio; who are you? -->
  <div class="profile-bio">
    <p>Username: &nbsp;&nbsp;{{Auth::user()->username}}</p>
    <p>Email:&nbsp;&nbsp;{{Auth::user()->email}}</p>
    <p>Password:&nbsp;&nbsp;*******</p>
  </div>
  <!-- some social links to show off -->
  <!-- <ul class="profile-social-links">
    <li>
      <a target="_blank" href="#">
        <i class="fa fa-facebook"></i>
      </a>
    </li>
    <li>
      <a target="_blank" href="#">
        <i class="fa fa-twitter"></i>
      </a>
    </li>
    <li>
      <a target="_blank" href="#">
        <i class="fa fa-github"></i>
      </a>
    </li>
    <li>
      <a target="_blank" href="#">
        <i class="fa fa-behance"></i>
      </a>
    </li>
  </ul> -->
</aside>
</div> <!-- .container -->
@endsection