                    </section>    
                    <!-- /.content -->

                </div>
                <!-- /.content-wrapper -->

            <footer class="main-footer">
                <strong>Copyright &copy; <?=date("Y")?>
            </footer>

        </div>
        <!-- ./wrapper -->


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
