<?php

namespace model;

class Folder {

    function __construct()
    {
        include( "mysql.php" );
    }

	public function getById($id){
		$r = mysql_query("SELECT  id, name FROM folders where id = $id");
    	if (!$r) throw new Exception('SQL SELECT failed');
    	$result = array();
	    while ($row = mysql_fetch_array($r, MYSQL_NUM)) {
	        $el = array();
	        array_push($el, $row[0]);
	        array_push($el, $row[1]);
	        array_push($result, $el);
	    }
	}

	public function getAll(){
		$r = mysql_query("SELECT  id, name FROM folders");
    	if (!$r) throw new Exception('SQL SELECT failed');
    	$result = array();
	    while ($row = mysql_fetch_array($r, MYSQL_NUM)) {
	        $el = array();
	        array_push($el, $row[0]);
	        array_push($el, $row[1]);
	        array_push($result, $el);
	    }
	} 	
		
	public function updateById($newItem){

	}

	public function updateAll($collection){

	} 	

	public function createNew($newItem){

	} 	

	public function deleteById($id){

	}

	public function deleteAll(){

	} 	

}