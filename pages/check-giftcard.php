<div class="row">
    <div class="col-xs-12 text-center">
        <h1>Check Giftcard</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3 col-xs-12">

    	<?
		if(isset($err_msg) && $err_msg != "")
		{
		?>
			<div class="alert alert-danger alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?=$err_msg?>
			</div>
		<?
		}
		?>

        <form action="" method="get" id="form_check">
        	<div class="form-group">
		        <div class="input-group">
					<input type="text" class="form-control" name="code" id="code" placeholder="Enter code" value="<?=(isset($_GET['code']) ? $_GET['code'] : "")?>">
					<span class="input-group-btn">
						<button class="btn btn-primary-preview" type="submit">Search</button>
					</span>
				</div>
				<p class="help-block">Enter the code received by email. The codes are valid for 10 days from the moment the giftcard is sent.</p>
			</div>
        </form>
    </div>
</div>

<?
if(!empty($purchase))
{
    $giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$account->id, "id"=>$purchase->account_giftcard_id), "id DESC");
    echo '
    	
		<div class="row">
    		<div class="col-xs-12">
				<div class="giftcards-row">
					<div class="giftcard-column-preview">
						<div class="giftcards-container">
							<div class="col-md-5 col-xs-12 giftcard-img-container">
								<img src="assets/' . $account->id . '/' . $giftcard->image . '" class="img-responsive giftcard-img" />
							</div>
							<div class="col-md-7 col-xs-12">
								<p class="giftcard-title">Hi ' . $purchase->receiver_name . ',</p>
								<p class="giftcard-description">You have received a giftcard from <strong>' . $purchase->sender_name . '</strong> and the following message:</p>
								<p class="giftcard-message">' . $purchase->message . '</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		';
}
?>