<?php
/*
 * Plugin Name: Simple Stripe Checkout Manager
 * Author: Kyle M. Brown <kyle@kylembrown.com>
 * Plugin URI: 
 * Description: This plug-in will show stripe transaction details inside of your WordPress Admin area.
 * Version: 1.1
 * Author URI: 
 * License: GPL2
 */



if ( ! defined( 'ABSPATH' ) ) { 
    exit; // Exit if accessed directly
}

register_activation_hook( __FILE__, 'stripe_transaction_details_activate' );
//register_deactivation_hook( __FILE__, 'stripe_transaction_details_deactivate' );
add_action('admin_menu', 'stripe_checkout_pro_manager_menu');


// Register style sheet.
add_action( 'init', 'register_plugin_styles' );

/**
 * Register style sheet.
 */
function register_plugin_styles() {
	wp_register_style( 'strip-transaction-pro', plugins_url( 'simple-stripe-checkout-manager/css/stripe-transaction-style.css' ) );
	wp_enqueue_style( 'strip-transaction-pro' );
}

### Wordpress action hook start to add the Menu of bid management plugin ##############
$icon='gid.jif';
function stripe_checkout_pro_manager_menu() {
	add_submenu_page( 'stripe-checkout-pro', 'Manager', 'Manager', 'manage_options', 'stripe-transaction-page', 'stripe_transaction_page' ); 
	add_submenu_page( 'stripe-checkout', 'Manager', 'Manager', 'manage_options', 'stripe-transaction-page', 'stripe_transaction_page' );
}



function stripe_transaction_page(){
	if(empty($_GET['action-type']) && empty($_GET['id'])){
		require_once plugin_dir_path( __FILE__ ) . 'inc/class.transaction-list-table.php';
		$User_Transaction_Table = new User_Transaction_Table();
		$User_Transaction_Table->prepare_items();
		require_once plugin_dir_path( __FILE__ ) . 'transaction-template.php';
	}else{
		require_once plugin_dir_path( __FILE__ ) . 'transaction-view.php';
	}
}



function sc_change_details( $html, $charge_response ) {
	global $wpdb;	
	$table_name = $wpdb->prefix."stripe_transaction_details";
	$sql_query = 'select * from '.$table_name." where strip_transaction_id='".$charge_response->id."'";
	$result = $wpdb->get_row($sql_query);


	if(!empty($charge_response->invoice)){
		$invoice = \Stripe\Invoice::retrieve( $charge_response->invoice);
		$subscription = $invoice->subscription;
		//echo 'subscription'.$subscription;
	}

	
	if(empty($result)){
		$strip_transaction_id = $charge_response->id;	
		$strip_object = $charge_response->object;
		$strip_created_at = $charge_response->created;
		$strip_livemode = $charge_response->livemode;
		$strip_paid = $charge_response->paid;
		$strip_status = $charge_response->status;
		$strip_amount = $charge_response->amount;
		$strip_currency = $charge_response->currency;
		$strip_refunded = $charge_response->refunded;
		$strip_card_object = $charge_response->source->object;
		$strip_last4 = $charge_response->source->last4;
		$strip_brand = $charge_response->source->brand;
		$strip_funding = $charge_response->source->funding;
		$strip_exp_month = $charge_response->source->exp_month;
		$strip_exp_year = $charge_response->source->exp_year;
		$strip_fingerprint = $charge_response->source->fingerprint;
		$strip_country = $charge_response->source->country;
		$strip_name = $charge_response->source->name;
		$strip_address_line1 = $charge_response->source->address_line1;
		$strip_address_line2 = $charge_response->source->address_line2;
		$strip_address_city = $charge_response->source->address_city;
		$strip_address_state = $charge_response->source->address_state;
		$strip_address_zip = $charge_response->source->address_zip;
		$strip_address_country = $charge_response->source->address_country;
		$strip_cvc_check = $charge_response->source->cvc_check;
		$strip_address_line1_check = $charge_response->source->address_line1_check;
		$strip_address_zip_check = $charge_response->source->address_zip_check;
		$strip_dynamic_last4 = $charge_response->source->dynamic_last4;
		$strip_balance_transaction = $charge_response->balance_transaction;	
		$strip_failure_message = $charge_response->failure_message;
		$strip_failure_code = $charge_response->failure_code;
		$strip_amount_refunded = $charge_response->amount_refunded;
		$strip_customer = $charge_response->customer;
		$strip_invoice = $charge_response->invoice;
		$strip_description = $charge_response->description;
		$strip_dispute = $charge_response->dispute;
		$sql_query = "insert into $table_name (strip_transaction_id,strip_object,strip_livemode,strip_paid,strip_status,strip_amount,strip_currency,strip_refunded,strip_card_object,strip_last4,strip_brand,strip_funding,strip_exp_month,strip_exp_year,strip_fingerprint,strip_country,strip_name,strip_address_line1,strip_address_line2,strip_address_city,strip_address_state,strip_address_zip,strip_address_country,strip_cvc_check,strip_address_line1_check,strip_address_zip_check,strip_dynamic_last4,strip_balance_transaction,strip_failure_message,strip_failure_code,strip_amount_refunded,strip_customer,strip_invoice,strip_description,strip_dispute) values('".$strip_transaction_id."','".$strip_object."','".$strip_livemode."','".$strip_paid."','".$strip_status."','".$strip_amount."','".$strip_currency."','".$strip_refunded."','".$strip_card_object."','".$strip_last4."','".$strip_brand."','".$strip_funding."','".$strip_exp_month."','".$strip_exp_year."','".$strip_fingerprint."','".$strip_country."','".$strip_name."','".$strip_address_line1."','".$strip_address_line2."','".$strip_address_city."','".$strip_address_state."','".$strip_address_zip."','".$strip_address_country."','".$strip_cvc_check."','".$strip_address_line1_check."','".$strip_address_zip_check."','".$strip_dynamic_last4."','".$strip_balance_transaction."','".$strip_failure_message."','".$strip_failure_code."','".$strip_amount_refunded."','".$strip_customer."','".$strip_invoice."','".$strip_description."','".$strip_dispute."')";
		$wpdb->query($sql_query);
	}
	//echo '<pre>';
	//print_r($charge_response);
	

	return $html;
	
}



add_filter( 'sc_payment_details', 'sc_change_details', 10, 2 );


##### Function start to activated the  plugin with the all the possible TABLE Entities ###

function stripe_transaction_details_activate()
{
	global $wpdb;
	$table_name = $wpdb->prefix . "stripe_transaction_details";

	if($wpdb->get_var("show tables like '$table_name'") != $table_name)
	{
		$sql = "CREATE TABLE ".$table_name." (
			  id int(11) NOT NULL primary key auto_increment, 
			  strip_transaction_id varchar(255),
			  strip_object varchar(255),
			  strip_created_at  TIMESTAMP,
			  strip_livemode varchar(255),
			  strip_paid varchar(255),
			  strip_status varchar(255),
			  strip_amount float(11),
			  strip_currency varchar(255),			 
			  strip_refunded varchar(255),
			  strip_card_object varchar(255),
			  strip_last4 int(11),
			  strip_brand varchar(255),
			  strip_funding varchar(255),
			  strip_exp_month int(3),
			  strip_exp_year int(5),
			  strip_fingerprint varchar(255),
			  strip_country varchar(255),
			  strip_name varchar(255),
			  strip_address_line1 varchar(255),
			  strip_address_line2 varchar(255),
			  strip_address_city varchar(255),
			  strip_address_state varchar(255),
			  strip_address_zip varchar(255),
			  strip_address_country varchar(255),
			  strip_cvc_check varchar(255),
			  strip_address_line1_check varchar(255),
			  strip_address_zip_check varchar(255),
			  strip_dynamic_last4 varchar(255),
			  strip_balance_transaction varchar(255),
			  strip_failure_message varchar(255),
			  strip_failure_code varchar(255),
			  strip_amount_refunded varchar(255),
			  strip_customer varchar(255),
			  strip_invoice varchar(255),
			  strip_description varchar(255),
			  strip_dispute varchar(255)
		)";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	
}


##### Function start to deactivate the plugin with the all the possible TABLE Entities ###

function stripe_transaction_details_deactivate()
{
   global $wpdb;
   $table_name = $wpdb->prefix . 'stripe_transaction_details';
   $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
?>