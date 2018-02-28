<?php get_header();

if (have_posts()) :
   while (have_posts()) :
      the_post();
         the_content();
   endwhile;
endif;

?>
<!-- Header -->
<header class="header header-team">
    <div class="container" id="maincontent" tabindex="-1">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-img-tit">
                    <div class="banner-img">
                        <img class="img-responsive" src="<?php echo get_template_directory_uri() ?>/img/web-img/team-header.png" >
                    </div>
                    <div class="page-main-title">
                        <h1>
                            about us
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Portfolio Section -->


<section class="my-work-section team-section">
    <div class="last-work-text hidden-xs">
        <h1>
            best team
        </h1>
    </div>
    
    <?php
    $team_args = array('post_type'=>'team');
    $team_post_data = new WP_Query($team_args);
    $i=1;
    if($team_post_data->have_posts()){
        while ($team_post_data->have_posts()){
            $team_post_data->the_post(); ?>
            <div class="<?php echo ($i%2==0)?"work-box":"work-box right-contant"?>">
                <div class="work-wrapper">
                    <div class="work-containt">
                        <div class="member-name">
                            <h1><?php the_title(); ?></h1>
                        </div>
                        <hr class="blue-1px-hr"></hr>
                        <div class="member-details">
                            <p>She's all about the money.</p><br>
                            <p>Business Director</p><br>
                            <a href="mailto:lea@makehappen.com">lea@makehappen.com</a>
                        </div>
                    </div>
                    <div class="work-bg">
                        <div class="bg">
                            <div class="member-graident"></div>
                            <img class="img-responsive" src="<?php the_post_thumbnail_url(); ?>">
                        </div>
                    </div>
                </div>
            </div>
        <?php $i++; }
        wp_reset_postdata();
    } 
    ?> 
</section>

<?php get_footer(); ?>