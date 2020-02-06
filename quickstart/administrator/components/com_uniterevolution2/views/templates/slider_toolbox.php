
	<div id="toolbox_wrapper" class="toolbox_wrapper postbox unite-postbox">
		<h3 class="box_closed tp-accordion tpa-closed"><div class="postbox-arrow"></div><i style="float:left;margin-top:4px;font-size:14px;" class="eg-icon-export"></i><span><?php _uge("Import / Export",REVSLIDER_TEXTDOMAIN) ?></span></h3>
		<div class="toggled-content tp-closedatstart p20">
			
			<div class="api-caption"><?php _uge("Import Slider",REVSLIDER_TEXTDOMAIN)?>:</div>
			<div class="divide20"></div>
			
			<form action="<?php echo UniteBaseClassRev::$url_ajax?>" enctype="multipart/form-data" method="post">			    
			    <input type="hidden" name="action" value="uniterevolution_ajax_action">
			    <input type="hidden" name="client_action" value="import_slider">
			    <input type="hidden" name="sliderid" value="<?php echo $sliderID?>">					
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("revslider_actions"); ?>">				
				<input type="file" name="import_file" class="input_import_slider" style="width:100%">
				<br><br>
				<span style="font-weight: 700;"><?php _uge("Note: custom styles will be updated if they exist!",REVSLIDER_TEXTDOMAIN)?></span><br><br>
				<table>
					<tr>
						<td><?php _uge("Custom Animations:",REVSLIDER_TEXTDOMAIN)?></td>
						<td><input type="radio" name="update_animations" value="true" checked="checked"> <?php _uge("overwrite",REVSLIDER_TEXTDOMAIN)?></td>
						<td><input type="radio" name="update_animations" value="false"> <?php _uge("append",REVSLIDER_TEXTDOMAIN)?></td>
					</tr>
					<tr>
						<td><?php _uge("Static Styles:",REVSLIDER_TEXTDOMAIN)?></td>
						<td><input type="radio" name="update_static_captions" value="true" checked="checked"> <?php _uge("overwrite",REVSLIDER_TEXTDOMAIN)?></td>
						<td><input type="radio" name="update_static_captions" value="false"> <?php _uge("append",REVSLIDER_TEXTDOMAIN)?></td>
					</tr>
				</table>
				<div class="divide20"></div>				
				<input type="submit" class='button-primary revgreen' value="Import Slider">
			</form>	
			<div class="divide20"></div>
			<div class="api-desc"><?php _uge("Note, that when you importing slider, it delete all the current slider settings and slides, then replace it with the new ones",REVSLIDER_TEXTDOMAIN)?>.</div>
			<hr>
			<div class="divide20"></div>
			
			<div class="api-caption"><?php _uge("Export Slider",REVSLIDER_TEXTDOMAIN)?>:</div>
			<div class="divide20"></div>
			
			<a id="button_export_slider" class='button-primary revblue' href='javascript:void(0)' ><?php _uge("Export Slider",REVSLIDER_TEXTDOMAIN)?></a> <div style="display: none;"><input type="checkbox" name="export_dummy_images"> <?php _uge("Export with Dummy Images",REVSLIDER_TEXTDOMAIN)?></div>
			
			&nbsp;&nbsp;&nbsp;
			
			<a id="button_export_slider_nozip" class='button-primary revblue' href='javascript:void(0)' ><?php _uge("Export Slider - No Zip",REVSLIDER_TEXTDOMAIN)?></a>
			
			<div class="divide20"></div>
			
			<div class="api-desc"><?php _uge("Export Slider button makes zip file with slider objects, images and css. <br> Export No Zip button outputs only slider objects. Use it when the zip file export don't works for any reason.",REVSLIDER_TEXTDOMAIN)?>.</div>
			
			<!-- replace image url's -->
			
			<div class="divide20"></div>
			<hr>
			<div class="divide10"></div>
			<div class="api-caption"><?php _uge("Replace Image Url's",REVSLIDER_TEXTDOMAIN)?>:</div>
			<div class="divide5"></div>
			<div class="api-desc"><?php _uge("Replace all layer and background image url's. Example: http://localhost/ to http://yourwbsite.com/. <br> Note, the replace is not reversible",REVSLIDER_TEXTDOMAIN)?>.</div>
						
			<div class="divide10"></div>
			
			<?php _uge("Replace From (example - http://localhost)",REVSLIDER_TEXTDOMAIN)?>:
			<div class="divide5"></div>			
			<input type="text" class="text-sidebar-link" id="replace_url_from">
			
			<div class="divide10"></div>
			
			<?php _uge("Replace To (example - http://yoursite.com)",REVSLIDER_TEXTDOMAIN)?>:
			<div class="divide5"></div>
			<input type="text" class="text-sidebar-link" id="replace_url_to">
			
			<div class="divide10"></div>
			
			<a id="button_replace_url" class='button-primary revyellow' href='javascript:void(0)' ><?php _uge("Replace",REVSLIDER_TEXTDOMAIN)?></a>
			<div id="loader_replace_url" class="loader_round" style="display:none;"><?php _uge("Replacing...",REVSLIDER_TEXTDOMAIN)?> </div>
			<div id="replace_url_success" class="success_message" class="display:none;"></div>


		</div>	
	</div>
	
