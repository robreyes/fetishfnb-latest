<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><!-- Section -->
<div class="page-default">
    <div class="container">
    	<div class="row">
    		<div class="col-md-12 table-responsive">
          <div class="card">
              <div class="header">
                <h2>BTC Test</h2>
              </div>
              <div class="body">
                <div cass="row">
                  <h3>Test BTC Payment</h3>
                  <?php echo form_open('payment/btc/credit');?>
                  <input type="text" name="amount" class="form-control" placeholder="amount"/>
                  <br>
                  <button class="btn" type="submit" value="submit">Submit</button>
                  <?php echo form_close();?>
                </div>
                </div>
              </div>
    		  </div>
      	</div>
    </div>
  </div>
</div>
