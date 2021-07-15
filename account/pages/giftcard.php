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
			<form method="post" action="" enctype="multipart/form-data" data-toggle="validator" role="form" novalidate="true">
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="name">Name</label>
					<div class="flex-grow-1 setting-field">
						<input name="name" type="text" class="form-control" id="name" placeholder="Enter giftcard name" required="" value="<?=(isset($POPULATE_FORM['name']) ? $POPULATE_FORM['name'] : "")?>">
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="name">Description / benefits</label>
					<div class="flex-grow-1 setting-field">
						<textarea name="description" class="form-control" id="description" placeholder="Giftcard description / benefits" ><?=(isset($POPULATE_FORM['description']) ? $POPULATE_FORM['description'] : "")?></textarea>
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="image">Giftcard image</label>
					<div class="flex-grow-1 setting-field">
						<div class="d-sm-flex align-items-start">
							<div id="preview-image">
								<?php if(isset($POPULATE_FORM['image']) && ($POPULATE_FORM['image'] != "")) { ?>
								<img class="img-responsive file-upload-preview" src="../assets/<?php echo $_SESSION['user']['account_id']; ?>/<?php echo $POPULATE_FORM['image'] . "?" . rand(); ?>">
								<?php } ?>
							</div>
							<div class="flex-grow-1">
								<input type="file" class="file-input" name="image" id="image" accept="image/*" onChange="showPreview(this);">
								<div>
									<label class="btn btn-primary btn-sm btn-split file-input-label" for="image"><i class="fas fa-fw fa-file-upload"></i><span>Choose image...</span></label>
								</div>
								<p class="help-block small">Choose an image to see its preview on the left-hand side. The image will not be saved into the database until you click the Save button.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="price">Price</label>
					<div class="flex-grow-1 setting-field">
						<input name="price" type="text" class="form-control" id="price" placeholder="Enter giftcard price" required="" value="<?=(isset($POPULATE_FORM['price']) ? $POPULATE_FORM['price'] : "")?>" pattern="[0-9.]{1,}" data-error="Only integer or decimal numbers are allowed">
					</div>
				</div>
				<div class="setting d-lg-flex mt-4 mt-lg-0">
					<label class="setting-label" for="status">Status</label>
					<div class="flex-grow-1 setting-field">
						<select name="status" id="status" class="form-control" required>
							<option value="active" <?=(isset($POPULATE_FORM['status']) && ($POPULATE_FORM['status'] == "active") ? "selected" : "")?>>Active</option>
							<option value="inactive" <?=(isset($POPULATE_FORM['status']) && ($POPULATE_FORM['status'] == "inactive") ? "selected" : "")?>>Inactive</option>
						</select>
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

	function showPreview(objFileInput) {
	    if (objFileInput.files[0]) {
	        var fileReader = new FileReader();
	        fileReader.onload = function (e) {
				$("#preview-image").html('<img src="' + e.target.result + '" class="img-responsive file-upload-preview">');
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
