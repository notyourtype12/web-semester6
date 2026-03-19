@extends('admin.layout.main')
@section('title', 'Berita')

@section('content')

<section class="section">

   <div class="section-header">
        <h1>Master Berita</h1>
    </div>
    @if(session('success'))
    <div id="alertPopup" class="alert alert-success alert-floating">
        {{ session('success') }}
    </div>
    @endif

    <div class="section-body">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    {{-- CARD HEADER --}}
                    <div class="card-header d-flex justify-content-between">

                        {{-- FORM SEARCH --}}
                        <form class="d-flex" action="{{ url('admin/berita') }}" method="get">
                            <input class="form-control me-2"
                                   type="search"
                                   name="katakunci"
                                   value="{{ Request::get('katakunci') }}"
                                   placeholder="Cari..."
                                   autocomplete="off">

                            <button class="btn btn-outline-primary">
                                Cari
                            </button>
                        </form>

                        {{-- TOMBOL TAMBAH --}}
                        <a href="{{ url('admin/berita/create') }}"
                           class="btn btn-primary">
                            + Tambah Data
                        </a>

                    </div>


                    {{-- CARD BODY --}}
                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-striped">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Gambar</th>
                                        <th>Deskripsi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @php
                                        $i = $databerita->firstItem();
                                    @endphp

                                    @forelse ($databerita as $item)

                                    <tr>

                                        <td>
                                            {{ $i }}
                                        </td>

                                        <td style="width: 30%" >
                                            {{ $item->judul }}
                                        </td>

                                        <td>

                                            <img src="{{ asset('storage/imageberita/'.$item->image) }}" class="border"
                                                 style="width:200px; height:auto;">
                                        </td>

                                        <td style="width: 30%" >

                                            @php
                                                $words = explode(' ', strip_tags($item->deskripsi));
                                            @endphp

                                            @if(count($words) > 50)
                                                {{ implode(' ', array_slice($words,0,50)) }}...
                                            @else
                                                {{ $item->deskripsi }}
                                            @endif

                                        </td>
                                        {{-- AKSI --}}
                                        <td>
                                            {{-- EDIT --}}
                                            <a href="{{ url('admin/berita/'.$item->id_berita.'/edit') }}" class="btn btn-warning btn-sm me-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            {{-- DELETE --}}
                                            <form id="formHapus{{ $item->id_berita }}"
                                                  class="d-inline"
                                                  action="{{ url('admin/berita/'.$item->id_berita) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                        class="btn btn-danger btn-sm btnHapus"
                                                        data-id="{{ $item->id_berita }}"
                                                        data-nama="{{ $item->judul }}">

                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @php $i++ @endphp
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            Belum ada data
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{-- PAGINATION --}}
                        {{ $databerita->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SWEET ALERT DELETE --}}
<script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('assets/js/page/modules-sweetalert.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){

    const hapusButtons = document.querySelectorAll('.btnHapus');

    hapusButtons.forEach(button => {

        button.addEventListener('click', function(e){

            e.preventDefault();

            const id   = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');

            swal({
                title: "Yakin ingin menghapus?",
                text: `Data berita dengan judul "${nama}" akan dihapus!`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {

                if (willDelete) {

                    // 🔥 alert sukses tanpa tombol
                    swal({
                        title: "Berhasil!",
                        text: "Data berhasil dihapus",
                        icon: "success",
                        buttons: false, // ❌ tidak ada tombol
                        timer: 3000     // ⏱ auto close 3 detik
                    });

                    // submit setelah sedikit delay
                    setTimeout(() => {
                        document.getElementById('formHapus' + id).submit();
                    }, 500);

                }

            });

        });

    });

});
</script>

@endsection