<?php
class M_timekeeping extends MY_Model{

  protected $_table = 'timekeeping';

  public function __construct()
  {
  	parent::__construct();
  	$this->load->database();
  }  

  public function timeout($id, $data){

    $rs = $this->update($id, $data);

    if($rs){

      $sql = "SELECT SUBTIME(`out`,`in`) as hr FROM $this->_table WHERE id = ?";
      $q = $this->db->query($sql, array($id));
      if($q->num_rows() > 0){

        #udpate hour and minute
        $res = $q->row();
        if($res){
          $total_time = $res->hr;
          $x = explode(':', $total_time);
          if(count($x) == 3){
            unset($data);
            $data['hours'] = $x[0];
            $data['minutes'] = $x[1];
            $this->update($id, $data);
          }
        }
      }

    }
  }
}
?>
