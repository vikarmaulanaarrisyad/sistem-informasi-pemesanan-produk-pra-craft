<x-modal data-backdrop="static" data-keyboard="false">
    <x-slot name="title">
        Tambah Data Kelas
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="nama_kategori">Kategori</label>
                <input id="nama_kategori" class="form-control" type="text" name="nama_kategori" autocomplete="off">
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-success" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
    </x-slot>

</x-modal>
