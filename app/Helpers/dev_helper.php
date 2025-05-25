<?php
function ccal($url,$post_data=null){
  $apiurl =  env("IPFS_API").$url;

  $ch=curl_init();
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_URL, $apiurl);
  curl_setopt($ch, CURLOPT_TIMEOUT, 10); //10 sec  time out

  // post_data
  curl_setopt($ch, CURLOPT_POST, true);
  if(!is_null($post_data)){
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
  }


  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));

  curl_setopt($ch, CURLOPT_VERBOSE, true);

  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

  $response = curl_exec($ch);
  curl_close($ch);

  return $response;


}
?>
