<?php defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="header">
                <!-- Page Heading -->
                <h2 class="text-uppercase p-l-3-em"><?php echo !empty($id) ? lang('action_edit') : lang('action_create'); ?></h2>
                
                <!-- Back Button -->
                <a href="<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2)) ?>" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-left"><i class="material-icons">arrow_back</i></a>

                <!-- Delete Button -->
                <?php if(!empty($id)) { echo '<a role="button" onclick="ajaxDelete('.$id.', ``, `'.lang('menu_testimonial').'`)" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-right"><i class="material-icons">delete_forever</i></a>'; } ?>
            </div>
            <div class="body">
                <?php echo form_open_multipart(site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.'save'), array('class' => 'form-horizontal', 'id' => 'form-create', 'role'=>"form")); ?>

                    <?php if(! empty($id)) { ?> <!-- in case of update testimonials -->
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <?php } ?>
                    
                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('testimonials_name', 't_name', array('class'=>'t_name')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($t_name);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('testimonials_type', 't_type', array('class'=>'t_type')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($t_type);?>
                                </div>
                                <div class="help-info"><?php echo lang('testimonials_eg'); ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('testimonials_feedback', 't_feedback', array('class'=>'t_feedback')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_textarea($t_feedback); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('common_image', 'image'); ?>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                
                                <div class="picture-container">
                                    <div class="picture">
                                        <?php if(! empty($c_image)) { ?>
                                            <img id="c_image" src="<?php echo base_url('upload/testimonials/images/'.image_to_thumb($c_image)); ?>" class="img-responsive">
                                        <?php } else { ?>
                                            <img id="c_image" src="<?php echo base_url('themes/admin/img/avatar2.png'); ?>" class="img-responsive">
                                        <?php } ?>
                                        <?php echo form_input($image);?>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('common_status', 'status', array('class'=>'status')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_dropdown($status);?>
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