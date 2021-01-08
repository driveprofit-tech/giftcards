                    </section>    
                    <!-- /.content -->

                </div>
                <!-- /.content-wrapper -->

            <footer class="main-footer">
                <strong>Copyright &copy; <?=date("Y")?>
            </footer>

        </div>
        <!-- ./wrapper -->

        <div class="modal fade" id="modal-help">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
              </div>
              <div class="modal-body">
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->


        <script src="../code/scripts/alertify.js" type="text/javascript"></script>
        <script type="text/javascript">
                
            $(document).ready(function(){

                $(document).on('click', '.open_help', function (evt) {
                    evt.preventDefault();
                    $("#modal-help").find('.modal-title').html($(".content_help_title").html());
                    $("#modal-help").find('.modal-body').html($(".content_help_content").html());
                    $("#modal-help").modal('show');
                });

                <?
                if(strlen($_SESSION['tempalert']) > 1){
                ?>
                    alertify.logPosition("bottom right");
                    timer = setTimeout(function(){alertify.delay(10000).success('<?=$_SESSION['tempalert']?>');},500);
                       
                <?
                    unset($_SESSION['tempalert']);
                }
                ?>

            });

        </script>
       
        
    </body>
</html>
