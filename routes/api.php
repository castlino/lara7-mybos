<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:api')->get('/token/revoke', function (Request $request) {
    DB::table('oauth_access_tokens')
        ->where('user_id', $request->user()->id)
        ->update([
            'revoked' => true
        ]);
    return response()->json('DONE');
});

// Route::middleware('auth:api')->get('/cases', function (Request $request) {
//     $cases = DB::table('cases')->get();
//     return response()->json($cases);
// });


Route::middleware('auth:api')->get('/cases', 'CaseController@cases')->name('cases');
Route::middleware('auth:api')->get('/case/get-by-id', 'CaseController@getCaseById')->name('cases.getById');
Route::middleware('auth:api')->get('/cases/paginated', 'CaseController@casesPaginated')->name('cases.paginated');
Route::middleware('auth:api')->get('/cases/get-type-stats', 'CaseController@getCaseTypeStatistics')->name('cases.typeStats');
Route::middleware('auth:api')->get('/cases/get-status-stats', 'CaseController@getCaseStatusStatistics')->name('cases.getCaseStatusStatistics');
Route::middleware('auth:api')->get('/case/get-next-case-number', 'CaseController@getNextCaseNumber')->name('cases.getNextCaseNumber');

Route::middleware('auth:api')->post('/case/set-status', 'CaseController@setCaseStatus')->name('cases.setCaseStatus');
Route::middleware('auth:api')->post('/case/set-star', 'CaseController@setCaseStarred')->name('cases.setCaseStarred');
Route::middleware('auth:api')->post('/case/create-new', 'CaseController@createNewCase')->name('cases.createNewCase');
Route::middleware('auth:api')->post('/case/update', 'CaseController@updateCase')->name('cases.updateCase');


