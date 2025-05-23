<?php
/*
Tasker for specific action and jobs

*/
namespace App\Controllers;

class Tasker extends BaseController
{

   public function index(){

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


       //check if the day entry exist
       if(property_exists($total_bw_json,$tt_time)){


         if($total_bw_json->$tt_time->in < $tdbw_json_obj->TotalIn){
           $total_bw_json->$tt_time->in = $tdbw_json_obj->TotalIn;
           $total_bw_json->$tt_time->out = $tdbw_json_obj->TotalOut;
         }

       }else{
         
         $total_bw_json->$tt_time = array("in"=>$tdbw_json_obj->TotalIn,"out"=>$tdbw_json_obj->TotalOut);

       }
       echo file_put_contents($total_bandwidth_file,json_encode($total_bw_json));


     }else{
       $bw_data= array();
       $bw_data[0]=array("in"=>0,"out"=>0);
       $bw_data[$tt_time] = array("in"=>$tdbw_json_obj->TotalIn,"out"=>$tdbw_json_obj->TotalOut);
       echo file_put_contents($total_bandwidth_file,json_encode($bw_data));
     }







   }
}
