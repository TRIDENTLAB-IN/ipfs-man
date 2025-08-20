<?php
/*
Tasker for specific action and jobs

*/
namespace App\Controllers;
use App\Models\Inda;

class Tasker extends BaseController
{

  public function __construct(){
    $this->inda =  new Inda();
  }


   public function index(){


   }

   public function knownpeers(){
     $peer_res = ccal("swarm/peers?verbose=true&timeout=10000ms");
     if(!$peer_res){
       echo "ipfs  offline";
       exit();
     }
     //this stores  the  connected  peer id in json to used connect them back later
     $peer_obj =   json_decode($peer_res);

     $currrent_peers = array();
     foreach ($peer_obj->Peers as  $peer) {
       $peer_row = $this->inda->fetch_peer(array("peerid"=>$peer->Peer));
       if($peer_row){
         //lets  update time
         $this->inda->update_peer(array("id"=>$peer_row->id),array("pubtime"=>time()));


       }else{

         $this->inda->add_peer($peer);
       }



     }

/*

    $knownpeers_file = FCPATH.'static/data/knownpeers.json';
     //is  knownpeers file exist
    if(file_exists($knownpeers_file)){
      $known_peers_obj = json_decode(file_get_contents($knownpeers_file));
      //check is  this peer exist ?
      foreach ($currrent_peers as $key => $c_peers) {
        if(!property_exists($known_peers_obj,$key)){
          $known_peers_obj->$key = $c_peers; //lets add the peers
        }else{
            $known_peers_obj->$key->pubtime=time();
        }
      }
      foreach ($known_peers_obj as $key => $k_peer_obj) {
        if(empty($k_peer_obj->city)){
          //lets get ip info
          if(isset($k_peer_obj->addr)){
            try{
              $addr = explode("/",$k_peer_obj->addr)[2];
              $ip_data = json_decode(file_get_contents("https://api.tridentlab.in/ipinfo/".$addr));
              if(isset($ip_data->city)){
                $known_peers_obj->$key->city =$ip_data->city;
              }
              if(isset($ip_data->country)){
                $known_peers_obj->$key->country =$ip_data->country;
              }



            }catch(Exception $e) {
              echo 'Message: ' .$e->getMessage();
            }

          }

        }

      }



      echo file_put_contents($knownpeers_file,json_encode($known_peers_obj));
    }else{
       echo file_put_contents($knownpeers_file,json_encode($currrent_peers));
    }


*/


 $peercount = FCPATH.'static/data/peercount.txt';
  echo file_put_contents($peercount,count($peer_obj->Peers));

   }


   public function bandwidth(){
     #record Bandwidth every 5 min. @ new  date  only store  max/last bandwidth in /out  in total file
     $bw = ccal("stats/bw");
     if(!$bw){
       echo "ipfs  offline";
       exit();
     }

     $tdbw_json_obj = json_decode($bw);
     $today_bandwidth = FCPATH.'static/data/tdbw.json';
     if(file_exists($today_bandwidth)){
       #load json
       $tdbw_json = json_decode(file_get_contents($today_bandwidth));
       if(count($tdbw_json) > 288){
         array_shift($tdbw_json);
       }



       //load last  object
       $last_bw_obj = $tdbw_json[count($tdbw_json)-1];
       if($last_bw_obj->time+300 < time()){ #if more than 5 min passed
         array_push($tdbw_json,array("time"=>time(),"in"=>$tdbw_json_obj->TotalIn,"out"=>$tdbw_json_obj->TotalOut));
         echo file_put_contents($today_bandwidth,json_encode($tdbw_json));
       }

     }else{
       #create one
       //echo $tdbw_json_obj->TotalIn.':'.$tdbw_json_obj->TotalOut;
       $bw_data= array("time"=>time(),"in"=>$tdbw_json_obj->TotalIn,"out"=>$tdbw_json_obj->TotalOut);
       echo file_put_contents($today_bandwidth,"[".json_encode($bw_data)."]");
     }

     //total exchange  of the day

     $tt_time = mktime(0,0,0,date("m"),date("d"),date("Y"));
     $bw_obj = $this->inda->get_bw(array("pubtime"=>$tt_time));
     if($bw_obj){

       $this->inda->update_bw(array("id"=>$bw_obj->id),array("totalin"=>$tdbw_json_obj->TotalIn,"totalout"=>$tdbw_json_obj->TotalOut));
     }else{
       $this->inda->add_bw(array("pubtime"=>$tt_time,"totalin"=>$tdbw_json_obj->TotalIn,"totalout"=>$tdbw_json_obj->TotalOut));
     }
   }

}
