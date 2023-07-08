<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use Illuminate\Http\Request;

class PuskesmasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function all()
    {
        //semua data
        $all = Puskesmas::with('posyandu.balita')->paginate(5);
        // return response()->json(['data' => $all]);
      
        if($all->isEmpty()){
            return response()->json([
            'status' => 'error',
            "message" => 'data tidak ditemukan',
            ],404);
        }
            return response()->json([
            'status' => 'success',
            'message' => 'seluruh data berhasil ditemukan',
            'data' => $all->items(),
            'current_page' => $all->currentPage(),
            'total' => $all->total(),
            'per_page' => $all->perPage(),
            'last_page' => $all->lastPage(),
            'next_page_url' => $all->nextPageUrl(),
            'prev_page_url' => $all->previousPageUrl()
        ]);
    }
    public function indexApi()
    {
        //
        $puskesmas = Puskesmas::paginate(5);
            return response()->json([
        'status' => 'success',
        'message' => 'data puskesmas berhasil ditemukan',
        'data' => $puskesmas->items(),
        'current_page' => $puskesmas->currentPage(),
        'total' => $puskesmas->total(),
        'per_page' => $puskesmas->perPage(),
        'last_page' => $puskesmas->lastPage(),
        'next_page_url' => $puskesmas->nextPageUrl(),
        'prev_page_url' => $puskesmas->previousPageUrl()
        ]);
    }

    public function create()
{
    return view('/login');
}   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
 public function storeApi(Request $request)
    {
        $validatedData = $request->validate([
            'nama_puskesmas' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'sms_wa' => 'required',
        ]);

        $puskesmas = Puskesmas::create([
            'nama_puskesmas' => $validatedData['nama_puskesmas'],
            'alamat' => $validatedData['alamat'],
            'telepon' => $validatedData['telepon'],
            'sms_wa' => $validatedData['sms_wa'],
        ]);

        return response()->json([
            'message' => 'Puskesmas created successfully',
            'data' => $puskesmas
        ], 201);
    }

public function namaMethod()
{
    return view('welcome');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showApi($id)
    {
        //
        $puskesmas = Puskesmas::findOrFail($id);
        return response()->json($puskesmas);
    
    }
       public function showApiPuskespos()
    {
        //
        $puskesmas = Puskesmas::with('posyandu')->get();
        return response()->json($puskesmas);
    
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
