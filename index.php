<?php
  $client_id = "##NAVER_CLIENT_ID##";
  $redirectURI = urlencode("##CALL_BACK.PHP URL##");
  $state = "##STATE##";
  $apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;
?><a href="<?php echo $apiURL ?>"><img height="50" src="http://static.nid.naver.com/oauth/small_g_in.PNG"/></a>
