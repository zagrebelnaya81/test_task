<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;

use Illuminate\Support\Facades\DB;
class UserInfoController extends Controller
{
    public function show($id)
    {
        $user = DB::table('leads')
        ->join('customers',  'leads.customer_id', '=', 'customers.id')
        ->join('open_leads',  'leads.id', '=', 'open_leads.lead_id')
        ->where('open_leads.agent_id', '=', $id)
        ->get();
        return view('userinfo.userinfo', compact('user'));
    }

     public function ajaxRequestPost(Request $request)
     {
         $user = DB::table('leads')
             ->join('customers',  'leads.customer_id', '=', 'customers.id')
             ->join('open_leads',  'leads.id', '=', 'open_leads.lead_id')
             ->where('open_leads.agent_id', '=', $request->id)
             ->first();

         $lables = DB::table('leads')
             ->join('sphere_attributes',  'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
             ->join('sphere_attribute_options',  'sphere_attributes.id', '=', 'sphere_attribute_options.sphere_attr_id')
             ->join('sphere_bitmask_'.$user->sphere_id, 'sphere_bitmask_'.$user->sphere_id.'.user_id', '=', 'leads.id')
             ->where('leads.agent_id', '=', $request->id)
             ->where('sphere_attribute_options.ctype', '=', 'agent')
             ->where('sphere_bitmask_'.$user->sphere_id.'.type', '=', 'lead')
             ->get(array('sphere_bitmask_'.$user->sphere_id.'.id as bid', 'sphere_attributes.sphere_id', 'sphere_attributes.label', 'sphere_attribute_options.value','sphere_attribute_options.sphere_attr_id', 'sphere_attribute_options.id'));
            $idf = [];
            foreach ($lables as $label) {
                $idfield = $label->sphere_attr_id . '_' . $label->id;
                $fb = DB::table('sphere_bitmask_'.$user->sphere_id)
                    ->where('sphere_bitmask_'.$user->sphere_id.'.fb_'.$idfield, '=', 1)
                    ->get(array('sphere_bitmask_'.$user->sphere_id.'.id'));
                if($fb){
                    $idf[] = [$label->sphere_attr_id , $label->id];
                }
            }
//         print_r($idf);

         foreach ($idf as $id) {
             $dats[] = DB::table('leads')
                 ->join('sphere_attributes', 'leads.sphere_id', '=', 'sphere_attributes.sphere_id')
                 ->join('sphere_attribute_options', 'sphere_attributes.id', '=', 'sphere_attribute_options.sphere_attr_id')
                 ->join('sphere_bitmask_' . $user->sphere_id, 'sphere_bitmask_' . $user->sphere_id . '.user_id', '=', 'leads.id')
                 ->where('leads.agent_id', '=', $request->id)
                 ->where('sphere_attribute_options.ctype', '=', 'agent')
                 ->where('sphere_bitmask_' . $user->sphere_id . '.type', '=', 'lead')
                 ->where('sphere_attribute_options.sphere_attr_id', '=', $id[0])
                 ->where('sphere_attribute_options.id', '=', $id[1])
                 ->get(array('sphere_attributes.label', 'sphere_attribute_options.value'));
         }
         return view('userinfo.usergeneralinfo', compact('user', 'dats'));
     }
}

