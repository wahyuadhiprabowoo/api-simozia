<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use Illuminate\Http\Request;

class FilterController extends Controller
{
  public function index(Request $request)
{
    $puskesmasList = Puskesmas::all();
    return view('filter', compact('puskesmasList'));
}
    // 
    public function getPosyandu(Request $request){
        $posyanduList = Posyandu::where("puskesmas_id", $request->id_puskesmas)->pluck('id','nama_posyandu');
        return response()->json($posyanduList);

    }
//     public function getPosyandu(Request $request, $puskesmasId)
// {
//     $posyanduList = Posyandu::where('puskesmas_id', $puskesmasId)->get();
    
//     return response()->json($posyanduList);
// }
public function getBalitaByPosyandu(Request $request)
{
    $puskesmasId = $request->input('puskesmas_id');
    $posyanduId = $request->input('posyandu_id');

    $balitaList = Balita::where('puskesmas_id', $puskesmasId)
        ->where('posyandu_id', $posyanduId)
        ->get();

    return response()->json($balitaList);
}
public function getPosyanduByPuskesmas(Request $request)
{
    $puskesmasId = $request->input('puskesmas_id');

    $posyanduList = Posyandu::where('puskesmas_id', $puskesmasId)->get();

    return response()->json($posyanduList);
}

}   
