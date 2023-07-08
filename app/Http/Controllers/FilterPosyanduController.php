<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\Puskesmas;
use Illuminate\Http\Request;

class FilterPosyanduController extends Controller
{
    public function index(){
    $puskesmasList = Puskesmas::all();
        return view("posyandu", compact('puskesmasList'));
    }
    public function getPosyanduByPuskesmas(Request $request)
{
    $puskesmasId = $request->input('puskesmas_id');

    $posyanduList = Posyandu::where('puskesmas_id', $puskesmasId)->get();

    return response()->json($posyanduList);
}
    public function store(Request $request)
{
    $posyandu = new Posyandu();
    $posyandu->nama_posyandu = $request->input('nama_posyandu');
    $posyandu->alamat = $request->input('alamat');
    $posyandu->kelurahan = $request->input('kelurahan');
    $posyandu->kecamatan = $request->input('kecamatan');
    $posyandu->puskesmas_id = $request->input('puskesmas_id'); // Ambil nilai puskesmas_id dari form
    $posyandu->save();

    return redirect()->back()->with('success', 'Posyandu berhasil ditambahkan.');
}
public function delete(Request $request)
{
    $puskesmasId = $request->input('puskesmas_id');
    $posyanduId = $request->input('posyandu_id');

    // Hapus posyandu berdasarkan puskesmas ID dan posyandu ID
    Posyandu::where('puskesmas_id', $puskesmasId)
            ->where('id', $posyanduId)
            ->delete();

    return response()->json(['success' => true]);
}
// get detail
public function get(Request $request)
{
    $puskesmasId = $request->input('puskesmas_id');
    $posyanduId = $request->input('posyandu_id');

    $posyandu = Posyandu::where('puskesmas_id', $puskesmasId)
                        ->where('id', $posyanduId)
                        ->first();

    return response()->json($posyandu);

}
// update posyandu
public function update(Request $request)
{
    $puskesmasId = $request->input('puskesmas_id');
    $posyanduId = $request->input('posyandu_id');

    // Temukan posyandu berdasarkan puskesmas ID dan posyandu ID
    $posyandu = Posyandu::where('puskesmas_id', $puskesmasId)
                        ->where('id', $posyanduId)
                        ->first();

    // Perbarui data posyandu dengan input yang diterima dari permintaan
    $posyandu->nama_posyandu = $request->input('nama_posyandu');
    $posyandu->alamat = $request->input('alamat');
    // Lakukan perbaruan untuk kolom-kolom lainnya sesuai kebutuhan

    // Simpan perubahan data posyandu
    $posyandu->save();

    // Redirect atau berikan respon sukses
    // return redirect()->back()->with('success', 'Data posyandu berhasil diperbarui');
    return response()->json(['success' => true]);
}
}
