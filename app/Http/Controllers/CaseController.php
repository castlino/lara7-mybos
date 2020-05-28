<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CaseController extends Controller
{
    public function cases(){
          $cases = DB::table('cases')->take(2)->get();
          return response()->json($cases);
    }
    
    public function casesPaginated(){
          $count = request('count') ? (int) request('count') : 2;
          $page = request('page') ? (int) request('page') : 1;
          $startFrom = ($page - 1) * $count;
          
          $total = DB::table('cases')->count();
          
          $end = $startFrom + $count;
          if($end > $total){
            $end = $total;
          }
          
          $maxPage = intdiv($total, $count);
          if(fmod($total, $count) > 0){
            $maxPage++;
          }
          
          
          $cases = DB::table('cases')->skip($startFrom)->take($count)->get();
          return response()->json(
            [
              'count' => $count,
              'page' => $page,
              'start' => $startFrom + 1,
              'end' => $end,
              'total' => $total,
              'maxPage' => $maxPage,
              'cases' => $cases
            ]
          );
    }
}
