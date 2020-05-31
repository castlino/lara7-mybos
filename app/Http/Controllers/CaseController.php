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
          return response()->json('success');
    }
    
    public function setCaseStarred(){
          $id = request('id') ? (int) request('id') : 0;
          $starStatus = request('starStatus') ? request('starStatus') : false;
          if($id == 0){
            return response()->json('no id specified.');
          }

          $case = DB::table('cases')->where('id', $id)->update(['starred' => $starStatus]);
          return response()->json($starStatus);
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
          $keywords = request('keywords') ? request('keywords') : '%%';
          
          $startFrom = ($page - 1) * $count;
          
          $total = DB::table('cases')->where('subject', 'like', '%'.$keywords.'%')->count();
          
          $end = $startFrom + $count;
          if($end > $total){
            $end = $total;
          }
          
          $maxPage = intdiv($total, $count);
          if(fmod($total, $count) > 0){
            $maxPage++;
          }
          
          
          $cases = DB::table('cases')->where('subject', 'like', '%'.$keywords.'%')->skip($startFrom)->take($count)->get();
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
    
    public function getCaseTypeStatistics(){
          $period = request('period') ? request('period') : '-1 month';
          $timeFrame = new \DateTime($period);
          
          $types = ['Other', 'gardening', 'Defects', 'Renovations', 'Cleaning', 'Repair & Maintenance'];
          
          $gardening = DB::table('cases')->where([['type', 'gardening'], ['added_date', '>=', $timeFrame]])->count();
          $other = DB::table('cases')->where([['type', 'Other'], ['added_date', '>=', $timeFrame]])->count();
          $defects = DB::table('cases')->where([['type', 'Defects'], ['added_date', '>=', $timeFrame]])->count();
          $renovations = DB::table('cases')->where([['type', 'Renovations'], ['added_date', '>=', $timeFrame]])->count();
          $cleaning = DB::table('cases')->where([['type', 'Cleaning'], ['added_date', '>=', $timeFrame]])->count();
          $repairs = DB::table('cases')->where([['type', 'Repair & Maintenance'], ['added_date', '>=', $timeFrame]])->count();
          
          $total = $gardening + $other + $defects + $renovations + $cleaning + $repairs;
          
          $gardeningPercent = 0;
          if($gardening>0){ $gardeningPercent = ($gardening/$total)*100; }
          
          $otherPercent = 0;
          if($other>0){ $otherPercent = ($other/$total)*100; }
          
          $defectsPercent = 0;
          if($defects>0){ $defectsPercent = ($defects/$total)*100; }
          
          $renovationsPercent = 0;
          if($renovations>0){ $renovationsPercent = ($renovations/$total)*100; }
          
          $cleaningPercent = 0;
          if($cleaning>0){ $cleaningPercent = ($cleaning/$total)*100; }
          
          $repairsPercent = 0;
          if($repairs>0){ $repairsPercent = ($repairs/$total)*100; }
          
          $returnData = [
            'types' => $types,
            'percentage' => [$gardeningPercent, $otherPercent, $defectsPercent, $renovationsPercent, $cleaningPercent, $repairsPercent]
          ];
          
          return response()->json( $returnData );
    }
}
