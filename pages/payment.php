
<h1 class="text-center"><i class="fa fa-refresh fa-spin"></i> Processing payment ..</h1>

<script type="text/javascript">
    $(document).ready(function(){
        timer = setTimeout(function(){ window.location = "<?=$account->name?>/payment-confirm&pay=success&purchase=<?=$_GET['purchase']?>";  }, 2000);
    });
</script>