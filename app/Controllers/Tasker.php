<?php
/*
Tasker for specific action and jobs

*/
namespace App\Controllers;

class Tasker extends BaseController
{

   public function index(){

   }

   public function knownpeers(){
     //this stores  the  connected  peer id in json to used connect them back later
     $peer_obj =   json_decode(ccal("swarm/peers?verbose=true&timeout=5000ms"));

     $currrent_peers = array();
     foreach ($peer_obj->Peers as  $peer) {
       $peer_id = $peer->Peer;
       $addr = $peer->Addr;
       $latency = $peer->Latency;
       $currrent_peers[$peer_id] = array("pubtime"=>time(),"addr"=>$addr,"latency"=>$latency,"city"=>"","country"=>"");
     }


    $knownpeers_file = FCPATH.'static/data/knownpeers.json';
     //is  knownpeers file exist
    if(file_exists($knownpeers_file)){
      $known_peers_obj = json_decode(file_get_contents($knownpeers_file));
      //check is  this peer exist ?
      foreach ($currrent_peers as $key => $c_peers) {
        if(!property_exists($known_peers_obj,$key)){
          $known_peers_obj->$key = $c_peers; //lets add the peers
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



   }


   public function bandwidth(){
     #record Bandwidth every 5 min. @ new  date  only store  max/last bandwidth in /out  in total file
     $bw = ccal("stats/bw");
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
     $total_bandwidth_file =   FCPATH.'static/data/ttbw.json';
     if(file_exists($total_bandwidth_file)){


       $total_bw_json = json_decode(file_get_contents($total_bandwidth_file));
       //is last object today ?
       $last_ttbw_obj = $total_bw_json[count($total_bw_json)-1];


       if($last_ttbw_obj->time == $tt_time){
         //its today data
         if($last_ttbw_obj->in < $tdbw_json_obj->TotalIn){
           $total_bw_json[count($total_bw_json)-1]->in =$tdbw_json_obj->TotalIn;
           $total_bw_json[count($total_bw_json)-1]->out =$tdbw_json_obj->TotalOut;
         }

       }else{
         //insert today data

         array_push($total_bw_json, array("time"=>$tt_time,"in"=>$tdbw_json_obj->TotalIn,"out"=>$tdbw_json_obj->TotalOut));
      }


     }else{
       $bw_data= array();
       $bw_data[] = array("time"=>$tt_time,"in"=>$tdbw_json_obj->TotalIn,"out"=>$tdbw_json_obj->TotalOut);
       echo file_put_contents($total_bandwidth_file,json_encode($bw_data));
     }


   }
}
