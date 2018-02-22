<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Carbon;

class ComplaintController extends Controller
{
    public function fetchAllComplaints(Request $request)
    {
        if ($request->session()->has('user_id')) {
            
            if ($request->session()->get('is_admin')) {
                $complaints = DB::select('SELECT * FROM complaints');
                $json_complaints = json_encode($complaints); 
                return response($json_complaints, 200);
            }

            else {
                return response('Not Authorized', 403);
            }
        }
        else {
            return response('Please Log In', 403);
        }
    }

    public function fetchUserComplaints(Request $request)
    {
        if ($request->session()->has('user_id')) {
            
            $user_id = session('user_id');
            
            $user_complaints = DB::select('SELECT * FROM complaints WHERE username = "'.$user_id.'"');
            $json_user_complaints = json_encode($user_complaints);
            
            return response($json_user_complaints, 200);
        }
        else {
            return response('Please Log In', 403);
        }
    }

    public function updateComplaintStatus(Request $request)
    {
        if ($request->session()->has('user_id')) {
            
            if ($request->session()->get('is_admin')) {
                $complaint_id = $request->input('complaint_id');
                $complaint_status = $request->input('complaint_status'); 
                $updated_at_time = Carbon::now();

                if (!isset($complaint_id) || !isset($complaint_status)) {
                    return response('Invalid Params', 400);
                }
            
                else {
                    $exists = DB::table('complaints')
                        ->where('id', $complaint_id)
                        ->first();

                    if (!$exists) {
                        return response('Complaint Does Not Exist', 404);
                    }

                    else {
                        DB::table('complaints')
                            ->where('id',$complaint_id)
                            ->update([
                                'status' => $complaint_status,
                                'updated_at' => $updated_at_time
                            ]);
                 
                        return response('Successfully Updated', 200);
                    }
                }
            }

            else {
                return response('Not Authorized', 403);    
            }
        }

        else {
            return response('Please Log In', 403);
        }
    }

    public function createComplaint(Request $request)
    {
        if ($request->session()->has('user_id')) {

            $user_id = session('user_id');
            $title = $request->input('title');
            $content = $request->input('content');
            $createad_at_time = Carbon::now();

            if (isset($title) && isset($title) && isset($content)) {
                DB::table('complaints')->insert([
                    'username' => $user_id,
                    'title' => $request->input('title'),
                    'content' => $request->input('content'),
                    'created_at' => $createad_at_time,
                    'updated_at' => $createad_at_time,
                    'status' => 'Registered'
                ]);

                return response('Complaint Registered', 200);
            }
        }

        else {
            return response('Please Log In', 403);
        }
    }

    public function fetchComplaintsFilterStatus(Request $request)
    {
        if ($request->session()->has('user_id')) {

            if ($request->session()->get('is_admin')) {
                $status = $request->input('status');
                $complaints = DB::table('complaints')
                    ->where(['status' => $status])
                    ->get();
                $json_complaints = json_encode($complaints);

                return response($json_complaints, 200);
            }
            else {
                return response('Not Authorized', 403);    
            }
        }

        else {
            return response('Please Log In', 403);
        }
    }
}


