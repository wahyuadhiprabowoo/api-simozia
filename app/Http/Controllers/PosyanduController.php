<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use Illuminate\Http\Request;

class PosyanduController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexApi($id_puskesmas)
    {
        //
        $posyandu = Posyandu::where('puskesmas_id', $id_puskesmas)->paginate(5);
          return response()->json([
          'status' => 'success',
        'message' => 'Data posyandu berdasarkan puskesmas berhasil ditemukan.',
        'data' => $posyandu->items(),
        'current_page' => $posyandu->currentPage(),
        'total' => $posyandu->total(),
        'per_page' => $posyandu->perPage(),
        'last_page' => $posyandu->lastPage(),
        'next_page_url' => $posyandu->nextPageUrl(),
        'prev_page_url' => $posyandu->previousPageUrl()
    ], 200);
        // $posyandu = Posyandu::paginate(10); // Menggunakan pagination dengan 10 item per halaman
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showApi($id, $id_puskesmas)
    {
        $posyandu = Posyandu::where('puskesmas_id', $id_puskesmas)->findOrFail($id);
          return response()->json([
        'status' => 'success',
        'message' => 'Detail dari posyandu berhasil ditemukan.',
        'data' => $posyandu
    ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
