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
			<form method="post" action="" enctype="multipart/form-data" id="frm_user" autocomplete="off">
				<div class="form-group">
					<label class="control-label" for="name">Name*</label>
					<input name="name" type="text" class="form-control" id="name" placeholder="Enter name" required="" value="<?=(isset($POPULATE_FORM['name']) ? $POPULATE_FORM['name'] : "")?>">
				</div>
				<div class="form-group">
					<label class="control-label" for="formname">Login email*</label>
					<input name="email" type="email" class="form-control" id="formname" placeholder="Enter Login Email" required="" value="<?=(isset($POPULATE_FORM['email']) ? $POPULATE_FORM['email'] : "")?>" data-error="Please enter a valid email address.">
					<div class="help-block with-errors"></div>
				</div>
				<div class="form-group">
					<label class="control-label" for="formpassword">Password*</label>
					<input name="password" type="text" class="form-control" id="formpassword" placeholder="Enter Password" required="" value="<?=(isset($POPULATE_FORM['password']) ? $POPULATE_FORM['password'] : "")?>">
				</div>
				<div class="form-group">
					<label class="control-label" for="formadmin">User Type*</label>
					<select name="admin" id="formadmin" class="form-control" required="">
						<option value="">Please Select</option>
						<option value="on" <?=($POPULATE_FORM['admin'] == "on" ? "selected" : "")?>>Admin user</option>
						<option value="off" <?=($POPULATE_FORM['admin'] == "off" ? "selected" : "")?>>Basic user</option>
					</select>
					<div class="help-block small">Admin users have full access to manage all components.</div>
				</div>	
				<div class="form-group">
					<label class="control-label" for="formadmin">Status*</label>
					<select name="status" id="status" class="form-control" required="">
						<option value="">Please Select</option>
						<option value="active" <?=($POPULATE_FORM['status'] == "active" ? "selected" : "")?>>Active</option>
						<option value="inactive" <?=($POPULATE_FORM['status'] == "inactive" ? "selected" : "")?>>Inactive</option>
					</select>
					<div class="help-block small">Inactive users are not able to access their accounts.</div>
				</div>			
				<div class="form-group">
					<label class="control-label" for="formaccess_ip">Restrict access to a list of IP addresses</label>
					<input name="access_ip" type="text" class="form-control" id="formaccess_ip" placeholder="Enter IP address(es)" value="<?=(isset($POPULATE_FORM['access_ip']) ? $POPULATE_FORM['access_ip'] : "")?>" pattern="^\*$|^(?:\d|1?\d\d|2[0-4]\d|25[0-5])(?:\.(?:\d|1?\d\d|2[0-4]\d|25[0-5])){3}(?:\s*,\s*(?:\d|1?\d\d|2[0-4]\d|25[0-5])(?:\.(?:\d|1?\d\d|2[0-4]\d|25[0-5])){3})*$" data-error="Please enter a valid format!">
					<div class="help-block small">If you enter one or more IP addresses this user will not be allowed to access the system unless they are doing it from those locations. Make sure you enter valid IP addresses, separated by comma!</div>
				</div>
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

		