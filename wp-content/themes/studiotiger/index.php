<?php
if (have_posts()) : while (have_posts()) : the_post();
the_content();
endwhile;
else:
  echo  get_template_part( 404 ); 
endif;
?>