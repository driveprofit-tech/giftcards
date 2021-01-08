<link href="../code/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../code/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<link href="../code/jquery-xeditable/css/bootstrap-editable.css" rel="stylesheet">
<script src="../code/jquery-xeditable/js/bootstrap-editable.min.js"></script>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				<div class="pull-right">
					<a href="index.php?page=giftcard" class="btn btn-primary btn-warning ">Add Giftcard</a>
					<a href="index.php?page=giftcard-gallery" class="btn btn-primary btn-info">Import giftcard from Gallery</a>
				</div>
				<h3 class="box-title">List Giftcards <a href="#" class="open_help" title="Click for help"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></h3>
			</div>

			<div class="content_help hide"><div class="content_help_title">Manage Giftcards</div><div class="content_help_content">Add your giftcards or select from our gallery.</div></div>

            <div class="box-body">		
            	
				<table class="table" id="table-giftcards">
					<thead>
						<tr>							
							<th>
								<div class="pretty p-icon p-smooth">
							        <input type="checkbox" id="select-all" />
							        <div class="state p-primary"><i class="icon fa fa-check"></i><label></label></div>
							    </div>
							</th>
							<th>#</th>
							<th>Image</th>
							<th>Name</th>
							<th>Price ($)</th>
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
								<div class="pretty p-icon p-smooth">
							        <input type="checkbox" class="select-row" value="<?=$item->id?>" />
							        <div class="state p-default"><i class="icon fa fa-check"></i><label></label></div>
							    </div>
							</td>
							<td style="white-space: nowrap;"><?=$item->id?></td>	
							<td><?=($item->image != "") ? "<img src=\"../assets/" . $_SESSION['user']['account_id'] . "/" . $item->image . "\" class=\"img-responsive\" style=\"max-width: 200px;\"/>" : ""?></td>						
							<td>
								<strong><a href="#" id="name_<?=$item->id?>" class="editable editable-click"><?=$item->name?></a></strong>
								<br/><br/>
								Description / benefits:<br/>
								<em><a href="#" id="description_<?=$item->id?>" class="editable editable-click"><?=$item->description?></a></em>
							</td>
							<td>
								<strong><a href="#" id="price_<?=$item->id?>" class="editable editable-click"><?=$item->price?></a></strong>
							</td>
							<td><input type="checkbox" <?=($item->status == "active" ? "checked" : "")?> data-toggle="toggle" class="toggle-status" data-on="Active" data-onstyle="success" data-off="Inactive" data-size="mini" id="status_<?=$item->id?>" data-status="<?=$item->status?>"></td>
							<td class="text-right" style="white-space: nowrap;">
								<a href="index.php?page=giftcard&id=<?=$item->id?>" title="edit" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i></a>
								<a href="index.php?page=manage-giftcards&delete=<?=$item->id?>" onclick="return confirm('Are you sure you want to delete the giftcard?');" title="delete" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></a>
							</td>
						</tr>
						<script>	

							$('#name_<?=$item->id?>').editable({
								mode: "inline",									
								title: 'Enter giftcard name',
								type: 'text',
								url: 'index.php?page=manage-giftcards&action=edit_giftcard',
								name: 'name',
								pk: <?=$item->id?>,									
						    });	

						    $('#description_<?=$item->id?>').editable({
								mode: "inline",									
								title: 'Enter giftcard description / benefits',
								type: 'textarea',
								url: 'index.php?page=manage-giftcards&action=edit_giftcard',
								name: 'description',
								pk: <?=$item->id?>,									
						    });	

						    $('#price_<?=$item->id?>').editable({
								mode: "inline",									
								title: 'Enter giftcard price',
								type: 'text',
								url: 'index.php?page=manage-giftcards&action=edit_giftcard',
								name: 'price',
								pk: <?=$item->id?>,									
						    });								

						</script> 
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
	      				window.location = "index.php?page=manage-giftcards&activate=" + id; 
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
	      				window.location = "index.php?page=manage-giftcards&deactivate=" + id; 
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
				{"name": "chk", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "1%"},
				{"name": "id", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "1%"},
				{"name": "image", "orderable": true, "searchable": false, "sClass": "custom-header", "width": "30%"},
				{"name": "name", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "40%"},	
				{"name": "price", "orderable": true, "searchable": false, "sClass": "custom-header", "width": "10%"},	
				{"name": "status", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "10%"},
				{"name": "actions", "orderable": false, "searchable": false, "sClass": "custom-header", "width": "5%"},
			],
			"filter": true,
			"order": [[1, "asc"]],
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
		            	window.location = "index.php?page=manage-giftcards&activate=" + ids_string;
		            }
		            else if(action == "deactivate")
		            {
		            	window.location = "index.php?page=manage-giftcards&deactivate=" + ids_string;
		            }
	            	else if(action == "delete")
		            {
		            	window.location = "index.php?page=manage-giftcards&delete=" + ids_string;
		            }	
		        }
		    }
	    }); 

	})

</script>

