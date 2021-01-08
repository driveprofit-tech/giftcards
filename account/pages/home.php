<div class="row">
	<div class="col-xs-12">
		<div class="box box-primary">

			<div class="box-header">
				<h3 class="box-title">System stats</h3>
			</div>

            <div class="box-body">	

	            <div class="row">

					<?if($_SESSION['user']['admin'] == "on"){?>

					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-green">
							<div class="inner">
								<h3><?=$count_giftcards?></h3>
								<p>Active Giftcards</p>
							</div>
							<div class="icon">
								<i class="fa fa-image"></i>
							</div>
							<a href="index.php?page=manage-giftcards" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>	

					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-yellow">
							<div class="inner">
								<h3><?=$count_purchases?></h3>
								<p>Giftcards purchased</p>
							</div>
							<div class="icon">
								<i class="fa fa-shopping-cart"></i>
							</div>
							<a href="index.php?page=manage-purchases" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>							
					<?}?>			

				</div>
			</div>

		</div>

		
    </div>
</div>

<script type="text/javascript">

	$(document).ready(function() {

		

    });

</script>