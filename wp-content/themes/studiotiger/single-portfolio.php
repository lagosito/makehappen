<?php get_header();
if (have_posts()) : while (have_posts()) : the_post(); ?>
<section class="p-b-0 p-t-180">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
        		<div class="section-title blue-color">
          			<p class="pink-text"><?php esc_html_e( 'PORTFOLIO', 'studiotiger' ); ?></p>
					<h2><?php 
                                        global $post;
                                        echo get_the_category($post->ID)[0]->name;?></h2>
                        </div>
      		</div>

		</div>
	</div>
</section>

<section class="selected-work-boxes p-t-0">
   <?php  if ( has_post_thumbnail() ) {
       $iurl = get_the_post_thumbnail_url(get_the_ID()); 
       $res="background-image:url('".$iurl."');"; }
else { 
 $res="background-color: #fbe6dc;";
} ?>    
	<div class="selected-work-wrapper">	
		<div class="work-box center-work-box" style="<?php echo $res; ?>">
			<p class="work-box-title"><?php the_title(); ?></p>
			<p class="work-box-desc-text"><p><?php echo the_content(); ?></p>
		</div>
		
	</div>
</section>	
	<div class="container">
    	<div class="row">
        	<div class="col-lg-12 text-center">
            	<div class="round-btn-box singlepagi">
                        <?php previous_post_link( '%link', __( '&larr; Previous', 'studiotiger' ) ); ?>
		       <?php next_post_link( '%link', __( 'Next &rarr;', 'studiotiger' ) ); ?>  
               	</div>
            </div>
        </div>
    </div>


<?php 
endwhile;
else:
include(TEMPLATEPATH . "/404.php");
endif;              
get_footer(); ?>