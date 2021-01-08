<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				
			</div>

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
			<form method="post" action="" enctype="multipart/form-data" data-toggle="validator" role="form" novalidate="true">

				<legend>Account info</legend>
				<div class="form-group">
					<label class="control-label" for="name">Account Name</label>
					<input name="name" type="text" class="form-control" id="name" placeholder="Enter account name" pattern="[A-Za-z0-9]{1,}" required="" value="<?=(isset($POPULATE_FORM['name']) ? $POPULATE_FORM['name'] : "")?>" data-minlength="3" data-error="At least 3 alphanumeric characters">
					<div class="help-block  with-errors small">Unique account identifier (only alphanumeric characters).</div>
				</div>	
				<div class="form-group">
					<label class="control-label" for="status">Account Status</label>
					<select name="status" id="status" class="form-control" required>
						<option value="active" <?=(isset($POPULATE_FORM['status']) && ($POPULATE_FORM['status'] == "active") ? "selected" : "")?>>Active</option>
						<option value="inactive" <?=(isset($POPULATE_FORM['status']) && ($POPULATE_FORM['status'] == "inactive") ? "selected" : "")?>>Inactive</option>
					</select>
				</div>	

				<legend>Company info</legend>
				<div class="form-group">
					<label class="control-label" for="site_name">Website Name</label>
					<input name="site_name" type="text" class="form-control" id="site_name" placeholder="Enter website name" required value="<?=(isset($POPULATE_FORM['site_name']) ? $POPULATE_FORM['site_name'] : "")?>">
					<div class="help-block small">Website name (as Example.com for http://www.example.com).</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="site_link">Website URL</label>
					<input name="site_link" type="url" class="form-control" id="site_link" placeholder="Enter website URL" required value="<?=(isset($POPULATE_FORM['site_link']) ? $POPULATE_FORM['site_link'] : "")?>">
					<div class="help-block small">Full URL of the website (as http://www.example.com).</div>
				</div>	
				<?
					if ($action == "add")
					{
				?>
				<legend>User info</legend>	
				<div class="form-group">
					<label class="control-label" for="user_name">Name</label>
					<input name="user_name" type="text" class="form-control" id="user_name" placeholder="Enter name" required value="<?=(isset($POPULATE_FORM['user_name']) ? $POPULATE_FORM['user_name'] : "")?>">
				</div>
				<div class="form-group">
					<label class="control-label" for="email">Email</label>
					<input name="email" type="email" class="form-control" id="email" placeholder="Enter email address" required value="<?=(isset($POPULATE_FORM['email']) ? $POPULATE_FORM['email'] : "")?>">
				</div>
				<div class="form-group">
					<label class="control-label" for="password">Password</label>
					<input name="password" type="text" class="form-control" id="password" placeholder="Enter password" required value="<?=(isset($POPULATE_FORM['password']) ? $POPULATE_FORM['password'] : "")?>">
				</div>
				<?
					}
				?>

				<button type="submit" class="btn btn-default btn-primary" name="save" value="save">Save</button>
				<button type="button" onclick="history.go(-1); return false;" class="btn btn-default btn-warning">Cancel</button>
			</form>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {

		

	});

</script>