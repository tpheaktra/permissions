<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\SettingsModel;
use auth;
class SettingsController extends Controller
{
    public function index(Request $request)
    {

        $theme = new SettingsModel();
        $userlogin = auth::user()->id;
        $condit = SettingsModel::where('user_id',$userlogin)->get();
        if(isset($condit[0]->user_id)){
             $uid = $condit[0]->user_id;
        }else{
             $uid = 'null';
        }


        if($request->theme == 'dark' || $request->theme == 'light'){
            if( $uid == $userlogin){
                SettingsModel::where('user_id',$userlogin)->update(array('name'=>$request->theme));
                return back()->with('success','your theme change successuly');
            }else{
                $theme->name    = $request->theme;
                $theme->user_id = $userlogin;
                $theme->save();
                return back()->with('success','your theme change successuly');
            }
        }else{
            return back()->with('danger','Sorry you can change this theme.');
        }





    }
}
