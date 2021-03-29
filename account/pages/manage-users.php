<link href="../code/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../code/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<div class="row">
	<div class="col-xs-12">

		<div class="whitebox box-secondary shadow-medium border-left-secondary">
			<div class="whitebox-title d-flex align-items-center">
				<h4 class="flex-1">
					<span class="valign-middle">List Users</span>
					<a href="#" class="valign-middle p-2" title="This view manages the users that will use this interface on your behalf. Admin users have full access to manage all components." data-toggle="tooltip"><i class="fas fa-fw fa-question-circle"></i></a>
				</h4>
				<a href="index.php?page=user" class="btn btn-primary btn-sm btn-split"><i class="fas fa-fw fa-user-plus"></i> Add User</a>
			</div>

			<div class="whitebox-content">
				<table class="table" id="table-users">
					<thead>
						<tr>
							<th>
								<input type="checkbox" id="select-all">
							</th>
							<th>#</th>
							<th>Name</th>
							<th>Login Email</th>
							<th>Type</th>
							<th>Status</th>
							<th>&nbsp;</th>
						</tr>
					</thead>
					<tbody>
						<?
						$i = 0;
						foreach ($items as $item) {
							$i++;
						?>
						<tr>
							<td>
								<input type="checkbox" id="select-row-<?= $item->id ?>" class="select-row" value="<?= $item->id ?>">
							</td>
							<td style="white-space: nowrap;"><?=$item->id?></td>
							<td><strong><?=$item->name?></strong></td>
							<td><?=$item->email?></td>
							<td><?=($item->admin == "on" ? "<strong>Admin</strong>" : "Basic")?></td>
							<td><input type="checkbox" <?=($item->status == "active" ? "checked" : "")?> data-toggle="toggle" class="toggle-status" data-on="Active" data-onstyle="success" data-off="Inactive" data-size="mini" id="status_<?=$item->id?>" data-status="<?=$item->status?>"></td>
							<td class="text-right" style="white-space: nowrap;">
								<a href="index.php?page=user&id=<?=$item->id?>" title="edit" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a href="index.php?page=manage-users&delete=<?=$item->id?>" onclick="return confirm('Are you sure you want to delete the user?');" title="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</td>
						</tr>
						<?
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="7">
								<div class="dropdown">
								  	<button class="btn btn-default dropdown-toggle btn-sm" type="button" id="dropdownActions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Apply action to selected <span class="caret"></span></button>
								  	<ul class="dropdown-menu" aria-labelledby="dropdownActions">
								  		<li><a href="#" id="activateAction" class="doAction"><i class="fa fa-check" aria-hidden="true"></i> Activate selected</a></li>
								  		<li><a href="#" id="deactivateAction" class="doAction"><i class="fa fa-ban" aria-hidden="true"></i> Deactivate selected</a></li>
								  		<li class="divider"></li>
										<li><a href="#" id="deleteAction" class="doAction"><i class="fa fa-trash" aria-hidden="true"></i> Delete selected</a></li>
							  		</ul>
								</div>
							</th>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</div>
</div>



<script type="text/javascript">

	$(document).ready(function() {

		$('[data-toggle="tooltip"]').tooltip({
			placement: 'right',
			trigger: 'click hover focus'
		});
		$('[data-toggle="tooltip"]').on('click', function(e) {
			e.preventDefault();
		});

		// Toggle status action
		$('.toggle-status').change(function() {
			var active = $(this).prop('checked');
			if ((active == true && $(this).attr('data-status') == "inactive") || (active == false && $(this).attr('data-status') == "active"))
      		{

      			var id = $(this).attr("id").replace("status_", "");
	      		if (active == true)
	      		{
	      			if (confirm("Are you sure you want to activate this user?"))
	      			{
	      				window.location = "index.php?page=manage-users&activate=" + id;
	      			}
	      			else
	      			{
	      				$(this).bootstrapToggle('off');
	      			}
	      		}
	      		else
	      		{
	      			if (confirm("Are you sure you want to deactivate this user?"))
	      			{
	      				window.location = "index.php?page=manage-users&deactivate=" + id;
	      			}
	      			else
	      			{
	      				$(this).bootstrapToggle('on');
	      			}
	      		}
	      	}
    	});

		// Set dataTable
		var this_table = $('#table-users').DataTable({
			"lengthChange": [25, 50, 100, 500],
			"pageLength": 50,
			"columns": [
				{"name": "chk", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "1%"},
				{"name": "id", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "1%"},
				{"name": "name", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "30%"},
				{"name": "email", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "30%"},
				{"name": "type", "orderable": true, "searchable": false, "sClass": "custom-header", "width": "10%"},
				{"name": "status", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "10%"},
				{"name": "actions", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "5%"},
			],
			"filter": true,
			"order": [[1, "asc"]],
			'drawCallback': function() {
				pretty_select();
				// pretty_checkbox();
			}
		});

		$("#select-all").on('click',function() {
	        var status = this.checked;
	        $(".select-row").each( function() {
	            $(this).prop("checked", status);
	        });
	    });

	    $('.doAction').on("click", function(event){

	    	event.preventDefault();

	    	if(confirm("Are you sure?"))
	    	{
		        if( $('.select-row:checked').length > 0 ){
		            var ids = [];
		            $('.select-row').each(function(){
		                if($(this).is(':checked')) {
		                    ids.push($(this).val());
		                }
		            });
		            var ids_string = ids.toString();

		            var action = $(this).attr("id").replace("Action", "");

		            if(action == "activate")
		            {
		            	window.location = "index.php?page=manage-users&activate=" + ids_string;
		            }
		            else if(action == "deactivate")
		            {
		            	window.location = "index.php?page=manage-users&deactivate=" + ids_string;
		            }
		            else if(action == "delete")
		            {
		            	window.location = "index.php?page=manage-users&delete=" + ids_string;
		            }
		        }
		    }
	    });

	})

</script>
