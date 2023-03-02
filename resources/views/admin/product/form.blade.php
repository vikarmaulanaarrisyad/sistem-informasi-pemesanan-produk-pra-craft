<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah Data Kelas
    </x-slot>

    @method('POST')
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="nama_produk">Nama Produk</label>
                <input id="nama_produk" class="form-control" type="text" name="nama_produk" autocomplete="off">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="categories">Kategori</label>
                <select name="categories[]" id="categories" class="form-control select2" multiple="multiple">
                    @foreach ($category as $key => $item)
                        <option value="{{ $key }}">{{ $item }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" name="harga" class="form-control" min="0"
                    autocomplete="off" onkeyup="format_uang(this)"></input>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="stok">Stok</label>
                <input type="number" id="stok" name="stok" class="form-control" min="0"
                    autocomplete="off"></input>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" class="summernote"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <div class="custom-file">
                    <input type="file" name="gambar" class="custom-file-input" id="gambar"
                        onchange="preview('.preview-gambar', this.files[0])">
                    <label class="custom-file-label" for="gambar">Choose file</label>
                </div>
            </div>

            <img src="" class="img-thumbnail preview-gambar" id="img-thumbnail" style="display: none;"
                width="200px" height="200px">
        </div>
    </div>


    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-success" id="submitBtn">
            <span id="spinner-border" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
    </x-slot>

</x-modal>
