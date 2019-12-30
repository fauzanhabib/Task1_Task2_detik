<?php

namespace App\Http\Controllers;

use App\User;
use App\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Retrieve the user for the given ID.
     *
     * @param  int  $id
     * @return Response
     */

    public function index()
        {
            $inven = inventory::all();
            return response()->json($inven);
        }

    public function create(Request $request)
        {
            $inven = new Inventory;
            $inven->nama = $request->nama;
            $inven->harga = $request->harga;
            $inven->deskripsi = $request->deskripsi;
        
            $inven->save();
            return response()->json($inven);
        }

    public function show($id)
        {
            $inven = Inventory::find($id);
            return response()->json($inven);
        }

    public function update(Request $request, $id)
        { 
            $inven = Inventory::find($id);
            
            $inven->nama = $request->input('nama');
            $inven->harga = $request->input('harga');
            $inven->deskripsi = $request->input('deskripsi');
            
            $inven->save();
            return response()->json([
                'data' => $inven,
                'status' => 'telah diupdate'
            ]);
        }

    public function destroy($id)
        {
            $inven = Inventory::find($id);
            $inven->delete();
            return response()->json([
                'status' => 'Inventory removed successfully'
            ]);
        }
    
     function numToStr($num){
        $numStr = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas'];
        
        if (isset($numStr[$num])) {
            return $numStr[$num];
        } else if ($num < 20) {
            return $numStr[$num - 10] . 'belas ';
        } else {
            return $numStr[floatval($num / 10)] . ' puluh ' . $numStr[$num % 10];
        }
    }

     function timeStatus($hours) {
        if ($hours < 6 || $hours == 24) {
            return 'dini hari';
        } else if ($hours < 12) {
            return 'pagi';
        } else if ($hours < 15) {
            return 'siang';
        } else if ($hours < 18) {
            return 'sore';
        } else {
            return 'malam';
        }
    }
    public function timeToStr(Request $request) {    
        $validateNum = '1234567890';
        // kalo jamnya bentuk string tidak ada waktu atau tidak ada tanda titik dua maka invalid time      
        if (strpos($validateNum, $request->waktu[0]) === false || strpos($request->waktu, ':') === false ) {
                $status = '0';    
                $result = 'invalid time';
            } else {
                $arrTimes = explode(":",$request->waktu);
                $h = number_format($arrTimes[0]);
                $m = number_format($arrTimes[1]);
    
                // special case at hours 24 and more than 12
                if ($h === 24) {
                    $h = 0;
                } else if ($h > 12) {
                    $h -= 12;
                }
        
                if ($h < 0 || $h > 12 || $m < 0 || $m > 59) {
                    $status = '1';
                    $result = 'invalid time';
                } else if ($m === 30) {
                    $result =  "setengah ". $this->numToStr($h + 1) . $this->timeStatus($arrTimes[0]++);
                    $status = '1';
                } else if ($m > 30) {
                    $status = '1';
                    $result = $this->numToStr($h + 1) . " kurang " . $this->numToStr(60 - $m) . $this->timeStatus($arrTimes[0]++);
                } else if ($m === 0) {
                    $status = '1';
                    $result =  numToStr($h) . timeStatus($arrTimes[0]);
                } else {
                    $status = '1';
                    $result =  $this->numToStr($h) . " lewat " . $this->numToStr($m) .  $this->timeStatus($arrTimes[0]);
                }
                
           }
           return response()->json([
            'status' => $status,
            'result' => $result
        ]);
    }
   
}