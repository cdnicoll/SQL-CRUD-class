<?php
include_once('lib/csv.class.php');
$c = new CSV('localhost','root','root','world');

$query = 'SELECT ct.name AS "city", c.name AS "country", cl.language AS "language" FROM Country c INNER JOIN City ct ON (ct.countryCode = c.code) INNER JOIN CountryLanguage cl ON (cl.countryCode = c.code) LIMIT 10';

if(isset($_GET['download'])) {
	
	if ($_GET['download']) {
		$c->sqlTable($query); // the table name OR select sql statement
		$c->fileName('worldDump.csv');
		$c->export();	
	}
}

?>

<a href="?download=true/">Download</a>