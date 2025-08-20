<?php
/*
This api will allow you to get info from local api without exposing to public

*/
namespace App\Controllers;

class Api extends BaseController
{
  public function index(): string
  {
    return "aarya.dev";
  }
  public function id($peerid=null){
    if(isset($peerid)){
      $id_url = "id/".$peerid;
    }else{
      $id_url = "id";
    }
    return ccal($id_url,null);
  }
  public function bw(){

    return ccal("stats/bw",null);
  }


  public function stat(){

    return $this->ipfsapi("repo/stat",null);
  }

  //peers info
  public function peers(){
    #lets set  to  1000ms
    return $this->ipfsapi("swarm/peers?verbose=true&timeout=1000ms",null);
  }

  #ls files
  public function ls($arg=null){
    if($arg == "" || $arg==NULL){
      $arg = "%2F";
    }

    return $this->ipfsapi("ls?arg=".$arg,null);
  }

  //GET FILES
  public function files(){
    $fl = json_decode($this->ipfsapi("files/stat?arg=/",null));
    #get hash
    $fl->Hash;
    return $this->ls($fl->Hash);
  }


  private function ipfsapi($url,$post_data=null){
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
