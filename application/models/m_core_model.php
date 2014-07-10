<?php
	
class M_core_model Extends MY_Model
{
	protected $_table;
	protected $_uid;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->database();

		$this->_uid = "id";
	}

	public function set_table($table="", $_uid = false)
	{
		$this->_table = $table;
		if($_uid){
			$this->_uid = $_uid;
		}else{
			$this->_uid = "id";
		}
	}
	
	public function run_sql($sql)
	{
		//INTENDED FOR DEVELOPMENT ONLY
		//SHOULD BE REMOVE IN PRODUCTION
		
		$array_sql = explode(";", $sql);
		
		foreach($array_sql as $qry)
		{
			if(trim($qry) != ""):
			$query = $this->db->query($qry);
		
			if(is_object($query) && $query->num_rows() > 0){
				echo "<hr/>";
				echo "Result<br/>";
				
				$result = $query->result();
				
				echo "<table border = 1 style='border-collapse:collapse;'>";
				echo "<tr>";
				echo "<th>#</th>";
				foreach($result as $obj)
				{
					foreach($obj as $key => $val)
					{
						echo "<th>".$key."</th>";
					}
					break;
				}
				echo "</tr>";
				
				$ctr = 1;
				
				foreach($result as $obj)
				{
					echo "<tr>";
					echo "<td>".$ctr."</td>";
					foreach($obj as $key => $val)
					{
						echo "<td>".$val."</td>";
					}
					echo "</tr>";
					$ctr++;
				}
				
				echo "</table>";
			}
			
			echo "<br/><hr/>Affected Rows<br/>";
			echo $this->db->affected_rows()." Affected Rows<br/>";
			echo "<br/><hr/> End of Query";
			endif;
		}
		
		echo "<hr/>";
		die();
	}
}
