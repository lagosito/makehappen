<?php /* Template Name: Homepage */ ?>
<?php get_header(); ?>
<!-- Header -->

<?php /*
<header class="header">
  <div class="container" id="maincontent" tabindex="-1">
    <div class="row">
      <div class="col-lg-12"> 
			<div class="banner-text">
            	<!--<div class="banner-big-text">
                	<h1>We like <br><span class="dark-text"> challenges </span></h1>
                </div>-->
				
				<div class="sentence">
	 <?php echo ot_get_option('banner_text'); ?>
</div> 

                
                <div class="detail-text">
                	<p>
                	 <?php echo ot_get_option('detail_text'); ?>
                    </p>
                </div>
         <div class="banner-btn">
                		<div class="left-btn">
                            <div class="round-btn-box">
            					<a class="rounded-btn" href="<?php  echo esc_url( get_permalink(135) ); ?>"><?php esc_html_e( 'Quote my idea', 'studiotiger' ); ?>
 <i class="fa fa-long-arrow-right" aria-hidden="true"></i> </a>
               				</div>
                            <div class="small-text">
                            	<span><?php _e( 'Got an idea already? <br> Sweet! Get a free quote', 'studiotiger' ); ?></span>
                            </div>
                       </div>
                       <div class="or-btn">
                            <div class="or-box">
                                <p><?php esc_html_e( 'or', 'studiotiger' ); ?></p>
                            </div>
                    	</div>
                        
                        <div class="right-btn">
                            <div class="round-btn-box">
            					<a class="rounded-btn" href="#"><?php esc_html_e( 'Chat with our bot', 'studiotiger' ); ?><i class="fa fa-long-arrow-right" aria-hidden="true"></i> </a>
               				</div>
                            <div class="small-text">
                            	<span><?php _e( 'Hate talking to humans? <br> No problemo.', 'studiotiger' ); ?></span>
                            </div>
                    	</div>
                </div>
            </div>
            
            <!--<div class="button-scroll" data-scrollto="about"><span></span></div>-->
            
            
            <div class="magic-mouse scroll vertical presantion">
	<i>↑↓</i>
</div>


     </div>
    </div>
  </div>
</header>
 */?>

<header class="content-section video-section">
  <a id="bgndVideo" class="player" data-property="{videoURL:'https://youtu.be/5hyQ1C9-KKc',containment:'.video-section', quality:'large', autoPlay:true, mute:true, opacity:1}">bg</a>
    <div class="container" id="maincontent" tabindex="-1">
    <div class="row">
      <div class="col-lg-12"> 
			<div class="banner-text">
            	<!--<div class="banner-big-text">
                	<h1>We like <br><span class="dark-text"> challenges </span></h1>
                </div>-->
				
				<div class="sentence">
	 <?php echo ot_get_option('banner_text'); ?>
</div> 

                
                <div class="detail-text">
                	<p>
                	 <?php echo ot_get_option('detail_text'); ?>
                    </p>
                </div>
         <div class="banner-btn">
                		<div class="left-btn">
                            <div class="round-btn-box">
            					<a class="rounded-btn" href="<?php  echo esc_url( get_permalink(135) ); ?>"><?php esc_html_e( 'Quote my idea', 'studiotiger' ); ?>
 <i class="fa fa-long-arrow-right" aria-hidden="true"></i> </a>
               				</div>
                            <div class="small-text">
                            	<span><?php _e( 'Got an idea already? <br> Sweet! Get a free quote', 'studiotiger' ); ?></span>
                            </div>
                       </div>
                       <div class="or-btn">
                            <div class="or-box">
                                <p><?php esc_html_e( 'or', 'studiotiger' ); ?></p>
                            </div>
                    	</div>
                        
                        <div class="right-btn">
                            <div class="round-btn-box">
            					<a class="rounded-btn" href="#"><?php esc_html_e( 'Chat with our bot', 'studiotiger' ); ?><i class="fa fa-long-arrow-right" aria-hidden="true"></i> </a>
               				</div>
                            <div class="small-text">
                            	<span><?php _e( 'Hate talking to humans? <br> No problemo.', 'studiotiger' ); ?></span>
                            </div>
                    	</div>
                </div>
            </div>
            
            <!--<div class="button-scroll" data-scrollto="about"><span></span></div>-->
            
            
            <div class="magic-mouse scroll vertical presantion">
	<i>↑↓</i>
</div>


     </div>
    </div>
  </div>
</header>


<!-- what-we-do Section -->
<section class="what-we-do" id="about">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title">
          <?php echo ot_get_option('what_we_do_section'); ?>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="what-we-do-containt">
     <?php     if ( function_exists( 'ot_get_option' ) ) {
  
            /* get the slider array */
            $slides = ot_get_option( 'box_section', array() );

            if ( ! empty( $slides ) ) {
              $i=1;
                foreach( $slides as $slide ) {
                  ?>
        <div class="col col-lg-4 col-md-4 col-sm-6 col-xs-6 what-we-do-box box-<?php echo $i++; ?>">
          <div class="title-box">
            <?php echo  $slide['title']; ?>
            <div class="title-box-icon"> <img class="img-responsive" src="<?php echo $slide['image']; ?>"> </div>
          </div>
          <div class="containt-box">
          <?php echo $slide['description']; ?>
          </div>
        </div>
          <?php 
              }
            }

          } ?>
      </div>
    </div>
  </div>
</section>

<!-- Portfolio Section -->
<section class="portfolio">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-title">
        <?php echo ot_get_option('portfolio_title'); ?>
            
        </div>
      </div>
    </div>
  </div>
</section>
  
<!--<section class="portfolio">
    <div class="work-box new-box">
        <div class="work-wrapper">
            <div class="work-containt">
                <div class="work-title">
                    <p>JOBI</p>
                </div>
                <div class="work-description">
                    <p>Making Freelancing <br>
reliable for Freelancers and <br>
businesses. Launching 2018</p>
                </div>
                <div class="read-more"> 
                    <a href="http://localhost/make_happen/portfolio/test-portfolio/">Read more</a>
                </div>
            </div>
            <div class="work-bg">
                <div class="bg">
                    <img src="http://localhost/make_happen/wp-content/themes/studiotiger/img/web-img/work-mobile-1.png" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
    
    <div class="work-box right-contant new-box">
        <div class="work-wrapper">
            <div class="work-containt">
                <div class="work-title">
                    <p>JOBI</p>
                </div>
                <div class="work-description">
                    <p>The easiest and intuitive way to <br>create your page or e-shop online<br>
in less than 5 minutes</p>
                </div>
                <div class="read-more">
                    <a href="http://localhost/make_happen/portfolio/launch-support/">Read more</a>
                </div>
            </div>
            <div class="work-bg">
                <div class="bg">
                    <img class="img-responsive" src="http://localhost/make_happen/wp-content/themes/studiotiger/img/web-img/work-mobile-2.png">
                </div>
            </div>
        </div>
    </div>
</section>-->


<section class="my-work-section">
    <div class="last-work-text hidden-xs">
        <h1>
            last work
        </h1>
    </div>
    <div class="my-work-box-wrp work-right-img my-box-1">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="my-work-containt">
                        <div class="work-title">
                            <p>JOBI</p>
                        </div>
                        <div class="work-description">
                            <p>Making Freelancing <br>
                                reliable for Freelancers and <br>
                                businesses. Launching 2018</p>
                        </div>
                        <div class="read-more"> 
                            <a href="/portfolio/test-portfolio/">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-work-right-img">
            <figure class="image">
                <img src="<?php echo get_template_directory_uri() ?>/img/web-img/work-mobile-1.png" class="img-responsive">
            </figure>
        </div>
    </div>
    
    <div class="my-work-box-wrp work-left-img my-box-2">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <div class="my-work-containt">
                        <div class="work-title">
                            <p>MI PAGINA</p>
                        </div>
                        <div class="work-description">
                            <p>An intuitive and snappy way to <br>
                                make your website or e-shop,<br>
                                in less than 5 minutes.<br>
                                So far the record time was <br>
                                4minutes 28 seconds by Joan.</p>
                            
                                
                        </div>
                        <div class="read-more">
                            <a href="/portfolio/launch-support/">Check out the video here.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-work-left-img">
            <figure class="image">
                <img src="<?php echo get_template_directory_uri() ?>/img/web-img/work-mobile-2.png" class="img-responsive">
            </figure>
        </div>
    </div>
    
    <div class="my-work-box-wrp work-right-img my-box-3">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="my-work-containt">
                        <div class="work-title">
                            <p>DON BUSCALO</p>
                        </div>
                        <div class="work-description">
                            <p>What if we told you that if<br>
                                you answered 5 questions, <br>
                                our app would give you the<br>
                                best food options in and around Lima? <br>
                                Don't believe it?  <br>
                                Check-out DON BUSCALO.</p>
                        </div>
                        <div class="read-more"> 
                            <a href="/portfolio/test-portfolio/">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-work-right-img">
            <figure class="image">
                <img src="<?php echo get_template_directory_uri() ?>/img/web-img/work-mobile-3.png" class="img-responsive">
            </figure>
        </div>
    </div>
    
    <div class="my-work-box-wrp work-left-img my-box-4">
        
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-right">
                    <div class="my-work-containt">
                        <div class="work-title">
                            <p>Selected Work</p>
                        </div>
                        <div class="work-description">
                            <p>Get a glimpse of our work <br>
                                that made our clients happy and <br>
                                make happend proud</p>
                        </div>
                        <div class="read-more">
                            <a href="/portfolio/launch-support/">Read more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-work-left-img">
            <figure class="image">
                <img src="<?php echo get_template_directory_uri() ?>/img/web-img/work-mobile-4.jpg" class="img-responsive">
            </figure>
        </div>
    </div>
    
    <div class="container">
        <div class="row">
                    <div class="col-lg-12 text-center">
                    <div class="line-btn-box">
                            <a class="line-btn" href="#"> View All </a>
                    </div>
                </div>
        </div>
    </div>
</section>


<!-- clients Section -->
<section class="clients-section">
	<div class="container">
    	<div class="row">
        	<div class="col-lg-12 text-center">
        		<div class="section-title">
                  <?php echo ot_get_option('client_title'); ?>
                </div>
            </div>
        </div>
        
        
         <div class="row">
			<div class="clients-logo-slider">
			<div class="col-lg-12">
				<div class="owl-carousel owl-theme">
                                     <?php  if ( function_exists( 'ot_get_option' ) ) {
  
  /* get the slider array */
  $slides = explode( ',', ot_get_option( 'slider', '' ) );
  if ( ! empty( $slides ) ) {
       for ($i = 0; $i <count($slides); $i++) {
            echo '<div class="item">
                           <ul class="client-logo-ul-li">';
           
            echo '<li>
                  <div class="logo-img-box-wrapper">
                    <div class="logo-img-box">'; 
                       if(!empty($slides[$i])){
                          $full_img_src = wp_get_attachment_image_src($slides[$i], '' );
                        echo '<img class="img-responsive" src="'.$full_img_src[0].'">';
                       }
                    echo '</div>';
            $i++;
            echo '<div class="logo-img-box">'; 
                      if(!empty($slides[$i])){
                          $full_img_src = wp_get_attachment_image_src( $slides[$i], '' );
                        echo '<img class="img-responsive" src="'.$full_img_src[0].'">';
                       }
                    echo '</div>
               </li>';
          echo ' </ul>
                       </div>';
                
          }
    
  }
  
}
            ?>
		  	</div>
			</div>
			</div>
		</div>
                </div>            
   
</section>


<!-- contact Section -->

<section class="contact-section">
	<div class="container">
    	<div class="row">
        	<div class="col-lg-12">
        		<div class="section-title">
          			<p><?php echo ot_get_option('contact_title'); ?></p>
        		</div>
      		</div>
        </div>
        
        <div class="row">
        	<div class="contact-detail">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-p-r">
                	<div class="contact-left-box contact-box-coman">
                            <div class="con-imgtit-wrp">
                                <div class="contact-img-box">
                                        <img class="img-responsive" src="<?php echo site_url() ?>/wp-content/uploads/2017/07/contact-left-img.jpg">
                                </div>
                                <div class="con-tit-box">
                                    <div class="contact-title">
                                        <h3>Hamburg / germany</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="contact-detail-box">
                                
                                <div class="address-details">
                                    <p>make happen GmbH</p>
                                     <p>g�rtnerstr.80</p>
                                     <p>20253 Hamburg Germany</p>
                                     </div>
                                    <div class="mail-phone">
                                    <a href="#">mail@makehappen.de</a>
                                    <a href="#">(+49) 151 2123 6390</a>
                                     </div>
                            </div>
                        </div>
                </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-p-l">
                	
                        
                        <div class="map-section contact-box-coman">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2368.7174022811055!2d9.961971315556925!3d53.580659980028805!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47b18f529220d9c1%3A0xb2eeed3acd81d380!2sG%C3%A4rtnerstra%C3%9Fe+80%2C+20253+Hamburg%2C+Germany!5e0!3m2!1sen!2sin!4v1512730400940" width="100%" height="450px" frameborder="0" style="border:0" allowfullscreen></iframe>
                        </div>
                </div>
         <?php /* if ( function_exists( 'ot_get_option' ) ) {
  
                     //get the slider array 
                    $slides = ot_get_option( 'contact_detail', array() );

                    if ( ! empty( $slides ) ) {
                        $i = 1;
                        foreach( $slides as $slide ) {
//                            $class = '';
                           if($i%2 != 0)
                               $class = "no-p-r";
                           else $class = "no-p-l";
                           $i++;
                          ?>
            	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 <?php echo $class; ?>">
                	<div class="contact-left-box contact-box-coman">
                            <div class="con-imgtit-wrp">
                                <div class="contact-img-box">
                                        <img class="img-responsive" src="<?php echo $slide['image']; ?>">
                                </div>
                                <div class="con-tit-box">
                                    <div class="contact-title">
                                        <h3><?php echo $slide['title']; ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="contact-detail-box">
                                
                                <?php echo $slide['description']; ?>
                            </div>
                        </div>
                </div>
                 <?php  }
                    }
               }  */ ?>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>