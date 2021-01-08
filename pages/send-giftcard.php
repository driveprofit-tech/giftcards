<?php

$intro_text = account_globals::getvalue($account->id, "intro_text");
$disclaimer_text = account_globals::getvalue($account->id, "disclaimer_text");

if($step == 1)
{
    $giftcards = MyActiveRecord::FindAll('account_giftcard', array("account_id"=>$account->id, "status"=>"active"), 'name ASC');
}

if($step == 2)
{
    $DATA1 = isset($_SESSION["giftcards"]['step1']) ? $_SESSION["giftcards"]['step1'] : array();
    $DATA2 = isset($_SESSION["giftcards"]['step2']) ? $_SESSION["giftcards"]['step2'] : array();

    $giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$account->id, "id"=>$DATA1['giftcard_id']), "id DESC");
}

if($step == 3)
{
    $DATA1 = isset($_SESSION["giftcards"]['step1']) ? $_SESSION["giftcards"]['step1'] : array();
    $DATA2 = isset($_SESSION["giftcards"]['step2']) ? $_SESSION["giftcards"]['step2'] : array();

    $giftcard = MyActiveRecord::FindFirst('account_giftcard', array("account_id"=>$account->id, "id"=>$DATA1['giftcard_id']), "id DESC");
}

?>

<?if($step == 1){?> 

<div class="row">
    <div class="col-xs-12">
        <h1>Select Giftcard</h1>
    </div>
</div>
<?if($intro_text != ""){?>
<div class="row">
    <div class="col-xs-12">
        <p><?=$intro_text?></p>        
    </div>
</div>
<?}?>

<form action="" method="post" id="form_send_1">
    <input type="hidden" name="step" id="step" value="1">
    <input type="hidden" name="giftcard_id" id="giftcard_id" value="">
	<div class="giftcards-row">
<?
if(!empty($giftcards))
{
    foreach ($giftcards as $item) {
        echo '
        <div class="giftcard-column">
			<div class="giftcards-container">
				<div class="col-md-5 col-xs-12 giftcard-img-container">
					<img src="assets/' . $account->id . '/' . $item->image . '" class="img-responsive giftcard-img" />
				</div>
				<div class="col-md-7 col-xs-12">
				<p class="giftcard-title">' . $item->name . '</p>
				<p class="giftcard-description">' . $item->description . '</p>
				<p class="giftcard-price">$' . $item->price . '
				<button id="send_giftcard_' . $item->id . '" type="button" class="btn btn-primary send_giftcard pull-right">Select</button>
				</p>
				</div>
			</div>
		</div>
        ';
    }
}
?>
	</div>
</form>

<?if($disclaimer_text != ""){?>
<div class="row">
    <div class="col-xs-12">
        <p><?=$disclaimer_text?></p>        
    </div>
</div>
<?}?>

<?}?> 

<?if($step == 2){?> 

<div class="row">
    <div class="col-xs-12">
        <h1>Add the details to send the selected Giftcard</h1>
    </div>
</div>

<form action="" method="post" id="form_send_2">
    <input type="hidden" name="step" id="step" value="2">
    <input type="hidden" name="giftcard_id" id="giftcard_id" value="<?=$DATA1['giftcard_id'];?>">
<?
if(!empty($giftcard))
{
    echo '
        <div class="giftcards-row">
			<div class="giftcard-column">
				<div class="giftcards-container">
					<div class="col-md-5 col-xs-12 giftcard-img-container">
						<img src="assets/' . $account->id . '/' . $giftcard->image . '" class="img-responsive giftcard-img" />
					</div>
					<div class="col-md-7 col-xs-12">
						<p class="giftcard-title">' . $giftcard->name . '</p>
						<p class="giftcard-description">' . $giftcard->description . '</p>
						<p class="giftcard-price">$' . $giftcard->price . '
							<a href="' . $account->name . '/send-giftcard" class="btn btn-primary pull-right">Change</a>
						</p>
					</div>
				</div>
			</div>
		</div>
		
		';
}
?>
	<div class="row">
		<div class="col-xs-12 col-sm-6">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<label class="control-label" for="sender_name">Sender's name</label>
						<input name="sender_name" type="text" class="form-control" id="sender_name" placeholder="Sender's name" required="" value="<?=(isset($DATA2['sender_name']) ? $DATA2['sender_name'] : "")?>">
					</div>
				</div>
				<div class="col-xs-12">
					<div class="form-group">
						<label class="control-label" for="sender_email">Sender's email</label>
						<input name="sender_email" type="email" class="form-control" id="sender_email" placeholder="Sender's email" required="" value="<?=(isset($DATA2['sender_email']) ? $DATA2['sender_email'] : "")?>">
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-6">
			<div class="row">
				<div class="col-xs-12">
					<div class="form-group">
						<label class="control-label" for="receiver_name">Receiver's name</label>
						<input name="receiver_name" type="text" class="form-control" id="receiver_name" placeholder="Receiver's name" required="" value="<?=(isset($DATA2['receiver_name']) ? $DATA2['receiver_name'] : "")?>">
					</div>
				</div>
				<div class="col-xs-12">
					<div class="form-group">
						<label class="control-label" for="receiver_email">Receiver's email</label>
						<input name="receiver_email" type="email" class="form-control" id="receiver_email" placeholder="Receiver's email" required="" value="<?=(isset($DATA2['receiver_email']) ? $DATA2['receiver_email'] : "")?>">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="form-group">
				<label class="control-label" for="message">Message</label>
				<textarea name="message" class="form-control" id="message" placeholder="Message" required=""><?=(isset($DATA2['message']) ? $DATA2['message'] : "")?></textarea>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="radio">
				<label class="radio-inline"><input type="radio" name="send_when" class="send_when" id="send_on_now" value="now" <?=(!isset($DATA2['send_when']) || (isset($DATA2['send_when']) && $DATA2['send_when'] == "now") ? "checked" : "")?>>Send right away</label>
				<label class="radio-inline"><input type="radio" name="send_when" class="send_when" id="send_on_future" value="future" <?=(isset($DATA2['send_when']) && $DATA2['send_when'] == "future" ? "checked" : "")?>>Send in the future</label>
			</div>
			<div class="form-group" id="send_on_container" style="<?=(isset($DATA2['send_when']) && $DATA2['send_when'] == "future" ? "" : "display: none;")?>">
				<label class="control-label" for="receiver_email">Send on</label>
				<input name="send_on" type="text" class="form-control datetimepicker" id="send_on" value="<?=(isset($DATA2['send_on']) ? $DATA2['send_on'] : "")?>" <?=(isset($DATA2['send_when']) && $DATA2['send_when'] == "future" ? "required" : "")?>  placeholder="Send on">
			</div>
			<div class="checkbox">
				<label><input type="checkbox" name="received_notification" id="received_notification" value="1" <?=(isset($DATA2['received_notification']) && $DATA2['received_notification'] == 1 ? "checked" : "")?>>I want to be notified when the receiver opens the giftcard</label>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Preview & Confirm</button>        
			</div>
		</div>
	</div>
</form>

<?}?> 

<?if($step == 3){?> 

<div class="row">
    <div class="col-xs-12">
        <h1>Preview & Confirm</h1>
    </div>
</div>

<form action="" method="post" id="form_send_3">
    <input type="hidden" name="step" id="step" value="3">
    <input type="hidden" name="giftcard_id" id="giftcard_id" value="<?=$DATA1['giftcard_id'];?>">
<?
if(!empty($giftcard))
{
    echo '
        
		<div class="giftcards-row">
			<div class="giftcard-column">
				<div class="giftcards-container">
					<div class="col-md-5 col-xs-12 giftcard-img-container">
						<img src="assets/' . $account->id . '/' . $giftcard->image . '" class="img-responsive giftcard-img" />
					</div>
					<div class="col-md-7 col-xs-12">
						<p class="giftcard-title">' . $giftcard->name . '</p>
						<p class="giftcard-description">' . $giftcard->description . '</p>
						<p class="giftcard-price">$' . $giftcard->price . '
							<a href="' . $account->name . '/send-giftcard" class="btn btn-primary pull-right">Change</a>
						</p>
					</div>
				</div>
			</div>
		</div>';
}
?>
    <div class="form-group">
        <p><strong>Sender's name: </strong><?=$DATA2['sender_name'];?></p>
        <p><strong>Sender's email: </strong><?=$DATA2['sender_email'];?></p>
        <p><strong>Receiver's name: </strong><?=$DATA2['receiver_name'];?></p>
        <p><strong>Receiver's name: </strong><?=$DATA2['receiver_email'];?></p>
        <p><strong>Message: </strong><em><?=$DATA2['message'];?></em></p>
        <p><strong>Send: </strong><?=($DATA2['send_when'] == "future" ? $DATA2['send_on'] : "Right Now");?></p>
        <?if(isset($DATA2['received_notification']) && $DATA2['received_notification'] == 1){?>
        <i class="fa fa-check-square-o" aria-hidden="true"></i> I want to be notified when the receiver opens the giftcard
        <?}else{?>
        <i class="fa fa-ban" aria-hidden="true"></i> Don't notify me when the receiver opens the giftcard
        <?}?>
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Proceed to Checkout</button>
        <a href="<?=$account->name;?>/send-giftcard/step-2" class="btn btn-primary">Edit details</a>
    </div>
</form>

<?}?> 


 <script type="text/javascript" charset="UTF-8">

    $(document).ready(function() {
        
        $(document).on('click', '.send_giftcard', function(evt)
        {
            evt.preventDefault();
            var giftcard_id = $(this).attr("id").replace("send_giftcard_", "");
            $("#giftcard_id").val(giftcard_id);
            $("#form_send_1").submit();
        })

        $(document).on('change', '.send_when', function(evt)
        {
            var checked = $(this).val();
            if(checked == "future")
            {
                $("#send_on_container").slideDown();
                $("#send_on").prop('required', true);
            }
            else
            {
                $("#send_on_container").slideUp();
                $("#send_on").prop('required', false);
            }
        })

        // Set min date
        var today = new Date();
        var mindate = new Date(today.getTime() + 24 * 60 * 60 * 1000);

        $(".datetimepicker").datetimepicker({
            format: 'MM/DD/YYYY hh:mm a',
            showClose: true,
            useCurrent: false,
            minDate: moment().millisecond(0).second(0).minute(0).hour(0),
            stepping: 15
        });

        

    });

</script>
    