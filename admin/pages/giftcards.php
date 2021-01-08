<link href="../code/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../code/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				<a href="index.php?page=giftcard" class="btn btn-primary btn-warning pull-right">Add Giftcard</a>
				<h3 class="box-title">List Giftcards</h3>
			</div>

            <div class="box-body">		

			<table class="table" id="table-giftcards">
				<thead>
					<tr>
						<th>ID</th>
						<th>Image</th>
						<th>Name</th>
						<th>Category</th>
						<th>Status</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?
					$i = 0;
					foreach ($items as $item) {
					?>
					<tr>
						<td style="white-space: nowrap;"><strong><?=$item->id?></strong></td>
						<td><?=($item->image != "") ? "<img src=\"../assets/giftcards/" . $item->image . "\" class=\"img-responsive\" style=\"max-width: 200px;\"/>" : ""?></td>	
						<td>
							<strong><?=$item->name?></strong><br/>
						</td>		
						<td><?=$item->category?></td>				
						<td><input type="checkbox" <?=($item->status == "active" ? "checked" : "")?> data-toggle="toggle" class="toggle-status" data-on="Active" data-onstyle="success" data-off="Inactive" data-size="mini" id="status_<?=$item->id?>" data-status="<?=$item->status?>"></td>
						<td class="text-right" style="white-space: nowrap;">
							<a href="index.php?page=giftcard&id=<?=$item->id?>" title="Edit giftcard" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span></a>
						</td>
					</tr>
					<?
					}
					?>
				</tbody>
			</table>
			
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(document).ready(function() {

		// Toggle status action
		$('.toggle-status').change(function() {
			var active = $(this).prop('checked');
			if ((active == true && $(this).attr('data-status') == "inactive") || (active == false && $(this).attr('data-status') == "active"))
      		{
	      		
      			var id = $(this).attr("id").replace("status_", "");
	      		if (active == true)
	      		{
	      			if (confirm("Are you sure you want to activate this giftcard?"))
	      			{
	      				window.location = "index.php?page=giftcards&activate=" + id; 
	      			}
	      			else
	      			{
	      				$(this).bootstrapToggle('off');
	      			}
	      		}
	      		else
	      		{
	      			if (confirm("Are you sure you want to deactivate this giftcard?"))
	      			{
	      				window.location = "index.php?page=giftcards&deactivate=" + id; 
	      			}
	      			else
	      			{
	      				$(this).bootstrapToggle('on');
	      			}
	      		}
	      	}
    	});

		// Set dataTable
		var this_table = $('#table-giftcards').DataTable({
			"lengthChange": [25, 50, 100, 500],
			"pageLength": 50,
			"columns": [		
				{"name": "id", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "5%"},
				{"name": "image", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "20%"},		
				{"name": "name", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "20%"},
				{"name": "category", "orderable": true, "searchable": false, "sClass": "custom-header", "width": "20%"},
				{"name": "status", "orderable": true, "searchable": false, "sClass": "custom-header", "width": "10%"},
				{"name": "actions", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "5%"},
			],
			"filter": true,
			"order": [[2, "asc"]],
		});	

	});

</script>