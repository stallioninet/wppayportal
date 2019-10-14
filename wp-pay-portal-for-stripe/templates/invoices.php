<div class="stl-row">
	<input type="hidden" class="stl_ajaxurl" value="<?php echo admin_url('admin-ajax.php'); ?>">
	<div class="stl-col-md-12">
		<div class="stl_ajaxloader"><img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" /></div>

			<?php include_once(WPSTRIPESM_DIR.'templates/common_input.php');
			include_once(WPSTRIPESM_DIR.'templates/sidebar.php');
			 ?>
			<div class="stl-col-md-12">
				<p class="stl_htitle"><?= _e('Invoice list','wp_stripe_management'); ?> &nbsp;&nbsp;<button type="button" class="stl-btn stl-btn-sm stl-btn-default btn_payall"><?= _e('Pay all','wp_stripe_management'); ?></button></p>
				<?php
					// echo "<pre>";print_r($invoicelists);echo "</pre>";exit;
					if($invoicelists['stl_status'])
					{
						$invoice_lists = $invoicelists['invoice_lists'];
						if(!empty($invoice_lists)){
						?>
						
						<table class="stl-table" id="invoice_tb">
							<thead>
								<tr>
									<th style="display: none;">
										<!-- <input type="checkbox" id="selectall"> -->
									</th>
									<!-- <th><?= _e('S.no','wp_stripe_management'); ?></th> -->
									<th class="stl-text-right padrighttd"><?= _e('Amt','wp_stripe_management'); ?> (<?=$cdefault_currency_symbol;?>)</th>
									<th class="stl-text-right padrighttd"><?= _e('Number','wp_stripe_management'); ?></th>
									<th><?= _e('Status','wp_stripe_management'); ?></th>
									<th><?= _e('Due','wp_stripe_management'); ?></th>
									<th><?= _e('Created','wp_stripe_management'); ?></th>
									<th><?= _e('Collection','wp_stripe_management'); ?></th>
									<th><?= _e('Action','wp_stripe_management'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i=0;
								$payall_enable = 0;
								foreach($invoice_lists as $invoice_list)
								{
									$invoice_status = $invoice_list['status'];
									$collection_method = $invoice_list['billing'];
									$due_date = $invoice_list['due_date'];
									$amount_paid = $invoice_list['amount_paid']/100;
									$amount_due = $invoice_list['amount_due']/100;
									$invoice_number1 = $invoice_list['number'];
									$invoice_number_arr = explode('-',$invoice_number1);
									$invoice_number = $invoice_number_arr[1];
									$due_date_strtotime = $invoice_list['due_date'];
									$due_date = ($invoice_list['due_date'] !='')?date('Y-m-d',$invoice_list['due_date']):'';
									$due_date_txt = ($invoice_list['due_date'] !='')?date('d M,Y',$invoice_list['due_date']):'';
									$invoice_pdf = ($invoice_list['invoice_pdf'] !='')?$invoice_list['invoice_pdf']:'';
									$amount_due = number_format($amount_due,2);
									$amount_paid = number_format($amount_paid,2);



									if($collection_method == 'charge_automatically')
									{
										$collection_method = __('Auto paid','wp_stripe_management');
									}
									else
									{
										$collection_method = __('Invoice sent','wp_stripe_management');
										
									}

									if($invoice_status == 'open')
									{
										//echo "due_date = ".$due_date_strtotime." = currrent = ".strtotime(date('Y-m-d'))."<br>";
										$data_order = 2;
										$data_status = '<span class="stl-label stl-label-primary">Open</span>';
										if($due_date_strtotime < strtotime(date('Y-m-d')))
										{
											$data_order = 1;
											$invoice_status = 'past_due';
											$data_status = '<span class="stl-label stl-label-warning">Past due</span>';
										}
									}
									else if($invoice_status == 'draft')
									{
										$data_order = 3;
										$data_status = '<span class="stl-label stl-label-default">Draft</span>';
									}
									else if($invoice_status == 'paid')
									{
										$data_order = 4;
										$data_status = '<span class="stl-label stl-label-success">Paid</span>';
									}
									else if($invoice_status == 'uncollectible')
									{
										$data_order = 5;
										$data_status = '<span class="stl-label stl-label-default">Uncollectible</span>';
									}
									else
									{
										$data_order = 6;
										$data_status = '<span class="stl-label stl-label-default">Void</span>';
									}

									// $currency = $invoice_list['currency'];
									// $currency_sympol = WSSM_CURRENCY[$currency];
									
									$i++;
									if($invoice_status !='void'){
										echo "<tr data-id='".$invoice_list['id']."' data-amt='".$invoice_list['amount_due']."' data-currency='".$cdefault_currency."' data-currency_symp='".$cdefault_currency_symbol."' data-cusid='".$invoice_list['customer']."'>
											<td style='display:none'>";
											if($invoice_status == 'open' || $invoice_status == 'past_due')
											{
												$payall_enable = 1;
	        									echo "<input type='checkbox' class='record' checked>";
	        								}

	      									echo "</td>";

											if($invoice_status == 'open' || $invoice_status == 'draft' || $invoice_status == 'past_due')
											{
												echo "<td class='stl-text-right padrighttd'>".$amount_due."</td>";
											}
											else
											{
												echo "<td class='stl-text-right padrighttd'>".$amount_paid."</td>";
											}

											
											echo "<td class='stl-text-right padrighttd'> ".$invoice_number."</td>
											<td data-order='".$data_order."' data-search='".$invoice_status."'>".$data_status."</td>";
											if($invoice_status == 'open' || $invoice_status == 'past_due')
											{
												echo "<td>".$due_date_txt."</td>";
											}
											else
											{
												echo "<td></td>";
											}
											echo "<td>".date('d M, Y',$invoice_list['created'])."</td>
											<td>".$collection_method."</td>
											<td>";
											$lilist = '';
											
											//echo "<button type='button' class='stl-btn stl-btn-sm stl-btn-info btn_editcardinfo'>".__('Edit','wp_stripe_management')."</button>";

											if($invoice_list['invoice_pdf'] !='')
											{
												$lilist .=  "<li><a href='".$invoice_list['invoice_pdf']."' class='stl-btn stl-btn-sm stl-btn-default' download>".__('Download','wp_stripe_management')."</a></li>";
											}

											if($invoice_status == 'open' || $invoice_status == 'past_due')
											{
												$lilist .=  "<li><button type='button' class='stl-btn stl-btn-sm stl-btn-default btn_payinvoicemodal'>".__('Pay','wp_stripe_management')."</button></li>";
											}

											    if($lilist !='')
											    {
											    	echo ' <div class="stl-dropdown">
											    			<button class="stl-btn stl-btn-sm stl-btn-default stl-dropdown-toggle" type="button" data-toggle="dropdown">'.__('Action','wp_stripe_management').'
											    				<span class="caret"></span></button>
											    			<ul class="stl-dropdown-menu">'.$lilist.'</ul></div>';
											    }


											echo "</td>
										</tr>";
									}
								}
								?>
							</tbody>
						</table>
						<?php
						}
						else
						{
							echo __('No records found','wp_stripe_management');
						}
					}
				?>
			</div>
		</div>
	</div>
</div>

<div id="pay_invoice_modal" class="stl-modal">
	 <div class="stl-modal-dialog">
	 	<div class="stl_ajaxloader1">
  			<img src="<?php echo PRELOADER_IMG; ?>" class="img-responsive" />
		</div>
	    <!-- Modal content-->
	    <div class="stl-modal-content">
	      	<div class="stl-modal-header">
	        	<button type="button" class="stl-close" data-dismiss="modal">&times;</button>
	        	<p class="stl-modal-title"><b><?php _e( 'Pay Amount', 'wp_stripe_management' ); ?>:</b> <span class="payamount"></span></p>
	      	</div>
	      	<div class="stl-modal-body">
	      		<div class="stl-row">
					<form id="pay_invoice" method="post">
						<input type="hidden" name="action" value="PayInvoice">
						<input type="hidden" name="invpayment_type" class="invpayment_type" value="single">
						<input type="hidden" name="invoice_arr" class="invoice_arr" value="">
						<input type="hidden" name="invoice_id" class="invoice_id" value="">
						<input type="hidden" name="customer_id" class="customer_id" value="">
						<input type="hidden" name="invoice_amount" class="invoice_amount" value="">
						<input type="hidden" name="invoice_currency" class="invoice_currency" value="">
					   	<div class="stl-col-md-12">
					   		
					   		<div class="stl-col-md-4">
					   			<div class="stl-form-group">
									<input type="radio" name="card_type" class="card_paytype" value="1" checked><label><?= _e('Pay using saved card','wp_stripe_management'); ?></label>
								</div>
					   		</div>
					   		<div class="stl-col-md-4">
					   			<div class="stl-form-group">
									<select name="card_id" class="stl-form-control">
										<?php
											if($cardlists['stl_status'])
											{
												$card_lists = $cardlists['card_lists'];
												foreach($card_lists as $card_list)
												{
													echo '<option value="'.$card_list['id'].'">•••• '.$card_list['last4'].'</option>';
												}
											}
										?>
									</select>
								</div>
					   		</div>
					   		<div class="stl-col-md-4">
					   			<div class="stl-form-group">
									<input type="radio" name="card_type" class="card_paytype" value="2"><label><?= _e('Pay using new card','wp_stripe_management'); ?></label>
								</div>
					   		</div>
					   		<div class="card_hiddendiv" style="display: none;">
					   			<div class="stl-col-md-12">
						   			<div class="stl-form-group">
										<label><?= _e('Name on card','wp_stripe_management'); ?></label>
										<input type="text" name="holder_name" class="stl-form-control holder_name" value="" checked>
									</div>
						   		</div>
						   		<div class="stl-col-md-6">
						   			<div class="stl-form-group">
										<label><?= _e('Card number','wp_stripe_management'); ?></label>
										<input type="text" name="card_no" class="stl-form-control card_no" value="">
									</div>
						   		</div>
					   		
						   		<div class="stl-col-md-2">
						   			<div class="stl-form-group">
										<label><?= _e('Exp.month','wp_stripe_management'); ?></label>
										<input type="number" name="expire_month" class="stl-form-control expire_month" value="">
									</div>
						   		</div>
						   		<div class="stl-col-md-2">
						   			<div class="stl-form-group">
										<label><?= _e('Exp.year','wp_stripe_management'); ?></label>
										<input type="number" name="expire_year" class="stl-form-control expire_year" value="">
									</div>
						   		</div>
						   		<div class="stl-col-md-2">	

						   			<div class="stl-form-group">
										<label><?= _e('CCV','wp_stripe_management'); ?></label>
										<input type="text" name="ccv" class="stl-form-control ccv" value="">
									</div>
						   		</div>
						   		<div class="stl-col-md-12">	

						   			<div class="stl-form-group">
										<label><?= _e('Street Address 1','wp_stripe_management'); ?></label>
										<input type="text" name="address_line1" class="stl-form-control address_line1" value="">
									</div>
						   		</div>
						   		<div class="stl-col-md-12">
						   			<div class="stl-form-group">
										<label><?= _e('Street Address 2','wp_stripe_management'); ?></label>
										<input type="text" name="address_line2" class="stl-form-control address_line2" value="">
									</div>
						   		</div>
						   		<div class="stl-col-md-6">
						   			<div class="stl-form-group">
										<label><?= _e('City','wp_stripe_management'); ?></label>
										<input type="text" name="city" class="stl-form-control city" value="">
									</div>
						   		</div>
						   		<div class="stl-col-md-6">
						   			<div class="stl-form-group">
										<label><?= _e('State','wp_stripe_management'); ?></label>
										<input type="text" name="state" class="stl-form-control state" value="">
									</div>
						   		</div>
						   		<div class="stl-col-md-6">
						   			<div class="stl-form-group">
										<label><?= _e('Postal Code','wp_stripe_management'); ?></label>
										<input type="text" name="postal_code" class="stl-form-control postal_code" value="">
									</div>
						   		</div>
						   		<div class="stl-col-md-6">
						   			<div class="stl-form-group">
										<label><?= _e('Country','wp_stripe_management'); ?></label>
										<!-- <input type="text" name="country" class="stl-form-control country" value=""> -->
										<?php
									$country_data = WSSM_COUNTRY;
										
										echo '<select name="country" class="stl-form-control country">';
											foreach($country_data as $key => $value)
											{
												echo "<option value='".$key."'>".$value."</option>";
											}
										echo '</select>';
										?>
										
									</div>
						   		</div>
						   	</div>
					   	</div>
				         <div class="stl-col-md-12 stl-text-right">
				          	<button type="button" class="stl-btn stl-btn-default btn_modalcancel"><?php _e('Cancel','wp_stripe_management'); ?></button>
				          	<button type="submit" name="savee" class="stl-btn stl-btn-success btn_payinvoice"><?php _e('Pay','wp_stripe_management'); ?></button>
				        </div>
    				</form>
				</div>
	      	</div>
	    </div>
	</div>
</div>


<script type="application/javascript">

jQuery(document).ready(function(){

	var payall_enable = "<?php echo $payall_enable; ?>";
	// console.log("payall_enable = "+payall_enable);
	if(payall_enable == '0')
	{
		// console.log("ifffffff");
		jQuery(".btn_payall").prop('disabled', true);
	}
	

    
});

</script>
