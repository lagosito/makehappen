<footer class="text-center">
  <div class="footer-above">
    <div class="container">
      <div class="row">
        <div class="footer-col col-md-3">
          	<div class="footer-logo-box">
            	<img class="img-responsive" src="<?php echo ot_get_option('footer_logo'); ?>">
            </div>
        </div>
        <div class="footer-col col-md-6">
        	<div class="footer-menu-box">
                 <?php   wp_nav_menu( array(
                        'menu' => 'footer menu',
                        'container'=>'',
                        'items_wrap'     => '<ul class="footer-menu">%3$s</ul>'
                    ) ); ?>
			</div>	
        </div>
        <div class="footer-col col-md-3">
        
          <ul class="list-inline">
            <li> <a href="<?php echo ot_get_option('facebook_link'); ?>" class="btn-social btn-outline"><span class="sr-only">Facebook</span><i class="fa fa-fw fa-facebook"></i></a> </li>
            <li> <a href="<?php echo ot_get_option('twitter_link'); ?>" class="btn-social btn-outline"><span class="sr-only">Twitter</span><i class="fa fa-fw fa-tumblr"></i></a> </li>
            <li> <a href="<?php echo ot_get_option('instagram_link'); ?>" class="btn-social btn-outline"><span class="sr-only">Dribble</span><i class="fa fa-fw fa-instagram"></i></a> </li>
          </ul>
          
        </div>
      </div>
    </div>
  </div>
        
  <div class="footer-below">
    <div class="container">
      <div class="row">
        <div class="col-lg-12"> 
            <div class="copy-right-box">
                <?php echo ot_get_option('copy_right_box'); ?>
            </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<?php  wp_footer()?>
<!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
<div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md"> <a class="btn btn-primary" href="#page-top"> <i class="fa fa-chevron-up"></i> </a> </div>
</body>
</html>
