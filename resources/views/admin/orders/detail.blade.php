@extends('layouts.app')

@section('title', 'Pesanan Detail')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}"> Daftar Pesanan</a></li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-md">
            <x-card>
                <div class="row">
                    <div class="col-md-4 text-center">
                        <h5>Nama Pemesan <b>{{ $orders->user->name }}</b></h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Dibuat pada <b>{{ tanggal_indonesia($orders->tgl_pesanan, true) }}</b></h5>
                    </div>
                    <div class="col-md-4">
                        <h5>Status pesanan <strong>{{ $orders->statusText() }}</strong></h5>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
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
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->product->nama_produk }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ $item->harga }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-center text-bold">Jumlah</td>
                        <td>{{ $item->order->total_harga }}</td>
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

        function editForm(url, status, message, color, product) {
            $(modal).modal('show');
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('put');
            resetForm(`${modal} form`);

            $(`${modal} [name=status]`).val(status);
            $(`${modal} .text-message`).html(message);
            $(`${modal} .alert`).removeClass('alert-success alert-danger').addClass(`alert-${color}`);
            if (status == 'rejected') {
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
