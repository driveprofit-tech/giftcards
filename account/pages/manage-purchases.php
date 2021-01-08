<link href="../code/bootstrap-toggle/bootstrap-toggle.min.css" rel="stylesheet">
<script src="../code/bootstrap-toggle/bootstrap-toggle.min.js"></script>

<link rel="stylesheet" type="text/css" href="../code/bootstrap-daterangepicker/daterangepicker.css" />
<script type="text/javascript" src="../code/bootstrap-daterangepicker/daterangepicker.js"></script>

<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				<!--<a href="index.php?page=route" class="btn btn-primary btn-warning pull-right">Add Booking</a>-->
				<h3 class="box-title">List Purchases <a href="#" class="open_help" title="Click for help"><i class="fa fa-question-circle-o" aria-hidden="true"></i></a></h3>
			</div>

			<div class="content_help hide"><div class="content_help_title">List Bookings</div><div class="content_help_content">View a list of giftcards purchased, that you can refine by using the available filters.</div></div>

            <div class="box-body">	

            	<div class="row">
					<div class="col-md-12">
						<form class="form-inline" method="get" action="index.php" autocomplete="off">
							<input type="hidden" name="page" value="manage-purchases">
							<div class="form-group">
								<input id="receiver" class="form-control" name="receiver" placeholder="Receiver (name / email / code)" value="<?=(isset($_GET['client']) && ($_GET['client'] != "") ? $_GET['client'] : "")?>" />	
							</div>
							<div class="form-group">
								<select name="giftcard" id="giftcard" class="form-control" style="max-width: 150px;">
									<option value="">Any giftcard</option>
									<?									
									if(!empty($giftcards))
									{
										foreach ($giftcards as $giftcard) {
											?>
											<option value="<?=$giftcard->id?>" <?=(isset($_GET['giftcard']) && ($_GET['giftcard'] == $giftcard->id) ? "selected" : "")?> ><?=$giftcard->name?></option>
											<?
										}
									}
									?>
								</select>
							</div>
							<div class="form-group">
								<select name="payment_status" id="payment_status" class="form-control" style="max-width: 150px;">
									<option value="">Any payment status</option>
									<option value="not_paid" <?=(isset($_GET['payment_status']) && ($_GET['payment_status'] == "not_paid") ? "selected" : "")?>>Not paid</option>
									<option value="paid" <?=(isset($_GET['payment_status']) && ($_GET['payment_status'] == "paid") ? "selected" : "")?>>Paid</option>
									<option value="rejected" <?=(isset($_GET['payment_status']) && ($_GET['payment_status'] == "rejected") ? "selected" : "")?>>Rejected</option>
								</select>
							</div>
							<div class="form-group">
								<select name="sent_status" id="sent_status" class="form-control" style="max-width: 150px;">
									<option value="">Any sent status</option>
									<option value="queued" <?=(isset($_GET['sent_status']) && ($_GET['sent_status'] == "queued") ? "selected" : "")?>>Queued</option>
									<option value="sent" <?=(isset($_GET['sent_status']) && ($_GET['sent_status'] == "sent") ? "selected" : "")?>>Sent</option>
									<option value="error" <?=(isset($_GET['sent_status']) && ($_GET['sent_status'] == "error") ? "selected" : "")?>>Error</option>
								</select>
							</div>
							<div class="form-group">
								<select name="redeemed" id="redeemed" class="form-control" style="max-width: 150px;">
									<option value="">Any redeemed status</option>
									<option value="on" <?=(isset($_GET['redeemed']) && ($_GET['redeemed'] == "on") ? "selected" : "")?>>Redeemed</option>
									<option value="off" <?=(isset($_GET['redeemed']) && ($_GET['redeemed'] == "off") ? "selected" : "")?>>Not redeemed</option>
								</select>
							</div>
							<div class="form-group">
								<input type="hidden" name="period" id="period" value="">
								<input id="custom-daterange" class="form-control" name="daterange" style="max-width: 150px;" />	
							</div>
							<button type="submit" name="search" id="search_btn" value="1" class="btn btn-primary">Search</button>
							<button type="submit" name="export" value="1" class="btn btn-success"><span class="fa fa-list-ol"></span> Export</button>
						</form>
					</div>
				</div>	

				<br/><br/>	

				<table class="table" id="table-purchases">
					<thead>
						<tr>
							<th>#</th>
							<th>Giftcard</th>
							<th>Receiver</th>
							<th>Price</th>
							<th>Payment</th>
							<th>Sent</th>
							<th>Redeemed</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>

		

<script type="text/javascript">

	$(document).ready(function() {

		$('#custom-daterange').daterangepicker({
			locale: {
		    	format: "MM/DD/YYYY"
		    },
		     <?if(!empty($start_interval) && !empty($end_interval)){?>
		    startDate: '<?=date_format(date_create_from_format('Y-m-d', $start_interval), 'm/d/Y')?>',
    		endDate: '<?=date_format(date_create_from_format('Y-m-d', $end_interval), 'm/d/Y')?>',
    		<?}else{?>
    		autoUpdateInput: false,
    		<?}?>
			opens: "left",
			<?if (!empty($predefined_ranges)){?>
			ranges: {
				<?foreach ($predefined_ranges as $range){?>
				"<?=$range['display']?>": [
					"<?=date_format(date_create_from_format('Y-m-d', $range['start_interval']), 'm/d/Y')?>",
					"<?=date_format(date_create_from_format('Y-m-d', $range['end_interval']), 'm/d/Y')?>"
				],
				<?}?>
			},
			<?}?>
    	});
		$('#custom-daterange').on('apply.daterangepicker', function(ev, picker) {
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
		$('#custom-daterange').on('cancel.daterangepicker', function(ev, picker) {
			$(this).val('');
		});
				
		// Set dataTable
		var this_table = $('#table-purchases').DataTable({
			"lengthChange": [25, 50, 100, 500],
			"pageLength": 50,
			"columns": [	
				{"name": "id", "orderable": true, "searchable": false, "sClass": "custom-header", "width": "1%"},
				{"name": "account_giftcard_id", "orderable": false, "searchable": true, "sClass": "custom-header", "width": "15%"},
				{"name": "receiver", "orderable": false, "searchable": true, "sClass": "custom-header", "width": "15%"},	
				{"name": "price_total", "orderable": true, "searchable": false, "sClass": "custom-header", "width": "10%"},	
				{"name": "payment_status", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "10%"},
				{"name": "sent_status", "orderable": false, "searchable": true, "sClass": "custom-header", "width": "10%"},
				{"name": "redeemed", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "10%"},	
				{"name": "added_on", "orderable": true, "searchable": true, "sClass": "custom-header", "width": "5%"},
			],
			"filter": true,
			"order": [[0, "desc"]],
			"processing": true,
			"serverSide": true,
			"ajax": {
				"type": "POST",
				"url": "index.php?page=manage-purchases&load=data",
				"data": function (d) {
				}
			},
			"fnDrawCallback": function() {
				$("#table-bookings_filter").addClass("hide");	
			}
		});	

		this_table.on('draw', function () {

			$('.toggle-status').bootstrapToggle();

			// Toggle status action
			$(document).on('change', '.toggle-status', function () {

				var redeemed = $(this).prop('checked');
				if ((redeemed == true && $(this).attr('data-status') == "off") || (redeemed == false && $(this).attr('data-status') == "on"))
	      		{
		      		
	      			var id = $(this).attr("id").replace("redeemed_", "");
		      		if (redeemed == true)
		      		{
		      			if (confirm("Are you sure you want to mark this purchase as redeemed?"))
		      			{
		      				window.location = "index.php?page=manage-purchases&mark_redeemed=on&id=" + id; 
		      			}
		      			else
		      			{
		      				$(this).bootstrapToggle('off');
		      			}
		      		}
		      		else
		      		{
		      			if (confirm("Are you sure you want to mark this purchase as not redeemed?"))
		      			{
		      				window.location = "index.php?page=manage-purchases&mark_redeemed=off&id=" + id; 
		      			}
		      			else
		      			{
		      				$(this).bootstrapToggle('on');
		      			}
		      		}
		      	}
	    	});


		});

		$(document).on('click', '#search_btn', function (evt) {

			evt.preventDefault();
			go_search();

		});

	    function go_search()
		{			
			this_table.columns(2).search($("#receiver").val());
			this_table.columns(1).search($("#giftcard").val());
			this_table.columns(4).search($("#payment_status").val());
			this_table.columns(5).search($("#sent_status").val());
			this_table.columns(6).search($("#redeemed").val());
			this_table.columns(7).search($("#custom-daterange").val());
			
			this_table.order([[0, "desc"]]);
			this_table.draw();
		}

		
		
	})

</script>
