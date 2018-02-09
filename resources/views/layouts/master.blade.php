<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title", "BikeShop | จำหน่ายอะไหล่จักรยานออนไลน์")</title>
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <!-- js -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('js/angular.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button"
                    class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{ URL::to('home') }}">BikeShop</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{{ URL::to('home') }}">หน้าแรก</a></li>
                    @guest
                    @else
                    <li><a href="{{ URL::to('product') }}">จัดการข้อมูลสินค้า</a></li>
                    <li><a href="#">รายงาน</a></li>
                    @endguest
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{{ URL::to('cart/view') }}"><i class="fa fa-shopping-cart"></i> ตะกร้า <span class="label label-danger">{!! count(Session::get('cart_items')) !!}</span></a></li>
                    @guest
                    <li><a href="{{ route('login') }}">ล็อกอิน</a></li>
                    <li><a href="{{ route('register') }}">ลงทะเบียน</a></li>
                    @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> ออกจากระบบ
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @yield("content")
    <!-- js -->
    @if(session('msg'))
        @if(session('ok'))
        <script>toastr.success("{{ session('msg') }}")</script>
        @else
        <script>toastr.error("{{ session('msg') }}")</script>
        @endif
    @endif
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
</body>
</html>
