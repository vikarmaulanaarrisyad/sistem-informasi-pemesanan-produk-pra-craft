@extends('layouts.app')

@section('title', 'Laporan Transaksi ' . tanggal_indonesia($start) . ' s/d ' . tanggal_indonesia($end))
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Laporan</li>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <div class="btn-group">
                        <button data-toggle="modal" data-target="#modal-form" class="btn btn-success"><i
                                class="fas fa-pencil-alt"></i> Ubah Periode</button>
                        <a target="_blank" href="{{ route('report.export_pdf', compact('start', 'end')) }}"
                            class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export PDF</a>
                        {{-- <a target="_blank" href="{{ route('report.export_excel', compact('start', 'end')) }}" class="btn btn-success"><i class="fas fa-file-excel"></i> Export Excel</a> --}}
                    </div>
                </x-slot>

                <div class="row">
                    <div class="col-md-12">

                        <x-table>
                            <x-slot name="thead">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Produk</th>
                                <th>Stok</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </x-slot>
                        </x-table>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    @include('admin.report.form')
@endsection

@include('layouts.includes.datepicker')
@include('layouts.includes.datatables')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let table;
        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('report.data', compact('start', 'end')) }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false,
                    className: 'text-center'
                },
                {
                    data: 'tanggal',
                    searchable: false,
                    sortable: false,
                    className: 'text-left'
                },
                {
                    data: 'product',
                    searchable: false,
                    sortable: false,
                    className: 'text-left'
                },
                {
                    data: 'stok',
                    searchable: false,
                    sortable: false,
                },
                {
                    data: 'qty',
                    searchable: false,
                    sortable: false,
                    className: 'text-center'
                },
                {
                    data: 'harga',
                    searchable: false,
                    sortable: false,
                    className: 'text-right'

                },

                {
                    data: 'subtotal',
                    searchable: false,
                    sortable: false,
                    className: 'text-right'

                },
            ],
            paginate: false,
            searching: false,
            bInfo: false,
            order: []
        });
    </script>
@endpush
