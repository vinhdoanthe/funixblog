<?php

class Helper {
    var $wpdb;
    var $register_table;
	
    function __construct($wpdb) {
        $this->wpdb = $wpdb;
        $table_prefix = $wpdb->prefix;
		$register_table_name = 'register';
		$register_table_with_prefix = $table_prefix . $register_table_name;		
		$this->register_table 	= $register_table_with_prefix;

    }

    function loadItem($id = 0) {
		$sql = "SELECT * FROM ". $this->register_table ." WHERE id = " . $id;
		$result = $this->wpdb->get_row($sql);
		return $result;

    }

    

    function loadItems() {
		
        $sql1 = "SELECT * FROM ". $this->register_table . " ORDER BY submitted_time DESC";
		$result = $this->wpdb->get_results($sql1);
		
        return $result;
		
    }
	
	
	function loadItemsWithDate($startdate, $enddate) {
	$where = "1 = 1 ";
		if(!empty($startdate)){
			$start_date = date("Y-m-d",strtotime(str_replace('/','-',$startdate)));
			$where .= " AND submitted_time >='".$start_date." 00:00:00' ";
		}

		if(!empty($enddate))
		{
			$end_date = date("Y-m-d",strtotime(str_replace('/','-',$enddate)));
			$where .=" AND submitted_time <='".$end_date." 23:59:59' ";
		}
	
        $sql = "SELECT * FROM ". $this->register_table . " WHERE " . $where . " ORDER BY submitted_time DESC";
		$result = $this->wpdb->get_results($sql);
        return $result;
		
    }

    

    function loadAllItems() {

        $sql = "SELECT * FROM ". $this->register_table;

		$result = $this->wpdb->get_results($sql);

        return $result;

    }

    

    function deleteItem($item_id = 0) {

		try {

            $sql = "DELETE FROM ". $this->register_table ." WHERE id = " . $item_id;

            $this->wpdb->query($sql);

        } catch (Exception $ex) {

	    echo $ex;

            return 0;

        }

        return 1;

    }

    

    function insertItem($item) {

	try {

	    $result = $this->wpdb->insert($this->register_table, $item);

	    return $result;

        } catch (Exception $ex) {

            echo $ex;

	    return 0;

        }

    }

	function loadColumns() {
		$sql = "SELECT * FROM ". $this->column_table;
		$result = $this->wpdb->get_results($sql);
        return $result;

    }
}
?>