	<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

	<div id="add_credits_modal" style="display:none;">
		<div class="opthead">
			<div class="col-md-12">
      	<h4 style="text-align: left;">Charge Bitcoin Credits</h4>
				<hr>
				<?php echo form_open('payment/btc/credit');?>
				<p style="text-align: left;">Please deposit the price of the event or a higher amount for easier purchasing in the future.</p>
				<p style="text-align: left;"><small><i>*Minimum deposit amount is 0.00020000 BTC</i></small></p>
				<input type="number" placeholder="Amount" min="0.00020000" max="9.99999999" step=".00000001" name="amount" class="form-control"/>
				<button type="submit" class="btn" value="submit">Proceed to Payment</button>
				<?php echo form_close();?>
			</div>
    </div>
    </div>
	</div>
	<div class="page-default">
		<!-- Container -->
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="card">
						<div class="header">
							<div class="col-md-6">
								<h2>Welcome,  <?php echo $user['username'];?>!</h2>
							</div>
							<div class="col-md-6">
								<h2 class="pull-right">Your current BTC balance is: <?php echo $btc_balance;?> <a id="add_credits" style="margin-left: 10px; display:inline-block;" href="#add_credits" class="btn">Add Credits</a></h2>
							</div>
							<div class="clear"></div>
						</div>
						<div id="btc_table" class="body">
							<?php echo form_open('charge/charge_btc');?>
							<input type="hidden" name="payer_id" value="<?php echo $this->user['id']?>" />
							<input type="hidden" name="txn_amount" value="<?php echo bcdiv($details['net_fees'],$btc_exchange['rate_float'], 8);?>" />
							<p>Your Booking Details: </p>
							<table width="100%">
								<tr>
									<td>Experience Title</td>
									<td><?php echo $details['event_title'];?></td>
								</tr>
								<tr>
									<td>Experience Category</td>
									<td><?php echo $details['event_type_title'];?></td>
								</tr>
								<tr>
									<td>Booking Date</td>
									<td><?php echo date('d, M Y', strtotime($details['booking_date']));?></td>
								</tr>
								<tr>
									<td>Starting Time</td>
									<td><?php echo date('h:i A', strtotime($details['start_time']));?></td>
								</tr>
								<tr>
									<td>Fees</td>
									<td><?php echo $details['fees'].' '.$details['currency'];?></td>
								</tr>
								<tr>
									<td>Net Fees</td>
									<td><?php echo $details['net_fees'].' '.$details['currency'];?> <span style="color: green;"><i><?php echo $details['net_price'].' '.$details['rate'].$details['rate_type'].'VAT';?></i></span></td>
								</tr>
								<tr>
									<td>Members Count</td>
									<td><?php echo $details['count_members'];?></td>
								</tr>
							</table>
							<br>
							<br>
							<p>Members:</p>
							<table width="100%">
							<?php foreach($details['members'] as $member){?>
								<tr>
									<td>Nickname</td>
									<td><?php echo $member['fullname']?></td>
								</tr>
								<tr>
									<td>Email</td>
									<td><?php echo $member['email']?></td>
								</tr>
								<tr>
									<td>Mobile</td>
									<td><?php echo $member['mobile']?></td>
								</tr>
							<?php }; ?>
						</table>
						<br>
						<br>
						<p>Grand Total:</p>
						<table width="100%">
							<tr>
								<td><?php echo $btc_exchange['description'];?></td>
								<td><?php echo $details['net_fees'];?></td>
							</tr>
							<tr>
								<td>BTC</td>
								<td>
								<?php
									$btc = bcdiv($details['net_fees'],$btc_exchange['rate_float'], 8);
									echo $btc;
								?>
							</td>
							</tr>
						</table>
							<div class="clear"></div>
						<div class="col-md-4 pull-right align-right">
							<br>
							<a href="<?php echo site_url('charge/cancel')?>" class="btn">Cancel</a>
							<button class="btn" name="book_proceed" id="booksubmit" value="submit">Submit Payment</button>
							<?php echo form_close();?>
						</div>
						<div class="clear"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
