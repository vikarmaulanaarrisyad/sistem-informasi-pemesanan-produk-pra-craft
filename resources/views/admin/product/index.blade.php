@extends('layouts.app')

@section('title', 'Produk')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Produk</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('product.store') }}`)" class="btn btn-success float-right mr-3"><i
                            class="fas fa-plus-circle"></i> Tambah Data</button>
                </x-slot>
                <x-table class="tabel-categories">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Gambar</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @includeIf('admin.product.form')
@endsection

@include('layouts.includes.datatables')
@include('layouts.includes.summernote')
@include('layouts.includes.select2')

@push('scripts')
    <script>
        let modal = '#modal-form';
        let button = '#submitBtn';
        let table;

        table = $('.table').DataTable({
            processing: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('api.data.product') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    searchable: false,
                    sortable: false
                },
                {
                    data: 'nama_produk'
                },
                {
                    data: 'deskripsi'
                },
                {
                    data: 'harga'
                },
                {
                    data: 'stok'
                },
                {
                    data: 'gambar'
                },
                {
                    data: 'aksi',
                    sortable: false,
                    searchable: false
                },
            ]
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
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    $('[name=harga]').val(format_uang(response.data.harga));

                    // let selectedCategories = [];
                    // response.data.categories.forEach(item => {
                    //     selectedCategories.push(item.id);
                    // });
                    // $('#categories')
                    //     .val(selectedCategories)
                    //     .trigger('change');

                    response.data.categories.forEach(function(category) {
                        var option1 = new Option(category.nama_kategori, category.id, true, true);
                        $('#categories').append(option1).trigger('change');
                    });

                    resetForm(`${modal} form`);
                    loopForm(response.data);
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
                    url: "{{ route('api.search.product') }}",
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
