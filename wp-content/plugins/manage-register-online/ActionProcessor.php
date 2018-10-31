<?php
require_once( ABSPATH . 'wp-content/plugins/manage-register-online/Helper.php' );
require_once( ABSPATH . 'wp-content/plugins/manage-register-online/ListPupilTable.php' );
class ActionProcessor {
    var $helper;
    function __construct() {
        global $wpdb;
        $this->helper = new Helper($wpdb);
    }
    function processAction() {
        // PROCESS ACTION
		$action = (isset($_REQUEST['action']))? $_REQUEST['action'] : null;
	if ($action == 'filter-done')
	    $this->displayDefault($_REQUEST['start_date'],$_REQUEST['end_date']);	else 
	    $this->displayDefault();
	}
    
    function displayDefault($startdate = "",$enddate = "") {

	    $regListTable = new ListPupilTable();
				$regListTable->prepare_items($startdate, $enddate);
?>
	<h3>Danh sách học sinh đăng ký</h3>
        <form id="items-filter" method="get">
		<!-- For plugins, we also need to ensure that the form posts back to our current page -->
		<input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>" />

		<!-- Now we can render the completed list table -->
		<?php $regListTable->display(); ?>
        </form>
<?php
	}    
}
?>