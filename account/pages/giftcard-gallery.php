<div class="row">
	<div class="col-xs-12">
		<div class="whitebox box-secondary shadow-medium border-left-secondary">

			<form method="post" action="" enctype="multipart/form-data" data-toggle="validator" role="form" novalidate="true">

				<div class="whitebox-content">
					<div class="setting d-lg-flex mt-4 mt-lg-0">
						<label class="setting-label" for="category_id">Filter by category</label>
						<div class="flex-grow-1 setting-field">
							<select name="category_id" id="category_id" class="form-control">
								<option value="">All categories</option>
								<?
								$categories = MyActiveRecord::FindBySql('category', "SELECT * FROM category WHERE status = 'active' ORDER BY name ASC");
								if(!empty($categories))
								{
									foreach ($categories as $category) {
										?>
										<option value="<?=$category->id?>" <?=(isset($_GET['category']) && ($_GET['category'] == $category->id) ? "selected" : "")?> ><?=$category->name?></option>
										<?
									}
								}
								?>
							</select>
							<div class="help-block small">Filter the results below by choosing a category from this list.</div>
						</div>
					</div>
				</div>

				<div class="form-group">
					<?php

						if(!empty($categories))
						{
							foreach ($categories as $category)
							{
								if(isset($_GET['category']) && ($_GET['category'] != $category->id))
								{
									continue;
								}

								$giftcards = MyActiveRecord::FindBySql('giftcard', "SELECT * FROM giftcard WHERE category_id = " . MyActiveRecord::Escape($category->id) . " AND status = 'active' ORDER BY name ASC");
								if(!empty($giftcards))
								{
								?>
								<div class="whitebox-title d-lg-flex align-items-center">
									<h4><?= $category->name ?></h4>
								</div>

								<div class="whitebox-content pt-0">
								<div class="row">
								<?php
								foreach ($giftcards as $giftcard)
								{
									?>
									<div class="col-md-4 col-xs-12 mt-5">
										<div class="image-select text-center">
											<label for="giftcard-<?=$giftcard->id?>" class="m-0">
												<input type="checkbox" class="select-row" name="sel_giftcard[]" value="<?=$giftcard->id?>" id="giftcard-<?=$giftcard->id?>" />
												<img src="../assets/giftcards/<?php echo $giftcard->image; ?>" class="img-responsive">
											</label>
										</div>
									</div>
									<?
								}
								?>
								</div>
								</div>
								<?
								}
							}
						}

					?>
				</div>

				<div class="whitebox-content pt-0">
					<div class="mt-5 pt-5 form-footer border-top-secondary border-width-1 border-top-dotted d-flex">
						<button type="button" onclick="history.go(-1); return false;" class="btn btn-warning btn-split" title="Return to the previous page" data-toggle="tooltip"><i class="fas fa-fw fa-arrow-left"></i>Cancel</button>
						<div class="flex-grow-1 text-right">
							<button type="submit" class="btn btn-success btn-split" name="save" value="save" title="Add the selected giftcards to my inventory" data-toggle="tooltip"><i class="fas fa-fw fa-file-import"></i>Import selected</button>
						</div>
					</div>
				</div>
			</form>

		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {

		$('.image-select input[type="checkbox"]').on('change', function() {
			if(this.checked) {
				$(this).parent().addClass('selected');
			} else {
				$(this).parent().removeClass('selected');
			};
		});

		// Toggle status action
		$('#category_id').change(function() {

			var sel_category = $(this).val();
			if(sel_category != "")
			{
				window.location = "index.php?page=giftcard-gallery&category=" + sel_category;
			}
			else
			{
				window.location = "index.php?page=giftcard-gallery";
			}

		});

	});

</script>
