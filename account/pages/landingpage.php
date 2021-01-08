<link rel="stylesheet" href="../code/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<script src="../code/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<script type="text/javascript" src="../code/jquery-ui/jquery-ui.min.js"></script>

<link rel="stylesheet" href="../code/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
<script src="../code/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>

<div class="row">
	<div class="col-xs-12">
		<div class="box">

            <div class="box-body">

            <?
			if(isset($err_msg) && $err_msg != "")
			{
			?>
				<div class="alert alert-danger alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?=$err_msg?>
				</div>
			<?
			}
			?>

            <div class="nav-tabs-custom">

            	<ul class="nav nav-tabs" role="tablist" id="tabnav">
            		<li role="presentation"><a href="#general" aria-controls="#general" role="tab" data-toggle="tab">General Settings</a></li>
            		<li role="presentation"><a href="#customization" aria-controls="#customization" role="tab" data-toggle="tab">Customization</a></li>
            	</ul>

            	<div class="tab-content">	

            		<div class="clearSpacer"><br/></div>		

					<div role="tabpanel" class="tab-pane fade" id="general">

						<form method="post" action="" enctype="multipart/form-data" id="frm_general" autocomplete="off">
							<input type="hidden" name="group" value="general" />
							<div class="form-group">
								<label class="control-label" for="description">Intro</label>
								<textarea name="description" class="form-control texteditor" id="description" rows="3"><?=(isset($POPULATE_FORM['description']) ? $POPULATE_FORM['description'] : "")?></textarea>
								<div class="clear"></div>
								<div class="help-block small">If entered, the text will be displayed on top of the reservation form.</div>
							</div>	
							<div class="form-group">
								<label class="control-label" for="disclaimer">Disclaimer</label>
								<textarea name="disclaimer" class="form-control texteditor" id="disclaimer" rows="3"><?=(isset($POPULATE_FORM['disclaimer']) ? $POPULATE_FORM['disclaimer'] : "")?></textarea>
								<div class="clear"></div>
								<div class="help-block small">If entered, the text will be displayed on the bottom part of the reservation form.</div>
							</div>						
							<div class="clearSpacer"><br/></div>
							<button type="submit" class="btn btn-default btn-primary" name="save" value="save">Save</button>
							<button type="button" onclick="history.go(-1); return false;" class="btn btn-default btn-warning">Cancel</button>
						</form>

					</div>					

					<div role="tabpanel" class="tab-pane fade" id="customization">
						<form method="post" action="" enctype="multipart/form-data" id="frm_customization" autocomplete="off">
							<input type="hidden" name="group" value="customization" />
							<div class="form-group"><legend>Fonts & Colors</legend></div>
							<div class="form-group">
								<label class="control-label" for="font_family">Font Family:</label>
								<select name="font_family" id="font_family" class="form-control">
									<option value="">Use default</option>
									<optgroup label="Sans-Serif Fonts">
										<option value="Arial, sans-serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Arial, sans-serif" ? "selected" : "")?>>Arial</option>
										<option value="Arial Narrow, sans-serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Arial Narrow, sans-serif" ? "selected" : "")?>>Arial Narrow</option>
										<option value="Helvetica, sans-serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Helvetica, sans-serif" ? "selected" : "")?>>Helvetica</option>
										<option value="Trebuchet MS, sans-serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Trebuchet MS, sans-serif" ? "selected" : "")?>>Trebuchet MS</option>	
										<option value="Verdana, sans-serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Verdana, sans-serif" ? "selected" : "")?>>Verdana</option>													
									</optgroup>
									<optgroup label="Serif Fonts">
										<option value="Bookman, URW Bookman L, serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Bookman, URW Bookman L, serif" ? "selected" : "")?>>Bookman</option>
										<option value="Georgia, serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Georgia, serif" ? "selected" : "")?>>Georgia</option>
										<option value="Palatino, URW Palladio L, serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Palatino, URW Palladio L, serif" ? "selected" : "")?>>Palatino</option>
										<option value="Times, Times New Roman, serif" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Times, Times New Roman, serif" ? "selected" : "")?>>Times, Times New Roman</option>							
									</optgroup>
									<optgroup label="Monospace Fonts">							
										<option value="Courier, monospace" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Courier, monospace" ? "selected" : "")?>>Courier</option>
										<option value="Courier New, monospace" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Courier New, monospace" ? "selected" : "")?>>Courier New</option>
										<option value="DejaVu Sans Mono, monospace" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "DejaVu Sans Mono, monospace" ? "selected" : "")?>>DejaVu Sans Mono</option>
										<option value="FreeMono, monospace" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "FreeMono, monospace" ? "selected" : "")?>>FreeMono</option>							
									</optgroup>
									<optgroup label="Cursive Fonts">
										<option value="Comic Sans MS, Comic Sans, cursive" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Comic Sans MS, Comic Sans, cursive" ? "selected" : "")?>>Comic Sans MS, Comic Sans</option>
									</optgroup>
									<optgroup label="Fantasy Fonts">
										<option value="Impact, fantasy" <?=(isset($POPULATE_FORM['font_family']) && $POPULATE_FORM['font_family'] == "Impact, fantasy" ? "selected" : "")?>>Impact</option>
									</optgroup>
								</select>
								<div class="help-block small"></div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-xs-8">
										<label class="control-label" for="font_size">Font size:</label>
										<input name="font_size" type="number" class="form-control" id="font_size" value="<?=(isset($POPULATE_FORM['font_size']) ? $POPULATE_FORM['font_size'] : "")?>" placeholder="Font size">								
									</div>
									<div class="col-xs-4">
										<label class="control-label" for="font_size_unit">Unit size:</label>
										<select name="font_size_unit" id="font_size_unit" class="form-control">
											<option value="px" <?=(isset($POPULATE_FORM['font_size_unit']) && $POPULATE_FORM['font_size_unit'] == "px" ? "selected" : "")?>>px</option>
											<option value="em" <?=(isset($POPULATE_FORM['font_size_unit']) && $POPULATE_FORM['font_size_unit'] == "em" ? "selected" : "")?>>em</option>
											<option value="%" <?=(isset($POPULATE_FORM['font_size_unit']) && $POPULATE_FORM['font_size_unit'] == "%" ? "selected" : "")?>>%</option>
										</select>								
									</div>
								</div>
								<div class="help-block small"></div>
							</div>
							<div class="form-group">
								<label class="control-label" for="main_color">Main color:</label>
								<div class="input-group colorpicker colorpicker-component">
									<input name="main_color" type="text" class="form-control" id="main_color" value="<?=(isset($POPULATE_FORM['main_color']) ? $POPULATE_FORM['main_color'] : "")?>" placeholder="Main color">
									<span class="input-group-addon"><i></i></span>
								</div>
								<div class="help-block small">If not entered, the main color defined for your account will be used. Used mainly for buttons.</div>
							</div>
							<div class="form-group">
								<label class="control-label" for="bg_color">Background color:</label>
								<div class="input-group colorpicker colorpicker-component">
									<input name="bg_color" type="text" class="form-control" id="bg_color" value="<?=(isset($POPULATE_FORM['bg_color']) ? $POPULATE_FORM['bg_color'] : "")?>" placeholder="Background color">
									<span class="input-group-addon"><i></i></span>
								</div>
								<div class="help-block small">The default color is white.</div>
							</div>
							<div class="form-group">
								<label class="control-label" for="bgrgba">Overlayer color (RGBA):</label>
								<div class="input-group colorpicker colorpicker-component">
									<input name="bgrgba" type="text" class="form-control" id="bgrgba" value="<?=(isset($POPULATE_FORM['bgrgba']) ? $POPULATE_FORM['bgrgba'] : "")?>" placeholder="Overlayer color">
									<span class="input-group-addon"><i></i></span>
								</div>
								<div class="help-block small">The default color is white.</div>
							</div>							
							<div class="form-group">
								<label class="control-label" for="description">Custom CSS</label>
								<textarea name="custom_css" class="form-control" id="custom_css" rows="10"><?=(isset($POPULATE_FORM['custom_css']) ? $POPULATE_FORM['custom_css'] : "")?></textarea>
								<div class="clear"></div>
								<div class="help-block small">Advanced setting, do not set this field unless you know what you are doing. Use this to ovveride existing css classes.</div>
							</div>
							<div class="form-group"><legend>Images</legend></div>
							<div class="form-group">
								<label class="control-label" for="logo">Logo</label>
								<input name="logo" type="file" id="logo">
								<?if ($POPULATE_FORM['logo'] != "") {?>
								<img src="../assets/<?=$_SESSION['user']['account_id']?>/<?=$POPULATE_FORM['logo']?>" style="margin-top: 10px; margin-bottom: 10px; border: 1px solid #d4e0eb; padding: 10px;" class="img-responsive"></img>
								<a href="index.php?page=survey&id=<?=$_GET['id']?>&delete=logo" onclick="return confirm('Are you sure you want to delete the logo image?');" title="delete logo image" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?}?>
							</div>
							<div class="form-group">
								<label class="control-label" for="header">Header</label>
								<input name="header" type="file" id="header">
								<?if ($POPULATE_FORM['header'] != "") {?>
								<img src="../assets/<?=$_SESSION['user']['account_id']?>/<?=$POPULATE_FORM['header']?>" style="margin-top: 10px; margin-bottom: 10px; border: 1px solid #d4e0eb; padding: 10px;" class="img-responsive"></img>
								<a href="index.php?page=survey&id=<?=$_GET['id']?>&delete=header" onclick="return confirm('Are you sure you want to delete the header image?');" title="delete header image" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?}?>
							</div>
							<div class="form-group">
								<label class="control-label" for="bgimage">Background Image</label>
								<input name="bgimage" type="file" id="bgimage">
								<?if ($POPULATE_FORM['bgimage'] != "") {?>
								<img src="../assets/<?=$_SESSION['user']['account_id']?>/<?=$POPULATE_FORM['bgimage']?>" style="margin-top: 10px; margin-bottom: 10px; border: 1px solid #d4e0eb; padding: 10px;" class="img-responsive"></img>
								<a href="index.php?page=survey&id=<?=$_GET['id']?>&delete=bgimage" onclick="return confirm('Are you sure you want to delete the background image?');" title="delete background image" class="btn btn-danger btn-sm"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								<?}?>
							</div>	

							<div class="clearSpacer"><br/></div>
							<button type="submit" class="btn btn-default btn-primary" name="save" value="save">Save</button>
							<button type="button" onclick="history.go(-1); return false;" class="btn btn-default btn-warning">Cancel</button>
						</form>
					</div>					

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
		
	});

		
</script>

		