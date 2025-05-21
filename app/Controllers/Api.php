<?php
/*
this api will allow you to
*/
namespace App\Controllers;

class Api extends BaseController
{
  public function index(): string
  {
    return "aarya.dev";
  }
  public function id(){

    return $this->ipfsapi("id",null);
  }
  public function bw(){

    return $this->ipfsapi("stats/bw",null);
  }


  public function stat(){

    return $this->ipfsapi("repo/stat",null);
  }


  private function ipfsapi($url,$post_data){
    $apiurl =  env("IPFS_API").$url;

    $ch=curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $apiurl);

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
}
