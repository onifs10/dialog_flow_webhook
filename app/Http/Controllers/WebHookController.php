<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
class WebHookController extends Controller
{

    function hook(Request  $request){
         $data  =    $request->all();
         $text = $data;
         $responseObj = new \stdClass();
         $message = $this->createMessage(json_encode($text));
         $responseObj->fulfillmentText = 'we have recieved your request';
         $responseObj->fulfillmentMessages = [ $message ];

         return response()->json($responseObj,200 );
    }

    private function createMessage($text){
        $message = new \stdClass();
        $textObj = new \stdClass();
        $message->text = $textObj;
        $message->text->text[] = 'search is been performed';
        return $message;
    }
}
