<?php
    namespace App\Helpers;
    class APIHelpers {

        // format the response for the api
        public static function createApiResponse($is_error , $code , $message_en , $message_ar , $content , $lang){
            if($lang == 'en'){
              $message = $message_en;
            }else{
              $message = $message_ar;
            }
            $result = [];
            if($is_error){
                $result['success'] = false;
                $result['code'] = $code;
                $result['message'] = $message;
            }else{
                $result['success'] = true;
                $result['code'] = $code;
                if($content == null){
                    $result['message'] = $message;
					          $result['data'] = [];
                }else{
                    $result['data'] = $content;
                }
            }
            return $result;
        }

        // calculate the distance
       public static function distance($lat1, $lon1, $lat2, $lon2, $unit) {
            if (($lat1 == $lat2) && ($lon1 == $lon2)) {
              return 0;
            }
            else {
              $theta = $lon1 - $lon2;
              $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
              $dist = acos($dist);
              $dist = rad2deg($dist);
              $miles = $dist * 60 * 1.1515;
              $unit = strtoupper($unit);
          
              if ($unit == "K") {
                return ($miles * 1.609344);
              } else if ($unit == "N") {
                return ($miles * 0.8684);
              } else {
                return $miles;
              }
            }
          }

          // send fcm notification
          public static function send_notification($title , $body , $image , $data , $token){
            
            $message= $body;
            $title= $title;
            $image = $image;
            $path_to_fcm='https://fcm.googleapis.com/fcm/send';
            $server_key="AAAAMUON44I:APA91bEA9uJBOkHS6LN-cnZ8UFs-acHT_T7xw5h9XyyA91FS51n3nFi11rhGs611jJ4ia4VisD2TIDqN5AbanKrcHdMhWO5mxPwSQL3I6S_NVyFInGtwtUbKZzRT12U2ybHGr29qf0IF";

            $headers = array(
                'Authorization:key=' .$server_key,
                'Content-Type:application/json'
            );

            $fields =array('registration_ids'=>$token,  
            'notification'=>array('title'=>$title,'body'=>$message , 'image'=>$image));  

            $payload =json_encode($fields);
            $curl_session =curl_init();
            curl_setopt($curl_session,CURLOPT_URL, $path_to_fcm);
            curl_setopt($curl_session,CURLOPT_POST, true);
            curl_setopt($curl_session,CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl_session,CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);
            curl_setopt($curl_session,CURLOPT_POSTFIELDS, $payload);
            $result=curl_exec($curl_session);
            curl_close($curl_session);
            return $result;
          }

          // convert currency
          public static function converCurruncy($token, $from, $to) {
            $path='https://currency.labstack.com/api/v1/convert/1/' . strtoupper($from) . '/' . strtoupper($to);
            $headers = array(
                'Authorization:Bearer ' .$token,
                'Content-Type:application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $path);
            curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            $result = json_decode($output);
            return $result;
          }



          


    }
?>