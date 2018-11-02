<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!-- Section -->
<div class="page-default bg-grey">
    <div class="container">
    	<div class="row">
    		<?php if(!empty($my_events)) { ?>
    		<div class="col-md-12 table-responsive">
    			<table class="table table-striped table-hover">
    				<thead>
	    				<tr class="my-be-tr">
	    					<th><?php echo lang('e_bookings_type'); ?></th>
	    					<th><?php echo lang('e_bookings_event').' '.lang('common_title'); ?></th>
	    					<th><?php echo lang('events_start_end'); ?></th>
	    					<th><?php echo lang('e_bookings_timing'); ?></th>
	    					<th><?php echo lang('b_bookings_payment_paid'); ?></th>
	    					<th><?php echo lang('c_l_payment'); ?></th>
	    					<th><?php echo lang('b_bookings_txn_id'); ?></th>
	    					<th><?php echo lang('b_bookings_booking'); ?></th>
	    				</tr>
    				</thead>
    				<tbody>
    					<?php foreach($my_events as $val) { ?>
    					<tr class="my-be-tr">
    						<td class="text-capitalize"><a href="<?php echo site_url('events/').str_replace(' ', '+', $val->event_type_title) ?>"><?php echo $val->event_type_title ?></a></td>
    						<td class="text-capitalize"><?php echo $val->event_title ?></td>
    						<td><?php echo date("F j, Y", strtotime($val->event_start_date)).' - '.date("F j, Y", strtotime($val->event_end_date)) ?></td>
    						<td><?php echo date("g:i A", strtotime($val->event_start_time)).' - '.date("g:i A", strtotime($val->event_end_time)) ?></td>
    						<td><?php echo ($val->payment_type == 'btc' ? $val->total_amount : round($val->total_amount, 2)).' '. ($val->payment_type == 'btc' ? 'BTC' : $val->currency) ?></td>
    						<td><?php echo $val->payment_type == 'locally' ? lang('b_bookings_payment_type_lly') : ($val->payment_type == 'stripe' ? lang('b_bookings_payment_type_ipe') : $val->payment_type == 'btc' ? lang('b_bookings_payment_type_btc') : lang('b_bookings_payment_type_pal')); ?> (<?php echo $val->payment_status == 1 ? lang('e_bookings_payment_status_successful') : ($val->payment_status == 2 ? lang('e_bookings_payment_status_failed') : lang('e_bookings_payment_status_pending')); ?>)</td>
    						<td><?php echo $val->txn_id ?></td>
    						<td><?php echo date("F j, Y", strtotime($val->date_added)) ?></td>
                            <td>
                                <a href="<?php echo site_url("myevents/view_invoice/".$val->id); ?>" target="_blank" class="btn btn-info btn-mini"><i class="fa fa-file-text"></i><?php echo lang('action_view_invoice'); ?></a>
                                <?php if(date('Y-m-d', strtotime(str_replace('-', '/', $val->booking_date))) > date('Y-m-d H:i:s')) { ?>
                                <div class="btn-group">
                                <?php if($val->cancellation) { echo $val->cancellation == 1 ? '<span class="label label-info">'.lang('common_cancellation_pending').'</span>' : ($val->cancellation == 2 ? '<span class="label label-warning">'.lang('common_cancellation_approved').'</span>' : ($val->cancellation == 3 ? '<span class="label label-success">'.lang('common_cancellation_refunded') : '<span class="label label-default">'.lang('common_cancellation_disabled')).'</span>'); } else { ?>
                                    <a role="button" class="btn btn-danger btn-mini" onclick="bookingCancel(`<?php echo $val->id ?>`, `<?php echo $val->event_title ?>`, `<?php echo lang('menu_e_booking') ?>`)"><i class="fa fa-times"></i> <?php echo lang('common_cancellation') ?></a>
                                <?php } ?>
                                </div>
                                <?php } else { ?>
                                <span class="label label-default"><?php echo lang('common_ended'); ?></span>
                                <?php } ?>
                            </td>
    					</tr>
    					<?php } ?>
    				</tbody>
    			</table>
    		</div>
    		<?php } else { ?>
    		<div class="col-md-12 text-center">
				<h3><?php echo lang('see_events_near') ?></h3>
				<p><a href="<?php echo site_url('') ?>"><?php echo lang('start_browse'); ?></a></p>
			</div>
    		<?php } ?>
    	</div>
    </div>
</div>
