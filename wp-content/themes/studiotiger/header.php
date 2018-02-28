<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head();?>
</head>
<body id="page-top" <?php body_class('index'); ?> >
<nav class='navbar navbar-inverse navbar-fixed-top page-header sam-nav-bar'>
  <div class='container'>
    <div class='navbar-header'>
        <?php  $custom_logo_id = get_theme_mod( 'custom_logo' );
               $image = wp_get_attachment_image_src( $custom_logo_id , 'full' ); ?>
      <a class="navbar-brand" href="<?php echo home_url(); ?>">
        <?php if(!empty($image[0])){ ?> 
      	<img class="img-responsive desktop-show" src="<?php echo $image[0]; ?>">
        <?php } ?>
        <img class="img-responsive mobile-show" src="<?php echo ot_get_option('mobile_logo'); ?>">
      </a> 
      <button class='btn navbar-btn btn-link pull-right sam-btn-menu' data-target='#modalNavigation' data-toggle='modal' type='button'>
        
		<label class="menu-open-button" for="menu-open">
    <span class="lines line-1"></span>
    <span class="lines line-2"></span>
    <span class="lines line-3"></span>
  </label>
  
      </button>
    </div>
  </div>
</nav>
<div class='modal fade modal-fullscreen-menu sam-cus-modal' id='modalNavigation' role='dialog' tabindex='-1'>
	<div class="container">
  		<div class="row">
				<div class="col-lg-12">
                                    <div class="mobile-logo hidden-lg hidden-md hidden-sm">
                                        <a class="navbar-brand" href="<?php echo home_url(); ?>">
                                            <?php if(!empty($image[0])){ ?>
                                            <img class="img-responsive desktop-show" src="<?php echo $image[0]; ?>">
                                                <?php } ?>
                                            <img class="img-responsive mobile-show" src="<?php echo ot_get_option('mobile_logo'); ?>">
                                        </a>
                                    </div>
				<div class="close-btn-section">
					  <button aria-label='Close' class='close' data-dismiss='modal' type='button'>
						<label class="menu-open-button menu-close-btn" for="menu-open">
							<span class="lines line-1"></span>
							<span class="lines line-2"></span>
							<span class="lines line-3"></span>
					  </label>
					  </button>
			  	</div>
			  </div>
			  </div>
			  <div class="row">
			 	<div class="col-lg-12">
                      <?php   wp_nav_menu( array(
                          'theme_location' => 'primary',
                        //'menu' => 'header menu',
                        'container'=>'',
                        'items_wrap'  => '<ul class="nav navbar-nav navbar-right menu-ul-li main-menu-sam"><li class="hidden"><a href="#page-top"></a></li>%3$s</ul>'
                    ) ); ?>
			 </div>
		</div>
		<div class="main-menu-bottom">
	  		<div class="row">
	  			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="address">
					<?php echo ot_get_option('address'); ?>	
					</div>
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="mail-phone">
						<?php echo ot_get_option('phone'); ?>
					</div>
				</div>
				
				<?php /* <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					<div class="main-menu-social">
								<ul class="list-inline">
						<li> <a href="<?php echo ot_get_option('facebook_link'); ?>" class="btn-social btn-outline"><span class="sr-only">Facebook</span><i class="fa fa-fw fa-facebook"></i></a> </li>
						<li> <a href="<?php echo ot_get_option('twitter_link'); ?>" class="btn-social btn-outline"><span class="sr-only">Twitter</span><i class="fa fa-fw fa-twitter"></i></a> </li>
						<li> <a href="<?php echo ot_get_option('instagram_link'); ?>" class="btn-social btn-outline"><span class="sr-only">Dribble</span><i class="fa fa-fw fa-instagram"></i></a> </li>
					  </ul>
					</div> 
				</div> */ ?>
				
				
	  		</div>
		</div>  
	</div>
</div>    
    
    
   