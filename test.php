<?php
// $arrjson = '{
//   "first_name": "Syafrizal",
//   "last_name": "Natawiria",
//   "profile_pic": "https://scontent.xx.fbcdn.net/v/t1.0-1/11141275_1042321919111647_7421877151081915115_n.jpg?oh=602b90854335b572ce55106e6d44e736&oe=59C0C813",
//   "locale": "en_GB",
//   "timezone": 7,
//   "gender": "male"
// }';
// $respon = (array) json_decode($arrjson, true);
// print_r($arrjson);
$data = array ('user_id' => 'insw_api',
               'password' => 'insw2017',
               'content' => 'Kau ada yang memiliki aku ada yang memiliki',
               'to' => '6285659650001'); 
$data_string = json_encode($data); 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://10.1.6.188:8080/SMSGatewayAPI/webresources/service/sendMessages");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string)                                                                       
));       
$output = curl_exec($ch);
echo($output) . PHP_EOL;
curl_close($ch);
?>