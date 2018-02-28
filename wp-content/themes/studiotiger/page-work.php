<?php get_header(); 


 while (have_posts()):the_post();
   the_content(); 
   endwhile;
   
   ?>
<section class="selected-work-boxes select-work-page p-t-0">
    <div id="ajax_response">
        <?php
            $postsPerPage = 4;
            $args = array(
                    'post_type' => 'portfolio',
                    'posts_per_page' => $postsPerPage,
                    'order'=>'desc'
            );

            $loop = new WP_Query($args);
            $i=1;
            $IDs_arr=array();
            while ($loop->have_posts()) : $loop->the_post();
            $post_id=get_the_ID();
           ?>
        <?php 
          if(($i%2)!="0"){
          if ( has_post_thumbnail() ) {
         $iurl = get_the_post_thumbnail_url($post_id); 
          $res="background-image:url('".$iurl."');"; 
          ?> 
         <div class="selected-work-wrapper">
            <div class="work-box brighten left-work-box" style="display: block;<?php echo $res; ?>" data-postid="<?php echo $post_id ?>" data-number="<?php echo $i ?>" data-portfoliocolore="light-orange">
          <?php } 
               else { ?>
               <div class="selected-work-wrapper">
            <div class="work-box brighten left-work-box" style="display: block;" data-postid="<?php echo $post_id ?>" data-number="<?php echo $i ?>" data-portfoliocolore="light-orange">
               <?php } ?>
            
                <p class="work-box-number"></p>
                <p class="work-box-title"><?php the_title(); ?></p>
                <a class="work-box-view" href="<?php the_permalink(); ?>">View</a>
            </div>
             <?php
           }else{
          if ( has_post_thumbnail() ) {
          echo $iurl = get_the_post_thumbnail_url($post_id); 
          $res="background-image:url('".$iurl."');"; 
          ?>      
           <div class="work-box brighten right-work-box" style="display: block;<?php echo $res; ?>" data-postid="<?php echo $post_id ?>" data-number="<?php echo $i ?>" data-portfoliocolore="light-blue">
          <?php } 
               else { ?>
                <div class="work-box brighten right-work-box" style="display: block;" data-postid="<?php echo $post_id ?>" data-number="<?php echo $i ?>" data-portfoliocolore="light-blue">
               <?php } ?>
                <p class="work-box-number"></p>
                <p class="work-box-title"><?php the_title(); ?></p>
                <a class="work-box-view" href="<?php the_permalink(); ?>">View</a>	
            </div>
            </div>
          <?php 
             
           }
           ?>
        
        <?php 
         $i++;    
         endwhile;
        wp_reset_postdata();
         ?>
        </div>
   <div class="view-all-btn">
	<div class="container">
    	<div class="row">
        	<div class="col-lg-12 text-center">
            	<div class="round-btn-box">
            		<button id="loadMore" class="rounded-btn start" >load more </button>
               	</div>
            </div>
        </div>
    </div>
	</div>
</section>

<script type="text/javascript">
  jQuery( document ).on( 'click', '#loadMore', function(){ 
          $(this).attr("disabled","disabled");
        var post_id= jQuery("#ajax_response div:last").data("postid");
        var number= jQuery("#ajax_response div:last").data("number");   
         jQuery.ajax({
                  url : "<?php echo admin_url('admin-ajax.php'); ?>",
                     type : "POST",
                     cache: false,
                     data : {
                         action: 'getpost_data',
                         post_id:post_id,
                          number: number
                     },
                     success: function(response) {
                         jQuery("#ajax_response").append(response);
                         $('#loadMore').removeAttr("disabled"); 
                          //console.log(response); 
                        }
                }); 
            });
    </script>
<?php get_footer(); ?> 