@extends('admin.layout.main')
@section('title', 'Tambah Berita')

@section('content')

<section class="section">

    <div class="section-header">
        <h1>Tambah Berita</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                        {{-- FORM TAMBAH BERITA --}}
                        <form action="{{ url('admin/berita') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="p-3 bg-body rounded mx-4 mt-4">

                                {{-- TOMBOL KEMBALI --}}
                                <a href="{{ url('admin/berita') }}" class="btn btn-outline-primary">
                                ← Kembali
                                </a>
                                {{-- ID BERITA --}}
                                <div class="mb-3 row mt-4">
                                    <label class="col-sm-2 col-form-label">
                                        ID Berita
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="id_berita" value="{{ $idBerita }}" class="form-control" readonly>
                                    </div>
                                </div>


                                {{-- JUDUL --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">
                                        Judul Berita
                                    </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="judul" id="judul" class="form-control" required>
                                    </div>
                                </div>


                                {{-- DESKRIPSI --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <textarea id="summernote" name="deskripsi" class="summernote"></textarea>
                                    </div>
                                </div>

                                {{-- TOMBOL SIMPAN --}}
                                <div class="mb-3 row">
                                    <div class="col-sm-10 offset-sm-2">
                                        <button type="submit" class="btn btn-primary">
                                            SIMPAN
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function(){

    $('#summernote').summernote({
    height: 300,
    dialogsInBody: true, // 🔥 WAJIB
    callbacks: {
        onImageUpload: function(files) {
            uploadImage(files[0]);
        }
    }
});

    function uploadImage(file) {

        let data = new FormData();
        data.append("file", file);

        $.ajax({
            url: "{{ route('upload.image') }}",
            method: "POST",
            data: data,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                $('#summernote').summernote('insertImage', res.url);
            },
            error: function(err) {
                alert('Upload gagal');
            }
        });
    }

});

</script>

@endsection