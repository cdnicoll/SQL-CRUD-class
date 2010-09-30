<?php

include_once('sql.class.php');
//include_once('SQLException.exception.class.php');

class Model
{
    private $db;    // Hold a database object
    
    public function Model()
    {
        $this->db = new Database('localhost','root','root','world');
    }
    
    /*
    function showing a select where all conent is obtained and the
    city name is vancouver
    */
    public function selectEg1()
    {
		try {
			// call first method. connect
	    	$this->db->connect();
			//($table, $rows, $where, $order, $limit)
			$this->db->select('City','*', 'name="Vancouver"', null, 10);	//SELECT * FROM City WHERE name = "Vancouver" LIMIT 10
			$result = $this->db->getResult();								// get the results
	    	$this->db->disconnect();    									// disconnect from DB
	    
	    	return $result;    												// return the results
	
		} catch(SQLException $e) {
			$this->db->disconnect();  
			die("SQL Error: ".$e->getMessage());
		}
    }
    
    /*
    function showing off how to get all cities with the name vancouver 
    and limit the result set to 10
    */
    public function selectEg2()
	{
	    // call first method. connect
    	$this->db->connect();
    	
    	//($table, $rows, $where, $order, $limit)
	    $this->db->select('City','*', 'name="Vancouver"', null, 10);  //SELECT a *(all) LIMIT 10 
    	$result = $this->db->getResult();
	    $this->db->disconnect();    // disconnect from DB
	}
	
	/*
    function showing a result set returned on the whole table, displaying
    only 10 results
    */
    public function selectEg3()
    {
        // call first method. connect
    	$this->db->connect();
    	
    	//($table, $rows, $where, $order, $limit)
	   if($this->db->select('City','*', null, null, 10) == true)  {  //SELECT a *(all) LIMIT 10 
    	    $result = $this->db->getResult();
	    }
	    $this->db->disconnect();    // disconnect from DB
	    
	    return $result;    // return the results
    }
    
    public function insertEg1()
    {
        try {
			$this->db->connect();
			$this->db->insert('City', array("Vancouver","VAN", "BC2", 514008),'Name, CountryCode, District, Population');
			$this->db->disconnect();  
			return true;
		} catch(SQLException $e) {
			$this->db->disconnect();  
			die("SQL Error: ".$e->getMessage());
		}
    }
    
    public function updateEg1()
    {
		try {
			$this->db->connect();
			$this->db->update('City',array('District'=>'BC', 'Name'=>'VanCity'),array('District','BC2','Population',514008));
			$this->db->disconnect();
			return true;
		} catch(SQLException $e) {
			$this->db->disconnect();  
			die("SQL Error: ".$e->getMessage());
		}

    }

	public function deleteEg1()
    {
		try {
			$this->db->connect();
			// delete($table, $where = null)
			$this->db->delete('City','District="BC" AND Population=514008');
			$this->db->disconnect();
			return true;
		} catch(SQLException $e) {
			$this->db->disconnect();  
			die("SQL Error: ".$e->getMessage());
		}
		
        //$db->update('City',array('District'=>'BC', 'Name'=>'VanCity'),array('ID',4085)); 
    }
}
?>