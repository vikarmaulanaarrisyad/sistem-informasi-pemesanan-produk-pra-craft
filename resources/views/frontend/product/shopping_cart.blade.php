@extends('layouts.front')

@section('title', 'Keranjang Belanja')

@section('breadcrumb')
    @parent
    <li><a href="#">Produk</a></li>
    <li class="active">Keranjang Belanja</li>
@endsection

@section('content')
    <div class="body-content outer-top-xs">

        <div class="container">
            <div class="row ">
                <div class="shopping-cart">
                    <div class="shopping-cart-table ">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-romove item">Remove</th>
                                        <th class="cart-description item">Image</th>
                                        <th class="cart-product-name item">Product Name</th>
                                        <th class="cart-qty item">Quantity</th>
                                        <th class="cart-sub-total item">Subtotal</th>
                                    </tr>
                                </thead><!-- /thead -->

                                <tbody>
                                    {{-- @dd($carts) --}}
                                    @foreach ($carts as $order)
                                        @foreach ($order->orderDetails as $item)
                                            <tr>
                                                <td class="romove-item">

                                                    <a href="{{ route('orders.remove_cart', [$item->id, $item->product->id]) }}"
                                                        title="cancel" class="icon"><i class="fa fa-trash-o"></i></a>

                                                </td>
                                                <td class="cart-image">
                                                    <img src="{{ Storage::url($item->product->gambar) }}" alt="">
                                                </td>
                                                <td class="cart-product-name-info">
                                                    <h4 class="cart-product-description"><a
                                                            href="{{ route('produk.show', $item->product->slug) }}">{{ $item->product->nama_produk }}</a>
                                                    </h4>
                                                </td>

                                                </td>
                                                <td class="cart-product-quantity">
                                                    <div class="quant-input">

                                                        <input type="number" class="form-control" min="1"
                                                            value="{{ $item->jumlah }}" style="width: 100px" name="qty"
                                                            data-qty="{{ $item->jumlah }}" onkeyup="{this}">
                                                    </div>
                                                </td>
                                                <td class="cart-product-sub-total">
                                                    <span class="cart-sub-total-price"
                                                        data-subtotal="{{ $item->product->harga }}">{{ $item->jumlah * $item->product->harga }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="7">
                                            <div class="shopping-cart-btn">
                                                <span class="">
                                                    <a href="#"
                                                        class="btn btn-upper btn-primary outer-left-xs">Continue
                                                        Shopping</a>
                                                    <a href="#"
                                                        class="btn btn-upper btn-primary pull-right outer-right-xs">Update
                                                        shopping cart</a>
                                                </span>
                                            </div><!-- /.shopping-cart-btn -->
                                        </td>
                                    </tr>
                                </tfoot>
                            </table><!-- /table -->
                        </div>
                    </div><!-- /.shopping-cart-table -->
                    <div class="col-md-4 col-sm-12 estimate-ship-tax">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <span class="estimate-title">Estimate shipping and tax</span>
                                        <p>Enter your destination to get shipping and tax.</p>
                                    </th>
                                </tr>
                            </thead><!-- /thead -->
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="info-title control-label">Country <span>*</span></label>
                                            <select class="form-control unicase-form-control selectpicker"
                                                style="display: none;">
                                                <option>--Select options--</option>
                                                <option>India</option>
                                                <option>SriLanka</option>
                                                <option>united kingdom</option>
                                                <option>saudi arabia</option>
                                                <option>united arab emirates</option>
                                            </select>
                                            <div class="btn-group bootstrap-select form-control unicase-form-control">
                                                <button type="button" class="btn dropdown-toggle selectpicker btn-default"
                                                    data-toggle="dropdown" title="--Select options--"><span
                                                        class="filter-option pull-left">--Select
                                                        options--</span>&nbsp;<span class="caret"></span></button>
                                                <div class="dropdown-menu open">
                                                    <ul class="dropdown-menu inner selectpicker" role="menu">
                                                        <li data-original-index="0" class="selected"><a tabindex="0"
                                                                class=""
                                                                data-normalized-text="--Select options--"><span
                                                                    class="text">--Select options--</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="1"><a tabindex="0" class=""
                                                                data-normalized-text="India"><span
                                                                    class="text">India</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="2"><a tabindex="0" class=""
                                                                data-normalized-text="SriLanka"><span
                                                                    class="text">SriLanka</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="3"><a tabindex="0" class=""
                                                                data-normalized-text="united kingdom"><span
                                                                    class="text">united kingdom</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="4"><a tabindex="0" class=""
                                                                data-normalized-text="saudi arabia"><span
                                                                    class="text">saudi
                                                                    arabia</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="5"><a tabindex="0" class=""
                                                                data-normalized-text="united arab emirates"><span
                                                                    class="text">united arab emirates</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="info-title control-label">State/Province <span>*</span></label>
                                            <select class="form-control unicase-form-control selectpicker"
                                                style="display: none;">
                                                <option>--Select options--</option>
                                                <option>TamilNadu</option>
                                                <option>Kerala</option>
                                                <option>Andhra Pradesh</option>
                                                <option>Karnataka</option>
                                                <option>Madhya Pradesh</option>
                                            </select>
                                            <div class="btn-group bootstrap-select form-control unicase-form-control">
                                                <button type="button"
                                                    class="btn dropdown-toggle selectpicker btn-default"
                                                    data-toggle="dropdown" title="--Select options--"><span
                                                        class="filter-option pull-left">--Select
                                                        options--</span>&nbsp;<span class="caret"></span></button>
                                                <div class="dropdown-menu open">
                                                    <ul class="dropdown-menu inner selectpicker" role="menu">
                                                        <li data-original-index="0" class="selected"><a tabindex="0"
                                                                class=""
                                                                data-normalized-text="--Select options--"><span
                                                                    class="text">--Select options--</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="1"><a tabindex="0" class=""
                                                                data-normalized-text="TamilNadu"><span
                                                                    class="text">TamilNadu</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="2"><a tabindex="0" class=""
                                                                data-normalized-text="Kerala"><span
                                                                    class="text">Kerala</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="3"><a tabindex="0" class=""
                                                                data-normalized-text="Andhra Pradesh"><span
                                                                    class="text">Andhra Pradesh</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="4"><a tabindex="0" class=""
                                                                data-normalized-text="Karnataka"><span
                                                                    class="text">Karnataka</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                        <li data-original-index="5"><a tabindex="0" class=""
                                                                data-normalized-text="Madhya Pradesh"><span
                                                                    class="text">Madhya Pradesh</span><span
                                                                    class="glyphicon glyphicon-ok icon-ok check-mark"></span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="info-title control-label">Zip/Postal Code</label>
                                            <input type="text" class="form-control unicase-form-control text-input"
                                                placeholder="">
                                        </div>
                                        <div class="pull-right">
                                            <button type="submit" class="btn-upper btn btn-primary">GET A QOUTE</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.estimate-ship-tax -->


                    <div class="col-md-4 col-sm-12 cart-shopping-total">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="cart-sub-total">
                                            Subtotal<span class="inner-left-md">$600.00</span>
                                        </div>
                                        <div class="cart-grand-total">
                                            Grand Total<span class="inner-left-md">$600.00</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead><!-- /thead -->
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="cart-checkout-btn pull-right">
                                            <button type="submit" class="btn btn-primary checkout-btn">PROCCED TO
                                                CHEKOUT</button>
                                            <span class="">Checkout with multiples address!</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody><!-- /tbody -->
                        </table><!-- /table -->
                    </div><!-- /.cart-shopping-total -->
                </div><!-- /.shopping-cart -->
            </div> <!-- /.row -->
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->
            <div id="brands-carousel" class="logo-slider wow fadeInUp animated"
                style="visibility: visible; animation-name: fadeInUp;">

                <div class="logo-slider-inner">
                    <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme"
                        style="opacity: 1; display: block;">
                        <div class="owl-wrapper-outer">
                            <div class="owl-wrapper"
                                style="width: 4700px; left: 0px; display: block; transition: all 0ms ease 0s; transform: translate3d(0px, 0px, 0px);">
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item m-t-15">
                                        <a href="#" class="image">
                                            <img src="{{ asset('FrontTemplate') }}/assets/images/brands/brand1.png"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item m-t-10">
                                        <a href="#" class="image">
                                            <img src="{{ asset('FrontTemplate') }}/assets/images/brands/brand2.png"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item">
                                        <a href="#" class="image">
                                            <img src="{{ asset('FrontTemplate') }}/assets/images/brands/brand3.png"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item">
                                        <a href="#" class="image">
                                            <img src="{{ asset('FrontTemplate') }}/assets/images/brands/brand4.png"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item">
                                        <a href="#" class="image">
                                            <img src="{{ asset('FrontTemplate') }}/assets/images/brands/brand5.png"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item">
                                        <a href="#" class="image">
                                            <img src="{{ asset('FrontTemplate') }}/assets/images/brands/brand6.png"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item">
                                        <a href="#" class="image">
                                            <img src="{{ asset('FrontTemplate') }}/assets/images/brands/brand2.png"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item">
                                        <a href="#" class="image">
                                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand4.png"
                                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item">
                                        <a href="#" class="image">
                                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand1.png"
                                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="owl-item" style="width: 235px;">
                                    <div class="item">
                                        <a href="#" class="image">
                                            <img data-echo="{{ asset('FrontTemplate') }}/assets/images/brands/brand5.png"
                                                src="{{ asset('FrontTemplate') }}/assets/images/blank.gif"
                                                alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="owl-controls clickable">
                            <div class="owl-buttons">
                                <div class="owl-prev"></div>
                                <div class="owl-next"></div>
                            </div>
                        </div>
                    </div><!-- /.owl-carousel #logo-slider -->
                </div><!-- /.logo-slider-inner -->

            </div><!-- /.logo-slider -->
            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
        </div><!-- /.container -->
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.cart-product-quantity').on('click', 'input[name="qty"]', function() {
                var qty = $(this).val(); // mendapatkan nilai qty
                var subtotal = $(this).closest('tr').find('.cart-sub-total-price').data(
                    'subtotal'); // mendapatkan nilai subtotal

                var total = qty * subtotal;
                $(this).closest('tr').find('.cart-sub-total-price').text(total);

            });
            $('.cart-product-quantity').on('change', 'input[name="qty"]', function() {
                var qty = $(this).val(); // mendapatkan nilai qty
                var subtotal = $(this).closest('tr').find('.cart-sub-total-price').data(
                    'subtotal'); // mendapatkan nilai subtotal

                var total = qty * subtotal;
                $(this).closest('tr').find('.cart-sub-total-price').text(total);

            });
        });


        function deleteData(url, name) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: true,
            })
            swalWithBootstrapButtons.fire({
                title: 'Perhatian',
                text: 'Apakah anda yakin ingin menghapus data ' + name +
                    ' ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'rgb(48, 133, 214)',
                cancelButtonColor: '#aaa',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_method': 'delete'
                        })
                        .done(response => {
                            if (response.status = 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                })
                                table.ajax.reload();
                            }
                        })
                        .fail(errors => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Opps! Gagal!',
                                text: errors.responseJSON.message,
                                showConfirmButton: true,
                            })
                            table.ajax.reload();
                        });
                }
            })
        }
    </script>
@endpush
