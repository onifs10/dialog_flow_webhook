<?php


namespace App\Http\Controllers;


use http\Env\Request;

class WebHook extends Controller
{

    function hook(Request  $request){
            $request->all();
    }
}
