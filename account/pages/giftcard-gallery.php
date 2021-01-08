<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				
			</div>

            <div class="box-body">

			
			<form method="post" action="" enctype="multipart/form-data" data-toggle="validator" role="form" novalidate="true">
				<div class="form-group">
					<label class="control-label" for="category_id">Category</label>
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
					<div class="help-block small">Select a category in order to filter the results.</div>
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
								<legend><?php echo $category->name; ?></legend>
								<div class="row">
								<?php
								$cnt = 0;
								foreach ($giftcards as $giftcard)
								{
									$cnt ++;
									?>
									<div class="col-md-4 col-xs-12">
										<div class="pretty p-icon p-smooth" style="float: left;">
									        <input type="checkbox" class="select-row" name="sel_giftcard[]" value="<?=$giftcard->id?>" id="giftcard-<?=$giftcard->id?>" />
									        <div class="state p-default p-primary"><i class="icon fa fa-check"></i><label></label></div>
									    </div>
									    <label for="giftcard-<?=$giftcard->id?>" style="cursor: pointer;"><img src="../assets/giftcards/<?php echo $giftcard->image; ?>" class="img-responsive" style="max-width: 200px; float: left;" /></label>
									</div>
									<?
									if($cnt % 3 == 0) {
										?>
										<div class="clearfix" style="margin: 30px;"></div>
										<?php
									}
								}
								?>
								</div>
								<?
								}
							}
						}

					?>
				</div>
				<button type="submit" class="btn btn-default btn-primary" name="save" value="save">Add the selected giftcards to my inventory</button>
				<button type="button" onclick="history.go(-1); return false;" class="btn btn-default btn-warning">Cancel</button>
			</form>

			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	
	$(document).ready(function() {

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