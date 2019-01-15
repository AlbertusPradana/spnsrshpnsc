$carouselTemplateBuilder = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder([
                            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Danus NSC", "Pilih jajan favoritmu yak","https://pbs.twimg.com/profile_images/1061068944914567168/Mpk7-_AF_400x400.jpg",[
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Sosis solo", "Sosissolo","Sosissolo"),
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Roti pisang", "Rotipisang","Sosissolo"),
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Pisang aroma", "Pisangaroma","Sosissolo"),
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Roti coklat", "Roticoklat","Sosissolo"),
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Tahu bakso", "Tahubakso","Sosissolo")
                            ]),
                            new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder("Danus NSC", "Pilih jajan favoritmu yak","https://pbs.twimg.com/profile_images/1061068944914567168/Mpk7-_AF_400x400.jpg",[
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Krakers", "Krakers","Sosissolo"),
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Sate bakso", "Satebakso","Sosissolo"),
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Dadar gulung", "Dadargulung","Sosissolo"),
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Sus keju", "Suskeju","Sosissolo"),
                            new \LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder("Susu fapet", "Susufapet","Sosissolo")
                            ]),
                            ]);
                        $templateMessage = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder('Pilih jajanan favoritmu yak',$carouselTemplateBuilder);
						$text1 = new TextMessageBuilder('Dari 2 bubble dibawa, pilih 1 jajanan fav ya');
						$text3 = new MultiMessageBuilder();
						$text3->add($text1);
						$text3->add($templateMessage);
                        $result = $bot->replyMessage($event['replyToken'], $text3);

                        return $response->withJson($result->getJSONDecodedBody(), $result->getHTTPStatus());