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

				$('[data-toggle="tooltip"]').tooltip();

				// File input
				$('input[type="file"]').each(function() {

					var $input = $(this),
						$label = $input.next('div').find('label');

					// Manage .focus class on label element
					$input.on('focus', function() {
						$label.addClass('focus');
					});
					$input.on('blur', function() {
						$label.removeClass('focus');
					});
					$label.on('click', function() {
						$label.addClass('focus');
					});

					$input.on('change', function() {
						if(this.files.length == 1) {
							$label.find('span').text(this.files[0].name);
						};
					});

				});

				<?
				if( strlen( $_SESSION[ 'tempalert' ] ) > 1 ) {
					$alert_type = isset( $_SESSION[ 'tempalert_type' ] ) ? $_SESSION[ 'tempalert_type' ] : 'success';
					?>
					alertify.logPosition("bottom right");
					<?php
					if( 'success' == $alert_type ) {
						?>timer = setTimeout(function(){alertify.delay(10000).success('<?=$_SESSION['tempalert']?>');},500);<?
					} else {
						?>timer = setTimeout(function(){alertify.delay(10000).error('<?=$_SESSION['tempalert']?>');},500);<?
					}
					unset( $_SESSION[ 'tempalert' ] );
					unset( $_SESSION[ 'tempalert_type' ] );
				}
				?>

			})(jQuery);

        </script>


    </body>
</html>
