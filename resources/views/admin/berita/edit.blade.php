@extends('admin.layout.main')
@section('title', 'Edit Berita')

@section('content')
<section class="section">

    <div class="section-header">
        <h1>Edit Berita</h1>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <!-- FORM -->
                    <form action="{{ url('admin/berita/' . $databerita->id_berita) }}" 
                          method="POST" 
                          enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="p-3 bg-body rounded mx-4 mt-4">

                            <!-- BUTTON BACK -->
                            <a href="{{ url('admin/berita') }}" class="btn btn-outline-primary">
                                ← Kembali
                            </a>

                            <!-- ID (HIDDEN) -->
                            <input type="hidden" name="id_berita" value="{{ $databerita->id_berita }}">

                            <!-- JUDUL -->
                            <div class="mb-3 row mt-4">
                                <label class="col-sm-2 col-form-label">Judul Berita</label>
                                <div class="col-sm-10">
                                    <input type="text" 
                                           name="judul" 
                                           class="form-control"
                                           value="{{ $databerita->judul }}" 
                                           required>
                                </div>
                            </div>

                            <!-- DESKRIPSI (SUMMERNOTE) -->
                            <div class="mb-3 row">
                                <label class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea id="summernote" name="deskripsi">
                                        {!! $databerita->deskripsi !!}
                                    </textarea>
                                </div>
                            </div>

                            <!-- SUBMIT -->
                            <div class="mb-3 row">
                                <div class="col-sm-10 offset-sm-2">
                                    <button class="btn btn-primary">SIMPAN</button>
                                </div>
                            </div>

                        </div>
                    </form>
                    <!-- END FORM -->

                </div>
            </div>
        </div>
    </div>

</section>

{{-- JQUERY --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- SUMMERNOTE --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
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