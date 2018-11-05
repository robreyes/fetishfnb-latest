	<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="page-default">
  <!-- Container -->
  <div class="container">
    <div class="row">
      <div class="col-md-12 table-responsive">
        <div class="card">
          <div class="header">
            <div class="col-md-6 padding-0">
              <h2><?php echo lang('e_bookings_payment_type_courier');?></h2>
            </div>
            <div class="clear"></div>
          </div>
          <div class="body">
            <p><?php echo lang('payment_courier_intro');?><p>
            <ul style="margin-left: 15px;">
              <li><p><?php echo lang('payment_courier_step_1');?><p></li>
              <li><p><?php echo lang('payment_courier_step_2');?><p></li>
              <li><p><?php echo lang('payment_courier_step_3');?><p></li>
            </ul>
            <hr>
            <br>
            <?php echo form_open('charge/charge_via_courier', array('id' => 'courier_form', 'class' => 'form-horizontal', 'role'=>"form"));?>
						<input type="hidden" name="courier_start_time" id="courier_start_time" />
						<input type="hidden" name="courier_end_time" id="courier_end_time" />

						<div class="row clearfix">
								<div class="col-md-8">
										<div class="col-md-12">
												<small><?php echo lang('courier_fields_required'); ?></small>
										</div>
								</div>
							</div>

						<div class="row clearfix">
								<div class="col-md-8">
										<div class="col-md-2">
												<?php echo lang('courier_select_date', 'courier_date', array('class'=>'courier_date')); ?>
										</div>
										<div class="col-md-8">
												<div class="form-group">
														<div class="form-line input-group date-range-group">
																<div class="input-group-addon">
																		<i class="fa fa-calendar"></i>
																</div>
																<?php echo form_input($courier_date);?>
														</div>
												</div>
										</div>
								</div>
							</div>

							<div class="row clearfix">
									<div class="col-md-6">
											<div class="input-group">
													<?php echo lang('courier_time_range', 'courier_start_time_1', array('class' => 'col-md-2 courier_start_time_1')); ?>
													<div class="col-sm-3 input-join"><?php echo form_dropdown($courier_start_time_1);?></div>
			                    <div class="col-sm-3 input-join"><?php echo form_dropdown($courier_start_time_2);?></div>
			                    <div class="col-sm-3 input-join"><?php echo form_dropdown($courier_start_time_3);?></div>
											</div>
									</div>
									<div class="col-md-6">
											<div class="input-group">
												<?php echo lang('courier_select_time_to', 'courier_end_time_1', array('class' => 'col-md-2 courier_end_time_1')); ?>
												<div class="col-sm-3 input-join"><?php echo form_dropdown($courier_end_time_1);?></div>
												<div class="col-sm-3 input-join"><?php echo form_dropdown($courier_end_time_2);?></div>
												<div class="col-sm-3 input-join"><?php echo form_dropdown($courier_end_time_3);?></div>
											</div>
									</div>
							</div>

							<div class="row clearfix">
									<div class="col-md-8">
											<div class="col-md-2">
													<?php echo lang('courier_address_line_1', 'courier_address_1', array('class'=>'courier_address_1')); ?>
											</div>
											<div class="col-md-8">
													<div class="form-group">
															<div class="form-line input-group date-range-group">
																	<div class="input-group-addon">
																			<i class="fa fa-map-marker" aria-hidden="true"></i>
																	</div>
																	<?php echo form_input($courier_address_1);?>
															</div>
													</div>
											</div>
									</div>
								</div>

								<div class="row clearfix">
										<div class="col-md-8">
												<div class="col-md-2">
														<?php echo lang('courier_address_line_2', 'courier_address_2', array('class'=>'courier_address_2')); ?>
												</div>
												<div class="col-md-8">
														<div class="form-group">
																<div class="form-line input-group date-range-group">
																		<div class="input-group-addon">
																				<i class="fa fa-map-marker" aria-hidden="true"></i>
																		</div>
																		<?php echo form_input($courier_address_2);?>
																</div>
														</div>
												</div>
										</div>
									</div>

									<div class="row clearfix">
											<div class="col-md-8">
													<div class="col-md-2">
															<?php echo lang('courier_address_city_2', 'courier_address_2', array('class'=>'courier_address_2')); ?>
													</div>
													<div class="col-md-8">
															<div class="form-group">
																	<div class="form-line input-group date-range-group">
																			<div class="input-group-addon">
																					<i class="fa fa-map-marker" aria-hidden="true"></i>
																			</div>
																			<?php echo form_input($courier_city);?>
																	</div>
															</div>
													</div>
											</div>
										</div>

										<div class="row clearfix">
												<div class="col-md-8">
														<div class="col-md-2">
																<?php echo lang('courier_address_zip', 'courier_zip', array('class'=>'courier_zip')); ?>
														</div>
														<div class="col-md-8">
																<div class="form-group">
																		<div class="form-line input-group date-range-group">
																				<div class="input-group-addon">
																						<i class="fa fa-location-arrow" aria-hidden="true"></i>
																				</div>
																				<?php echo form_input($courier_zip);?>
																		</div>
																</div>
														</div>
												</div>
											</div>

											<div class="row clearfix">
													<div class="col-md-8">
															<div class="col-md-2">
																	<?php echo lang('courier_address_doorbell', 'courier_doorbell', array('class'=>'courier_doorbell')); ?>
															</div>
															<div class="col-md-8">
																	<div class="form-group">
																			<div class="form-line input-group date-range-group">
																					<div class="input-group-addon">
																							<i class="fa fa-bell" aria-hidden="true"></i>
																					</div>
																					<?php echo form_input($courier_doorbell);?>
																			</div>
																	</div>
															</div>
													</div>
												</div>

												<div class="row clearfix">
														<div class="col-md-8">
																<div class="col-md-2">
																		<?php echo lang('courier_address_phone', 'courier_phone', array('class'=>'courier_phone')); ?>
																</div>
																<div class="col-md-8">
																		<div class="form-group">
																				<div class="form-line input-group date-range-group">
																						<div class="input-group-addon">
																								<i class="fa fa-phone" aria-hidden="true"></i>
																						</div>
																						<?php echo form_input($courier_phone);?>
																				</div>
																		</div>
																</div>
														</div>
													</div>

													<div class="row clearfix">
		                          <div class="col-lg-offset-2 col-md-offset-2 col-sm-offset-4 col-xs-offset-5">
		                              <div class="btn-group">
		                                  <button type="submit" class="btn bg-<?php echo $this->settings->admin_theme ?> btn-lg waves-effect"><?php echo lang('action_submit') ?></button>
		                              </div>
		                              <span id="submit_loader"></span>
		                          </div>
		                      </div>

              <?php echo form_close();?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
