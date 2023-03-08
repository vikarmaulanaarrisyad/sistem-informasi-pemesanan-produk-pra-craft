@extends('layouts.app')

@section('title', 'Pesanan Detail')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}"> Daftar Pesanan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
    <div class="row">

        <div class="col-md-12">
            <x-card>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="font-weight-bold">PROVINSI TUJUAN</label>
                            <select class="form-control provinsi-tujuan" name="province_destination">
                                <option value="0">-- pilih provinsi tujuan --</option>
                                @foreach ($provinces as $province => $value)
                                    <option value="{{ $province }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">KOTA / KABUPATEN TUJUAN</label>
                            <select class="form-control kota-tujuan" name="city_destination">
                                <option value="">-- pilih kota tujuan --</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>PROVINSI TUJUAN</label>
                            <select class="form-control kurir" name="courier">
                                <option value="0">-- pilih kurir --</option>
                                <option value="jne">JNE</option>
                                <option value="pos">POS</option>
                                <option value="tiki">TIKI</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-weight-bold">BERAT (GRAM)</label>
                            <input type="number" class="form-control"   name="weight" id="weight"
                                placeholder="Masukkan Berat (GRAM)">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pilih hari</label>
                            <select class="form-control kurir" name="ongkir" id="ongkir">
                                <option value="">-- pilih hari --</option>
                            </select>
                        </div>
                    </div>
                </div>

                <x-slot name="footer">
                    <button class="btn btn-md btn-success btn-sm btn-check"><i class="fas fa-motorcycle"></i> Cek
                        Ongkir</button>
                    
                    <button  class="btn btn-md btn-primary btn-sm btn-add-ongkir"><i class="fas fa-plus-circle"></i> Tambah
                        Ongkir</button>
                </x-slot>
            </x-card>
        </div>


        <div class="col-md-6">
            <x-card>
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ asset('Templates/dist/img/user4-128x128.jpg') }}" alt="User profile picture">
                    </div>
                    <h3 class="profile-username text-center">{{ $orders->user->name }}</h3>
                    <p class="text-muted text-center">{{ $orders->user->email }}</p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Nomor Telepon</b> <a class="float-right">{{ $orders->user->telepon }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Alamat</b> <a class="float-right">{{ $orders->user->alamat }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Tanggal pesanan ini dibuat </b> <a class="float-right">
                                {{ tanggal_indonesia($orders->created_at) }} -
                                {{ date('H:i:s', strtotime($orders->created_at)) }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Status pesanan anda </b> <a class="float-right">
                                @if ($orders->status == 'success')
                                    Berhasil Dikonfirmasi pada tanggal
                                    {{ date('d-m-Y H:i', strtotime($orders->updated_at)) }}
                                @endif

                                @if ($orders->status == 'cancel')
                                    Pesanan dibatalkan
                                    {{ date('d-m-Y H:i', strtotime($orders->updated_at)) }}
                                @endif

                                @if ($orders->status == 'pending')
                                    @if (auth()->user()->hasRole('admin'))
                                        Sedang dalam proses approval oleh Anda
                                    @else
                                        Sedang dalam proses approval oleh Admin
                                    @endif
                                @endif
                            </a>
                        </li>
                    </ul>
                    @if ($orders->status == 'success')
                        <a href="{{ route('orders.invoice', $orders->id) }}" class="btn btn-success btn-block"><b><i
                                    class="fas fa-print"></i> Cetak
                                Invoice</b></a>
                    @endif
                </div>
            </x-card>
        </div>

        <div class="col-md-6">
            <x-card>
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Jumlah Beli</th>
                        <th>Harga</th>
                        <th>Jumlah Bayar</th>
                    </x-slot>
                    @foreach ($orderDetail as $item)
                        <tr>
                            <td width="10%">{{ $loop->iteration }}</td>
                            <td>{{ $item->product->nama_produk }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td class="text-right">{{ format_uang($item->product->harga) }}</td>
                            <td class="text-right">{{ format_uang($item->product->harga * $item->jumlah) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-bold text-right">Biaya Pengiriman</td>
                        <td class="text-right"> {{ format_uang($orders->ongkirs->biaya) }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-right text-bold">TOTAL Bayar</td>
                        <td class="text-right text-bold">{{ format_uang($subTotal +  $orders->ongkirs->biaya) }}</td>
                    </tr>
                </x-table>

                <input type="hidden" name="order_id" value="{{ $orders->id }}">

                <x-slot name="footer">
                    @switch($orders->status)
                        @case('pending')
                            @if ($orders->user_id == auth()->id())
                                <button class="btn btn-secondary float-left"
                                    onclick="editForm('{{ route('orders.update_status', $orders->id) }}', 'cancel', 'Yakin ingin membatalkan pencairan terpilih?', 'secondary')">Batalkan</button>

                                @if ($orders->shipping_cost_id != null)
                                    <button class="btn btn-primary float-right"
                                        onclick="editForm('{{ route('orders.update_status', $orders->id) }}', 'pending', 'Yakin ingin melanjutkan pesanan anda ?', 'success')">Bayar</button>
                                @endif
                            @endif

                            @if (auth()->user()->hasRole('admin'))
                                <button class="btn btn-secondary float-left"
                                    onclick="editForm('{{ route('orders.update_status', $orders->id) }}', 'cancel', 'Yakin ingin membatalkan pesanan terpilih?', 'secondary')">Batalkan</button>

                                <button class="btn btn-success float-right ml-2"
                                    onclick="editForm('{{ route('orders.update_status', $orders->id) }}', 'success', 'Yakin ingin mengkonfirmasi pesanan terpilih?', 'success')">Konfirmasi</button>
                            @endif
                        @break

                        @case('cancel')
                            <span class="text-{{ $orders->statusColor() }}">
                                {{ ucfirst($orders->statusText()) }} oleh
                                @if (auth()->id() == $orders->user_id)
                                    Anda
                                @else
                                    {{ $orders->user->name }}
                                @endif
                            </span>
                        @break

                        @case('alasan')
                            <span class="text-{{ $orders->statusColor() }}">
                                {{ ucfirst($orders->statusText()) }} oleh Admin karena {{ $orders->alasan }}
                            </span>
                        @break

                        @case('success')
                            @if (auth()->user()->hasRole('admin'))
                                <span class="text-{{ $orders->statusColor() }}">
                                    Berhasil {{ ucfirst($orders->statusText()) }} oleh Anda
                                </span>
                            @else
                                <span class="text-{{ $orders->statusColor() }}">
                                    Berhasil {{ ucfirst($orders->statusText()) }} oleh Admin
                                </span>
                            @endif
                        @break

                        @default
                    @endswitch
                </x-slot>
            </x-card>
        </div>
    </div>

    <x-modal size="modal-md">
        <x-slot name="title">Form Konfirmasi</x-slot>

        @method('put')

        <input type="hidden" name="status">

        <div class="alert mt-3">
            <i class="fas fa-info-circle mr-1"></i> <span class="text-message"></span>
        </div>

        <div class="form-group alasan" style="display: none">
            <label for="alasan">Alasan</label>
            <textarea name="alasan" id="alasan" rows="3" class="form-control"></textarea>
        </div>

        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" onclick="submitForm(this.form)">Ya</button>
        </x-slot>
    </x-modal>
@endsection

@include('layouts.includes.select2')

@push('scripts')
    <script>
        let modal = '#modal-form';

        function editForm(url, status, message, color) {
            $(modal).modal('show');
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('put');
            resetForm(`${modal} form`);

            $(`${modal} [name=status]`).val(status);
            $(`${modal} .text-message`).html(message);
            $(`${modal} .alert`).removeClass('alert-success alert-danger').addClass(`alert-${color}`);
            if (status == 'deny') {
                $('.alasan').show()
            } else {
                $('.alasan').hide()
            }
        }

        function submitForm(originalForm) {
            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    })
                    $('.card-footer').remove();

                    location.reload()
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }

        $(document).ready(function() {
            //active select2
            $(".provinsi-asal , .kota-asal, .provinsi-tujuan, .kota-tujuan").select2({
                theme: 'bootstrap4',
                width: 'style',
            });
            //ajax select kota asal
            $('select[name="province_origin"]').on('change', function() {
                let provindeId = $(this).val();
                if (provindeId) {
                    jQuery.ajax({
                        url: '/cities/' + provindeId,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="city_origin"]').empty();
                            $('select[name="city_origin"]').append(
                                '<option value="">-- pilih kota asal --</option>');
                            $.each(response, function(key, value) {
                                $('select[name="city_origin"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city_origin"]').append(
                        '<option value="">-- pilih kota asal --</option>');
                }
            });
            //ajax select kota tujuan
            $('select[name="province_destination"]').on('change', function() {
                let provindeId = $(this).val();
                if (provindeId) {
                    jQuery.ajax({
                        url: '/cities/' + provindeId,
                        type: "GET",
                        dataType: "json",
                        success: function(response) {
                            $('select[name="city_destination"]').empty();
                            $('select[name="city_destination"]').append(
                                '<option value="">-- pilih kota tujuan --</option>');
                            $.each(response, function(key, value) {
                                $('select[name="city_destination"]').append(
                                    '<option value="' + key + '">' + value +
                                    '</option>');
                            });
                        },
                    });
                } else {
                    $('select[name="city_destination"]').append(
                        '<option value="">-- pilih kota tujuan --</option>');
                }
            });
            //ajax check ongkir
            let isProcessing = false;
            $('.btn-check').click(function(e) {
                e.preventDefault();


                let token = $("meta[name='csrf-token']").attr("content");
                let city_origin = $('select[name=city_origin]').val();
                let city_destination = $('select[name=city_destination]').val();
                let courier = $('select[name=courier]').val();
                let weight = $('#weight').val();

                if (isProcessing) {
                    return;
                }

                isProcessing = true;
                jQuery.ajax({
                    url: "/ongkir",
                    data: {
                        _token: token,
                        city_origin: city_origin,
                        city_destination: city_destination,
                        courier: courier,
                        weight: weight,
                    },
                    dataType: "JSON",
                    type: "POST",
                    success: function(response) {
                        isProcessing = false;
                        if (response) {
                            $('#ongkir').empty();
                            $('.ongkir').addClass('d-block');
                            $.each(response[0]['costs'], function(key, value) {

                                $('#ongkir').append(
                                    '<option value="' + value.cost[0].value  + '">' + 'Rp. ' +
                                    value.cost[0].value + ' ' + value.cost[0].etd +
                                    ' hari' +
                                    '</option>');

                            });

                        }
                    }
                });

            });



            $('.btn-add-ongkir').click(function() {
                // e.preventDefault();
                let orderid = $('[name=ongkir]').val();
                let token = $("meta[name='csrf-token']").attr("content");
                let city_origin = $('select[name=city_origin]').val();
                let city_destination = $('select[name=city_destination]').val();
                let courier = $('select[name=courier]').val();
                let weight = $('#weight').val();
                let ongkir = $('[name=ongkir]').val();

                if (isProcessing) {
                    return;
                }

                isProcessing = true;
                jQuery.ajax({
                    url: '{{ route('orders.add_ongkir', $orders->id) }}',
                    data: {
                        _token: token,
                        city_origin: city_origin,
                        city_destination: city_destination,
                        courier: courier,
                        weight: weight,
                        ongkir: ongkir,
                    },
                    dataType: "JSON",
                    type: "POST",
                    success: function(response) {
                        isProcessing = false;
                        if (response.status = 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                showConfirmButton: false,
                                timer: 3000
                            })
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endpush
