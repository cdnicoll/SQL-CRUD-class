<?php
################################################
## NOTE:
##      THIS USES THE WORLD DATABASE
// DROP DATABASE IF EXISTS world;
// CREATE DATABASE world;
// USE world;
// SOURCE sql_files/world.sql;
################################################
	include('lib/model.class.php');    // include the sql class file

    $model = new Model();
    
	$case = 1;
	
	switch($case) {
		case 1: {
			echo '<h3>'.'Case 1'.'</h3>';
			
			$select = $model->selectEg1();
			echo '<pre>';
		    	print_r($select);
		    echo '</pre>';
		}
		break;
		
		case 2: {
			echo '<h3>'.'Case 2'.'</h3>';
			
			if($model->insertEg1()) {
				echo "--Running insert--";
			}
			
			if($model->updateEg1()) {
				echo "--Running Update--";
			}
			
			if($model->deleteEg1()) {
				echo "--Running Delete--";
			}
		}
		break;
		
		case 3: {
			
			
		}
		
		default:
			echo '<h3>'.'No test selected'.'</h3>';
		break;
		
	}

    
	
    //$q2 = $model->selectEg2();
    //$q3 = $model->selectEg3();
    
    
    /*
    echo '<pre>';
    	print_r($q2);
    echo '</pre>';
    echo "<hr>";
    
    echo '<pre>';
    	print_r($q3);
    echo '</pre>';
    */
?>