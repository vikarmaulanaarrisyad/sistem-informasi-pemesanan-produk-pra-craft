@extends('layouts.app')

@section('title', 'Pesanan Detail')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}"> Daftar Pesanan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')
    <div class="row">

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
                                @if ($orders->status == 'confirmed')
                                    Sedang dalam proses pengiriman
                                @endif

                                @if ($orders->status == 'pending')
                                    Sedang dalam proses packing
                                @endif
                            </a>
                        </li>
                    </ul>
                    @if ($orders->status == 'confirmed')
                        <a href="{{ route('orders.invoice', $orders->id) }}" class="btn btn-success btn-block"><b>Buat
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
                    </x-slot>
                    @foreach ($orderDetail as $item)
                        <tr>
                            <td width="10%">{{ $loop->iteration }}</td>
                            <td>{{ $item->product->nama_produk }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ format_uang($item->product->harga) }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-center text-bold">Jumlah</td>
                        <td>{{ format_uang($subTotal) }}</td>
                    </tr>
                </x-table>

                <x-slot name="footer">
                    @switch($orders->status)
                        @case('pending')
                            @if ($orders->user_id == auth()->id())
                                <button class="btn btn-secondary float-left"
                                    onclick="editForm('{{ route('orders.update_status', $orders->id) }}', 'canceled', 'Yakin ingin membatalkan pencairan terpilih?', 'secondary')">Batalkan</button>
                            @endif

                            @if (auth()->user()->hasRole('admin'))
                                <button class="btn btn-success float-right ml-2"
                                    onclick="editForm('{{ route('orders.update_status', $orders->id) }}', 'confirmed', 'Yakin ingin mengkonfirmasi pesanan terpilih?', 'success')">Konfirmasi</button>
                                <button class="btn btn-danger float-right"
                                    onclick="editForm('{{ route('orders.update_status', $orders->id) }}', 'not confirmed', 'Yakin ingin menolak pesanan terpilih?', 'danger')">Tolak</button>
                            @endif
                        @break

                        @case('canceled')
                            <span class="text-{{ $orders->statusColor() }}">
                                {{ ucfirst($orders->statusText()) }} oleh
                                @if (auth()->id() == $orders->user_id)
                                    Anda
                                @else
                                    {{ $orders->user->name }}
                                @endif
                            </span>
                        @break

                        @case('rejected')
                            <span class="text-{{ $orders->statusColor() }}">
                                {{ ucfirst($orders->statusText()) }} oleh Admin karena {{ $orders->reason_rejected }}
                            </span>
                        @break

                        @case('success')
                            <span class="text-{{ $orders->statusColor() }}">
                                Berhasil {{ ucfirst($orders->statusText()) }} oleh Admin
                            </span>
                        @break

                        @default
                    @endswitch
                </x-slot>
            </x-card>
        </div>

    </div>
    <div class="row">
        <div class="col-md-6">
            <x-card>

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

        <div class="form-group reason-rejected" style="display: none">
            <label for="reason_rejected">Alasan</label>
            <textarea name="reason_rejected" id="reason_rejected" rows="3" class="form-control"></textarea>
        </div>

        <x-slot name="footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
            <button type="button" class="btn btn-primary" onclick="submitForm(this.form)">Ya</button>
        </x-slot>
    </x-modal>
@endsection

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
            if (status == 'not confirmed') {
                $('.reason-rejected').show()
            } else {
                $('.reason-rejected').hide()
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
    </script>
@endpush
