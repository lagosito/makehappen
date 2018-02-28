<?php get_header(); 
 while(have_posts()):the_post(); 
   the_content();
 endwhile;
 if(isset($_REQUEST['lsbtn'])){
 $ptype =  $_COOKIE['ptype'];   
 $service =  $_COOKIE['pservice'];
 $sd1 = $_COOKIE['sd1'];
 $sy1 = $_COOKIE['sy1'];
 $ed1 = $_COOKIE['ed1'];
 $ey1 = $_COOKIE['ey1'];
 $pfname = $_COOKIE['pfname'];
 $pemail = $_COOKIE['pemail'];
 $pphone= $_COOKIE['pphone'];
 $pcomname= $_COOKIE['pcomname'];
 $pmsg = $_COOKIE['pmsg'];
 $webserices = $_COOKIE['webserices']; 
 $result = '';
 if($service=="Website"){
        if($webserices=="noidea"){
           $wo1 = "Not Avilable Option";
           $wo2 = $_COOKIE['wo2'];
           $wo3 = $_COOKIE['wo3'];
           $wo4 = $_COOKIE['wo4'];
           $wo5 = $_COOKIE['wo5'];
           $data=array($webserices,$wo1,$wo2,$wo3,$wo4,$wo5);
          $result= serialize( $data );
        }
        if($webserices=="ecom" || $webserices=="onepager" || $webserices=="multipager") {
          $wo1 = $_COOKIE['wo1'];  
          $wo2 = $_COOKIE['wo2'];
          $wo3 = $_COOKIE['wo3'];
          $wo4 = $_COOKIE['wo4'];
          $wo5 = $_COOKIE['wo5'];
           $data=array($webserices,$wo1,$wo2,$wo3,$wo4,$wo5);
           $result=serialize( $data );
       }
 }
 else if($service=="App"){
      $wo1 = $_COOKIE['wo1'];  
      $wo2 = $_COOKIE['wo2'];
      $wo3 = $_COOKIE['wo3'];
      $wo4 = "Not Avilable Option";
      $wo5 = $_COOKIE['wo5'];

     $data=array($webserices,$wo1,$wo2,$wo3,$wo4,$wo5);
     $result = serialize( $data );
 }
else{
      $wo1 = "Not Avilable Option";  
      $wo2 = "Not Avilable Option";
      $wo3 ="Not Avilable Option";
      $wo4 = "Not Avilable Option";
      $wo5 = "Not Avilable Option";

     $data=array($webserices,$wo1,$wo2,$wo3,$wo4,$wo5);
     $result = serialize( $data );
 }

 global $wpdb;


    $tablename=$wpdb->prefix.'project_data';

    $data=array(
        'projecttype' => $ptype, 
        'servicename' => $service,
        'servicedetail' => $result,
        'startdate_year' => $sd1, 
        'startdate_month' => $sy1,
        'enddate_year' => $ed1, 
        'enddate_month' =>$ey1, 
        'name' => $pfname,
        'email' => $pemail, 
        'companyname' => $pcomname, 
        'phone' => $pphone,
        'message' => $pmsg );

    $insert = $wpdb->insert( $tablename, $data);
     $url   = site_url();
    $admin_email = get_option('admin_email'); 
    $sitetitle = get_option('blogname');
    $body  ="From: [$pfname] <[$pemail]><br/>
            Subject: Studiotiger<br/>
            Message Body:$pmsg<br/>
    This e-mail was sent from a project plan form on $sitetitle ($url)";
    $headers = array("Content-Type: text/html; charset=UTF-8","From:$sitetitle <$admin_email>");
 $mail = wp_mail($admin_email,$sitetitle,$body,$headers);   
  if($mail && $insert){ 
        ?>
<script>
$.removeCookie('ptype', { path: '/' });
$.removeCookie('pservice', { path: '/' });
$.removeCookie('sd1', { path: '/' });
$.removeCookie('sy1', { path: '/' });
$.removeCookie('ed1', { path: '/' });
$.removeCookie('ey1', { path: '/' });
$.removeCookie('pfname', { path: '/' });
$.removeCookie('pemail', { path: '/' });
$.removeCookie('pphone', { path: '/' });
$.removeCookie('pcomname', { path: '/' });
$.removeCookie('pmsg', { path: '/' });
$.removeCookie('webserices', { path: '/' });
$.removeCookie('wo1', { path: '/' });
$.removeCookie('wo2', { path: '/' });
$.removeCookie('wo3', { path: '/' });
$.removeCookie('wo4', { path: '/' });
$.removeCookie('wo5', { path: '/' });

   $(document).ready(function(){
   $('#alert-success').css('display','block');
     });
     </script>
 <?php } 
 else{ ?>
   <script>  
   $(document).ready(function(){
   $('#alert-danger').css('display','block');
     });
     </script>
 <?php }
 }    
get_footer(); ?>