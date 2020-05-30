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
    
    public function getCaseById(){
          $caseId = request('id') ? (int) request('id') : 0;
          if($caseId == 0){
            return response()->json('no id specified.');
          }
          
          $case = DB::table('cases')->where('id', $caseId)->first();
          return response()->json($case);
    }
    
    public function setCaseStatus(){
          $id = request('id') ? (int) request('id') : 0;
          $status = request('status') ? request('status') : '';
          if($id == 0){
            return response()->json('no id specified.');
          }

          $case = DB::table('cases')->where('id', $id)->update(['status' => $status]);
          return response()->json($status);
    }
    
    public function createNewCase(){
          $case_number = request('case_number') ? request('case_number') : 0;
          $type = request('type') ? request('type') : '';
          $added_date = request('added_date') ? request('added_date') : '';
          $due_date = request('due_date') ? request('due_date') : '';
          $priority = request('priority') ? request('priority') : 'Low';
          $status = request('status') ? request('status') : 'New Type 1';
          $contractors = request('contractors') ? request('contractors') : '';
          $subject = request('subject') ? request('subject') : '';
          $description = request('description') ? request('description') : '';
          
          $addedDate = new \DateTime();
          if($added_date != ''){
              //$addedDate = $addedDate->createFromFormat('Y-m-d', $added_date['year'].'-'.$added_date['month'].'-'.$added_date['day']);
              $addedDate = new \DateTime($added_date['year'].'-'.$added_date['month'].'-'.$added_date['day']);
          }
          
          $dueDate = new \DateTime();
          if($due_date != ''){
              $dueDate = new \DateTime($due_date['year'].'-'.$due_date['month'].'-'.$due_date['day']);
          }

          try {
            $new_id = DB::table('cases')->insertGetId(
                [
                  'case_number' => $case_number, 
                  'type' => $type,
                  'added_date' => $addedDate,
                  'due_date' => $dueDate,
                  'priority' => $priority,
                  'status' => $status,
                  'contractors' => $contractors,
                  'subject' => $subject,
                  'description' => $description,
                  'created_at' => new \DateTime(),
                  'updated_at' => new \DateTime()
                ]
            );
            return response()->json(['status'=>'success', 'id' => $new_id]);
          }
          catch (Exception $e) {
            return response()->json(['status' => 'failed']);
          }
          
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
