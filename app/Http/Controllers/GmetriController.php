<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Input;

class GmetriController extends Controller
{
    public function fetch(Request $request)
    {
    	$viewpoints = DB::select('select * from viewpoints');
    	$json_viewpoints = json_encode($viewpoints);
    	return $json_viewpoints;
    }

    public function updateGmetri(Request $request)
    {
        $parent_data = json_decode($request->input('parent_data'));
        $children_data = json_decode($request->input('children_data'));
        DB::table('viewpoints')->delete();
        for($i = 0;$i < sizeof($parent_data);$i++){  
                $insert = DB::table('viewpoints')->insert(
                    ['vp_id' => $parent_data[$i]->vp_id, 'viewpoint_name' => $parent_data[$i]->viewpoint_name, 'parent_id' => $parent_data[$i]->parent_id]
            );
        }

        for($i = 0;$i < sizeof($children_data);$i++){ 
            for($j = 0;$j < sizeof($children_data[$i]);$j++){   
                $insert = DB::table('viewpoints')->insert(
                        ['vp_id' => $children_data[$i][$j]->vp_id, 'viewpoint_name' => $children_data[$i][$j]->viewpoint_name, 'parent_id' => $children_data[$i][$j]->parent_id]
                );
            }
        }
    }
}


