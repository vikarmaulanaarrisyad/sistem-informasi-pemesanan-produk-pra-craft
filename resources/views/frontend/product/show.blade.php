@extends('layouts.front')

@section('title', $product->nama_produk)

@section('breadcrumb')
    @parent
    <li><a href="#">Produk</a></li>
    <li class="active">{{ $product->nama_produk }}</li>
@endsection

@section('content')
    <div class='container-fluid'>
        <div class='row single-product'>
            <div class='col-md-12 '>
                <div class="detail-block">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 gallery-holder">
                            <div class="product-item-holder size-big single-product-gallery small-gallery">
                                <div id="owl-single-product">
                                    <div class="single-product-gallery-item" id="slide1">
                                        <a data-lightbox="image-1" data-title="Gallery"
                                            href="{{ asset('FrontTemplate') }}/assets/images/products/p1.jpg">
                                            <img class="img-responsive" alt=""
                                                src="{{ Storage::url($product->gambar) }}"
                                                data-echo="{{ Storage::url($product->gambar) }}" />
                                        </a>
                                    </div><!-- /.single-product-gallery-item -->

                                </div><!-- /.single-product-slider -->

                            </div><!-- /.single-product-gallery -->
                        </div><!-- /.gallery-holder -->
                        <div class='col-sm-12 col-md-8 col-lg-8 product-info-block'>
                            <div class="product-info">
                                <h1 class="name">{{ $product->nama_produk }}</h1>

                                <div class="rating-reviews m-t-20">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="pull-left">
                                                <div class="rating rateit-small"></div>
                                            </div>
                                            <div class="pull-left">
                                                <div class="reviews">
                                                    <a href="#" class="lnk">(13 Reviews)</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->
                                </div><!-- /.rating-reviews -->

                                <div class="stock-container info-container m-t-10">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="pull-left">
                                                <div class="stock-box">
                                                    <span class="label">Availability :</span>
                                                </div>
                                            </div>
                                            <div class="pull-left">
                                                <div class="stock-box">
                                                    <span class="value">{{ $product->stok }} Stock</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.row -->
                                </div><!-- /.stock-container -->

                                <div class="description-container m-t-20">
                                    {!! $product->deskripsi !!}
                                </div><!-- /.description-container -->

                                <div class="price-container info-container m-t-30">
                                    <div class="row">

                                        <div class="col-sm-6 col-xs-6">
                                            <div class="price-box">
                                                <span class="price">Rp. {{ format_uang($product->harga) }}</span>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 col-xs-6">
                                            <div class="favorite-button m-t-5">
                                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="right"
                                                    title="Wishlist" href="#">
                                                    <i class="fa fa-heart"></i>
                                                </a>
                                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="right"
                                                    title="Add to Compare" href="#">
                                                    <i class="fa fa-signal"></i>
                                                </a>
                                                <a class="btn btn-primary" data-toggle="tooltip" data-placement="right"
                                                    title="E-mail" href="#">
                                                    <i class="fa fa-envelope"></i>
                                                </a>
                                            </div>
                                        </div>

                                    </div><!-- /.row -->
                                </div><!-- /.price-container -->

                                <div class="quantity-container info-container">
                                    <div class="row">

                                        <div class="qty">
                                            <span class="label">Qty :</span>
                                        </div>

                                        <form action="{{ route('orders.add_cart', $product->slug) }}" method="post">
                                            @csrf
                                            <div class="qty-count">
                                                <div class="cart-quantity">
                                                    <div class="quant-input">
                                                        <input type="number" value="1" min="1"
                                                            class="form-control" name="qty">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="add-btn">
                                                <button type="submit" class="btn btn-primary"><i
                                                        class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART</button>
                                            </div>
                                        </form>




                                    </div><!-- /.row -->
                                </div><!-- /.quantity-container -->

                            </div><!-- /.product-info -->
                        </div><!-- /.col-sm-7 -->
                    </div><!-- /.row -->
                </div>


            </div><!-- /.col -->
            <div class="clearfix"></div>
        </div><!-- /.row -->
        <!-- ============================================== BRANDS CAROUSEL ============================================== -->
        <div id="brands-carousel" class="logo-slider">

            <div class="logo-slider-inner">
                <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
                    <div class="item m-t-15">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand1.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item m-t-10">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand2.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand3.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand4.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand5.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand6.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand2.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand4.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand1.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->

                    <div class="item">
                        <a href="#" class="image">
                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand5.png"
                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif" alt="">
                        </a>
                    </div>
                    <!--/.item-->
                </div><!-- /.owl-carousel #logo-slider -->
            </div><!-- /.logo-slider-inner -->

        </div><!-- /.logo-slider -->
        <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
    </div><!-- /.container -->
@endsection
