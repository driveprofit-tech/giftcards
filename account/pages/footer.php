                    </section>
                    <!-- /.content -->

                </div>
                <!-- /.content-wrapper -->

            <footer id="main-footer" class="main-footer">
				<span>Copyright &copy; <?=date("Y")?></span>
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

			gsap.registerPlugin(ScrollTrigger);

			// Debounce window resize
			var
				resizeEnd = new Event('resize-end'),
				resizeTimer,
				resizeInterval = 150;

			window.addEventListener('resize', function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function() {
					window.dispatchEvent(resizeEnd);
				}, resizeInterval);
			});

			(function($) {

				<?
				if(strlen($_SESSION['tempalert']) > 1){
					?>
					alertify.logPosition("bottom right");
					timer = setTimeout(function(){alertify.delay(10000).success('<?=$_SESSION['tempalert']?>');},500);

					<?
					unset($_SESSION['tempalert']);
				}
				?>

			})(jQuery);

        </script>


    </body>
</html>
