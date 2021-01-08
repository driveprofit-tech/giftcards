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
				<div class="form-group">
					<label class="control-label" for="name">Name</label>
					<input name="name" type="text" class="form-control" id="name" placeholder="Enter category name" required="" value="<?=(isset($POPULATE_FORM['name']) ? $POPULATE_FORM['name'] : "")?>">
				</div>	
				<div class="form-group">
					<label class="control-label" for="name">Description</label>
					<textarea name="description" class="form-control" id="description" placeholder="Category description" ><?=(isset($POPULATE_FORM['description']) ? $POPULATE_FORM['description'] : "")?></textarea>
				</div>
				<div class="form-group">
					<label class="control-label" for="status">Status</label>
					<select name="status" id="status" class="form-control" required>
						<option value="active" <?=(isset($POPULATE_FORM['status']) && ($POPULATE_FORM['status'] == "active") ? "selected" : "")?>>Active</option>
						<option value="inactive" <?=(isset($POPULATE_FORM['status']) && ($POPULATE_FORM['status'] == "inactive") ? "selected" : "")?>>Inactive</option>
					</select>
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