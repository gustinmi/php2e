<?php

namespace controllers;

class Category extends Controller implements ICrud {

    public function __construct() {
        parent::__construct();
    }

	// retrieve
	public function get($args){
        logm(__CLASS__  . ' ' . __METHOD__ . __LINE__ ."\r\n");
        $id = is_array($args) && array_key_exists('id', $args) ? $args['id'] : NULL;
        $q = isset($id) ? "SELECT id, name FROM categories where id = $id" : "SELECT  id, name FROM categories";
        $r = mysqli_query($this->link, $q);
        if (!$r) die ('SQL SELECT failed' . $q);
        $result = array();
        while ($row = mysqli_fetch_array($r)) {
            $el = array();
            array_push($el, $row[0]);
            array_push($el, $row[1]);
            array_push($result, $el);
        }
		return $this->renderResponse($result);
	}

	// replace
	public function put($args){
        if (array_key_exists('id',$args) && array_key_exists('name',$args)){
            extract($args);
            $q = "UPDATE categories SET name = '${name}' WHERE id = $id";
            $result = mysqli_query($this->link, $q);
        }
        return $result == true ? $this->renderResponse(array()) : $this->renderError(array());
	}

	// create new
	public function post($args){
        if (array_key_exists('name',$args)){
            extract($args);
            $q = "INSERT INTO categories VALUES (NULL, '${name}')";
            logm($q);
            $result = mysqli_query($this->link, $q);
        }

        return $result == true ? $this->renderResponse(array()) : $this->renderError(array());
	}

	// delete
	public function delete($args){
        $id = is_array($args) && array_key_exists('id', $args) ? $args['id'] : NULL;
        $q = "DELETE FROM categories where id = ${id}";
        mysqli_query($this->link, $q);
		return $this->renderResponse(array());
	}
		

}