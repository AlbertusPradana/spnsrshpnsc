<?php
require __DIR__ . '/vendor/autoload.php';
 
use \LINE\LINEBot;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use \LINE\LINEBot\MessageBuilder\MessageBuilder;
use \LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use \LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use \LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use \LINE\LINEBot\SignatureValidator as SignatureValidator;
 
// set false for production
$pass_signature = true;
 
// set LINE channel_access_token and channel_secret
$channel_access_token = "wRYlFKl8ZaXfVCxjlK39tH3cbXM8pcVerRt5Oz6SDnQ6EiKfdGf5HkwPOBRPELOrpSz2E+iLx2WLS83ZEHIctjPUvw/3KHinGOw1ml4Hoz/R1a0k4ttJO6ZXTV5PbTAsIeImfMM8MwORtvk3ZYCWfAdB04t89/1O/w1cDnyilFU=";
$channel_secret = "454970daa2330e2748835602b4ec4608";
 
// inisiasi objek bot
$httpClient = new CurlHTTPClient($channel_access_token);
$bot = new LINEBot($httpClient, ['channelSecret' => $channel_secret]);
 
$configs =  [
    'settings' => ['displayErrorDetails' => true],];
$app = new Slim\App($configs);
 
// buat route untuk url homepage
$app->get('/', function($req, $res){
  echo "Welcome at Slim Framework";
});
 
// buat route untuk webhook
$app->post('/webhook', function ($request, $response) use ($bot, $pass_signature, $httpClient){
    // get request body and line signature header
    $body = file_get_contents('php://input');
    $signature = isset($_SERVER['HTTP_X_LINE_SIGNATURE']) ? $_SERVER['HTTP_X_LINE_SIGNATURE'] : '';
 
    // log body and signature
    file_put_contents('php://stderr', 'Body: '.$body);
 
    if($pass_signature === false)
    {
        // is LINE_SIGNATURE exists in request header?
        if(empty($signature)){
            return $response->withStatus(400, 'Signature not set');
        }
 
        // is this request comes from LINE?
        if(! SignatureValidator::validateSignature($body, $channel_secret, $signature)){
            return $response->withStatus(400, 'Invalid signature');
        }
    }
 
    // kode aplikasi nanti disini
	$data = json_decode($body, true);
	if (is_array($data['events'])){
        $host = "host = ec2-107-20-183-142.compute-1.amazonaws.com";
        $user = "user = nrtbiimbhcafvg";
        $password = "password = b5a06ee5b7e826f7d8515bf4e3c0d39bb04c2e1ee5d35b223d46b37a3ebe89f7";
        $dbname = "dbname = d3dfk0c84suatq";
        $port = "port = 5432";

        $db = pg_connect("$host $port $dbname $user $password");
		foreach ($data['events'] as $event){
			if ($event['type'] == 'message'){
				if ($event['message']['type'] == 'text'){
					$command = substr($event['message']['text'], 0, 7);
					if (strtolower($event['message']['text'])=='survey'){
						$carouselTemplateBuilder = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder([
                            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Survey Danusan Favorit", "Khusus TE17","https://pbs.twimg.com/profile_images/1061068944914567168/Mpk7-_AF_400x400.jpg",[
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Survey TE17',"Survey 1","TE17"),
                            ]),
                            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Survey Danusan Favorit", "Khusus TI17","https://pbs.twimg.com/profile_images/1061068944914567168/Mpk7-_AF_400x400.jpg",[
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Survey TI17',"Survey 2","TI17"),
                            ]),
                            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Survey Danusan Favorit", "Khusus TE18","https://pbs.twimg.com/profile_images/1061068944914567168/Mpk7-_AF_400x400.jpg",[
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Survey TE18',"Survey 3","TE18"),
                            ]),
                            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Survey Danusan Favorit", "Khusus TI18","https://pbs.twimg.com/profile_images/1061068944914567168/Mpk7-_AF_400x400.jpg",[
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder('Survey TI18',"Survey 4","TI18"),
                            ]),
                            ]);
                        $templateMessage = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('Pilih jurusan yak',$carouselTemplateBuilder);
						$text1 = new TextMessageBuilder('Pilih jurusan masing-masing ya');
						$text3 = new MultiMessageBuilder();
						$text3->add($text1);
						$text3->add($templateMessage);
                        $result = $bot->replyMessage($event['replyToken'], $text3);

                        return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                    }
                    else if (strtolower($event['message']['text'])=='credit'){
						$text1 = new TextMessageBuilder('Makasih buat teman-teman tim DILo saya (Wildan, Ichsan, Labib, Gia) yang telah menginsirasi saya untuk membuat bot ini di sela-sela kegabutan liburan saya UwU.');
						$text2 = new TextMessageBuilder('Bot ini sebenernya merupakan re-work dari produk tim saya di DILo Hackathon kemarin.');
						$text3 = new MultiMessageBuilder();
						$text3->add($text2);
						$text3->add($text1);
						
						$result = $bot->replyMessage($event['replyToken'], $text3);						
						return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
					}
				}
			}
			else if ($event['type'] == 'postback'){
                    if($event['postback']['data'] == 'Survey 1'){
                        $flexSurveyte17 = file_get_contents('survey_te17.json');

                    $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
                                    "type" => "flex",
                                    "altText" => "Survey TE17",
                                    "contents" => json_decode($flexSurveyte17)
                            ]                    
                        ],
                    ]);
                    return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                    }
                    else if ($event['postback']['data']=="Survey 2"){
                        $flexSurveyti17 = file_get_contents('survey_ti17.json');

                    $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
                                    "type" => "flex",
                                    "altText" => "Survey TI17",
                                    "contents" => json_decode($flexSurveyti17)
                            ]                    
                        ],
                    ]);
                    return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                    }
                    else if ($event['postback']['data']=="Survey 3"){
                        $flexSurveyte18 = file_get_contents('survey_te18.json');

                    $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
                                    "type" => "flex",
                                    "altText" => "Survey TE18",
                                    "contents" => json_decode($flexSurveyte18)
                            ]                    
                        ],
                    ]);
                    return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                    }
                    else if ($event['postback']['data']=="Survey 4"){
                        $flexSurveyti18 = file_get_contents('survey_ti18.json');

                    $result = $httpClient->post(LINEBot::DEFAULT_ENDPOINT_BASE . '/v2/bot/message/reply', [
                        'replyToken' => $event['replyToken'],
                        'messages' => [
                            [
                                    "type" => "flex",
                                    "altText" => "Survey TI18",
                                    "contents" => json_decode($flexSurveyti18)
                            ]                    
                        ],
                    ]);
                    return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                    }
                    //survey te17
                    else if($event['postback']['data'] == 'te17sosissolo'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Sosissolo';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te17rotipisang'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Rotipisang';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te17pisangaroma'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Pisangaroma';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te17roticoklat'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Roticoklat';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te17tahubakso'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Tahubakso';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te17krakers'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Krakers';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te17satebakso'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Satebakso';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te17suskeju'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Suskeju';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te17susufapet'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Susufapet';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te17(userid,answerte17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    //survey ti17
                    else if($event['postback']['data'] == 'ti17sosissolo'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Sosissolo';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti17rotipisang'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Rotipisang';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti17pisangaroma'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Pisangaroma';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti17roticoklat'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Roticoklat';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti17tahubakso'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Tahubakso';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti17krakers'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Krakers';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti17satebakso'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Satebakso';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti17suskeju'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Suskeju';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti17susufapet'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Susufapet';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti17(userid,answerti17) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    //survey te18
                    else if($event['postback']['data'] == 'te18sosissolo'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Sosissolo';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te18rotipisang'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Rotipisang';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te18pisangaroma'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Pisangaroma';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te18roticoklat'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Roticoklat';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te18tahubakso'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Tahubakso';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te18krakers'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Krakers';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te18satebakso'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Satebakso';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te18suskeju'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Suskeju';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'te18susufapet'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Susufapet';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_te18(userid,answerte18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    //survey ti18
                    else if($event['postback']['data'] == 'ti18sosissolo'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Sosissolo';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti18rotipisang'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Rotipisang';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti18pisangaroma'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Pisangaroma';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti18roticoklat'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Roticoklat';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti18tahubakso'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Tahubakso';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti18krakers'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Krakers';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti18satebakso'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Satebakso';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti18suskeju'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Suskeju';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                    else if($event['postback']['data'] == 'ti18susufapet'){
                        $res = $bot->getProfile($event['source']['userId']);
    
                        if ($res->isSucceeded()) {
                            $profile = $res->getJSONDecodedBody();
                            $userId = $profile['userId'];
                            $displayName = $profile['displayName'];
                            $answer = 'Susufapet';
        
                            //retrieve user answer into DB
                            $psql = "INSERT INTO public.survey_ti18(userid,answerti18) VALUES ('$userId','$answer')";
                            $ret = pg_query($db, $psql);
        
                            if($ret){
                                $repMessage = new TextMessageBuilder("Terima kasih atas pilihanmu. Pesan telah disimpan di database kami.");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
    
                            else{
                                $repMessage = new TextMessageBuilder("Anda telah mengisi survey ini. Jangan diisi lagi :(");
                                $result = $bot->replyMessage($event['replyToken'], $repMessage);
            
                                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());
                            }
                        }
                    }
                }
            //user baru nge-add kita
            else if($event['type'] == 'follow'){
                $res = $bot->getProfile($event['source']['userId']);

                if($res->isSucceeded()){
                    $profile = $res->getJSONDecodedBody();
                    $userId = $profile['userId'];
                    $displayName = $profile['displayName'];

                    //retrieve user data into DB
                    $psql = "INSERT INTO public.users_info(userid, displayname, timestamp) VALUES ('$userId','$displayName',CURRENT_TIMESTAMP)";
                    $ret = pg_query($db, $psql);

                    if($ret){
                        //welcoming message
                        $message1 = new TextMessageBuilder("Halo " . $displayName . ", gimana nih liburannya? :D ");
                        $message2 = new TextMessageBuilder("Silahkan ketik 'survey' untuk memulai");
                        $welcomingText = new MultiMessageBuilder();
                        $welcomingText->add($message1);
                        $welcomingText->add($message2);

                    }

                    else{
                        $welcomingText = new TextMessageBuilder("Halo " . $displayName . " ! Maaf ya, database sedang error :(");
                    }
                }

                $result = $bot->replyMessage($event['replyToken'], $welcomingText);
                return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus()); 
            }
        } 
	}
});
$app->run();