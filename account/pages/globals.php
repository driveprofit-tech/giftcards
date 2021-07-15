<link rel="stylesheet" href="../code/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="../code/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!--
jQuery UI interferes with Bootstrap's tooltip. Unless it's really necessary we shouldn't load it.
-->
<!-- <script type="text/javascript" src="../code/jquery-ui/jquery-ui.min.js"></script> -->

<link rel="stylesheet" href="../code/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="../code/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<div class="row">
	<div class="col-xs-12">
		<div class="whitebox box-secondary shadow-medium border-left-secondary">

            <div class="whitebox-content">

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
						<?php
						if( $group[ 'hint' ] != '' ) {
							?>
							<p class="help-block mt-4"><?=$group['hint']?></p>
							<?php
						}
						if( $group[ 'warning' ] != '' ) {
							?>
							<div class="alert bg-warning text-white alert-dismissible shadow-small shadow-hover-medium mt-5 mb-0" role="alert">
								<button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
									<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
										<path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
									</svg>
								</button>
								<?=$group['warning']?>
							</div>
							<?
						}
						?>
						<form class="mt-5" name="form-globals" action="" method="POST" id="form-globals-<?=$key?>" data-toggle="validator" role="form" enctype="multipart/form-data">
							<input type="hidden" name="group" value="<?=$key?>" />
								<?
									foreach ($group['settings'] as $setting)
									{
										$item = $itemstolist[$setting];
									?>
											<div class="setting d-lg-flex mt-4 mt-lg-0">
												<label class="setting-label" for="<?= $setting ?>"><?= $setting == 'type_allow_stops' ? 'Stops for reservation types' : ucfirst( str_replace( '_', ' ', $setting ) ) ?></label>
												<div class="flex-grow-1 setting-field">
											<?

											switch ($setting) {

												case "site_link";
												echo "
														<input type=\"url\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														<p class=\"help-block small\">Link to your website. Must be a valid URL.</p>";
												break;

												case "contact_link";
												echo "
														<input type=\"url\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														<p class=\"help-block small\">Link to your contact page. Must be a valid URL.</p>";
												break;

												case "terms_of_use_link";
												echo "
														<input type=\"url\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														<p class=\"help-block small\">Link to your \"Terms of Use\" page. Must be a valid URL.</p>";
												break;

												case "privacy_policy_link";
												echo "
														<input type=\"url\" class=\"form-control\" name=\"" . $setting . "\" id=\"" . $setting . "\" value=\"" . $item->value . "\" />
														<p class=\"help-block small\">Link to your \"Privacy Policy\" page. Must be a valid URL.</p>";
												break;

												case "site_logo";
												echo
														'<div class="d-sm-flex align-items-start">' .
														(($item->value != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->value . "?" . time() . "\" class=\"img-responsive file-upload-preview\">" : "") .
														"<div class=\"flex-grow-1\">
														<input class=\"file-input\" type=\"file\" name=\"" . $setting . "\" id=\"" . $setting . "\" />
														<div><label class=\"btn btn-primary btn-sm btn-split file-input-label\" for=\"$setting\"><i class=\"fas fa-fw fa-file-upload\"></i><span>Choose file...</span></label></div>
														<p class=\"help-block small\">Only image files are allowed. The current logo is replaced only if a new one is uploaded.</p>
														</div>
														</div>";
												break;

												case "site_favicon";
												echo
														'<div class="d-sm-flex align-items-start">' .
														(($item->value != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->value . "?" . time() . "\" class=\"img-responsive file-upload-preview\">" : "") .
														"<div class=\"flex-grow-1\">
														<input class=\"file-input\" type=\"file\" name=\"" . $setting . "\" id=\"" . $setting . "\" />
														<div><label class=\"btn btn-primary btn-sm btn-split file-input-label\" for=\"$setting\"><i class=\"fas fa-fw fa-file-upload\"></i><span>Choose file...</span></label></div>
														<p class=\"help-block small\">Only ico files are allowed. The current favicon is replaced only if a new one is uploaded.</p>
														</div>
														</div>";
												break;

												case "header_image";
												echo
														'<div class="d-sm-flex align-items-start">' .
														(($item->value != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->value . "?" . time() . "\" class=\"img-responsive file-upload-preview\">" : "") .
														"<div class=\"flex-grow-1\">
														<input class=\"file-input\" type=\"file\" name=\"" . $setting . "\" id=\"" . $setting . "\" />
														<div><label class=\"btn btn-primary btn-sm btn-split file-input-label\" for=\"$setting\"><i class=\"fas fa-fw fa-file-upload\"></i><span>Choose file...</span></label></div>
														<p class=\"help-block small\">Only image files are allowed. The current image is replaced only if a new one is uploaded.</p>
														</div>
														</div>";
												break;

												case "background_image";
												echo
														'<div class="d-sm-flex align-items-start">' .
														(($item->value != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->value . "?" . time() . "\" class=\"img-responsive file-upload-preview\">" : "") .
														"<div class=\"flex-grow-1\">
														<input class=\"file-input\" type=\"file\" name=\"" . $setting . "\" id=\"" . $setting . "\" />
														<div><label class=\"btn btn-primary btn-sm btn-split file-input-label\" for=\"$setting\"><i class=\"fas fa-fw fa-file-upload\"></i><span>Choose file...</span></label></div>
														<p class=\"help-block small\">Only image files are allowed. The current image is replaced only if a new one is uploaded.</p>
														</div>
														</div>";
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
														<p class=\"help-block small\">Customize the CSS classes that control the appearance of the lanfing page. Advanced setting, do not change the classes defined here unless you know what you are doing.</p>";
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
														<p class=\"help-block small\">
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
											</div>
									<?
									}
									?>

							<div class="mt-5 pt-5 form-footer border-top-secondary border-width-1 border-top-dotted text-right">
								<button type="submit" class="btn btn-success btn-split" name="save" value="save" title="Save changes" data-toggle="tooltip"><i class="fas fa-fw fa-check"></i>Save</button>
							</div>
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
