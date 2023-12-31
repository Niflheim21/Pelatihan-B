<?php

namespace App\Http\Controllers;

use App\Models\Post;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //read data post
    public function tampil()
    {
        //query get data table post
        $data = Post::orderBy('id', 'ASC')->get();

        return view('post.index', compact('data'));
    }

    //update data post
    public function tambah()
    {
        return view('post.create');
    }

    //create data post
    public function simpan(Request $request)
    {
        //validasi
        $this->validate($request, [
            'judul' => 'required|min:3',
            'deskripsi' => 'required',
        ],[
            'judul.required' => 'Judul harus diisi',
            'judul.min' => 'Judul minimal 3 karakter',
            'deskrpsi.required' => 'Deskripsi harus diisi'
        ]);

        //query simpan
        Post::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('post.tampil')->with('success', 'Data berhasil disimpan');
    }

    //menampilkan form edit
    public function edit($id)
    {
        //querry gt id
        $data = Post::findOrFail($id);

        return view('post.edit', compact('data'));
    }

    //mengupdate data
    public function update(Request $request, $id)
    {
         //validasi
         $this->validate($request, [
            'judul' => 'required',
            'deskripsi' => 'required',
        ]);

        $data = Post::findOrFail($id);

        //query simpan
        $data->update([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('post.tampil')->with('success', 'Data berhasil diupdate');
    }

    //hapus data
    public function hapus($id)
    {
        $data = Post::findOrFail($id);
        $data->delete();

        return redirect()->route('post.tampil')->with('success', 'Data berhasil dihapus');
    }
}
