<link href="../code/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../code/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				<a href="index.php?page=account" class="btn btn-primary btn-warning pull-right">Add Account</a>
				<h3 class="box-title">List Accounts</h3>
			</div>

            <div class="box-body">		

			<table class="table" id="table-accounts">
				<thead>
					<tr>
						<th>ID</th>
						<th>Account</th>
						<th>Website Data</th>
						<th>Status</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?
					$i = 0;
					foreach ($items as $item) {
						$i++;
						$rand_seed = rand(1000, 100000);
						$sess = base64_encode($item->id . "-" . $rand_seed . "-" . $_SERVER['REMOTE_ADDR'] . "-" . (time() + $rand_seed * $item->id) . "-" . APP_SALT);
					?>
					<tr>
						<td style="white-space: nowrap;"><strong><?=$item->id?></strong></td>
						<td>
							<strong><?=$item->name?></strong><br/>
						</td>
						<td><?=$item->site_name?><br/><?=$item->site_link?> <a href="<?=$item->site_link?>" class="text-muted small" target="_blank" title="Go to website"><span class="glyphicon glyphicon-new-window"></span></a></td>
						<td><input type="checkbox" <?=($item->status == "active" ? "checked" : "")?> data-toggle="toggle" class="toggle-status" data-on="Active" data-onstyle="success" data-off="Inactive" data-size="mini" id="status_<?=$item->id?>" data-status="<?=$item->status?>"></td>
						<td class="text-right" style="white-space: nowrap;">
							<a href="index.php?page=account&id=<?=$item->id?>" title="Edit account" class="btn btn-primary btn-sm"><span class="fa fa-pencil"></span></a>
							<a href="<?=BASE_PATH?>account/index.php?page=sulogin&sess=<?=$sess?>" target="_blank" title="Log in on this account" class="btn btn-warning btn-sm"><span class="fa fa-user"></span></a>
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
	      			if (confirm("Are you sure you want to activate this account?"))
	      			{
	      				window.location = "index.php?page=home&activate=" + id; 
	      			}
	      			else
	      			{
	      				$(this).bootstrapToggle('off');
	      			}
	      		}
	      		else
	      		{
	      			if (confirm("Are you sure you want to deactivate this account?"))
	      			{
	      				window.location = "index.php?page=home&deactivate=" + id; 
	      			}
	      			else
	      			{
	      				$(this).bootstrapToggle('on');
	      			}
	      		}
	      	}
    	});

		// Set dataTable
		var this_table = $('#table-accounts').DataTable({
			"lengthChange": [25, 50, 100, 500],
			"pageLength": 50,
			"columns": [		
				{"name": "id", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "5%"},		
				{"name": "account", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "20%"},
				{"name": "data", "orderable": false, "searchable": true, "sClass": "custom-header", "width": "20%"},
				{"name": "status", "orderable": true, "searchable": false, "sClass": "custom-header", "width": "10%"},
				{"name": "actions", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "5%"},
			],
			"filter": true,
			"order": [[0, "asc"]],
		});	

	});

</script>