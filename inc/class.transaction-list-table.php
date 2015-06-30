<?php

class User_Transaction_Table extends WP_List_Table {

	function __construct() {
		global $status, $page;

		// Set parent defaults
		parent::__construct( array(
				'singular'  => 'transaction',     // singular name of the listed records
				'plural'    => 'transactions',    // plural name of the listed records
				'ajax'      => false        // does this table support ajax?
			) );

    // Add helper JS
	  wp_deregister_script('record_transaction_admin_table');
      wp_enqueue_script( 'record_transaction_admin_table',
      plugin_dir_url( __FILE__ ) . '../js/record_transaction_admin_table.js', array( 'jquery' ), '1.3', true );

	}

	function column_default( $item, $column_name ) {
		switch ( $column_name ) {
		case 'id':
			return $item[$column_name];	
		case 'strip_transaction_id':
			return $item[$column_name];
		case 'strip_invoice':
			return $this->check_invoice($item[$column_name]);	
		case 'strip_name':
			return $item[$column_name];
		case 'strip_amount':
			return $item[$column_name];
		case 'strip_created_at':
			return $item[$column_name];		
		default:
			return print_r( $item, true ); // Show the whole array for troubleshooting purposes
		}
	}

	function check_invoice($value){
		if($value == ""){
			$invoice_type = "One Time";
		}else{
			$invoice_type = "Recurring";
		}
		return $invoice_type;
	}


	function column_strip_transaction_id( $item ) {
		// Build row actions
		$actions = array(
			'view'    => sprintf( '<a  href="?page=%s&action-type=%s&id=%s">View</a>', $_REQUEST['page'], 'view', $item['id'] ),
		);
		// Return the title contents
		return sprintf( '%1$s %3$s',
			/*$1%s*/ $item['strip_transaction_id'],
			/*$2%s*/ $item['id'],
			/*$3%s*/ $this->row_actions( $actions )
		);
	}





	function column_cb( $item ) {
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			/*$1%s*/ $this->_args['singular'],
			/*$2%s*/ $item['id']
		);
	}

	function get_columns() {
		$columns = array(
			'cb'          => '<input type="checkbox" />', // Render a checkbox instead of text
			'strip_transaction_id'    => 'Transaction ID',
			'strip_name'    => 'Name',
			'strip_invoice'    => 'Type',
			'strip_amount'   => 'Amount',
			'strip_created_at' => 'Date'

		);
		return $columns;
	}

	function get_sortable_columns() {
		
		$sortable_columns = array(			
			//'strip_name'    => array( 'strip_name', false )
			
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
		if ( 'delete' === $this->current_action() ) {
			global $wpdb;
			if ( isset($_REQUEST['transaction']) ) {
				if ( is_array( $_REQUEST['transaction'] ) ) {
					// Delete multiple transaction
					foreach ( $_REQUEST['transaction'] as &$transaction ) {
						$wpdb->delete( $wpdb->prefix . 'stripe_transaction_details', array( 'id' => $transaction ) );
					}
				} else {
					// Delete single transaction
					$wpdb->delete( $wpdb->prefix . 'stripe_transaction_details', array( 'id' => $_REQUEST['transaction'] ) );
				}
			}
		}

	}

	

	function prepare_items() {
		global $wpdb; $_wp_column_headers;
		 $screen = get_current_screen();

		// Bulk action handler
		$this->process_bulk_action();

		// Initial query
		$query = "SELECT * FROM " . $wpdb->prefix . "stripe_transaction_details";

		// Parameters that are going to be used to order the result
		$orderby = !empty( $_GET["orderby"] ) ? $_GET["orderby"]  : 'id';
		$order = !empty( $_GET["order"] ) ? $_GET["order"]  : 'DESC';
		if ( !empty( $orderby ) & !empty( $order ) ) { $query.=' ORDER BY '.$orderby.' '.$order; }

		// Number of elements in your table?
		$total_items = $wpdb->query( $query ); //return the total number of affected rows

		
		// How many to display per page?
		$per_page = 20;

		// Which page is this?
		$paged = !empty( $_GET["paged"] ) ? $_GET["paged"] : '';

		// Page Number
		if ( empty( $paged ) || !is_numeric( $paged ) || $paged<=0 ) { $paged=1; }

		// How many pages do we have in total?
		$total_pages = ceil( $total_items/$per_page );

		// Adjust the query to take pagination into account
		if ( !empty( $paged ) && !empty( $per_page ) ) {
			$offset = ( $paged - 1 ) * $per_page;
			$query .= ' LIMIT ' . (int)$offset . ',' . (int)$per_page;
		}

		// Register the pagination
		$this->set_pagination_args( array(
				"total_items" => $total_items,
				"total_pages" => $total_pages,
				"per_page" => $per_page,
			) );

		// Register the Columns
		$columns = $this->get_columns();
		$hidden = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );

		// Fetch the items
		$this->items = $wpdb->get_results( $query, ARRAY_A );

		
	}

}

?>
