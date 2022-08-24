<?php
  // 네이버 로그인 콜백 예제
  $client_id = "##NAVER_CLIENT_ID##";
  $client_secret = "##NAVER_CLIENT_SECRET##";
  $code = $_GET["code"];
  $state = $_GET["state"];
  $redirectURI = urlencode("##CALL_BACK_URL##");
  $url = "https://nid.naver.com/oauth2.0/token?grant_type=authorization_code&client_id=".$client_id."&client_secret=".$client_secret."&redirect_uri=".$redirectURI."&code=".$code."&state=".$state;

  $get_token = json_decode(file_get_contents($url), true);
  $token = $get_token['access_token'];
  $refresh_token = $get_token['refresh_token'];

  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, 'https://openapi.naver.com/v1/nid/me');
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
  $headers = array();
  $headers[] = "Authorization: Bearer $token";
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  $result = curl_exec($ch);
  curl_close($ch);

  $api = json_decode($result, true);
  $current_year = date("Y");
  $status = $api['message'];
  $id = $api['response']['id'];
  $nickname = $api['response']['nickname'];
  $email = $api['response']['email'];
  $mobile = $api['response']['mobile'];
  $name = $api['response']['name'];
  $profile_image = $api['response']['profile_image'];
  $birthyear = $api['response']['birthyear'];
  $birthday = $api['response']['birthday'];
  $age = $api['response']['age'];
  $gender = $api['response']['gender'];
  $mobile_e164 = $api['response']['mobile_e164'];

  $real_age = 1 + $current_year - $birthyear;
  if($gender == "M"){
      $gender = "남자";
  }else{
      $gender = "여자";
  }

  if($status == "success"){
    echo "<img src=\"$profile_image\" style=\"width: 200; height: auto;\"><br><br>";
    echo "고유번호 : ".$id."<br>";
    echo "닉네임 : ".$nickname."<br>";
    echo "이메일 : ".$email."<br>";
    echo "전화번호 : ".$mobile."<br>";
    echo "전화번호(국가번호 포함) : ".$mobile_e164."<br>";
    echo "이름 : ".$name."<br>";
    echo "생년월일 : ".$birthyear." ".$birthday."<br>";
    echo "나이 : ".$real_age."<br>";
    echo "나이(네이버) : ".$age."<br>";
    echo "성별 : ".$gender."<br>";
  }else{
    echo "세션만료";
  }
?>
