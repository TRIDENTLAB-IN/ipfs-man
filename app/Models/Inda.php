<?php
namespace App\Models;
use CodeIgniter\Model;

class Inda extends Model {
  public function initialize(){
    $this->db = \Config\Database::connect();
  }

  #fetch peer row
  public function fetch_peer($where){
    return $this->db->table("peers")->where($where)->get()->getRow();
  }

  # add  new  peer  data
  public function add_peer($peer_obj){

    $peer_id = $peer_obj->Peer;
    $addr = $peer_obj->Addr;
    $latency = substr($peer_obj->Latency,0,-2);

    $this->db->table("peers")->insert(array(
      "peerid"=>$peer_id,
      "addr"=>$addr,
      "latency"=>$latency,
      "cc"=>"E",
      "location"=>"",
      "pubtime"=>time()
    ));




  }

  public function update_peer($where,$data){
    $this->db->table("peers")->where($where)->set($data)->update();

  }

  #bandwidth data

  public function get_bw($where){
    return $this->db->table("bandwidth")->where($where)->get()->getRow();
  }

  public function update_bw($where,$data){
    $this->db->table("bandwidth")->where($where)->set($data)->update();
  }

  public function add_bw($in_data){
    $this->db->table("bandwidth")->insert($in_data);
  }




}
