<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TugasPraktikum3Controller extends Controller
{
    public function index(Request $request)
    {   
        $transaksi = Transaksi::select('pelanggan.nama as nama_pelangagan','pelanggan.alamat','barang.nama','barang.harga')
                            ->join('pelanggan', 'pelanggan.id', '=', 'transaksi.id_pelanggan')
                            ->join('barang', 'barang.id', '=', 'transaksi.id_barang')
                            ->get();

        $query = Barang::select('id', 'nama','harga');
        
        if($request->has("search")){
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        
        $tugas_praktikum = $query->get();

        return view('0049', compact('tugas_praktikum', 'transaksi'));
    }

    public function create()
    {
        return view('P3_0049');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'nama'     => 'required',
            'harga'    => 'required|max:6'
        ]);
        
        $tugas_praktikum        = new Barang;
        $tugas_praktikum->nama  = $request->nama;
        $tugas_praktikum->harga = $request->harga;  
        
        if ($tugas_praktikum->save()) {
            alert()->html('Barang', "Berhasil", 'success');
        } else {
            alert()->html('Barang', "Gagal", 'error');
        }

        return redirect('tugas_praktikum3');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $tugas_praktikum = Barang::find($id);
        return view('P3_0049', compact('tugas_praktikum'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama'     => 'required',
            'harga'    => 'required|max:6'
        ]);

        $tugas_praktikum        = Barang::find($id);
        $tugas_praktikum->nama  = $request->nama;
        $tugas_praktikum->harga = $request->harga;  
        
        if ($tugas_praktikum->save()) {
            alert()->html('Barang', "Berhasil", 'success');
        } else {
            alert()->html('Barang', "Gagal", 'error');
        }

        return redirect('tugas_praktikum3');
    }

    public function destroy($id)
    {
        if (Barang::find($id)->delete()) {
            alert()->html('Barang', "Berhasil", 'success');
        } else {
            alert()->html('Barang', "Gagal", 'error');
        }

        return redirect()->back();
    }
}
