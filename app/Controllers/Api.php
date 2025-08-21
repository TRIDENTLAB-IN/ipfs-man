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

    return ccal("repo/stat",null);
  }

  //peers info
  public function peers(){
    #lets set  to  1000ms
    return ccal("swarm/peers?verbose=true&timeout=1000ms",null);
  }

  #ls files
  public function ls($arg=null){
    if($arg == "" || $arg==NULL){
      $arg = "%2F";
    }

    return ccal("ls?arg=".$arg,null);
  }

  //GET FILES
  public function files(){
    $fl = json_decode(ccal("files/stat?arg=/",null));
    #get hash
    $fl->Hash;
    return $this->ls($fl->Hash);
  }
  



}
