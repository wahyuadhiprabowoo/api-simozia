<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use Illuminate\Http\Request;
use Carbon\Carbon;
class BalitaController extends Controller
{
    // balita berdasarkan id posyandu
    public function indexFromPosyandu($posyanduId){
          $balitas = Balita::join('posyandu', 'balita.posyandu_id', '=', 'posyandu.id')
            ->join('puskesmas', 'posyandu.puskesmas_id', '=', 'puskesmas.id')
            ->where('posyandu.id', $posyanduId)
            ->select('balita.*')
            ->get();

        return response()->json($balitas);
    }
    // balita demgam posyandu
     public function index()
    {
        $balitas = Balita::with('posyandu')->get();
        
        return response()->json($balitas);
    }
  
    // balita dengan id_puskesmas dan id_posyandu
    public function indexApi($id_puskesmas, $id_posyandu)
    {
         // Dapatkan data balita berdasarkan ID puskesmas dan posyandu yang diberikan
        $balitas = Balita::where('puskesmas_id', $id_puskesmas)
            ->where('posyandu_id', $id_posyandu)
            ->paginate(5);
            if($balitas->isEmpty()){
            return response()->json([
            'status' => 'error',
            "message" => 'data balita tersebut tidak ditemukan',
            ],404);
        }
            return response()->json([
        'status' => 'success',
        'message' => 'data balita berhasil ditemukan',
        'data' => $balitas->items(),
        'current_page' => $balitas->currentPage(),
        'total' => $balitas->total(),
        'per_page' => $balitas->perPage(),
        'last_page' => $balitas->lastPage(),
        'next_page_url' => $balitas->nextPageUrl(),
        'prev_page_url' => $balitas->previousPageUrl()
    ]);
    }
             public function showApi(Request $request, $id_puskesmas, $id_posyandu, $id_balita)
    {
           // Cek apakah balita terkait dengan ID puskesmas dan posyandu yang diberikan
        $balita = Balita::where('puskesmas_id', $id_puskesmas)
            ->where('posyandu_id', $id_posyandu)
            ->findOrFail($id_balita);
          return response()->json([
        'status' => 'success',
        'message' => 'Detail dari balita berhasil ditemukan.',
        'data' => $balita
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
      public function storeApi(Request $request, $id_puskesmas, $id_posyandu)
    {
        $validatedData = $request->validate([
            'nama_anak' => 'required',
            'nama_ibu' => 'required',
            'alamat' => 'required',
            'umur' => 'required',
            'tanggal_lahir' => 'required',
            'berat_badan' => 'required',
            'panjang_badan' => 'required',
            'detak_jantung' => 'required',
            'zscore_berat_badan' => 'required',
            'zscore_panjang_badan' => 'required',
            'klasifikasi_berat_badan' => 'required',
            'klasifikasi_panjang_badan' => 'required',
            'klasifikasi_detak_jantung' => 'sometimes|nullable',
            'jenis_kelamin' => 'required',
            'detak_jantung' => 'sometimes|nullable',
            'sistolik' => 'sometimes|nullable',
            'diastolik' => 'sometimes|nullable',
        ]);
        // Lakukan penyimpanan balita dengan mengakses $id_puskesmas dan $id_posyandu
        $balita = Balita::create([
            'nama_anak' => $validatedData['nama_anak'],
            'jenis_kelamin' => $validatedData['jenis_kelamin'],
            'nama_ibu' => $validatedData['nama_ibu'],
            'umur' => $validatedData['umur'],
            'tanggal_lahir' => $validatedData['tanggal_lahir'],
            'alamat' => $validatedData['alamat'],
            'berat_badan' => $validatedData['berat_badan'],
            'panjang_badan' => $validatedData['panjang_badan'],
            'detak_jantung' => $validatedData['detak_jantung'],
            'zscore_berat_badan' => $validatedData['zscore_berat_badan'],
            'zscore_panjang_badan' => $validatedData['zscore_panjang_badan'],
            'klasifikasi_berat_badan' => $validatedData['klasifikasi_berat_badan'],
            'klasifikasi_panjang_badan' => $validatedData['klasifikasi_panjang_badan'],
            'klasifikasi_detak_jantung' => $request->input('klasifikasi_detak_jantung', "-"),
            'detak_jantung' => $request->input('detak_jantung', 0),
            'sistolik' => $request->input('sistolik', 0),
            'diastolik' => $request->input('diastolik', 0),
            'puskesmas_id' => $id_puskesmas,
            'posyandu_id' => $id_posyandu,
        ]);

        return response()->json([
            'message' => 'Balita berhasil ditambahkan.',
            'data' => $balita
        ], 201);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateApi(Request $request, $id_puskesmas, $id_posyandu, $id_balita)
    {
        // Cek apakah balita terkait dengan ID puskesmas dan posyandu yang diberikan
        $balita = Balita::where('puskesmas_id', $id_puskesmas)
            ->where('posyandu_id', $id_posyandu)
            ->findOrFail($id_balita);

        // Update data balita dengan data yang diberikan dalam permintaan
        // Validasi data yang diterima dari permintaan
        $validatedData = $request->validate([
            'nama_ibu' => 'sometimes|required',
            'nama_anak' => 'sometimes|required',
            'alamat' => 'sometimes|required',
            'jenis_kelamin' => 'sometimes|required',
            'umur' => 'sometimes|required|integer',
            'tanggal_lahir' => 'sometimes|required|date',
            'berat_badan' => 'sometimes|required',
            'panjang_badan' => 'sometimes|required',
            'zscore_berat_badan' => 'sometimes|required',
            'zscore_panjang_badan' => 'sometimes|required',
            'klasifikasi_berat_badan' => 'sometimes|required',
            'klasifikasi_panjang_badan' => 'sometimes|required',
            'klasifikasi_detak_jantung' => 'sometimes|nullable',
            'detak_jantung' => 'sometimes|nullable',
            'sistolik' => 'sometimes|nullable',
            'diastolik' => 'sometimes|nullable',
            'posyandu_id' => 'sometimes|required|integer',
            'puskesmas_id' => 'sometimes|required|integer',
        ]);

        // Perbarui nilai-nilai data dengan nilai baru dari permintaan
        $balita->update($validatedData);
        return response()->json([
            'message' => 'Data balita berhasil diupdate.',
            'data' => $balita
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyApi($id_puskesmas, $id_posyandu, $id_balita)
    {
        // Cek apakah balita terkait dengan ID puskesmas dan posyandu yang diberikan
        $balita = Balita::where('puskesmas_id', $id_puskesmas)
            ->where('posyandu_id', $id_posyandu)
            ->findOrFail($id_balita);

        $balita->delete();

        return response()->json([
            'message' => 'Data balita berhasil dihapus.'
        ]);
    }
    // filtering api single
    public function filterByKlasifikasiPanjangBadan($id_puskesmas, $id_posyandu, $klasifikasi_panjang_badan){
        // Dapatkan data balita berdasarkan kategori yang diberikan
         $balitas = Balita::where('puskesmas_id', $id_puskesmas)
         ->where('posyandu_id', $id_posyandu)
         ->where('klasifikasi_panjang_badan', $klasifikasi_panjang_badan)
         ->paginate(5);
        if ($balitas->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data balita dengan filter yang diberikan tidak ditemukan.'
        ], 404);
    }
        return response()->json([
            'data' => $balitas,
            'status' => 'success',
            'message' => 'filter berdasarkan klasifikasi panjang badan berhasil'
        ], 200);
    }   
    // klasifikasi berat badan
     public function filterByKlasifikasiBeratBadan($id_puskesmas, $id_posyandu, $klasifikasi_berat_badan){
        // Dapatkan data balita berdasarkan kategori yang diberikan
         $balitas = Balita::where('puskesmas_id', $id_puskesmas)
         ->where('posyandu_id', $id_posyandu)
         ->where('klasifikasi_berat_badan', $klasifikasi_berat_badan)
         ->paginate(5);
        if ($balitas->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data balita dengan filter yang diberikan tidak ditemukan.'
        ], 404);
    }
        return response()->json([
            'data' => $balitas,
            'status' => 'success',
            'message' => 'filter berdasarkan klasifikasi berat badan berhasil'
        ], 200);
    }   
    // klasifikasi detak jantung
    public function filterByKlasifikasiDetakJantung($id_puskesmas, $id_posyandu, $klasifikasi_detak_jantung){
        // Dapatkan data balita berdasarkan kategori yang diberikan
         $balitas = Balita::where('puskesmas_id', $id_puskesmas)
         ->where('posyandu_id', $id_posyandu)
         ->where('klasifikasi_detak_jantung', $klasifikasi_detak_jantung)
         ->paginate(5);
        if ($balitas->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data balita dengan filter yang diberikan tidak ditemukan.'
        ], 404);
    }
        return response()->json([
            'data' => $balitas,
            'status' => 'success',
            'message' => 'filter berdasarkan klasifikasi detak jantung berhasil'
        ], 200);
    }   
    // filtering create/at
    public function filterByKlasifikasiCreatedAt($id_puskesmas, $id_posyandu, Request $request){
        // Dapatkan data balita berdasarkan kategori yang diberikan
        $today = Carbon::today();

        // Filter balita berdasarkan ID puskesmas, ID posyandu, dan tanggal pembuatan
        $balitas = Balita::where('puskesmas_id', $id_puskesmas)
            ->where('posyandu_id', $id_posyandu)
            ->whereDate('created_at', $today)->get();

        if ($balitas->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data balita dengan filter yang diberikan tidak ditemukan.'
        ], 404);
    }
        return response()->json([
            'data' => $balitas,
            'status' => 'success',
            'message' => 'filter berdasarkan klasifikasi detak jantung berhasil'
        ], 200);
    }     
    // filtering berat,detak,panjang,create_at query params
    public function filteringQuery(Request $request){
     $query = Balita::query();

        // Filter berdasarkan query parameter puskesmas_id
        if ($request->has('puskesmas_id')) {
            $query->where('puskesmas_id', $request->input('puskesmas_id'));
        }

        // Filter berdasarkan query parameter posyandu_id
        if ($request->has('posyandu_id')) {
            $query->where('posyandu_id', $request->input('posyandu_id'));
        }

        // Filter berdasarkan query parameter klasifikasi_panjang_badan
        if ($request->has('klasifikasi_panjang_badan')) {
            $query->where('klasifikasi_panjang_badan', $request->input('klasifikasi_panjang_badan'));
        }

        // Filter berdasarkan query parameter klasifikasi_berat_badan
        if ($request->has('klasifikasi_berat_badan')) {
            $query->where('klasifikasi_berat_badan', $request->input('klasifikasi_berat_badan'));
        }

        // Filter berdasarkan query parameter klasifikasi_detak_jantung
        if ($request->has('klasifikasi_detak_jantung')) {
            $query->where('klasifikasi_detak_jantung', $request->input('klasifikasi_detak_jantung'));
        }

        // Filter berdasarkan query parameter create_at (tanggal pembuatan)
        if ($request->has('created_at')) {
            $query->whereDate('created_at', $request->input('created_at'));
        }

        // Eksekusi query dan ambil data balita

        $balitas = $query->get();
           if ($balitas->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Data balita dengan filter yang diberikan tidak ditemukan.'
        ], 404);
        }
        return response()->json([
            'data' => $balitas,
            'status' => 'success',
            'message' => 'filter data berhasil'
        ], 200);
}
}
