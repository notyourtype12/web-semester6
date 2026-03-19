<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\master_berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $katakunci = $request->katakunci;
        $jumlahbaris = 10;

        if ($katakunci) {
            $databerita = master_berita::where('id_berita', 'like', "%$katakunci%")
                ->orWhere('judul', 'like', "%$katakunci%")
                ->orWhere('deskripsi', 'like', "%$katakunci%")
                ->paginate($jumlahbaris);
        } else {
            $databerita = master_berita::latest()->paginate($jumlahbaris);
        }

        return view('admin.berita.index', compact('databerita'));
    }

    public function create()
    {
        $tahun = now()->format('Y');
        $prefix = "B{$tahun}-";

        $last = master_berita::where('id_berita', 'like', "$prefix%")
            ->orderBy('id_berita', 'desc')
            ->first();

        $no = $last ? (int)substr($last->id_berita, strlen($prefix)) + 1 : 1;

        $idBerita = $prefix . str_pad($no, 4, '0', STR_PAD_LEFT);

        return view('admin.berita.create', compact('idBerita'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_berita' => 'required',
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        master_berita::create([
            'id_berita' => $request->id_berita,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'nik' => Auth::user()->nik,
        ]);

        return redirect('admin/berita')->with('success', 'Berhasil ditambahkan');
    }

    public function edit($id)
    {
        $databerita = master_berita::findOrFail($id);
        return view('admin.berita.edit', compact('databerita'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $berita = master_berita::findOrFail($id);

        $berita->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect('admin/berita')->with('success', 'Berhasil diupdate');
    }



    public function destroy($id)
    {
        $berita = master_berita::find($id);

        if ($berita) {

            // 🔥 ambil semua gambar dari deskripsi
            preg_match_all('/<img[^>]+src="([^">]+)"/', $berita->deskripsi, $matches);

            if (!empty($matches[1])) {
                foreach ($matches[1] as $imgUrl) {

                    // ambil path dari url
                    $path = str_replace(asset('storage') . '/', '', $imgUrl);

                    $fullPath = public_path('storage/' . $path);

                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                }
            }

            // hapus data
            $berita->delete();
        }

        return redirect('admin/berita')->with('success', 'Berhasil dihapus');
    }

    // UPLOAD IMAGE SUMMERNOTE
    public function uploadImage(Request $request) 
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');

            $filename = time().'_'.$file->getClientOriginalName();

            $path = $file->storeAs('artikel', $filename, 'public');

            return response()->json([
                'url' => asset('storage/'.$path)
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}