<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><!-- Section -->
<div class="page-default">
    <div class="container">
    	<div class="row">
    		<div class="col-md-12 table-responsive">
          <div class="card">
              <div class="header">
                <h2><?php echo lang('action_paywith_bitcoin')?></h2>
              </div>
              <div class="body">
                <div class="loader"><i class="fa fa-circle-o-notch fa-spin loader"></i></div>
                <div class="row">
                <div class="col-lg-12">
                  <h3>Payment Details</h3>
                    <div class="col-md-6">
                      <p>Payment for: <?php echo $txn_type;?></p>
                      <p id="amount" data-amount="<?php echo $pay_amount;?>" data-amount-satoshi="<?php echo bcmul($pay_amount, 100000000) ;?>">Amount: <?php echo $pay_amount;?> BTC</p>
                      <p id="tx_fee">Fee: <i>Calculating fees...</i></p>
                    </div>
                    <div class="col-md-6 align-right">
                      <div id="qrcode"></div>
                      <span id="qr-address">Address: </span>
                    </div>
                    <div class="col-md-12 padding-0">
                      <hr>
                      <div class="col-md-6">
                        <p id="paystatus">Status: Awaiting transfer <i class="fa fa-circle-o-notch fa-spin loader"></i></p>
                        <small><i>Do not close this window while waiting for confirmation.</i></small>
                      </div>
                      <div class="col-md-6">
                        <?php
                        if(isset($address))
                        {
                          echo form_open('btc/process_redeemcode');
                        }
                        else
                        {
                          echo form_open('btc/add_redeem_code_to_user');
                        }
                        ?>
                        <input id="grand_total" type="hidden" name="redeem_amount" value="">
                        <input id="redeem_fee" type="hidden" name="redeem_fee" value="">
                        <input id="txntype" type="hidden" name="txn_type" value="<?php echo $txn_type;?>">
                        <input id="redeemcode" type="hidden" name="redeem_code" value="">
                        <input id="redeemaddress" type="hidden" name="redeem_address" value="">
                        <input id="redeeminvoice" type="hidden" name="redeem_invoice" value="">
                        <div id="payloader"><span id="submit_loader"></span></div>
                        <div class="col-sm-8 align-right padding-0">
                          <h3 id="pay_total">Total: <i>Calculating...</i></h3>
                        </div>
                        <div class="col-sm-4 align-right padding-0">
                          <button id="paysub" type="submit" class="btn btn-primary" name="pay_proceed" value="submit" disabled>Proceed</button>
                        </div>
                        <?php echo form_close();?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    		  </div>
      	</div>
    </div>
  </div>
</div>
