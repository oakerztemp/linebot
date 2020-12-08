<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'xjfUrjHuLxfuxkPURAgewxeyhkw7t8DeGQ5PN/NXe9dR7m84+SAHEch5iuqa7JzaNqwvDO2a6TAcvoylHDSpVcHN0B8799BXmelVdiNhkUdcj/0R7zg3bSYe0SVFeBEERxfJHtDptKBz1DFP0p75YwdB04t89/1O/w1cDnyilFU='; 
$channelSecret = '79b5d64ade6e6d617aef2df8eb49fb3c';

$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array
$jsonFlex = [
    "type" => "flex",
    "altText" => "Hello Flex Message",
    "contents" => [
      "type" => "bubble",
      "direction" => "ltr",
      "header" => [
        "type" => "box",
        "layout" => "vertical",
        "contents" => [
          [
            "type" => "text",
            "text" => "Purchase",
            "size" => "lg",
            "align" => "start",
            "weight" => "bold",
            "color" => "#009813"
          ],
          [
            "type" => "text",
            "text" => "฿ 100.00",
            "size" => "3xl",
            "weight" => "bold",
            "color" => "#000000"
          ],
          [
            "type" => "text",
            "text" => "Rabbit Line Pay",
            "size" => "lg",
            "weight" => "bold",
            "color" => "#000000"
          ],
          [
            "type" => "text",
            "text" => "2019.02.14 21:47 (GMT+0700)",
            "size" => "xs",
            "color" => "#B2B2B2"
          ],
          [
            "type" => "text",
            "text" => "Payment complete.",
            "margin" => "lg",
            "size" => "lg",
            "color" => "#000000"
          ]
        ]
      ],
      "body" => [
        "type" => "box",
        "layout" => "vertical",
        "contents" => [
          [
            "type" => "separator",
            "color" => "#C3C3C3"
          ],
          [
            "type" => "box",
            "layout" => "baseline",
            "margin" => "lg",
            "contents" => [
              [
                "type" => "text",
                "text" => "Merchant",
                "align" => "start",
                "color" => "#C3C3C3"
              ],
              [
                "type" => "text",
                "text" => "BTS 01",
                "align" => "end",
                "color" => "#000000"
              ]
            ]
          ],
          [
            "type" => "box",
            "layout" => "baseline",
            "margin" => "lg",
            "contents" => [
              [
                "type" => "text",
                "text" => "New balance",
                "color" => "#C3C3C3"
              ],
              [
                "type" => "text",
                "text" => "฿ 45.57",
                "align" => "end"
              ]
            ]
          ],
          [
            "type" => "separator",
            "margin" => "lg",
            "color" => "#C3C3C3"
          ]
        ]
      ],
      "footer" => [
        "type" => "box",
        "layout" => "horizontal",
        "contents" => [
          [
            "type" => "text",
            "text" => "View Details",
            "size" => "lg",
            "align" => "start",
            "color" => "#0084B6",
            "action" => [
              "type" => "uri",
              "label" => "View Details",
              "uri" => "https://google.co.th/"
            ]
          ]
        ]
      ]
    ]
  ];

$url = "https://bitpay.com/api/rates";
$url2 = "https://api.taapi.io/rsi?secret=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJlbWFpbCI6Im9hay5zdW1yZXRAZ21haWwuY29tIiwiaWF0IjoxNjA3MzM0NzczLCJleHAiOjc5MTQ1MzQ3NzN9.UVotfjpZkD2qLwbZSBauhE48F1isq7_JiLAQsp8nYWg&exchange=binance&symbol=BTC/USDT&interval=1h";
$json = file_get_contents($url);
$json2 = file_get_contents($url2);
$data2 = json_decode($json2, TRUE);
$data = json_decode($json, TRUE);
$rsibtc = $data2["value"];
$rate = $data[2]["rate"];
$rate2 = $rate/$data[13]["rate"];
$rate3 = $rate/$data[14]["rate"];
$val = (rand(40,80));
$audioUrl = "https://drive.google.com/file/d/1D8bCrfGQVbD4-MLNKGFq5QtzqCSMyrEK/view";
$val2 = 100-$val;
$check = 0;
$text2 = "ขณะนี้ Long : ".$val." % และ short :".$val2." %";
#$val3 = (rand(1,2));
$sig = 0;
if ( sizeof($request_array['events']) > 0) {

    foreach ($request_array['events'] as $event) {
        

        $reply_message = '';
        $reply_token = $event['replyToken'];
        if(strpos(strtolower($event['message']['text']),'rose') !== false or $sig == 1){  
            if(strpos($event['message']['text'],'ราคา') !== false){
                $text = "BTC : ".$rate."\r\n"."ETH : ".$rate2."\r\n"."XRP : ".$rate3;
                $sig = 0;
            }else if (strpos($event['message']['text'],'เล่น') !== false){
                if($rsibtc >= 60){
                    $text = 'long ไปเลยค่าา ปิ้วๆ'."RSI ตอนนี้อยู่ที่ "."\r\n"."RSI ตอนนี้อยู่ที่ ".$rsibtc."\r\n"."ที่ Binance BTC/USDT TF 1 Hr ค่าา";
                }else if($rsibtc <= 25){
                    $text = 'short ไปเลยค่าา ฮ๊วบๆ'."RSI ตอนนี้อยู่ที่ "."\r\n"."RSI ตอนนี้อยู่ที่ ".$rsibtc."\r\n"."ที่ Binance BTC/USDT TF 1 Hr ค่าา";
                }else{
                    $text = 'กลางๆคะอย่าเสี่ยงเลยนะคะ '."\r\n"."RSI ตอนนี้อยู่ที่ ".$rsibtc."\r\n"."ที่ Binance BTC/USDT TF 1 Hr ค่าา";
                }
            } else if (strpos($event['message']['text'],'ขึ้นหรือลง') !== false){
                $text = $text2;
            } else if (strpos($event['message']['text'],'รู้') !== false){
                $text = 'ไม่ทราบค่าา';
            } else if (strpos($event['message']['text'],'กลับบ้าน') !== false){
                $text = 'เก็บของสิค่ะ รออะไร';
            } else if (strpos($event['message']['text'],'สัญญาณ') !== false){
                #$text = 'ขณะนี้ยังไม่มีสัญญานคะ ลองคิดดูเอาเองก่อนนะคะ';
                $text = 'ตอนนี้มีสัญญาณ ซื้อ DUSK/BTC ที่ราคา 0.00000261 คะ'."\r\n"."ชื่อเหรียญ : Dusk Network"."\r\n"."TF : 1 Hr"."\r\n"."โปรดตรวจสอบคะ";
            } else if (strpos($event['message']['text'],'เพลง') !== false){
                $micdata = new AudioMessageBuilder($audioUrl,11000);
                $check = 2;
            } else if (strpos($event['message']['text'],'จ่ายเงิน') !== false){
                $check = 1;
            } else {
                $text = 'ว่าไงคะ';
                $sig += 1;
            }
        }
        #$text = $event['message']['text'];
        if ($check == 0){
            $data = [
                'replyToken' => $reply_token,
                // 'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  Debug Detail message
                'messages' => [['type' => 'text', 'text' => $text ]]
            ];
            $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
            $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
            echo "Result: ".$send_result."\r\n";
        } else if ($check == 1){
            $data = ['replyToken' => $reply_token,'messages' => [$jsonFlex]];
            $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
            $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
            echo "Result: ".$send_result."\r\n";
        }   
    }
}
echo "OK";




function send_reply_message($url, $post_header, $post_body)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}


?>
