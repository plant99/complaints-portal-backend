<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/get_all_complaints', 'ComplaintController@fetchAllComplaints');

Route::get('/get_user_complaints', 'ComplaintController@fetchUserComplaints');

Route::post('/get_status_complaints', 'ComplaintController@fetchComplaintsFilterStatus');

Route::post('/update_complaint_status', 'ComplaintController@updateComplaintStatus');

Route::post('/create_complaint', 'ComplaintController@createComplaint');

Route::post('/user_login', 'LoginController@userAuthenticate');

Route::get('/user_logout', 'LoginController@userLogout');

Route::get('/user_login', 'LoginController@checkUserAuthenticate');