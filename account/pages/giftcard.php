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
					<input name="name" type="text" class="form-control" id="name" placeholder="Enter giftcard name" required="" value="<?=(isset($POPULATE_FORM['name']) ? $POPULATE_FORM['name'] : "")?>">
				</div>
				<div class="form-group">
					<label class="control-label" for="name">Description / benefits</label>
					<textarea name="description" class="form-control" id="description" placeholder="Giftcard description / benefits" ><?=(isset($POPULATE_FORM['description']) ? $POPULATE_FORM['description'] : "")?></textarea>
				</div>
				<div class="form-group">
					<label class="control-label" for="image">Giftcard image</label>
					<input type="file" class="form-control" name="image" id="image" accept="image/*" onChange="showPreview(this);">					
				</div>
				<div id="preview-image">
					<?php if(isset($POPULATE_FORM['image']) && ($POPULATE_FORM['image'] != "")) { ?>
					<img src="../assets/<?php echo $_SESSION['user']['account_id']; ?>/<?php echo $POPULATE_FORM['image'] . "?" . rand(); ?>" style="max-width: 200px; margin-top: 10px; margin-bottom: 10px;" />
					<?php } ?>
				</div>
				<div class="form-group">
					<label class="control-label" for="price">Price</label>
					<input name="price" type="text" class="form-control" id="price" placeholder="Enter giftcard price" required="" value="<?=(isset($POPULATE_FORM['price']) ? $POPULATE_FORM['price'] : "")?>" pattern="[0-9.]{1,}" data-error="Only integer or decimal numbers are allowed">
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

	function showPreview(objFileInput) {
	    if (objFileInput.files[0]) {
	        var fileReader = new FileReader();
	        fileReader.onload = function (e) {
				$("#preview-image").html('<img src="' + e.target.result + '" style="max-width: 200px; margin-top: 10px; margin-bottom: 10px;" />');
	        }
			fileReader.readAsDataURL(objFileInput.files[0]);
	    }
	    else
	    {
	    	$("#preview-image").html('');
	    }
	}

	$(document).ready(function() {

		

	});

</script>