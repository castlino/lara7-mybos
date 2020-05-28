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
          $count = request('count') ? request('count') : 2;
          
          $cases = DB::table('cases')->take($count)->get();
          return response()->json($cases);
    }
}
