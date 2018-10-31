<?php
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class ListPupilTable extends WP_List_Table {
    
    var $helper;
    var $pupil_data = null;

    function __construct(){
	global $status, $page;
	global $wpdb;
	$this->helper = new Helper($wpdb);
		
	//Set parent defaults
	parent::__construct(array(
			'singular'  => 'item',
			'plural'    => 'items',
			'ajax'      => false
		) );
    }


    function column_default($item, $column_name) {
	    switch ($column_name) {
		case 'id':
		    return print_r($item,true);
		    break;
		case 'timeregister':
			$dt = date_create($item[$column_name]);
		    return date_format($dt,"d/m/Y");
		    break;
		default:
		    return $item[$column_name];
		    break;
		}
    }

    
    function column_title($item){
	    $actions = array(
		    'delete'	=> sprintf('<a href="?page=%s&action=%s&item[]=%s">Delete</a>',$_REQUEST['page'],'delete',$item['id']),
	    );
	
	
	//Return the title contents
	return sprintf('%1$s <span style="color:silver">(id:%2$s)</span>%3$s',
		/*$1%s*/ $item['title'],
		/*$2%s*/ $item['id'],
		/*$3%s*/ $this->row_actions($actions)
	);
    }

    function column_cb($item) {
	return sprintf (
		'<input type="checkbox" name="%1$s[]" value="%2$s" />',
		/*$1%s*/ $this->_args['singular'],
		/*$2%s*/ $item['id']
	);
    }


    function get_columns(){
	$columns = array(
		'cb'		=> '<input type="checkbox" />',
		'title'		=> 'Tên học sinh',
		'birthday'	=> 'Năm sinh',
		'object'	=> 'Đối tượng',
		'email' 	=> 'Email',
		'phone'		=> 'Số điện thoại',
		'country'	=> 'Quốc gia',
		'timeregister'	=> 'Ngày đăng ký',
		'Url_refer' => 'Url_refer',
		'Url_request' => 'Url_request',
		'Url_on_submit' => 'Url_on_submit',
        'course_certificate' => 'Môn, chứng chỉ'
	);
	
	$results = $this->helper->loadColumns();
	
	foreach ($results as $result)
	    $columns['ref_' . $result->text_in_refer] = $result->title;
	
	return $columns;
    }

    function get_sortable_columns() {
	$sortable_columns = array(
		'title'		=> array('Tên học sinh', true)
	);
	return $sortable_columns;
    }

    function get_bulk_actions() {
	$actions = array(
		'delete'    => 'Delete'
	);
	return $actions;
    }

    function process_bulk_action() {
	if('delete' === $this->current_action() ) {
	    $count = 0;
	    $items = isset($_GET['item'])? $_GET['item'] : null;
	    foreach($items as $item) {
			$count = $count + $this->helper->deleteItem($item);
	    }
	}
    }
    

    function prepare_items($startdate = "", $enddate = "") {
	
	global $status, $page;
	global $wpdb;	
	
	$per_page = 10;
	
	$columns = $this->get_columns();
	
	$hidden = array();
	$sortable = $this->get_sortable_columns();
		
	$this->_column_headers = array($columns, $hidden, $sortable);
	
	$this->process_bulk_action();
		
	//$results = $this->helper->loadItems();
	if ($startdate == "" && $enddate == "")
		$results = $this->helper->loadItems();
	else
		$results = $this->helper->loadItemsWithDate($startdate, $enddate);
		
	$data = array();
	$reg_columns = $this->helper->loadColumns();
	
	foreach ($results as $result) {
	    $item = array(
		    'id'		=> $result->id,
		    'title'		=> $result->full_name,
		    'birthday' 	=> $result->birthday,
			'object'	=> $result->object,
			'email'		=> $result->email,
		    'phone'		=> $result->phone_number,
			'country'	=> $result->country,
			'timeregister'   	=> $result->submitted_time,
			'Url_refer'   	=> $result->Url_refer,
			'Url_request'   	=> $result->Url_request,
			'Url_on_submit' => $result->Url_on_submit,
            'course_certificate' => $result->course_certificate
		);
	    foreach ($reg_columns as $reg_columns) {
			$reg = 'reg_' . $reg_columns->text_in_refer;
			$item[$reg] = $result->$reg;
	    }
	    array_push($data, $item);
	}
		
	$this->referrer_data = $data;

	
	function usort_order($a, $b){
	    $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'id';
	    $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'asc';
	    $result = strcmp($a[$orderby], $b[$orderby]);
	    return ($order === 'asc') ? $result : -$result;
	}
	
	//usort($data, 'usort_order');
	
	$current_page = $this->get_pagenum();

	$total_items = count($data);

	$data = array_slice($data,(($current_page-1)*$per_page),$per_page);

	$this->items = $data;

	$this->set_pagination_args( array(
		'total_items' => $total_items,
		'per_page'    => $per_page,
		'total_pages' => ceil($total_items/$per_page)
	) );
    }
	
	function extra_tablenav($which) {
		global $wpdb;

		if(isset($_REQUEST['start_date'])&&isset($_REQUEST['end_date']))
		{
			$start_date=$_REQUEST['start_date'];
			$end_date=$_REQUEST['end_date'];
		}	

		?>
		<div class="actions">
			<?php _e('Start Date');?>: <input type="text" name="start_date" class="datepick" value="<?php echo $start_date;?>" size="15" />
			<?php _e('End Date');?>: <input type="text" name="end_date" class="datepick" value="<?php echo $end_date;?>" size="15" />

			<input class="button-primary" type="submit" value="Tìm kiếm" />
			<input type="hidden" name="action" value="filter-done" />
			
			<a style="float:right;" href="<?php echo  WP_PLUGIN_URL . '/manage-register-online/'?>exportExcel.php?start_date=<?php echo $start_date?>&end_date=<?php echo $end_date;?>">Export Excel</a>
		</div>
		<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('.datepick').datepick({showTrigger: '<img src="<?php echo plugins_url( '/manage-register-online/css/images/calendar-blue.gif')?>" alt="..."></img>', dateFormat: 'dd/mm/yyyy'});
				});

			</script>
		<?php
		return;
	}
	
    function display() {
		extract( $this->_args );

		$this->display_tablenav( 'top' );

		?>
		<table class="wp-list-table <?php echo implode( ' ', $this->get_table_classes() ); ?>" cellspacing="0">
			<thead>
			<tr>
				<?php $this->print_column_headers();?>
			</tr>
			</thead>

			<tfoot>
			<tr>
				<?php $this->print_column_headers( false ); ?>
			</tr>
			</tfoot>

			<tbody id="the-list"<?php if ( $singular ) echo " data-wp-lists='list:$singular'"; ?>>
				<?php $this->display_rows_or_placeholder(); ?>
			</tbody>
		</table>
		<?php
		
	}
}

?>