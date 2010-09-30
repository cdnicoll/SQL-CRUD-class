<?
/**
 * Database CSV Class
 *
 * This class is meant to extract data from a database and put it into a .csv
 * document.  With this class you can set to be prompted to download the csv,
 * write the csv to a folder on your server or both.
 *
 * For more information visit www.boedesign.com
 *
 * @version 1.0
 * @author Jordan Boesch <jordan@boedesign.com>
 * @copyright Copyright (c) 2008 - 2009 Jordan Boesch
 * @link http://www.boedesign.com/
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 */
/**

// Example 1
$c = new Database_CSV();
$c->sqlTable('SELECT * FROM page_content LEFT JOIN page_details ON page_content.page_id = page_details.page_id');
$c->fileName('myfile.csv');
$c->ignoreFields(array('page_id')); // optional
$c->renameFields(array('title' => 'Teetle')); // optional
$c->humanizeFields(true); // optional (defaults to false)
$c->errors(true); // optional (defaults to false)
$c->export(); // accepts 'both', 'server' and 'download' (defaults to download)

/*
Example 2

$c = new Database_CSV();
$c->sqlTable('SELECT patients.name, meds.name, meds.dose FROM patients LEFT JOIN meds ON patients.med_id = meds.med_id');
$c->fileName('myfile.csv');
$c->humanizeFields(true); // optional (defaults to false)
$c->export('both'); // accepts 'both', 'server' and 'download' (defaults to download)

*/

/*
Example 3 

$c = new Database_CSV();
$c->sqlTable('SELECT * FROM articles');
$c->fileName('myfile.csv');
$c->saveTo('backups/test/another/teasd'); // optional (where you want the .csv to be put on your server)
$c->export('server'); // accepts 'both', 'server' and 'download' (defaults to download)

*/

/*
Example 4

$c = new Database_CSV();
$c->sqlTable('articles');
$c->fileName('articles.csv');
$c->export(); // accepts 'both', 'server' and 'download' (defaults to download)
 */
 
 /*
 TODO: 
 	- Add "orderFields" function to sort them in a certain way.
 	- Add try/catch block for initializing
 */
 
include_once('sql.class.php');

class CSV extends Database {
    
	/**
    * Table to extract data from
    * @var string
    */
    private $table = '';
	
	/**
    * SQL statement to use (instead of specifying a $table)
    * @var string
    */
	private $sql = '';
	
	/**
    * Fields in the table
    * @var array
    */
    private $fields = array();
	
	/**
    * Default file name for exporting, can be over-ridden
    * @var string
    */
	private $file_name = 'export.csv';
	
	/**
    * Fields that will be ignored before the export
    * @var array
    */
	private $ignore_fields = array();
	
	/**
    * Fields that will be renamed before the export
    * @var array
    */
	private $rename_fields = array();
	
	/**
    * Take fields and rewrite them to be read in a human fashion.  Example: 'first_name' would become 'First Name'
    * @var bool
    */
	private $humanize_fields = false;
	
	/**
    * Do you want it to prompt you to download the file? Do you want it to just store on the server or both?
    * @var string (download, server, both)
    */
	private $output_type = 'download';
	
	/**
    * Array to store errors in if any occur
    * @var array
    */
	private $_errors = array();
	
	/**
    * If export('server') is specified, where are we going to save the file to?
    * @var string
    */
	private $save_to_folder = '';
	
	/**
    * Display errors if there are any
    * @var bool
    */
	private $errors_set = false;
   	
	// constructor
	public function __construct ($db_host, $db_user, $db_pass, $db_name)
	{
		parent::__construct($db_host, $db_user, $db_pass, $db_name);
	}
	
	/**
    * Set a table to grab data from or use an SQL statement
	* @param string: SQL statement or table name
    * @access public
    */
    public function sqlTable($sql_table){
		
		$sel = substr($sql_table,0,6);
		// check for the keyword "select"
		(stristr($sel,'SELECT')) ? $this->sql = $sql_table : $this->table = $sql_table;
    }
	
	/**
    * Set fields to ignore (OPTIONAL)
	* @param array: Array of fields to ignore. Example array('id')
    * @access public
    */
	public function ignoreFields($fields){
		
		if(is_array($fields)){
			foreach($fields as $f) $this->ignore_fields[] = $f;
		}
	}
   	
	/**
    * Set fields to rename (OPTIONAL)
	* @param array: Array of fields to rename. Example array('per_recc' => 'Personal Recommendation')
    * @access public
    */
    public function renameFields($fields){
       
       if(is_array($fields)){
			foreach($fields as $f => $rename) $this->rename_fields[$f] = $rename;
	   }
    }
   
   /**
    * Set the field names to a readable format (OPTIONAL)
	* @param bool: Example: 'first_name' would become 'First Name'
    * @access public
    */
    public function humanizeFields($bool){ 
	   $this->humanize_fields = $bool;
    }
	
	/**
    * Set the file name (OPTIONAL)
	* @param bool: Example: 'first_name' would become 'First Name'
    * @access public
    */
	public function fileName($name){
		$this->file_name =  str_replace(array('.csv','_csv'),'',$this->_file_friendly($name)).'.csv';
	}
	
	/**
    * Set if we want to display errors
	* @param bool: True or false
    * @access public
    */
	public function errors($bool){
		$this->errors_set = $bool;
	}
   	
	/**
    * Bundle it into one and let 'er rip 
    * @access public
    */
    public function export($output_type = null){
       
	   	if(isset($output_type)) $this->output_type = $output_type;
        // if we are dealing with one table
        if($this->table){
            //$sql = "SELECT * FROM ".$this->table;
        }
        // if we are dealing with an sql statement
        else if($this->sql){
           $sql = $this->sql;
        }
		
		$this->connect();
		$this->customQuery($sql);
		$arr = $this->getResult();
		$this->fields = $this->_fieldNames($arr);
		$this->disconnect();
		
		// if their aren't any errors
		//if(false) {
		if(!$this->_has_errors()) {
			
			$top_fields = $this->fields;
			
			// take away fields that we are ignoring
			if($this->ignore_fields){
				foreach($this->ignore_fields as $f){
					$k = array_search($f,$this->fields);
					if(isset($this->fields[$k]))
						unset($this->fields[$k]);
					else
						if($this->errors_set) $this->_set_error('The field: <strong>'.$f.'</strong> does not exist. (function: ignoreFields)');
				}
			}
			
			// rename the fields
			if($this->rename_fields){
				$top_fields = $this->fields;
				$renamed = array(); // we want to remember which fields we renamed, for if they humanize
				foreach($this->rename_fields as $f => $rename){
					$k = array_search($f,$top_fields);
					if(isset($top_fields[$k])){
						$top_fields[$k] = $rename;
						$renamed[$k] = $rename;
					}
					else {
						if($this->errors_set) $this->_set_error('The field: <strong>'.$f.'</strong> does not exist. (function: renameFields)');
					}
				}
			}
			
			// humanize the fields
			if($this->humanize_fields){
				// if they have renamed the fields.. there should not be a conflict
				if(isset($renamed)){
					foreach($this->fields as $k => $field){
						if(!isset($renamed[$k])) $top_fields[$k] = $this->_humanize($field);
					}
				}
				else {
					$top_fields = $this->fields;
					foreach($top_fields as $f){
						$k = array_search($f,$top_fields);
						$top_fields[$k] = $this->_humanize($f);
					}
				}
			}
			
			$tempFields = implode(',',$top_fields)."\n";
			
			
			foreach($arr as $key) {
				$row[]="\n";
				foreach($key as $k=>$v) {
					$row[] = $v.',';
				} 
			}
			
			$tempFields .= implode($row);
			
			
			//echo $tempFields;
			
			
			/*
			while($data = mysql_fetch_assoc($q)){
				$row = array();
				foreach($this->fields as $field) $row[] = $data[$field];
				$tempFields .= implode(',',$row)."\n";
			}
			*/
			
			if(!$this->_has_errors()){
				$this->_output($tempFields,$this->file_name,$this->output_type);
			}
			else {
				//$this->_print_errors();
			}
		}
		else {
			//$this->_print_errors();
			
		}
       
    }
   
   
   	/**
    * Send it for output
    * @access private
    */
	public function saveTo($folder){
		
		$f = strrev($folder);
		$slash = (substr($f,0,1) != '/') ? '/' : '';
		$folder = $folder.$slash;
		if(!is_dir($folder)) $this->recursive_mkdir($folder);
		$this->save_to_folder = $folder.$slash;
		
	}
   
   	/**
    * Send it for output
    * @access private
    */
	private function _output($data,$filename,$type){
		
		if($this->_has_errors()) $this->_print_errors();
		// this will put the .csv on the server with the path you specified
		if($type == 'server' || $type == 'both'){
		
			$lines = explode("\n",$data);
			foreach($lines as $line){
				$list[] = $line;
			}
			
			$fp = fopen($this->save_to_folder.$filename, 'w');
			
			foreach ($list as $line) {
				fputcsv($fp, split(',', $line));
			}
			
			fclose($fp);

			if($type == 'both'){
				header('Content-type: application/csv');
				header('Content-Disposition: attachment; filename="'.$filename.'"');
				//echo $data;
			}
			
		}
		
		else if($type == 'download' || $type == 'both'){
		
			header('Content-type: application/csv');
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			echo $data;
			
		}
		
	}
	
	/**
    * Make the .csv file have legal chars if it is renamed manually
    * @access private
    */
	private function _file_friendly($file){
		return preg_replace(array('/[^\w\s]/', '/\\s+/') , array(' ', '_'), $file);
	}
	
	/**
    * If the field values have a comma, get rid of it.  This needs to be fixed some how
    * @access private
    */
	private function _clean($data){
		$data = str_replace(',','',$data);
		return $data;
	}
	
	/**
    * Alter fields to show up in a human readable format
    * @access private
    */
	private function _humanize($str){
		$str = ucwords(str_replace(array('_'),array(' '),$str));
		return $str;
	}
   	
	/**
    * Append each error to the $_errors array
    * @access private
    */
    private function _set_error($str){
        $this->_errors[] = $str;
    }
	
	/**
    * Print out the errors in text instead of an array
    * @access private
    */
	private function _print_errors(){
	
		$str = '';
		foreach($this->_errors as $e){
			$str .= $e.'<br>';
		}
		//echo $str;
		exit;
		
	}
	
	/**
    * Provide a check to see if we have errors
    * @access private
    */
	private function _has_errors(){
		return (count($this->_errors) > 0) ? true : false;
	}
   
   	/**
    * Return a list of each field from the DB
    * @access private
    */
    private function _fieldNames($sql) {
        
		return array_keys($sql[0]);		
    }
	
	/**
    * Allows multiple directories to be made
    * @access private
    */
	private function recursive_mkdir($path, $mode = 0777) {
	
		$dirs = explode('/', $path);
		$count = count($dirs);
		$path = '.';
		
		for ($i = 0; $i < $count; ++$i) {
			$path .= '/'.$dirs[$i];
			if (!is_dir($path) && !mkdir($path, $mode)) {
				return false;
			}
		}
		return true;
	}

}


?>