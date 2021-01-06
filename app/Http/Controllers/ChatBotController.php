<?php


namespace App\Http\Controllers;

use Google\Cloud\Dialogflow\V2\SessionsClient;
use Google\Cloud\Dialogflow\V2\TextInput;
use Google\Cloud\Dialogflow\V2\QueryInput;
use Illuminate\Http\Request;


class ChatBotController extends Controller
{

    public function  sendText(Request $request){
        $response = $this->detect_intent_texts(null,[$request->text],uniqid());
        return response($response,  200);
    }

    private function detect_intent_texts($projectId = null, $texts, $sessionId, $languageCode = 'en-US')
    {
        // new session
        $projectId = (!is_null($projectId)) ? $projectId : getenv('DIALOGFLOW_PROJECT_ID');
        $sessionsClient = new SessionsClient(['credentials' => base_path(). '/client-secret.json']);
        $session = $sessionsClient->sessionName($projectId, $sessionId ?: uniqid());
        printf('Session path: %s' . PHP_EOL, $session);
        $output = [];
        // query for each string in array
        foreach ($texts as $text) {
            // create text input
            $textInput = new TextInput();
            $textInput->setText($text);
            $textInput->setLanguageCode($languageCode);

            // create query input
            $queryInput = new QueryInput();
            $queryInput->setText($textInput);

            // get response and relevant info
            $response = $sessionsClient->detectIntent($session, $queryInput);
            $queryResult = $response->getQueryResult();
            $queryText = $queryResult->getQueryText();
            $intent = $queryResult->getIntent();
            $displayName = $intent->getDisplayName();
            $confidence = $queryResult->getIntentDetectionConfidence();
            $fulfilmentText = $queryResult->getFulfillmentText();
            $fulfilmentMessages = $queryResult->getWebhookPayload();

            // output relevant info
            print(str_repeat("=", 20) . PHP_EOL);
            printf('Query text: %s' . PHP_EOL, $queryText);
            printf('Detected intent: %s (confidence: %f)' . PHP_EOL, $displayName,
                $confidence);
            print(PHP_EOL);
            printf('Fulfilment text: %s' . PHP_EOL, $fulfilmentText);
            $output[] =  ['Fulfilment text' => $fulfilmentText, 'Detected intent' => ['displayname' => $displayName, 'confidence' => $confidence , 'response' => $fulfilmentMessages]];
        }
        $sessionsClient->close();
        return $output;
    }
}
