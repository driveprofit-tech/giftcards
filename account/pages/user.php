<div class="row">
	<div class="col-xs-12">
		<div class="whitebox box-secondary shadow-medium border-left-secondary">

            <div class="whitebox-content">

			<?
			if(isset($err_msg) && $err_msg != "")
			{
			?>
				<div class="alert bg-danger text-white alert-dismissible shadow-small shadow-hover-medium" role="alert">
					<button type="button" class="close text-white" data-dismiss="alert" aria-label="Close">
						<svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
							<path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
						</svg>
					</button>
					<?=$err_msg?>
				</div>
			<?
			}
			?>
			<form method="post" action="" enctype="multipart/form-data" id="frm_user" autocomplete="off">
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="name">Name*</label>
					<div class="flex-grow-1 setting-field">
						<input name="name" type="text" class="form-control" id="name" placeholder="Enter name" required="" value="<?=(isset($POPULATE_FORM['name']) ? $POPULATE_FORM['name'] : "")?>">
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="formname">Login email*</label>
					<div class="flex-grow-1 setting-field">
						<input name="email" type="email" class="form-control" id="formname" placeholder="Enter Login Email" required="" value="<?=(isset($POPULATE_FORM['email']) ? $POPULATE_FORM['email'] : "")?>" data-error="Please enter a valid email address.">
						<div class="help-block with-errors small bg-danger text-white"></div>
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="formpassword">Password*</label>
					<div class="flex-grow-1 setting-field">
						<input name="password" type="text" class="form-control" id="formpassword" placeholder="Enter Password" required="" value="<?=(isset($POPULATE_FORM['password']) ? $POPULATE_FORM['password'] : "")?>">
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="formadmin">User Type*</label>
					<div class="flex-grow-1 setting-field">
						<select name="admin" id="formadmin" class="form-control" required="">
							<option value="">Please Select</option>
							<option value="on" <?=($POPULATE_FORM['admin'] == "on" ? "selected" : "")?>>Admin user</option>
							<option value="off" <?=($POPULATE_FORM['admin'] == "off" ? "selected" : "")?>>Basic user</option>
						</select>
						<div class="help-block small">Admin users have full access to manage all components.</div>
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="formadmin">Status*</label>
					<div class="flex-grow-1 setting-field">
						<select name="status" id="status" class="form-control" required="">
							<option value="">Please Select</option>
							<option value="active" <?=($POPULATE_FORM['status'] == "active" ? "selected" : "")?>>Active</option>
							<option value="inactive" <?=($POPULATE_FORM['status'] == "inactive" ? "selected" : "")?>>Inactive</option>
						</select>
						<div class="help-block small">Inactive users are not able to access their accounts.</div>
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="formaccess_ip">Restrict access to a list of IP addresses</label>
					<div class="flex-grow-1 setting-field">
						<input name="access_ip" type="text" class="form-control" id="formaccess_ip" placeholder="Enter IP address(es)" value="<?=(isset($POPULATE_FORM['access_ip']) ? $POPULATE_FORM['access_ip'] : "")?>" pattern="^\*$|^(?:\d|1?\d\d|2[0-4]\d|25[0-5])(?:\.(?:\d|1?\d\d|2[0-4]\d|25[0-5])){3}(?:\s*,\s*(?:\d|1?\d\d|2[0-4]\d|25[0-5])(?:\.(?:\d|1?\d\d|2[0-4]\d|25[0-5])){3})*$" data-error="Please enter a valid format!">
						<div class="help-block small">If you enter one or more IP addresses this user will not be allowed to access the system unless they are doing it from those locations. Make sure you enter valid IP addresses, separated by comma!</div>
					</div>
				</div>
				<div class="mt-5 pt-5 form-footer border-top-secondary border-width-1 border-top-dotted d-flex">
					<button type="button" onclick="history.go(-1); return false;" class="btn btn-warning btn-split" title="Return to the previous page" data-toggle="tooltip"><i class="fas fa-fw fa-arrow-left"></i>Cancel</button>
					<div class="flex-grow-1 text-right">
						<button type="submit" class="btn btn-success btn-split" name="save" value="save" title="Save changes" data-toggle="tooltip"><i class="fas fa-fw fa-check"></i>Save</button>
					</div>
				</div>
			</form>
			</div>

		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {


	});

</script>
