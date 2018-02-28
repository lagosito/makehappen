<?php  get_header(); 
while(have_posts()):the_post(); ?>
<section class="p-b-0">
<div class="container">
<div class="row">
<div class="col-lg-12 text-center">
<div class="section-title blue-title text-uppercase">
<h2><?php the_title(); ?></h2>
</div>
</div>
</div>
<?php  the_content(); 
endwhile; ?>
</div>
</section>
<?php get_footer(); ?>


    