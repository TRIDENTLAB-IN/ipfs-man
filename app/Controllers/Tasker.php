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
     //if(file_exist())
     echo FCPATH;




   }
}
