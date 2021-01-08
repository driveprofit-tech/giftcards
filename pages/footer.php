    </div></div></div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="custom-container">
				<p class="custom-footer-links">
                    <?if ($terms_of_use_link != ""){?>
                    <a href="<?=$terms_of_use_link?>" target="_blank">Terms of Use</a>
                    <?}?>
                    <?if ($privacy_policy_link != ""){?>
                    <a href="<?=$privacy_policy_link?>" target="_blank">Privacy Policy</a>
                    <?}?>					
				</p>
				<p class="text-center">&copy; Copyright <? echo date("Y"); ?></p>
			</div>
		</div>
	</div>
</div>

    <script type="text/javascript" charset="UTF-8">

    $(document).ready(function() {
        
          
        

    });

    </script>
      
    <?
    if(strlen($_SESSION['tempalert']) > 1){
    ?>
        <script type="text/javascript">
            $(document).ready(function(){
                timer = setTimeout(function(){alert('<?=$_SESSION['tempalert']?>');},500);
            });
        </script>
    <?
        unset($_SESSION['tempalert']);
    }
    ?>

    </body>       

</html>