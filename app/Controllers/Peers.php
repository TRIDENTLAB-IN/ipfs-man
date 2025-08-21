<?php
namespace App\Controllers;
use App\Models\Inda;
class Peers extends BaseController
{
  public function __construct(){
    $this->inda =  new Inda();
  }

 public function index(){
   $data["peer_list"] = $this->inda->fetch_peer_list(30);
   return view('peers',$data);

 }

 public function jj(){
   echo '<pre>';
   var_dump($this->inda-> peerloc());
 }

 public function uploc(){
   $peer_row = $this->inda->fetch_peer(array("cc"=>"E"));
   if($peer_row){

   try{
     $cc = "E";
     $location= "Earth";

     $addr = explode("/",$peer_row->addr);
     if(count($addr)>2){


     $ip_data = json_decode(file_get_contents("https://api.tridentlab.in/ipinfo/".$addr[2]));
     if(isset($ip_data->city)){
       $location =$ip_data->city.','.$ip_data->region;
     }
     if(isset($ip_data->country)){
       $cc =$ip_data->country;
     }
     $this->inda->update_peer(array("id"=>$peer_row->id),array("cc"=>$cc,"location"=>$location));
     echo "Updated->".$peer_row->peerid.','.$cc.','.$location;
   }else{
     echo $peer_row->addr;
   }
   }catch(Exception $e) {
       echo 'Message: ' .$e->getMessage();

   }
 }else{
   echo "all done";
 }



 }
}
