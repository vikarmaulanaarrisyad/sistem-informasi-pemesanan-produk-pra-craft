<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
        <div class="logo">
            <a href="{{ route('homepage') }}">
                <img src="{{ asset('FrontTemplate') }}/assets/images/logo.png" alt="logo">

            </a>
        </div>
    </div>

    <div class="col-lg-7 col-md-6 col-sm-8 col-xs-12 top-search-holder">
        <div class="search-area">
            <form>
                <div class="control-group">
                    <input class="search-field" placeholder="Search here..." />
                    <a class="search-button" href="#"></a>
                </div>
            </form>
        </div>

    </div>
    <!-- /.top-search-holder -->

    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 animate-dropdown top-cart-row">
        <!-- ============================================================= SHOPPING CART DROPDOWN ============================================================= -->

        <div class="dropdown dropdown-cart"> <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                <div class="items-cart-inner">
                    <div class="basket">
                        <div class="basket-item-count"><span class="count">2</span></div>
                        <div class="total-price-basket"> <span class="lbl">Shopping Cart</span> <span
                                class="value">$4580</span> </div>
                    </div>
                </div>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <div class="cart-item product-summary">
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="image"> <a href="detail.html"><img
                                            src="{{ asset('FrontTemplate') }}/assets/images/products/p4.jpg"
                                            alt=""></a> </div>
                            </div>
                            <div class="col-xs-7">
                                <h3 class="name"><a href="index8a95.html?page-detail">Simple Product</a></h3>
                                <div class="price">$600.00</div>
                            </div>
                            <div class="col-xs-1 action"> <a href="#"><i class="fa fa-trash"></i></a> </div>
                        </div>
                    </div>
                    <!-- /.cart-item -->
                    <div class="clearfix"></div>
                    <hr>
                    <div class="clearfix cart-total">
                        <div class="pull-right"> <span class="text">Sub Total :</span><span
                                class='price'>$600.00</span> </div>
                        <div class="clearfix"></div>
                        @if ($order)
                            <a href="{{ route('orders.show_cart', $order->id) }}"
                                class="btn btn-upper btn-primary btn-block m-t-20">Checkout</a>
                        @endif

                    </div>
                    <!-- /.cart-total-->

                </li>
            </ul>
            <!-- /.dropdown-menu-->
        </div>
        <!-- /.dropdown-cart -->

        <!-- ============================================================= SHOPPING CART DROPDOWN : END============================================================= -->
    </div>
    <!-- /.top-cart-row -->
</div>
