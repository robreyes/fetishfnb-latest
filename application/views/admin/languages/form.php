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
                <?php if(!empty($id)) { echo '<a role="button" onclick="ajaxDelete('.$id.', ``, `'.lang('menu_language').'`)" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-right"><i class="material-icons">delete_forever</i></a>'; } ?>
            </div>
            <div class="body">
                <?php echo form_open_multipart(site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.'save'), array('class' => 'form-horizontal', 'id' => 'form-create', 'role'=>"form")); ?>

                    <?php if(! empty($id)) { ?> <!-- in case of update languages -->
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <?php } ?>
                    
                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('common_title', 'title', array('class'=>'title')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($title);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('languages_flag', 'image'); ?>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="picture-container">
                                    <div class="picture-square width-15">
                                        <?php if(! empty($c_image)) { ?>
                                            <img id="c_image" src="<?php echo base_url('upload/languages/flags/'.image_to_thumb($c_image)); ?>" class="img-responsive">
                                        <?php } else { ?>
                                            <img id="c_image" src="<?php echo base_url('themes/admin/img/img_place.png'); ?>" class="img-responsive">
                                        <?php } ?>
                                        <?php echo form_input($image);?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('languages_core_lang', 'core_lang'); ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($core_lang);?>
                                </div>
                                <div class="help-info">
                                    *<?php echo lang('languages_download_core_sample'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo site_url().$this->uri->segment(1).'/'.$this->uri->segment(2) ?>/download_lang/core" class="btn btn-default waves-effect" title="core_lang.php"><i class="material-icons">file_download</i></a>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('languages_form_validation_lang', 'form_validation_lang'); ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($form_validation_lang);?>
                                </div>
                                <div class="help-info">
                                    *<?php echo lang('languages_download_form_validation_sample'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <a href="<?php echo site_url().$this->uri->segment(1).'/'.$this->uri->segment(2) ?>/download_lang/form_validation" class="btn btn-default waves-effect" title="core_lang.php"><i class="material-icons">file_download</i></a>
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