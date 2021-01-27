<div class="row">
	<div class="col-xs-12">

		<div class="row">
			<?php
			if( $_SESSION[ 'user' ][ 'admin' ] == 'on' ) {
				?>

				<div class="col col-xs-6 col-sm-12 col-md-6">
					<div class="card card-primary shadow-medium shadow-hover-large border-left-primary border-radius-0">
						<div class="card-header bg-transparent text-uppercase text-small text-strong">
							Active Giftcards
						</div>
						<div class="card-body pt-0">
							<div class="card-lead">
								<span class="lead"><?= $count_giftcards ?></span>
								<span>Active giftcards</span>
								<div class="card-icon">
									<i class="fas fa-fw fa-gift"></i>
								</div>
							</div>
							<div class="text-right mt-4">
								<a href="index.php?page=manage-giftcards" class="btn btn-primary btn-sm text-uppercase d-block d-xl-inline-block">More info <i class="fas fa-fw fa-arrow-right"></i></a>
							</div>
						</div>
					</div>
				</div>

				<div class="col col-xs-6 mt-5 mt-sm-0 col-sm-12 mt-md-5 col-md-6 mt-lg-0">
					<div class="card card-success shadow-medium shadow-hover-large border-left-success border-radius-0">
						<div class="card-header bg-transparent text-uppercase text-small text-strong">
							Purchased Giftcards
						</div>
						<div class="card-body pt-0">
							<div class="card-lead">
								<span class="lead"><?= $count_purchases ?></span>
								<span>Purchased giftcards</span>
								<div class="card-icon">
									<i class="fas fa-fw fa-shopping-cart"></i>
								</div>
							</div>
							<div class="text-right mt-4">
								<a href="index.php?page=manage-purchases" class="btn btn-success btn-sm text-uppercase d-block d-xl-inline-block">More info <i class="fas fa-fw fa-arrow-right"></i></a>
							</div>
						</div>
					</div>
				</div>

				<?php
			}
			?>
		</div>

    </div>
</div>
