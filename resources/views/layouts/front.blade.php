<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    <title>@yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/Templates/plugins/sweetalert2/sweetalert2.min.css') }}">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/main.css">
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/blue.css">
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/owl.transitions.css">
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/animate.min.css">
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/rateit.css">
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/bootstrap-select.min.css">

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{ asset('FrontTemplate') }}/assets/css/font-awesome.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Barlow:200,300,300i,400,400i,500,500i,600,700,800"
        rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800'
        rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    {{-- SweetAlert2 --}}
    @stack('css_vendor')

    @stack('css')
</head>

<body class="cnt-home">
    <!-- ============================================== HEADER ============================================== -->
    <header class="header-style-1">
        <!-- ============================================== TOP MENU ============================================== -->
        <div class="top-bar animate-dropdown">
            <div class="container">
                <div class="header-top-inner">
                    <div class="cnt-account">
                        <ul class="list-unstyled">
                            <li class="header_cart hidden-xs"><a href="#"><span>My Cart</span></a></li>

                            @if ($order && $order->orderDetails != null && $order->orderDetails()->exists())
                                <li class="check"><a
                                        href="{{ route('orders.show_cart', $order->id) }}"><span>Checkout</span></a>
                                </li>
                            @else
                                <li class="check"><a href="{{ route('homepage') }}"><span>Checkout</span></a>
                                </li>
                            @endif


                            @auth
                                <li class="login"><a href="{{ route('dashboard') }}"><span>Dashboard</span></a></li>
                            @endauth

                            @guest
                                <li class="login"><a href="{{ route('login') }}"><span>Login</span></a></li>
                                <li class="login"><a href="{{ route('register') }}"><span>Register</span></a></li>
                            @endguest
                        </ul>
                    </div>
                    <!-- /.cnt-account -->


                    <!-- /.cnt-cart -->
                    <div class="clearfix"></div>
                </div>
                <!-- /.header-top-inner -->
            </div>
            <!-- /.container -->
        </div>
        <!-- /.header-top -->
        <!-- ============================================== TOP MENU : END ============================================== -->
        <div class="main-header">
            <div class="container">
                @include('layouts.partials.frontend.header')
            </div>
            <!-- /.container -->

        </div>
        <!-- /.main-header -->

        <!-- ============================================== NAVBAR ============================================== -->
        <div class="header-nav animate-dropdown">
            <div class="container">
                @include('layouts.partials.frontend.navbar-header')
                <!-- /.navbar-default -->
            </div>
            <!-- /.container-class -->

        </div>
        <!-- /.header-nav -->
        <!-- ============================================== NAVBAR : END ============================================== -->

    </header>

    <!-- ============================================== HEADER : END ============================================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    @section('breadcrumb')

                        <li><a href="{{ route('homepage') }}">Home</a></li>
                    @show
                    {{-- <li><a href="#">Clothing</a></li>
                    <li class="active">Floral Print Buttoned</li> --}}
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>

    <div class="body-content outer-top-vs" id="top-banner-and-menu">

        <div class="container">
            <div class="class="col-xs-12 col-sm-12 col-md-12 homebanner-holder">
                @yield('content')
            </div>

            <!-- ============================================== BRANDS CAROUSEL ============================================== -->
            <div id="brands-carousel" class="logo-slider">
                @include('frontend.homepage.brand_carausel')
            </div>
            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
        </div>
    </div>

    <!-- ============================================== INFO BOXES ============================================== -->
    <div class="row our-features-box">
        <div class="container">
            <ul>
                <li>
                    <div class="feature-box">
                        <div class="icon-truck"></div>
                        <div class="content-blocks">We ship worldwide</div>
                    </div>
                </li>
                <li>
                    <div class="feature-box">
                        <div class="icon-support"></div>
                        <div class="content-blocks">call
                            +1 800 789 0000</div>
                    </div>
                </li>
                <li>
                    <div class="feature-box">
                        <div class="icon-money"></div>
                        <div class="content-blocks">Money Back Guarantee</div>
                    </div>
                </li>
                <li>
                    <div class="feature-box">
                        <div class="icon-return"></div>
                        <div class="content">30 days return</div>
                    </div>
                </li>

            </ul>
        </div>
    </div>
    <!-- /.info-boxes -->
    <!-- ============================================== INFO BOXES : END ============================================== -->


    <!-- ============================================================= FOOTER ============================================================= -->
    <footer id="footer" class="footer color-bg">
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="address-block">

                            <!-- /.module-heading -->

                            <div class="module-body">
                                <ul class="toggle-footer" style="">
                                    <li class="media">
                                        <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                                    class="fa fa-map-marker fa-stack-1x fa-inverse"></i> </span>
                                        </div>
                                        <div class="media-body">
                                            <p>ThemesGround, 789 Main rd, Anytown, CA 12345 USA</p>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                                    class="fa fa-mobile fa-stack-1x fa-inverse"></i> </span> </div>
                                        <div class="media-body">
                                            <p> + (888) 123-4567 / + (888) 456-7890</p>
                                        </div>
                                    </li>
                                    <li class="media">
                                        <div class="pull-left"> <span class="icon fa-stack fa-lg"> <i
                                                    class="fa fa-envelope fa-stack-1x fa-inverse"></i> </span> </div>
                                        <div class="media-body"> <span><a
                                                    href="#">marazzo@themesground.com</a></span> </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.module-body -->
                    </div>
                    <!-- /.col -->

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="module-heading">
                            <h4 class="module-title">Customer Service</h4>
                        </div>
                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class='list-unstyled'>
                                <li class="first"><a href="#" title="Contact us">My Account</a></li>
                                <li><a href="#" title="About us">Order History</a></li>
                                <li><a href="#" title="faq">FAQ</a></li>
                                <li><a href="#" title="Popular Searches">Specials</a></li>
                                <li class="last"><a href="#" title="Where is my order?">Help Center</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.module-body -->
                    </div>
                    <!-- /.col -->

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="module-heading">
                            <h4 class="module-title">Corporation</h4>
                        </div>
                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class='list-unstyled'>
                                <li class="first"><a title="Your Account" href="#">About us</a></li>
                                <li><a title="Information" href="#">Customer Service</a></li>
                                <li><a title="Addresses" href="#">Company</a></li>
                                <li><a title="Addresses" href="#">Investor Relations</a></li>
                                <li class="last"><a title="Orders History" href="#">Advanced Search</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.module-body -->
                    </div>
                    <!-- /.col -->

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="module-heading">
                            <h4 class="module-title">Why Choose Us</h4>
                        </div>
                        <!-- /.module-heading -->

                        <div class="module-body">
                            <ul class='list-unstyled'>
                                <li class="first"><a href="#" title="About us">Shopping Guide</a></li>
                                <li><a href="#" title="Blog">Blog</a></li>
                                <li><a href="#" title="Company">Company</a></li>
                                <li><a href="#" title="Investor Relations">Investor Relations</a></li>
                                <li class=" last"><a href="contact-us.html" title="Suppliers">Contact Us</a></li>
                            </ul>
                        </div>
                        <!-- /.module-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-bar">
            <div class="container">
                <div class="col-xs-12 col-sm-4 no-padding social">
                    <ul class="link">
                        <li class="fb pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="Facebook"></a></li>
                        <li class="tw pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="Twitter"></a></li>
                        <li class="googleplus pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="GooglePlus"></a></li>
                        <li class="rss pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="RSS"></a></li>
                        <li class="pintrest pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="PInterest"></a></li>
                        <li class="linkedin pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="Linkedin"></a></li>
                        <li class="youtube pull-left"><a target="_blank" rel="nofollow" href="#"
                                title="Youtube"></a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-sm-4 no-padding copyright"><a target="_blank"
                        href="https://www.templateshub.net">Templates Hub</a> </div>
                <div class="col-xs-12 col-sm-4 no-padding">
                    <div class="clearfix payment-methods">
                        <ul>
                            <li><img src="{{ asset('FrontTemplate') }}/assets/images/payments/1.png" alt="">
                            </li>
                            <li><img src="{{ asset('FrontTemplate') }}/assets/images/payments/2.png" alt="">
                            </li>
                            <li><img src="{{ asset('FrontTemplate') }}/assets/images/payments/3.png" alt="">
                            </li>
                            <li><img src="{{ asset('FrontTemplate') }}/assets/images/payments/4.png" alt="">
                            </li>
                            <li><img src="{{ asset('FrontTemplate') }}/assets/images/payments/5.png" alt="">
                            </li>
                        </ul>
                    </div>
                    <!-- /.payment-methods -->
                </div>
            </div>
        </div>
    </footer>
    <!-- ============================================================= FOOTER : END============================================================= -->

    <!-- For demo purposes – can be removed on production -->

    <!-- For demo purposes – can be removed on production : End -->

    <!-- JavaScripts placed at the end of the document so the pages load faster -->
    <script src="{{ asset('FrontTemplate') }}/assets/js/jquery-1.11.1.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/owl.carousel.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/echo.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/jquery.easing-1.3.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/bootstrap-slider.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/jquery.rateit.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/lightbox.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/wow.min.js"></script>
    <!-- sweetalert2 -->
    <script src="{{ asset('/Templates/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('FrontTemplate') }}/assets/js/scripts.js"></script>


    <script src="{{ asset('js/cutom.js') }}"></script>
    @stack('scripts')

    @if (session()->has('success'))
        <script>
            setTimeout(() => {
                Swal.fire(
                    'Sukses!',
                    '{{ session('message') }}',
                    'success'
                )
                location.reload();
            }, 3000);
        </script>
    @elseif (session()->has('error_msg'))
        <script>
            Swal.fire(
                'Sukses!',
                '{{ session('message') }}',
                'error'
            )
        </script>
    @endif
</body>

</html>
