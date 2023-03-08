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

                                    @if ($order && $order->orderDetails != null && $order->orderDetails()->exists())

                                        @foreach ($carts as $order)
                                            @foreach ($order->orderDetails as $item)
                                                <form action="{{ route('orders.update_cart', [$order->id,$item->product->id]) }}" >
                                                    <tr>
                                                        <td class="romove-item">

                                                            <a href="{{ route('orders.remove_cart', [$item->id, $item->product->id]) }}"
                                                                title="cancel" class="icon"><i
                                                                    class="fa fa-trash-o"></i></a>

                                                        </td>
                                                        <td class="cart-image">
                                                            <img src="{{ Storage::url($item->product->gambar) }}"
                                                                alt="">
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
                                                                    value="{{ $item->jumlah }}" style="width: 100px"
                                                                    name="qty" data-qty="{{ $item->jumlah }}"
                                                                    onkeyup="{this}">
                                                            </div>
                                                        </td>
                                                        <td class="cart-product-sub-total">
                                                            <span class="cart-sub-total-price"
                                                                data-subtotal="{{ $item->product->harga }}">{{ $item->jumlah * $item->product->harga }}</span>
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        @endforeach
                                        <tr>
                                            <td colspan="7">
                                                <div class="shopping-cart-btn">
                                                    <span class="">
                                                        <a href="#"
                                                            class="btn btn-upper btn-primary outer-left-xs">Continue
                                                            Shopping</a>
                                                        <button type="submit"
                                                            class="btn btn-upper btn-primary pull-right outer-right-xs">Update
                                                            shopping cart</button>
                                                    </span>
                                                </div><!-- /.shopping-cart-btn -->
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>

                            </table>

                            </form>

                        </div>
                    </div><!-- /.shopping-cart-table -->

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
