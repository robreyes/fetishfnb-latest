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
                <?php if(!empty($id)) { echo '<a role="button" onclick="ajaxDelete('.$id.', ``, `'.lang('menu_course').'`)" class="btn btn-default btn-circle waves-effect waves-circle waves-float pull-right"><i class="material-icons">delete_forever</i></a>'; } ?>
            </div>
            <div class="body">
                <?php echo form_open_multipart(site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.'save'), array('class' => 'form-horizontal', 'id' => 'form-create', 'role'=>"form")); ?>

                    <?php if(! empty($id)) { ?> <!-- in case of update courses -->
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <?php } ?>
                    
                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('courses_category', 'category', array('class'=>'category')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line" id="show_sub_categories">
                                    <?php echo form_dropdown($category); ?>
                                    <?php if(!empty($id)) foreach($category_l as $c_l) { echo form_dropdown($c_l); } ?>
                                </div>
                            </div>
                        </div>
                    </div>

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
                            <?php echo lang('common_description', 'description', array('class'=>'description')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_textarea($description); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('common_images', 'images'); ?>
                        </div>
                        <div class="col-md-8">
                            <div class="form-group">
                                <div class="picture-container">
                                    <div class="picture-select">
                                        <img src="<?php echo base_url('themes/admin/img/choose_files.png'); ?>" class="img-responsive">
                                        <?php echo form_input($images);?>
                                    </div>
                                </div>
                                <?php if(! empty($c_images)) { ?>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="gallery">
                                                <?php foreach($c_images as $val) { ?> 
                                                    <img src="<?php echo base_url('upload/courses/images/'.image_to_thumb($val)); ?>" class="col-sm-2 img-responsive thumbnail">            
                                                <?php } ?>
                                            </div>                                
                                        </div>
                                    </div>
                                <?php } else { ?> 
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="gallery">
                                            </div>                                
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('common_meta_title', 'meta_title', array('class'=>'meta_title')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($meta_title);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('common_meta_tags', 'meta_tags', array('class'=>'meta_tags')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_input($meta_tags);?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-md-2 form-control-label">
                            <?php echo lang('common_meta_description', 'meta_description', array('class'=>'meta_description')); ?>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <div class="form-line">
                                    <?php echo form_textarea($meta_description);?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row clearfix">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 form-control-label">
                                    <?php echo lang('common_status', 'status', array('class'=>'status')); ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <?php echo form_dropdown($status);?>
                                        </div>
                                    </div>
                                </div>
                            </div>      
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-4 form-control-label">
                                    <?php echo lang('common_featured', 'featured', array('class'=>'featured')); ?>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="form-line">
                                            <?php echo form_dropdown($featured);?>
                                        </div>
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