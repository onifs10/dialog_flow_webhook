<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
class WebHookController extends Controller
{

    function hook(Request  $request){
//         $data  =  $request->all();'
        $responseId = $request->responseId;
        $session = $request->input('session');
        $queryResult = $request->queryResult;
        //destructuring in php
         [
            "queryText" => $input_text ,
            "parameters" => $parameters  ,
            "fulfillmentText" => $fulfillmentText  , //Output text the user sees
            "fulfillmentMessages" => $fulfillmentMessages  , //array of array|objects
            "outputContexts" => $outputContexts,  //array of obj|array
            "intent" => $intent ,
            "intentDetectionConfidence" => $intentDetectionConfidence  ,
             "languageCode" => $languageCode
        ] = $queryResult;


        $responseObj = new \stdClass();
        $message = $this->createMessage($input_text);
        $responseObj->fulfillmentText = 'your request has been approved, we would let you know when your account has been created';
        $responseObj->fulfillmentMessages = [ $message ];

        return response()->json($responseObj,200 );
    }

    private function createMessage($text){
        $message = new \stdClass();
        $textObj = new \stdClass();
        $message->text = $textObj;
        $message->text->text[] = $text;
        return $message;
    }
}
