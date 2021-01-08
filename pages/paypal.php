<div class="row">
<div class="col-xs-12 col-sm-3">&nbsp;</div>
<div class="col-xs-12 col-sm-6">
    <div class="alert alert-info"> 
        <span class="badge pull-right"><i class="fa fa-usd" aria-hidden="true"></i><?= $total_price ?></span>
        <h4>Transaction#: <?= $account_purchase->sender_code ?></h4>
    </div>
    <form action="" method="POST" data-toggle="validator" role="form" autocomplete="off">
        <input type="hidden" name="gateway" value="PayPal">
        <input type="hidden" name="purchase" value="<?= $account_purchase->id ?>">
        <input type="hidden" name="description" value="<?= $x_description ?>">
        <div class="form-group">
            <label>Name on card</label>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user"></i></span>
                <input type="text" placeholder="John Doe" id="name_on_card" name="name_on_card" class="form-control" required>
            </div>
        </div>
        <div class="form-group">
            <label>Card number</label>
            <div class="input-group">
                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-credit-card"></i></span>
                <input type="text" placeholder="1234 5678 9012 3456" maxlength="20" id="card_number" name="card_number" class="form-control" required>
            </div>
        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-xs-8"><label>Expiry</label></div>
                <div class="col-xs-4"><label>CVV</label></div>
            </div>
            <div class="row">
                <div class="col-xs-4">
                    <select name="expiry_month" class="form-control">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?= str_pad($i, 2, "0", STR_PAD_LEFT) . date(" - F", strtotime("2000-$i-25")); ?></option>
                        <?php } ?>
                    </select></div>
                <div class="col-xs-4">
                    <div class="input-group">
                        <span class="input-group-addon" style="background-color: transparent;border: 0;" id="basic-addon1">/</span>
                        <select name="expiry_year" class="form-control">
                            <?php for ($i = date('Y'); $i <= date('Y') + 20; $i++) { ?>
                                <option value="<?= str_pad($i, 2, "0", STR_PAD_LEFT); ?>"><?= str_pad($i, 2, "0", STR_PAD_LEFT); ?></option>
                            <?php } ?>
                        </select></div></div>
                <div class="col-xs-4">
                    <input type="text" placeholder="123" maxlength="3" id="cvv" name="cvv" class="form-control" required>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Address</label>
            <input type="text" placeholder="Street" id="address" name="address" class="form-control" required>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-xs-4">
                    <label>City</label>
                    <input type="text" placeholder="City" id="address" name="city" class="form-control" required>
                </div>                                    
                <div class="col-xs-4">
                    <label>State</label>
                    <select id="address" name="state" class="form-control">
                        <option value="AL">Alabama (AL)</option>
                        <option value="AK">Alaska (AK)</option>
                        <option value="AZ">Arizona (AZ)</option>
                        <option value="AR">Arkansas (AR)</option>
                        <option value="CA">California (CA)</option>
                        <option value="CO">Colorado (CO)</option>
                        <option value="CT">Connecticut (CT)</option>
                        <option value="DE">Delaware (DE)</option>
                        <option value="DC">District Of Columbia (DC)</option>
                        <option value="FL">Florida (FL)</option>
                        <option value="GA">Georgia (GA)</option>
                        <option value="HI">Hawaii (HI)</option>
                        <option value="ID">Idaho (ID)</option>
                        <option value="IL">Illinois (IL)</option>
                        <option value="IN">Indiana (IN)</option>
                        <option value="IA">Iowa (IA)</option>
                        <option value="KS">Kansas (KS)</option>
                        <option value="KY">Kentucky (KY)</option>
                        <option value="LA">Louisiana (LA)</option>
                        <option value="ME">Maine (ME)</option>
                        <option value="MD">Maryland (MD)</option>
                        <option value="MA">Massachusetts (MA)</option>
                        <option value="MI">Michigan (MI)</option>
                        <option value="MN">Minnesota (MN)</option>
                        <option value="MS">Mississippi (MS)</option>
                        <option value="MO">Missouri (MO)</option>
                        <option value="MT">Montana (MT)</option>
                        <option value="NE">Nebraska (NE)</option>
                        <option value="NV">Nevada (NV)</option>
                        <option value="NH">New Hampshire (NH)</option>
                        <option value="NJ">New Jersey (NJ)</option>
                        <option value="NM">New Mexico (NM)</option>
                        <option value="NY">New York (NY)</option>
                        <option value="NC">North Carolina (NC)</option>
                        <option value="ND">North Dakota (ND)</option>
                        <option value="OH">Ohio (OH)</option>
                        <option value="OK">Oklahoma (OK)</option>
                        <option value="OR">Oregon (OR)</option>
                        <option value="PA">Pennsylvania (PA)</option>
                        <option value="RI">Rhode Island (RI)</option>
                        <option value="SC">South Carolina (SC)</option>
                        <option value="SD">South Dakota (SD)</option>
                        <option value="TN">Tennessee (TN)</option>
                        <option value="TX">Texas (TX)</option>
                        <option value="UT">Utah (UT)</option>
                        <option value="VT">Vermont (VT)</option>
                        <option value="VA">Virginia (VA)</option>
                        <option value="WA">Washington (WA)</option>
                        <option value="WV">West Virginia (WV)</option>
                        <option value="WI">Wisconsin (WI)</option>
                        <option value="WY">Wyoming (WI)</option>
                        <option value="AS">American Samoa (AS)</option>
                        <option value="GU">Guam (GU)</option>
                        <option value="MP">Northern Mariana Islands (MP)</option>
                        <option value="PR">Puerto Rico (PR)</option>
                        <option value="UM">United States Minor Outlying Islands (UM)</option>
                        <option value="VI">Virgin Islands (VI)</option>                           </select>		
                </div>                                    
                <div class="col-xs-4">
                    <label>Zip</label>
                    <input type="text" placeholder="Zipcode" id="address" name="zip" class="form-control" required>
                </div>                                    
            </div>
        </div>
        <div class="form-group">
            <input type="submit" id="cardSubmitBtn" value="Proceed" class="btn btn-primary form-control ">            

        </div>
    </form>
</div>