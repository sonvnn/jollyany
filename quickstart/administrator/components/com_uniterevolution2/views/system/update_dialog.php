<div id="dialog_update_plugin" class="api_wrapper" title="<?php _uge("Update Slider Plugin",REVSLIDER_TEXTDOMAIN)?>" style="display:none;">	<div class="api-caption"><?php _uge("Update Unite Slider Plugin",REVSLIDER_TEXTDOMAIN)?>:</div>	<div class="api-desc">		<?php _uge("To update the slider please show the slider install package. The files will be overwriten.",REVSLIDER_TEXTDOMAIN) ?>		<br> <?php _uge("File example: revslider.zip",REVSLIDER_TEXTDOMAIN)?>	</div>	<br>	<form action="<?php echo UniteBaseClassRev::$url_ajax?>" enctype="multipart/form-data" method="post">		<input type="hidden" name="action" value="uniterevolution_ajax_action">		<input type="hidden" name="client_action" value="update_plugin">		<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">		<?php _uge("Choose the update file:",REVSLIDER_TEXTDOMAIN)?>   		<br>		<input type="file" name="update_file" class="input_update_slider">		<input type="submit" class='button-secondary' value="<?php _uge("Update Slider",REVSLIDER_TEXTDOMAIN)?>">	</form></div>

