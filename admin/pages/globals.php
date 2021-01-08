<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				
			</div>

            <div class="box-body">

				<!-- Table -->
				<form name="form-globals" action="" method="POST" id="form-globals" data-toggle="validator" role="form" enctype="multipart/form-data">
				<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th width="30%">Name</th>
							<th width="70%">Value</th>
						</tr>
					</thead>
					<tbody>
						<?
						$i = 0;
						foreach ($itemstolist as $item) {
							$i++;
						?>
						<tr>
							<td><strong><?=ucfirst(str_replace("_", " ", $item->name))?></strong></td>
							<td style=\"vertical-align: top;\">
								<?

								switch ($item->name) {

									case "site_link"; 
									echo "
											<input type=\"url\" class=\"form-control\" name=\"" . $item->name . "\" id=\"" . $item->name . "\" value=\"" . $item->value . "\" required />
											<p class=\"help-block\">Must be a valid URL</p>";
									break; 

									case "site_logo"; 
									echo 
											(($item->value != "") ? "<img src=\"../assets/" . $item->value . "\" style=\"margin-bottom: 10px; max-height:100px;\"></img>" : "") . 
											"<input type=\"file\" name=\"" . $item->name . "\" id=\"" . $item->name . "\" /> 
											<p class=\"help-block\">Only image files are allowed. The current logo is replaced only if a new one is uploaded.</p>";
									break; 

									case "site_bg"; 
									echo 
											(($item->value != "") ? "<img src=\"../assets/" . $item->value . "\" style=\"margin-bottom: 10px; max-height:100px;\"></img>" : "") . 
											"<input type=\"file\" name=\"" . $item->name . "\" id=\"" . $item->name . "\" /> 
											<p class=\"help-block\">Only image files are allowed. The current background is replaced only if a new one is uploaded.</p>";
									break; 

									case "site_favicon"; 
									echo 
											(($item->value != "") ? "<img src=\"../assets/" . $item->value . "\" style=\"margin-bottom: 10px; max-height:100px;\"></img>" : "") . 
											"<input type=\"file\" name=\"" . $item->name . "\" id=\"" . $item->name . "\" /> 
											<p class=\"help-block\">Only ico files are allowed. The current favicon is replaced only if a new one is uploaded.</p>";
									break; 

									case (strpos($item->name, "email_notify")); 
									echo "
											<input type=\"email\" class=\"form-control\" name=\"" . $item->name . "\" id=\"" . $item->name . "\" value=\"" . $item->value . "\" required />
											<p class=\"help-block\">Must be a valid email address</p>";
									break; 

									case "admin_password"; 
	                                echo "
	                                <div id=\"has_admin_password\" class=\"" . ($item->value != "" ? "show" : "hide") . "\">
	                                ** .. 
	                                <a class=\"edit_admin_password\" id=\"edit_admin_password\" href=\"javascript:\" title=\"Change password\"><span class=\"fa fa-pencil\"></span></a>
	                                </div>
	                                <input name=\"" . $item->name . "\" id=\"" . $item->name . "\" type=\"text\" class=\"form-control " . ($item->value != "" ? "hide" : "show") . "\"  placeholder=\"Enter password\" " . ($item->value != "" ? "" : "required") . ">
	                                <div class=\"help-block small\">
	                                You can not see your password as we save it encrypted. In order to change it, click the edit icon.
	                               </div>
	                                ";
	                                break;

									default:
									echo "
											<input type=\"text\" class=\"form-control\" name=\"" . $item->name . "\" id=\"" . $item->name . "\" value=\"" . $item->value . "\" required />";
									
									break;
								}

								?>
							</td>
						</tr>
						<?
						}
						?>
					</tbody>
				</table>

				<button type="submit" class="btn btn-default btn-primary" name="save" value="save">Save</button>
				<input type="reset" class="btn btn-default btn-warning" name="reset" value="Reset" />

				</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function () {

	   $(document)
        // Edit admin password
        .on('click', '.edit_admin_password', function (evt) {
            evt.preventDefault();
            $("#has_admin_password").addClass("hide").removeClass("show");
            $("#admin_password").removeClass("hide").addClass("show").attr("required", true);
            $("#admin_password").focus();
        })

    });

</script>