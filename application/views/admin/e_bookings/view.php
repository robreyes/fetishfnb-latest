<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row clearfix index-page">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <!-- Page Heading -->
                <h2 class="text-uppercase p-l-3-em"><?php echo lang('action_view'); ?></h2>
                
                <!-- Back Button -->
                <a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2)) ?>" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-left"><i class="material-icons">arrow_back</i></a>

                <!-- Invoice Button -->
                <?php  echo '<a href="'.site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/view/'.$e_bookings->id.'/invoice').'" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-right" target="_blank"><i class="material-icons">description</i></a>';  ?>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-md-6">
                <div class="card">
                    <!-- Booking Info -->
                    <div class="header">
                        <h2><?php echo lang('e_bookings_booking_info') ?></h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th><?php echo sprintf(lang('alert_id'), lang('menu_e_booking')); ?></th>
                                    <td><?php echo $e_bookings->id; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('e_bookings_event_type'); ?></th>
                                    <td><?php echo $e_bookings->event_type_title; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('e_bookings_event'); ?></th>
                                    <td><?php echo $e_bookings->event_title; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('common_description'); ?></th>
                                    <td><?php echo $e_bookings->event_description; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('events_capacity'); ?></th>
                                    <td><?php echo $e_bookings->event_capacity; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('events_recurring'); ?></th>
                                    <td><?php echo $e_bookings->event_recurring ? lang('action_yes') : lang('action_no'); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('e_bookings_fees'); ?></th>
                                    <td><?php echo $e_bookings->fees.' '.$payments->currency; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('e_bookings_net_fees'); ?></th>
                                    <td><?php echo $e_bookings->net_fees.' '.$payments->currency; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('e_bookings_booking_date'); ?></th>
                                    <td><?php echo date("F j, Y", strtotime($e_bookings->booking_date)); ?></td>
                                </tr>

                                <tr>
                                    <th><?php echo lang('events_start_date'); ?></th>
                                    <td><?php echo date("F j, Y", strtotime($e_bookings->event_start_date)); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('events_end_date'); ?></th>
                                    <td><?php echo date("F j, Y", strtotime($e_bookings->event_end_date)); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('events_start_time'); ?></th>
                                    <td><?php echo date("g:i A", strtotime($e_bookings->event_start_time)); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('events_end_time'); ?></th>
                                    <td><?php echo date("g:i A", strtotime($e_bookings->event_end_time)); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('common_added'); ?></th>
                                    <td><?php echo date("F j, Y g:i A ", strtotime($e_bookings->date_added)) ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('common_status'); ?></th>
                                    <td><?php echo ($e_bookings->status) ? '<span class="label label-success">'.lang('common_status_active').'</span>' : '<span class="label label-default">'.lang('common_status_inactive').'</span>'; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('common_cancellation'); ?></th>
                                    <td><?php echo $e_bookings->cancellation == 1 ? '<span class="label label-info">'.lang('common_cancellation_pending').'</span>' : ($e_bookings->cancellation == 2 ? '<span class="label label-warning">'.lang('common_cancellation_approved').'</span>' : ($e_bookings->cancellation == 3 ? '<span class="label label-success">'.lang('common_cancellation_refunded') : '<span class="label label-default">'.lang('common_cancellation_disabled')).'</span>');
                                    ; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <!-- Customer Info -->
                <div class="card">
                    <div class="header">
                        <h2><?php echo lang('e_bookings_customer_info') ?></h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th><?php echo lang('e_bookings_customer'); ?></th>
                                    <td><?php echo $e_bookings->customer_name; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('users_email'); ?></th>
                                    <td><?php echo $e_bookings->customer_email; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('users_address'); ?></th>
                                    <td><?php echo $e_bookings->customer_address; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('users_mobile'); ?></th>
                                    <td><?php echo $e_bookings->customer_mobile; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Members Info -->
                <div class="card">
                    <div class="header">
                        <h2><?php echo lang('e_bookings_members_info') ?></h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th><?php echo lang('users_fullname'); ?></th>
                                <th><?php echo lang('users_email'); ?></th>
                                <th><?php echo lang('users_mobile'); ?></th>
                            </tr>
                            <?php foreach($members as $val) { ?>
                                <tr>
                                    <td><?php echo $val->fullname; ?></td>
                                    <td><?php echo $val->email; ?></td>
                                    <td><?php echo $val->mobile; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Payments Info -->
                <div class="card">
                    <div class="header">
                        <h2><?php echo lang('e_bookings_payment_info') ?></h2>
                    </div>
                    <div class="body table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th><?php echo lang('e_bookings_payment_type'); ?></th>
                                    <td><?php echo $payments->payment_type == 'locally' ? lang('e_bookings_payment_type_locally') : ($payments->payment_type == 'stripe' ? lang('e_bookings_payment_type_stripe') : lang('e_bookings_payment_type_paypal')); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('e_bookings_payment_status'); ?></th>
                                    <td><?php echo $payments->payment_status == 1 ? lang('e_bookings_payment_status_successful') : ($payments->payment_status == 2 ? lang('e_bookings_payment_status_failed') : lang('e_bookings_payment_status_pending')); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('e_bookings_payment_paid_amount'); ?></th>
                                    <td><?php echo $payments->paid_amount.' '.$payments->currency; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('menu_tax').lang('common_title'); ?></th>
                                    <td><?php echo $payments->tax_title; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('menu_tax').lang('taxes_rate_type'); ?></th>
                                    <td><?php echo $payments->tax_rate_type == 'percent' ? lang('taxes_rate_type_percent') : lang('taxes_rate_type_fixed'); ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('menu_tax').lang('taxes_rate'); ?></th>
                                    <td><?php echo $payments->tax_rate; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo lang('menu_tax').lang('taxes_net_price'); ?></th>
                                    <td><?php echo $payments->tax_net_price == 'including' ? lang('taxes_net_price_including') : lang('taxes_net_price_excluding'); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>              
        </div>
            
    </div>
</div>