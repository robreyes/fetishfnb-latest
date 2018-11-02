<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section -->
<section class="page-default bg-grey">
  <div class="container">
    <div class="row">
        <div class="col-md-12 table-responsive">
          <div class="card">
            <div class="header">
              <h2><?php echo lang('action_paywith_bitcoin')?></h2>
            </div>
            <div class="body">
              <div class="row">
              <div class="col-lg-12">
                <h3><?php echo lang('transaction_details_btc');?></h3>
                <p style="text-align: center;"><i style="color: green; font-size: 62px; margin" class="fa fa-check-circle"></i><br><br><?php echo $payment_act['msg'];?></p>
                </div>
              </div>
            </div>
        </div>
        </div>
    </div>
  </div>
</section>
