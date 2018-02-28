<?php 
include_once get_template_directory().'/option.php';
function theme_prefix_setup() {
	
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-width' => true,
	) );
     add_theme_support( 'post-thumbnails' );

}
add_action( 'after_setup_theme', 'theme_prefix_setup' );
function studiotiger_scripts_styles() {
    wp_enqueue_style('style-name', get_stylesheet_uri());
    wp_enqueue_style('fontawesome-style', get_template_directory_uri().'/vendor/font-awesome/css/font-awesome.min.css' );
    wp_enqueue_style('familymonrserrat-style', 'https://fonts.googleapis.com/css?family=Montserrat:400,700');
    wp_enqueue_style('familyopensans-style', 'https://fonts.googleapis.com/css?family=Open+Sans:300i');
    wp_enqueue_style('bootstrap-style', get_template_directory_uri().'/vendor/bootstrap/css/bootstrap.min.css' );
    wp_enqueue_style('freelancer-style', get_template_directory_uri().'/css/freelancer.css' );
    wp_enqueue_style('form-elements-style', get_template_directory_uri().'/css/form-elements.css' );
    wp_enqueue_style('owl.carousel-style', get_template_directory_uri().'/css/owl.carousel.min.css');
    wp_enqueue_style('owl.theme.-style', get_template_directory_uri().'/css/owl.theme.default.min.css');
    wp_enqueue_style('multi-step-style', get_template_directory_uri().'/css/multi-step-style.css');
    
    wp_enqueue_script('google-script','http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js');
    wp_enqueue_script('jquery-script', get_template_directory_uri() . '/vendor/jquery/jquery.min.js');
    wp_enqueue_script('bootstrap-script', get_template_directory_uri() . '/vendor/bootstrap/js/bootstrap.min.js');
    wp_enqueue_script('easing-script', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js');
    wp_enqueue_script('validation-script', get_template_directory_uri() . '/js/jqBootstrapValidation.js' );
    wp_enqueue_script('contactme-script', get_template_directory_uri() . '/js/contact_me.js');
    wp_enqueue_script('freelancer-script', get_template_directory_uri() . '/js/freelancer.min.js');
    wp_enqueue_script('owl.carousel-script', get_template_directory_uri() . '/js/owl.carousel.js');
    wp_enqueue_script('comman.js-script', get_template_directory_uri() . '/js/comman.js');
    wp_enqueue_script('jquery.backstretch-script', get_template_directory_uri() . '/js/jquery.backstretch.min.js');
    wp_enqueue_script('retina-1.1.0.min-script', get_template_directory_uri() . '/js/retina-1.1.0.min.js');
    wp_enqueue_script('script-script', get_template_directory_uri() . '/js/scripts.js');
    wp_enqueue_script('cookie-script',get_template_directory_uri() . '/js/jquery.cookie.js');
    wp_enqueue_script('YTPlayer', 'http://pupunzi.com/mb.components/mb.YTPlayer/demo/inc/jquery.mb.YTPlayer.js');
    wp_enqueue_script('my-js',get_template_directory_uri() . '/js/my-js.js',array(),'',true); 

}
add_action( 'wp_enqueue_scripts', 'studiotiger_scripts_styles' );

register_nav_menus(array(
    'primary' => __('Primary Menu', 'My_First_WordPress_Theme'),
    'secondary' => __('Secondary Menu',       'My_First_WordPress_Theme'),
    'My_custome_menu' => __('finally Menu', 'My_First_WordPress_Theme')
));

function footer_script(){ ?>
<script>
       var adminurl;
   window.adminurl="<?php echo admin_url('admin-ajax.php'); ?>";
 
</script>

<?php    
}
add_action('wp_footer','footer_script');

function my_custom_post_product() {
  $labels = array(
    'name'               => _x( 'Portfolio', 'post type general name' ),
    'singular_name'      => _x( 'Portfolio', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Portfolio' ),
    'edit_item'          => __( 'Edit Portfolio' ),
    'new_item'           => __( 'New Portfolio' ),
    'all_items'          => __( 'All Portfolio' ),
    'view_item'          => __( 'View Portfolio' ),
    'search_items'       => __( 'Search Portfolio' ),
    'not_found'          => __( 'No Portfolio found' ),
    'not_found_in_trash' => __( 'No Portfolio found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Portfolio'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds our products and product specific data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'taxonomies'    => array('category')  
  );
  register_post_type( 'portfolio', $args ); 
}
add_action( 'init', 'my_custom_post_product' );

function my_custom_post_type() {
  $labels = array(
    'name'               => _x( 'Team', 'post type general name' ),
    'singular_name'      => _x( 'Team', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'book' ),
    'add_new_item'       => __( 'Add New Team' ),
    'edit_item'          => __( 'Edit Team' ),
    'new_item'           => __( 'New Team' ),
    'all_items'          => __( 'All Team' ),
    'view_item'          => __( 'View Team' ),
    'search_items'       => __( 'Search Team' ),
    'not_found'          => __( 'No Team found' ),
    'not_found_in_trash' => __( 'No Team found in the Trash' ), 
    'parent_item_colon'  => '',
    'menu_name'          => 'Team'
  );
  $args = array(
    'labels'        => $labels,
    'description'   => 'Holds data',
    'public'        => true,
    'menu_position' => 5,
    'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
    'has_archive'   => true,
    'taxonomies'    => array('category')  
  );
  register_post_type( 'team', $args ); 
}
add_action( 'init', 'my_custom_post_type');

        add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
        add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
        function my_css_attributes_filter($var) {
            if(is_array($var)){
                $varci= array_intersect($var, array('current-menu-item'));
                $cmeni = array('current-menu-item');
                $selava   = array('selectedmenu');
                $selavaend = array();
                $selavaend = str_replace($cmeni, $selava, $varci);
            }
            else{
                $selavaend= '';
            }
        return $selavaend;
        }
        
     
add_action( 'wp_ajax_nopriv_getpost_data', 'getpost_data' );
add_action( 'wp_ajax_getpost_data', 'getpost_data' );

function getpost_data(){
    global $wpdb;
     $id=$_REQUEST['post_id'];
     
  if(!empty($id)){
            //$testdomin_result = _e('Your Action hear','textdomin');
      $query="SELECT * FROM wp_posts  WHERE wp_posts.ID < $id  AND wp_posts.post_type = 'portfolio' AND (wp_posts.post_status = 'publish')  ORDER BY wp_posts.post_date DESC LIMIT 0, 2";
      
      $loop =  $wpdb->get_results($query);

      if(empty($loop)){
         echo "<h3 class='ptext_center'>Now Post Is Not Avilable</h3>"; ?>
         <script>
           jQuery(document).ready(function(){
                jQuery('#loadMore').css("display","none");
         });  
         </script>
       <?php    
      }
 else {
          
            $i=$_REQUEST['number']+1;
            $IDs_arr=array();
           foreach ($loop as $data):
           ?>
        <?php 
          if(($i%2)!="0"){
         
            $iurl = get_the_post_thumbnail_url($data->ID); 
            if(!empty($iurl)){
             $result = "background-image:url('".$iurl."');";  ?>
         
       <div class="selected-work-wrapper">
            <div class="work-box brighten left-work-box" style="display: block;<?php echo $result; ?>" data-postid="<?php echo $data->ID; ?>" data-number="<?php echo $i ?>" data-portfoliocolore="light-orange">
          <?php } 
               else { ?>
               <div class="selected-work-wrapper">
            <div class="work-box brighten left-work-box" style="display: block;" data-postid="<?php echo $data->ID; ?>" data-number="<?php echo $i ?>" data-portfoliocolore="light-orange">
               <?php } ?>
                <p class="work-box-number"></p>
                <p class="work-box-title"><?php echo $data->post_title; ?></p>
                <a class="work-box-view" href="<?php echo $data->guid; ?>">View</a>
            </div>
             <?php
           }else{
            $iurl = get_the_post_thumbnail_url($data->ID); 
            if(!empty($iurl)){
             $result = "background-image:url('".$iurl."');";  ?>
        <div class="work-box brighten right-work-box" style="display: block;<?php echo $result; ?>" data-postid="<?php echo $data->ID; ?>" data-number="<?php echo $i ?>" data-portfoliocolore="light-blue">
          <?php } 
               else { ?>
                <div class="work-box brighten right-work-box" style="display: block;" data-postid="<?php echo $data->ID; ?>" data-number="<?php echo $i ?>" data-portfoliocolore="light-blue">
               <?php } ?>
                <p class="work-box-number"></p> 
                <p class="work-box-title"><?php echo $data->post_title; ?></p>
                <a class="work-box-view" href="<?php echo $data->guid; ?>">View</a>	
            </div>
            </div>
          
          <?php     
           }
           ?>
        
        <?php 
         $i++;    
          array_push($IDs_arr, $post_id);
      endforeach;
         wp_reset_postdata();
      }   

       }
         
   wp_die();
    return;
 } 
function TemplateUrl(){
    return get_template_directory_uri();
 }
add_shortcode("templateurl","TemplateUrl");

function SiteUrl(){
    return site_url();
 }
add_shortcode("siteurl","SiteUrl");

function projectmng(){
    ob_start();   
  $i=0;  
  $loop = new WP_Query( array( 'post_type'=>'team','post_status'=>'publish') );
  if(!empty($loop)){
       while ($loop->have_posts()) : $loop->the_post();
        $id    = get_the_ID();
        $title = get_the_title();
        $link  = get_the_permalink();
        $cat  = get_the_category($id)[0]->name;
        
           if($i==4){unset($i);$i=0;}
           $return = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">';
          
           $img = get_the_post_thumbnail_url($id); 
                   if($img==''){
		  $return .='<div class="team-box  brighten"  id="team-box'.$i.'">';
                   }else{
                       $img1 = "background-image:url('".$img."');"; 
                      $return .='<div class="team-box" style="'.$img1 .'">'; }  
				$return .='<a href="'.$link.'"><div class="emp-photo">
					</div>
					<div class="emp-details">
						<h3 class="emp-name">'.$title.'</h3>
						<p class="emp-designation">'.$cat.'</p>
					</div></a>
				</div>
		  	</div>';
 
        $i++;
          echo $return;      
     
   endwhile;
 } 
 return ob_get_clean();
}
add_shortcode('teamdata','projectmng');

remove_filter( 'the_content', 'wpautop' );


function wpdocs_register_my_custom_menu_page(){
    add_menu_page( __( 'Project Plan List', 'textdomain' ),
        'Project Plan List',
        'manage_options',
        'projectplanlist',
        'my_menu_page',
        'dashicons-awards',
        6
    ); 
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

function my_menu_page(){?>
<div class="row"  style="margin-left:15px;margin-right:15px;">
  <div class="col-sm-6">
      <h1 style="text-align: center;color: #f36866; margin-bottom: 28px;margin-top: 32px;">Project Plan List</h1>
      <table border="2" style="background-color: #f36866;text-align: center;color: #fff;border-collapse: collapse;border-color: #000;">
        <td><h3>ID</h3></td>
        <td><h3>Name</h3></td>
        <td><h3>Email</h3></td> 
        <td><h3>Company Name</h3></td> 
        <td><h3>Phone No</h3></td> 
        <td><h3>Project type</h3></td>
        <td><h3>Service Name</h3></td>
        <td><h3>Startdate Year/Month</h3></td>
        <td><h3>Endtdate Year/Month</h3></td>
        <td><h3>Service Type</h3></td> 
        <td><h3>Login</h3></td> 
        <td><h3>Personal Profile</h3></td> 
        <td><h3>Website Connect Api</h3></td> 
        <td><h3>SEO CMS</h3></td> 
        <td><h3>Design</h3></td> 
        <td><h3>Message</h3></td> 
       </tr>
  <?php
        global $wpdb;
        $i=0;
        $result = $wpdb->get_results( "SELECT * FROM wp_project_data");
        foreach ( $result as $print )   {
            $i++; 
            $mydata = $print->servicedetail; 
            $data= unserialize($mydata); 
// print_r($data); ?>
          <tr>
                  <td>  <?php echo $i; ?> </td>
                  <td><?php echo $print->name; ?> </td>
                  <td> <?php echo $print->email ; ?> </td>
                  <td> <?php echo $print->companyname ; ?> </td>
                  <td> <?php echo $print->phone ; ?> </td>
                  <td><?php echo $print->projecttype; ?> </td>
                  <td> <?php echo $print->servicename ; ?> </td>
                  <td> <?php echo $print->startdate_year."/".$print->startdate_month; ?> </td>
                  <td> <?php echo $print->enddate_year."/".$print->enddate_month; ?> </td>
                  <td><?php echo $data[0]; ?></td>
                  <td><?php echo $data[1]; ?></td>
                  <td><?php echo $data[2]; ?></td>
                  <td><?php echo $data[3]; ?></td>
                  <td><?php echo $data[4]; ?></td>
                  <td><?php echo $data[5]; ?></td>
                  <td><?php echo $print->message; ?></td>
          </tr>
            <?php }
      ?>
</table>
  </div>
</div>    
<?php } ?>
