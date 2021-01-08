<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				
			</div>

            <div class="box-body">

				<?
				if (isset($_GET['mode']) && ($_GET['mode'] == "preview") && isset($_SESSION['notify_users']))
				{
				?>
				<form method="post" action="" enctype="multipart/form-data" data-toggle="validator" role="form" novalidate="true">
					<div class="row">
						<div class="col-xs-12">
							<div class="alert alert-<?=$_SESSION['notify_users']['type']?> alert-dismissible" role="alert">
								<button type="button" class="close close-alert" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<?=nl2br($_SESSION['notify_users']['message'])?>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-default btn-primary" name="save" value="save">Save</button>
					<a href="index.php?page=notify-users" class="btn btn-default btn-warning">Modify</a>
				</form>
				<?
				}
				else
				{
				?>
				<form method="post" action="" enctype="multipart/form-data" data-toggle="validator" role="form" novalidate="true">
					<div class="form-group">
						<label class="control-label" for="message">Message</label>
						<textarea name="message" class="form-control" id="message" required="" rows="10"><?=$POPULATE_FORM['message']?></textarea>
					</div>	
					<div class="form-group">
						<label class="control-label" for="status">Message type</label>
						<select name="type" id="type" class="form-control" required>
							<option value="info" <?=(isset($POPULATE_FORM['type']) && ($POPULATE_FORM['type'] == "info") ? "selected" : "")?>>Info</option>
							<option value="warning" <?=(isset($POPULATE_FORM['type']) && ($POPULATE_FORM['type'] == "warning") ? "selected" : "")?>>Warning</option>
							<option value="danger" <?=(isset($POPULATE_FORM['type']) && ($POPULATE_FORM['type'] == "danger") ? "selected" : "")?>>Alert</option>
						</select>
					</div>	
					<button type="submit" class="btn btn-default btn-primary" name="preview" value="preview">Preview</button>
					<button type="button" onclick="history.go(-1); return false;" class="btn btn-default btn-warning">Cancel</button>
				</form>
				<?
				}
				?>
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {

		

	});

</script>