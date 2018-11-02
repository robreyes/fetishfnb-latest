<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section -->
<div class="page-default">
    <div class="container">
        <?php echo form_open_multipart('', array('role'=>'form', 'class'=>'form-horizontal', 'id'=>'form_login')); ?>
        <?php if ($this->session->userdata('logged_in')) : ?>
        <div class="card">
        <div class="header"><h2>My BTC Transactions</h2><a class="btn pull-right" href="<?php echo site_url('profile/billing');?>">Billing Details</a></div>
        <div class="body table-responsive">
          <table id="btc_transactions" class="table table-striped table-hover"></table>
        </div>
      <?php endif;?>
    </div>
</div>
