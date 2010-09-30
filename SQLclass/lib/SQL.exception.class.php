<?php
class SQLException extends Exception {

	// path to the log file
	private $log_file;


	public function __construct($message=NULL, $query = NULL) {

		$this->log_file =  $_SERVER['DOCUMENT_ROOT'].'/'.$_SERVER['REQUEST_URI'].'/SQLException.log';
		
		$code = mysql_errno();
		$sql_error = mysql_error();

		// open the log file for appending
		if ($fp = fopen($this->log_file,'a')) {

			// construct the log message
			$log_msg = date("[Y-m-d H:i:s]") .
				" Code: $code " .
				" || Message: $message".
				" || SQL error: $sql_error \n".
				"Query: $query\n-------\n";

			fwrite($fp, $log_msg);

			fclose($fp);
		}

		// call parent constructor
		parent::__construct($message, $code);
	}

}


?>