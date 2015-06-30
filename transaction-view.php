<?php
if(!empty($_GET['action-type']) && !empty($_GET['id'])){
	global $wpdb;
	$table_name = $wpdb->prefix."stripe_transaction_details where id='".$_GET['id']."'";
	$sql_query = 'select * from '.$table_name;
	$result = $wpdb->get_row($sql_query);
}
?>
<div class="wrap">
  <h2>Simple Stripe Checkout Manager</h2>
  <h3>Transaction Details</h3>
  <table class="form-table-new">
	<tbody>
		<tr valign="top">	
			<th valign="top" scope="row">Transaction ID</th>
			<td><label class="description"><?php echo $result->strip_transaction_id; ?></label></td>
		</tr>
    <tr valign="top">	
			<th valign="top" scope="row">Customer ID</th>
			<td><label class="description"><?php echo $result->strip_customer; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Name</th>
			<td><label class="description"><?php echo $result->strip_name; ?></label></td>
		</tr>		
		<tr valign="top">	
			<th valign="top" scope="row">Type</th>
			<td><label class="description"><?php echo $result->strip_invoice == "" ? "One Time" : "Recurring"; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Description</th>
			<td><label class="description"><?php echo $result->strip_description; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Invoice</th>
			<td><label class="description"><?php echo $result->strip_invoice; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Amount</th>
			<td><label class="description"><?php echo $result->strip_amount; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Paid</th>
			<td><label class="description"><?php echo $result->strip_paid; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Created Date</th>
			<td><label class="description"><?php echo $result->strip_created_at; ?></label></td>
		</tr>	
		<tr valign="top">	
			<th valign="top" scope="row">Object</th>
			<td><label class="description"><?php echo $result->strip_object; ?></label></td>
		</tr>
		
		<tr valign="top">	
			<th valign="top" scope="row">Livemode</th>
			<td><label class="description"><?php echo $result->strip_livemode; ?></label></td>
		</tr>		
		<tr valign="top">	
			<th valign="top" scope="row">Status</th>
			<td><label class="description"><?php echo $result->strip_status; ?></label></td>
		</tr>	
		
		<tr valign="top">	
			<th valign="top" scope="row">Currency</th>
			<td><label class="description"><?php echo $result->strip_currency; ?></label></td>
		</tr>	
		<tr valign="top">	
			<th valign="top" scope="row">Refunded</th>
			<td><label class="description"><?php echo $result->strip_refunded; ?></label></td>
		</tr>	
		<tr valign="top">	
			<th valign="top" scope="row">Card Object</th>
			<td><label class="description"><?php echo $result->strip_card_object; ?></label></td>
		</tr>	
		<tr valign="top">	
			<th valign="top" scope="row">Last Four Digit</th>
			<td><label class="description"><?php echo $result->strip_last4; ?></label></td>
		</tr>	
		<tr valign="top">	
			<th valign="top" scope="row">Card Brand</th>
			<td><label class="description"><?php echo $result->strip_brand; ?></label></td>
		</tr>	
		<tr valign="top">	
			<th valign="top" scope="row">Funding</th>
			<td><label class="description"><?php echo $result->strip_funding; ?></label></td>
		</tr>	
		<tr valign="top">	
			<th valign="top" scope="row">Expire Month</th>
			<td><label class="description"><?php echo $result->strip_exp_month; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Expire Year</th>
			<td><label class="description"><?php echo $result->strip_exp_year; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Finger Print</th>
			<td><label class="description"><?php echo $result->strip_fingerprint; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Country</th>
			<td><label class="description"><?php echo $result->strip_country; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Address Line 1</th>
			<td><label class="description"><?php echo $result->strip_address_line1; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Address Line 2</th>
			<td><label class="description"><?php echo $result->strip_address_line2; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">City</th>
			<td><label class="description"><?php echo $result->strip_address_city; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">State</th>
			<td><label class="description"><?php echo $result->strip_address_state; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Zip Code</th>
			<td><label class="description"><?php echo $result->strip_address_zip; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Country</th>
			<td><label class="description"><?php echo $result->strip_address_country; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Balance Transaction</th>
			<td><label class="description"><?php echo $result->strip_balance_transaction; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Failure Message</th>
			<td><label class="description"><?php echo $result->strip_failure_message; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Failure Code</th>
			<td><label class="description"><?php echo $result->strip_failure_code; ?></label></td>
		</tr>
		<tr valign="top">	
			<th valign="top" scope="row">Amount Refunded</th>
			<td><label class="description"><?php echo $result->strip_amount_refunded; ?></label></td>
		</tr>		
		<tr valign="top">	
			<th valign="top" scope="row">Dispute</th>
			<td><label class="description"><?php echo $result->strip_dispute; ?></label></td>
		</tr>
	</tbody>
 </table>
</div>