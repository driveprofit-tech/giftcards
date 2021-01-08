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
					<label class="control-label" for="category_id">Category</label>
					<select name="category_id" id="category_id" class="form-control" required>
						<option value="">Select category</option>
						<?
				        $categories = MyActiveRecord::FindBySql('category', "SELECT * FROM category WHERE status = 'active' ORDER BY name ASC");
						if(!empty($categories))
						{
							foreach ($categories as $category) {
								?>
								<option value="<?=$category->id?>" <?=(isset($POPULATE_FORM['category_id']) && ($POPULATE_FORM['category_id'] == $category->id) ? "selected" : "")?> ><?=$category->name?></option>
								<?
							}
						}
						?>
					</select>
					<div class="help-block small">If the category is not in this list, <a href="index.php?page=categories">click here to add it</a>.</div>
				</div>	
				<div class="form-group">
					<label class="control-label" for="name">Description</label>
					<textarea name="description" class="form-control" id="description" placeholder="Giftcard description" ><?=(isset($POPULATE_FORM['description']) ? $POPULATE_FORM['description'] : "")?></textarea>
				</div>
				<div class="form-group">
					<label class="control-label" for="image">Giftcard image</label>
					<input type="file" class="form-control" name="image" id="image" accept="image/*" onChange="showPreview(this);">					
				</div>
				<div id="preview-image">
					<?php if(isset($POPULATE_FORM['image']) && ($POPULATE_FORM['image'] != "")) { ?>
					<img src="../assets/giftcards/<?php echo $POPULATE_FORM['image'] . "?" . rand(); ?>" style="max-width: 200px; margin-top: 10px; margin-bottom: 10px;" />
					<?php } ?>
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