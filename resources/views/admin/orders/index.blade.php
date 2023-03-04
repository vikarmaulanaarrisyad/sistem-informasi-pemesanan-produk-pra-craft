@extends('layouts.app')

@section('title', 'Pesanan')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Pesanan</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>

                <div class="d-flex justify-content-between">
                    <div class="form-group">
                        <label for="status2">Status</label>
                        <select name="status2" id="status2" class="custom-select">
                            <option value="" selected>Semua</option>
                            <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Konfirmasi
                            </option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="cancel" {{ request('status') == 'cancel' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                    </div>

                    <div class="d-flex">
                        <div class="form-group mx-3">
                            <label for="start_date2">Tanggal Awal</label>
                            <div class="input-group datepicker" id="start_date2" data-target-input="nearest">
                                <input type="text" name="start_date2" class="form-control datetimepicker-input"
                                    data-target="#start_date2" />
                                <div class="input-group-append" data-target="#start_date2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end_date2">Tanggal Akhir</label>
                            <div class="input-group datepicker" id="end_date2" data-target-input="nearest">
                                <input type="text" name="end_date2" class="form-control datetimepicker-input"
                                    data-target="#end_date2" />
                                <div class="input-group-append" data-target="#end_date2" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <x-table class="tabel-categories">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Tanggal Pesanan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    {{-- @includeIf('admin.orders.form') --}}
@endsection

@include('layouts.includes.datatables')
@include('layouts.includes.summernote')
@include('layouts.includes.select2')
@include('layouts.includes.datepicker')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let button = '#submitBtn';
        let table;

        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('data.order') }}',
                data: function(d) {
                    d.status = $('[name=status2]').val();
                    d.start_date = $('[name=start_date2]').val();
                    d.end_date = $('[name=end_date2]').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nama'
                },
                {
                    data: 'tanggal'
                },
                {
                    data: 'status'
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ]
        });

        $('[name=status2]').on('change', function() {
            table.ajax.reload();
        });
        $('.datepicker').on('change.datetimepicker', function() {
            table.ajax.reload();
        });

        function addForm(url, title = 'Tambah Produk') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('POST');
            $('#spinner-border').hide();
            $(button).prop('disabled', false);

            resetForm(`${modal} form`);


            $('#categories').val('').trigger('change');
        }

        function editForm(url, title = 'Edit Produk') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('PUT');
                    resetForm(`${modal} form`);
                    loopForm(response.data);
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    $('[name=harga]').val(format_uang(response.data.harga));

                    let selectedCategories = [];
                    response.data.categories.forEach(item => {
                        selectedCategories.push(item.id);
                    });

                    $('#categories')
                        .val(selectedCategories)
                        .trigger('change');
                })
                .fail(errors => {
                    Swall.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });

                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                });
        }

        function submitForm(originalForm) {
            $(button).prop('disabled', true);
            $('#spinner-border').show();

            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }

                    $(button).prop('disabled', false);
                    $('#spinner-border').hide();

                    table.ajax.reload();
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }

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

    <script type="text/javascript">
        $(function() {
            $('#spinner-border').hide();
            // categories
            $('#categories').select2({
                placeholder: 'Pilih Kategori',
                ajax: {
                    url: "{{ route('api.search.category') }}",
                    type: 'get',
                    dataType: 'json',
                    delay: 200,
                    processResults: function(response) {
                        return {
                            results: response.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.nama_kategori
                                }
                            })
                        };
                    },
                    cache: false
                }
            });
        });
    </script>
@endpush
