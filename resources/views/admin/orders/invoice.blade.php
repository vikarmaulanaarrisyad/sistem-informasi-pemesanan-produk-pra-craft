@extends('layouts.app')

@section('title', 'Pesanan Detail')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}"> Daftar Pesanan</a></li>
    <li class="breadcrumb-item active">Invoice</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="callout callout-info">
                <h5><i class="fas fa-info"></i> Note:</h5>
                This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
            </div>

            <div class="invoice p-3 mb-3">

                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> {{ config('app.name') }}
                            <small class="float-right">Date: {{ date('d/m/Y', strtotime($orders->tgl_pesanan)) }}</small>
                        </h4>
                    </div>

                </div>

                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>{{ auth()->user()->name }}</strong><br>
                            {{ auth()->user()->alamat }}<br>
                            Phone: {{ auth()->user()->telepon }}<br>
                            Email: {{ auth()->user()->email }}
                        </address>
                    </div>

                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>{{ $orders->user->name }}</strong><br>
                            {{ $orders->user->alamat }}<br>
                            Phone: {{ $orders->user->telepon }}<br>
                            Email: {{ $orders->user->email }}
                        </address>
                    </div>

                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #007612</b><br>
                        <br>
                        <b>Order ID:</b> {{ $orders->id }}<br>
                        <b>Payment Due:</b> 2/22/2014<br>
                        <b>Account:</b> 968-34567
                    </div>

                </div>


                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Serial #</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orderDetail as $item)
                                    <tr>
                                        <td>{{ $item->product->nama_produk }}</td>
                                        <td>455-981-221</td>
                                        <td>{{ $item->product->deskripsi }}</td>
                                        <td>{{ $item->jumlah }}</td>
                                        <td>{{ format_uang($item->product->harga) }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="row">

                    <div class="col-6">
                        <p class="lead">Payment Methods:</p>
                        <img src="{{ asset('Templates') }}/dist/img/credit/visa.png" alt="Visa">
                        <img src="{{ asset('Templates') }}/dist/img/credit/mastercard.png" alt="Mastercard">
                        <img src="{{ asset('Templates') }}/dist/img/credit/american-express.png" alt="American Express">
                        <img src="{{ asset('Templates') }}/dist/img/credit/paypal2.png" alt="Paypal">
                        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango
                            imeem
                            plugg
                            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                        </p>
                    </div>

                    <div class="col-6">
                        <p class="lead">Amount Due 2/22/2014</p>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>{{ format_uang($orders->total_harga) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diskon</th>
                                        <td>0</td>
                                    </tr>
                                    <tr>
                                        <th>Ongkos Kirim:</th>
                                        <td>2.000</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>{{ format_uang($orders->total_harga + 2000) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>


                <div class="row no-print">
                    <div class="col-12">
                        <a href="{{ route('orders.print_invoice', $orders->id) }}" rel="noopener" target="_blank" class="btn btn-success"><i
                                class="fas fa-print"></i> Print</a>
                        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                            Payment
                        </button>
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
