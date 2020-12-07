<?php


$API_URL = 'https://api.line.me/v2/bot/message';
$ACCESS_TOKEN = 'xjfUrjHuLxfuxkPURAgewxeyhkw7t8DeGQ5PN/NXe9dR7m84+SAHEch5iuqa7JzaNqwvDO2a6TAcvoylHDSpVcHN0B8799BXmelVdiNhkUdcj/0R7zg3bSYe0SVFeBEERxfJHtDptKBz1DFP0p75YwdB04t89/1O/w1cDnyilFU='; 
$channelSecret = '79b5d64ade6e6d617aef2df8eb49fb3c';

$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

$request = file_get_contents('php://input');   // Get request content
$request_array = json_decode($request, true);   // Decode JSON to Array

$url = "https://bitpay.com/api/rates";
$json = file_get_contents($url);
$data = json_decode($json, TRUE);
$rate = $data[2]["rate"];
$rate2 = $rate/$data[13]["rate"];
$rate3 = $rate/$data[14]["rate"];
$val = (rand(40,80));
$val2 = 100-$val;
$text2 = "ขณะนี้ Long : ".$val." % และ short :".$val2." %";
$val3 = (rand(1,2));
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
                if($val3 == 1){
                    $text = 'long';
                    $sig = 0;
                }else{
                    $text = 'short';
                    $sig = 0;
                }
            } else if (strpos($event['message']['text'],'ขึ้นหรือลง') !== false){
                $text = $text2;
                $sig = 0;
            } else if (strpos($event['message']['text'],'รู้') !== false){
                $text = 'ไม่ทราบค่าา';
                $sig = 0;
            } else if (strpos($event['message']['text'],'กลับบ้าน') !== false){
                $text = 'เก็บของสิค่ะ รออะไร';
                $sig = 0;
            } else if (strpos($event['message']['text'],'สัญญาณ') !== false){
                #$text = 'ขณะนี้ยังไม่มีสัญญานคะ ลองคิดดูเอาเองก่อนนะคะ';
                $text = 'ตอนนี้มีสัญญาณ ซื้อ DUSK/BTC ที่ราคา 0.00000261 คะ'."\r\n"."ชื่อเหรียญ : Dusk Network"."\r\n"."TF : 1 Hr"."\r\n"."โปรดตรวจสอบคะ";
                $sig = 0;
            } else {
                $text = 'ว่าไงคะ';
                $sig += 1;
            }
        }
        #$text = $event['message']['text'];
        $data = [
            'replyToken' => $reply_token,
            // 'messages' => [['type' => 'text', 'text' => json_encode($request_array) ]]  Debug Detail message
            'messages' => [['type' => 'text', 'text' => $text ]]
        ];
        $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);

        $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);

        echo "Result: ".$send_result."\r\n";
    }
}
echo $sig;
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
