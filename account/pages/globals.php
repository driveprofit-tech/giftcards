<link rel="stylesheet" href="../code/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="../code/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript" src="../code/jquery-ui/jquery-ui.min.js"></script>

<link rel="stylesheet" href="../code/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="../code/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<div class="row">
	<div class="col-xs-12">
		<div class="box">

            <div class="box-body">	

            <div class="nav-tabs-custom">
            	
            	<?
				if (!empty($group_settings))
				{
				?>
				<ul class="nav nav-tabs" role="tablist" id="tabnav">
						<?
							foreach ($group_settings as $key => $group) {
						?>
						<li role="presentation"><a href="#<?=$key?>" aria-controls="<?=$key?>" role="tab" data-toggle="tab"><?=$group['name']?></a></li>
						<?
							}
						?>
				</ul>
				<?
					}
				?>

				<?
				if (!empty($group_settings))
				{
			?>
			<div class="tab-content">
					<?
						foreach ($group_settings as $key => $group) {
					?>
					<div role="tabpanel" class="tab-pane fade" id="<?=$key?>">
						<br />
						<p><strong><?=$group['hint']?></strong></p>
						<?
						if($group['warning'] != "")
						{
							?>
							<div class="alert alert-warning alert-dismissible" role="alert">
								<?=$group['warning']?>
							</div>
							<?
						}
						?>
						<form name="form-globals" action="" method="POST" id="form-globals-<?=$key?>" data-toggle="validator" role="form" enctype="multipart/form-data">
							<input type="hidden" name="group" value="<?=$key?>" />
							<table class="table table-striped table-hover">
								<thead></thead>
								<tbody>

								<?
									foreach ($group['settings'] as $setting)
									{
										$item = $itemstolist[$setting];
									?>
									<tr>
										<td width="30%"><strong>
											<?=(
													($setting == "type_allow_stops") ? "Stops for reservation types" : ucfirst(str_replace("_", " ", $setting))
												)
											?>
										</strong></td>
										<td width="70%" style=\"vertical-align: top;\">
											<div class="form-group">
											<?

											switch ($setting) {

												case "site_link"; 
												echo "
														<input type=\"url\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														<p class=\"help-block\">Link to your website. Must be a valid URL.</p>";
												break; 

												case "contact_link"; 
												echo "
														<input type=\"url\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														<p class=\"help-block\">Link to your contact page. Must be a valid URL.</p>";
												break; 

												case "terms_of_use_link"; 
												echo "
														<input type=\"url\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														<p class=\"help-block\">Link to your \"Terms of Use\" page. Must be a valid URL.</p>";
												break; 

												case "privacy_policy_link"; 
												echo "
														<input type=\"url\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														<p class=\"help-block\">Link to your \"Privacy Policy\" page. Must be a valid URL.</p>";
												break; 

												case "site_logo"; 
												echo 
														(($item->value != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->value . "?" . time() . "\" class=\"img-responsive\" style=\"margin-bottom: 10px; max-width: 200px;\"></img>" : "") . 
														"<input type=\"file\" name=\"" . $setting . "\" id=\"" . $setting . "\" /> 
														<p class=\"help-block\">Only image files are allowed. The current logo is replaced only if a new one is uploaded.</p>";
												break; 

												case "site_favicon"; 
												echo 
														(($item->value != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->value . "?" . time() . "\" class=\"img-responsive\" style=\"margin-bottom: 10px; max-width: 200px;\"></img>" : "") . 
														"<input type=\"file\" name=\"" . $setting . "\" id=\"" . $setting . "\" /> 
														<p class=\"help-block\">Only ico files are allowed. The current favicon is replaced only if a new one is uploaded.</p>";
												break; 	

												case "header_image"; 
												echo 
														(($item->value != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->value . "?" . time() . "\" class=\"img-responsive\" style=\"margin-bottom: 10px; max-width: 200px;\"></img>" : "") . 
														"<input type=\"file\" name=\"" . $setting . "\" id=\"" . $setting . "\" /> 
														<p class=\"help-block\">Only image files are allowed. The current image is replaced only if a new one is uploaded.</p>";
												break; 

												case "background_image"; 
												echo 
														(($item->value != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->value . "?" . time() . "\" class=\"img-responsive\" style=\"margin-bottom: 10px; max-width: 200px;\"></img>" : "") . 
														"<input type=\"file\" name=\"" . $setting . "\" id=\"" . $setting . "\" /> 
														<p class=\"help-block\">Only image files are allowed. The current image is replaced only if a new one is uploaded.</p>";
												break; 	

												case "font_family"; 
												echo "
														<select name=\"font_family\" id=\"font_family\" class=\"form-control\">
														<option value=\"\">Please select</option>
														<optgroup label=\"Sans-Serif Fonts\">
															<option value=\"Arial, sans-serif\" " . ($item->value == "Arial, sans-serif" ? "selected" : "") . ">Arial</option>
															<option value=\"Arial Narrow, sans-serif\" " . ($item->value == "Arial Narrow, sans-serif" ? "selected" : "") . ">Arial Narrow</option>
															<option value=\"Helvetica, sans-serif\" " . ($item->value == "Helvetica, sans-serif" ? "selected" : "") . ">Helvetica</option>
															<option value=\"Trebuchet MS, sans-serif\" " . ($item->value == "Trebuchet MS, sans-serif" ? "selected" : "") . ">Trebuchet MS</option>	
															<option value=\"Verdana, sans-serif\" " . ($item->value == "Verdana, sans-serif" ? "selected" : "") . ">Verdana</option>													
														</optgroup>
														<optgroup label=\"Serif Fonts\">
															<option value=\"Bookman, URW Bookman L, serif\" " . ($item->value == "Bookman, URW Bookman L, serif" ? "selected" : "") . ">Bookman</option>
															<option value=\"Georgia, serif\" " . ($item->value == "Georgia, serif" ? "selected" : "") . ">Georgia</option>
															<option value=\"Palatino, URW Palladio L, serif\" " . ($item->value && $POPULATE_FORM['font_family'] == "Palatino, URW Palladio L, serif" ? "selected" : "") . ">Palatino</option>
															<option value=\"Times, Times New Roman, serif\" " . ($item->value == "Times, Times New Roman, serif" ? "selected" : "") . ">Times, Times New Roman</option>							
														</optgroup>
														<optgroup label=\"Monospace Fonts\">							
															<option value=\"Courier, monospace\" " . ($item->value == "Courier, monospace" ? "selected" : "") . ">Courier</option>
															<option value=\"Courier New, monospace\" " . ($item->value == "Courier New, monospace" ? "selected" : "") . ">Courier New</option>
															<option value=\"DejaVu Sans Mono, monospace\" " . ($item->value == "DejaVu Sans Mono, monospace" ? "selected" : "") . ">DejaVu Sans Mono</option>
															<option value=\"FreeMono, monospace\" " . ($item->value == "FreeMono, monospace" ? "selected" : "") . ">FreeMono</option>							
														</optgroup>
														<optgroup label=\"Cursive Fonts\">
															<option value=\"Comic Sans MS, Comic Sans, cursive\" " . ($item->value == "Comic Sans MS, Comic Sans, cursive" ? "selected" : "") . ">Comic Sans MS, Comic Sans</option>
														</optgroup>
														<optgroup label=\"Fantasy Fonts\">
															<option value=\"Impact, fantasy\" " . ($item->value == "Impact, fantasy" ? "selected" : "") . ">Impact</option>
														</optgroup>
													</select>";
												break; 	

												case "font_size"; 
												echo "
														<input type=\"number\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														";
												break; 

												case "font_unit_size"; 
												echo "
														<select name=\"font_unit_size\" id=\"font_unit_size\" class=\"form-control\">
														<option value=\"px\"  " . ($item->value == "px" ? "selected" : "") . ">px</option>
														<option value=\"em\"  " . ($item->value == "em" ? "selected" : "") . ">em</option>
														<option value=\"%\"  " . ($item->value == "%" ? "selected" : "") . ">%</option>
													</select>";
												break; 	

												case "main_color"; 
												echo "
														<div class=\"input-group colorpicker colorpicker-component\">
															<input type=\"text\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" placeholder=\"Main color\">
															<span class=\"input-group-addon\"><i></i></span>
														</div>														
														";
												break; 

												case "background_color"; 
												echo "
														<div class=\"input-group colorpicker colorpicker-component\">
															<input type=\"text\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" placeholder=\"Background color\">
															<span class=\"input-group-addon\"><i></i></span>
														</div>														
														";
												break; 

												case "overlayer_color"; 
												echo "
														<div class=\"input-group colorpicker colorpicker-component\">
															<input type=\"text\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" placeholder=\"Overlayer color\">
															<span class=\"input-group-addon\"><i></i></span>
														</div>														
														";
												break; 

												case "text_color"; 
												echo "
														<div class=\"input-group colorpicker colorpicker-component\">
															<input type=\"text\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" placeholder=\"Text color\">
															<span class=\"input-group-addon\"><i></i></span>
														</div>														
														";
												break; 	

												case "custom_css"; 
												echo "
														<textarea class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" rows=\"10\" >" . $item->value . "</textarea>								
														<p class=\"help-block\">Customize the CSS classes that control the appearance of the lanfing page. Advanced setting, do not change the classes defined here unless you know what you are doing.</p>";
												break; 	

												case "intro_text"; 
												echo "
														<textarea class=\"form-control texteditor\" name=\"" . $setting . "\" id=\"" . $setting . "\" rows=\"10\" >" . $item->value . "</textarea>";
												break;	

												case "disclaimer_text"; 
												echo "
														<textarea class=\"form-control texteditor\" name=\"" . $setting . "\" id=\"" . $setting . "\" rows=\"10\" >" . $item->value . "</textarea>";
												break;						

												case "custom_booking_domain"; 
												echo "
														<div class=\"row\">
															<div class=\"col-xs-8\">
																<input type=\"text\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
																<div class=\"text-center\" id=\"domain_error\"></div>
															</div>
															<div class=\"col-xs-4\">
																<button type=\"button\" class=\"btn btn-default pull-right\" id=\"btn_check_domain\" title=\"Check Domain\"><i class=\"fa fa-check\"></i> Check domain</button>
															</div>
														</div>
														<div class=\"row\"><div class=\"col-xs-12\">
														<p class=\"help-block\">
															Make sure you enter a valid domain, without the http:// or https:// part. 
															The domain entered here must resolve to " . MAIN_IP . ", otherwise it will not be saved. 
															You can use the button placed next to the input in order to check if the domain rezolves to " . MAIN_IP . ".<br />
															If not provided, the default domain (" . MAIN_DOMAIN . ") will be used.
														</p>
														</div></div>";
												break; 

												case "time_zone"; 
                                                echo "
		                                                <select class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" />
			                                                <option value=\"\">Select timezone</option>";
			                                                foreach(tz_list() as $t) {
			                                                	echo "<option value=\"" . $t['diff_from_GMT'] . " - " . $t['zone'] . "\" " . ($item->value == ($t['diff_from_GMT'] . " - " . $t['zone']) ? "selected" : "") . ">" . $t['diff_from_GMT'] . " - " . $t['zone'] . "</option>";
			                                                }
			                                                echo "
		                                                </select>
		                                                ";
                                                break;

                                                case "authorize_sandbox"; 
                                                case "paypal_sandbox"; 
	                                            echo "
		                                                <select class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" />
			                                                <option value=\"off\" " . ($item->value == "off" ? "selected" : "") . ">Use your live account</option>
			                                                <option value=\"on\" " . ($item->value == "on" ? "selected" : "") . ">Use our sandbox account</option>
		                                                </select>
		                                                <p class=\"help-block small\">Use your live account, or use our sandbox account to test the payment before going live. While your payment account is in sandbox mode, we'll use our sandbox credentials.</p>";
                                                break;

                                                case "payment_gateway"; 
                                                echo "
		                                                <select class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" />
			                                                <option value=\"\" " . ($item->value == "" ? "selected" : "") . "> = NOT SET =</option>
			                                                <option value=\"authorize\" " . ($item->value == "authorize" ? "selected" : "") . ">Authorize.net</option>
			                                                <option value=\"paypal\" " . ($item->value == "paypal" ? "selected" : "") . ">PayPal.com</option>
		                                                </select>";
                                                break;

                                                case "authorize_api_login_id"; 
                                                echo "
		                                                <div id=\"has_authorize_api_login_id\" class=\"" . ($item->value != "" ? "show" : "hide") . "\">"
		                                                . str_replace(substr($item->value, floor(strlen($item->value) / 2)), str_repeat("*", strlen($item->value) - floor(strlen($item->value) / 2)), $item->value) . "
		                                                <a class=\"edit_auth_setting\" id=\"edit_" . $setting . "\" href=\"javascript:\" title=\"Edit Authorize API Login Id\"><span class=\"fa fa-pencil\"></span></a>
		                                                </div>
		                                                <input name=\"" . $setting . "\" id=\"" . $setting . "\" type=\"text\" class=\"form-control " . ($item->value != "" ? "hide" : "show") . "\"  placeholder=\"Enter Authorize API Login Id\">
		                                                <div class=\"help-block small\">
		                                                To obtain the API Login ID:<br />
		                                                - Log into your Merchant Interface at <a href=\"https://account.authorize.net\" target=\"_blank\">https://account.authorize.net</a>.<br />
		                                                - Click Account from the main toolbar.<br />
		                                                - Click Settings in the main left-side menu.<br />
		                                                - Click API Credentials & Keys.<br />
		                                                Your API Login ID is displayed on the page if one has been generated already. If not, enter your Secret Answer. The API Login ID will then be generated.
		                                                </div>
		                                                ";
                                                break;

                                                case "authorize_transaction_key"; 
                                                echo "
		                                                <div id=\"has_authorize_transaction_key\" class=\"" . ($item->value != "" ? "show" : "hide") . "\">"
		                                                . str_replace(substr($item->value, floor(strlen($item->value) / 2)), str_repeat("*", strlen($item->value) - floor(strlen($item->value) / 2)), $item->value) . "
		                                                <a class=\"edit_auth_setting\" id=\"edit_" . $setting . "\" href=\"javascript:\" title=\"Edit Authorize Transaction Key\"><span class=\"fa fa-pencil\"></span></a>
		                                                </div>
		                                                <input name=\"" . $setting . "\" id=\"" . $setting . "\" type=\"text\" class=\"form-control " . ($item->value != "" ? "hide" : "show") . "\"  placeholder=\"Enter Authorize Transaction Key\">
		                                                <div class=\"help-block small\">
		                                                To obtain your Transaction Key:<br />
		                                                - Log into your Merchant Interface at <a href=\"https://account.authorize.net\" target=\"_blank\">https://account.authorize.net</a>.<br />
		                                                - Click Account from the main toolbar.<br />
		                                                - Click Settings in the main left-side menu.<br />
		                                                - Click API Credentials & Keys.<br />
		                                                - Enter your Secret Answer.<br />
		                                                - Select New Transaction Key.<br />
		                                                - To disable the old Transaction Key, click the check box labeled Disable Old Transaction Key Immediately.<br />
		                                                The Transaction Key will not be visible at any other time in the Merchant Interface. You must record it temporarily or copy and paste it to a secure file location immediately.
		                                                </div>
                                                ";
                                                break;

                                                case "authorize_signature_key"; 
                                                echo "
		                                                <div id=\"has_authorize_signature_key\" class=\"" . ($item->value != "" ? "show" : "hide") . "\">"
		                                                . str_replace(substr($item->value, floor(strlen($item->value) / 2)), str_repeat("*", strlen($item->value) - floor(strlen($item->value) / 2)), $item->value) . "
		                                                <a class=\"edit_auth_setting\" id=\"edit_" . $setting . "\" href=\"javascript:\" title=\"Edit Authorize Signature Key\"><span class=\"fa fa-pencil\"></span></a>
		                                                </div>
		                                                <textarea name=\"" . $setting . "\" id=\"" . $setting . "\" class=\"form-control " . ($item->value != "" ? "hide" : "show") . "\"  placeholder=\"Enter Authorize Signature Key\" rows=\"3\"></textarea>
		                                                <div class=\"help-block small\">
		                                                To obtain your Signature Key:<br />
		                                                - Log into your Merchant Interface at <a href=\"https://account.authorize.net\" target=\"_blank\">https://account.authorize.net</a>.<br />
		                                                - Click Account from the main toolbar.<br />
		                                                - Click API Credentials & Keys.<br />
		                                                - Select New Signature Key and hit Submit.<br />
		                                                - Get the Signature Key.<br />
		                                                The Signature Key will not be visible at any other time in the Merchant Interface. You must record it temporarily or copy and paste it to a secure file location immediately.
		                                                </div>
		                                                ";
                                                break;
                                                
                                                case "paypal_password"; 
                                                echo "
		                                                <div id=\"has_paypal_password\" class=\"" . ($item->value != "" ? "show" : "hide") . "\">"
		                                                . str_replace(substr($item->value, floor(strlen($item->value) / 2)), str_repeat("*", strlen($item->value) - floor(strlen($item->value) / 2)), $item->value) . "
		                                                <a class=\"edit_auth_setting\" id=\"edit_" . $setting . "\" href=\"javascript:\" title=\"Edit PayPal Password\"><span class=\"fa fa-pencil\"></span></a>
		                                                </div>
		                                                <input name=\"" . $setting . "\" id=\"" . $setting . "\" type=\"text\" class=\"form-control " . ($item->value != "" ? "hide" : "show") . "\"  placeholder=\"Enter Paypal Password\">
		                                                ";
                                                break;

                                                case "paypal_signature"; 
		                                        echo "
		                                                <div id=\"has_paypal_signature\" class=\"" . ($item->value != "" ? "show" : "hide") . "\">"
		                                                . str_replace(substr($item->value, floor(strlen($item->value) / 2)), str_repeat("*", strlen($item->value) - floor(strlen($item->value) / 2)), $item->value) . "
		                                                <a class=\"edit_auth_setting\" id=\"edit_" . $setting . "\" href=\"javascript:\" title=\"Edit PayPal Signature\"><span class=\"fa fa-pencil\"></span></a>
		                                                </div>
		                                                <textarea name=\"" . $setting . "\" id=\"" . $setting . "\" class=\"form-control " . ($item->value != "" ? "hide" : "show") . "\"  placeholder=\"Enter PayPal Signature\" rows=\"3\"></textarea>
		                                                ";
                                                break;												
												
												default:
												echo "
														<input type=\"text\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />";
												
												break;
											}

											?>
											</div>
										</td>
									</tr>
									<?
									}
									?>
									
								</tbody>
							</table>

							<button type="submit" class="btn btn-default btn-primary" name="save" value="save">Save</button>
						</form>
					</div>
					<?
						}
					?>
			</div>
			<?
				}
			?>
				

            </div>


			</div>

		</div>
	</div>
</div>

<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="../code/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="../code/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>


<script type="text/javascript">

	$(function () {
    	$('.texteditor').wysihtml5()
  	})
	
	$(document).ready(function() {

		var url = window.location.hash;
		var hash = url.substring(url.indexOf("#") + 1);
		if (hash != "")
		{
			$('#tabnav a[href="#' + hash + '"]').tab('show');
		}
		else
		{
			$('#tabnav a[href="#general"]').tab('show');
		}

		$('.colorpicker').colorpicker();

		$(document)
			// Edit restricted settings
            .on('click', '.edit_auth_setting', function (evt) {
                evt.preventDefault();
                var sett_id = $(this).attr('id').replace("edit_", "");
                $("#has_" + sett_id).addClass("hide").removeClass("show");
                $("#" + sett_id).removeClass("hide").addClass("show");
                $("#" + sett_id).focus();
            })
			// Test domain
			.on('click', '#btn_check_domain', function (evt) {
				$.post("index.php?page=globals&action=check_domain", 
					{
						check_domain: $('#custom_booking_domain').val(),
					},
					function(result){
						$("#domain_error").html(result);
					}
				);
			});

	});

</script>