<?php get_header(); ?>
<section class="project-wizard-section multistep-section">
	<div class="top-content">
            <div class="container"><div class="row">
                    <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                         <div class="alert alert-success fade in" id="alert-success" style="display:none;">
          <a href="<?php echo site_url(); ?>" class="close" data-dismiss="alert">&times;</a>
          <strong>Success!</strong> Your message has been sent successfully.
          </div>
                         <div class="alert alert-danger fade in" id="alert-danger" style="display:none;">
        <a href="<?php echo site_url(); ?>" class="close" data-dismiss="alert">&times;</a>
        <strong>Error!</strong> A problem has been occurred while submitting your message.
    </div>
                    	<form role="form" action="" method="post" name="sayhiform" class="f1" id="sayhiform">			
                                <div class="help-page-title text-center">
						<h2>How can we help?</h2>	
								</div>
								<div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                                <div class="help-icon-blog we-happen-help">
                                                                                    
											<a href="<?php echo site_url(); ?>/project-js" class="help-icon-box">
												<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/web-img/help-icon.png">
											</a>
											<div class="help-box-detail">
												<h3>I´d like to plan a project!</h3>
											</div>
                                                                                    <div class="help-tit">
                                                                                        <h2>Project</h2>
                                                                                    </div>
										</div>
									</div>
									
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="help-icon-blog we-happen-help">
                                                                                    
											<a class="help-icon-box" data-toggle="collapse" data-target="#demo">
												<img class="img-responsive" src="<?php echo get_template_directory_uri(); ?>/img/web-img/help-icon-1.png">
											</a>
											<div class="help-box-detail">
												<h3>I just want to say Hi!</h3>
											</div>
                                                                                    <div class="help-tit">
                                                                                        <h2>Hi</h2>
                                                                                    </div>
										</div>
									</div>
									
								</div>
							<div class="row collapse" id="demo">
									<div class="information-wrapper">
										
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										
											<div class="form-group">
                    			    			<label class="lable-design" for="f1-first-name">Your Name</label>
                                    			<input type="text" name="sfname" id="sfn" required class="input-design">
                                			</div>
											
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											
											<div class="form-group">
                    			    			<label class="lable-design" for="f1-first-name">YOUR EMAIL </label>
                                    			<input type="email" name="semail" id="semail" required class="input-design">
                                			</div>
											
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											
											<div class="form-group">
                    			    			<label class="lable-design" for="f1-first-name">Message</label>
                                    			
												<textarea rows="50" cols="10" class="input-design-textarea" required id="smsg" name="smsg"></textarea>
                                			</div>
											
										</div>
										
									</div>
								

							
                               <div class="f1-buttons m-t-0">
                                    <button type="submit" class="btn btn-next cus-next-btn border-bottom-btn" name="saybtn" id="shibtn">Submit</button>
                                </div>
								
								
								</div>
                            
                    </form>
                    </div>
                </div>      
            </div>
        </div>
</section>
<?php 
if(isset($_REQUEST['saybtn'])){
    $fname  = $_REQUEST['sfname'];
    $to     = $_REQUEST['semail'];
    $msg   = $_REQUEST['smsg'];  
    $url    =site_url();
    $admin_email = get_option('admin_email'); 
    $sitetitle = get_option('blogname');
    $body  ="From: [$fname] <[$to]><br/>
            Subject: Studiotiger<br/>
            Message Body:$msg<br/>
    This e-mail was sent from a sayhi form on $sitetitle ($url)";
    $headers = array("Content-Type: text/html; charset=UTF-8","From:$sitetitle <$admin_email>");
 
$mail = wp_mail($admin_email,$sitetitle,$body,$headers);
  if($mail){ ?>
     <script>
   $(document).ready(function(){
   $('#alert-success').css('display','block');
     });
     </script>
  <?php }  else { ?>
    <script>
        $(document).ready(function(){
   $('#alert-danger').css('display','block');
     });
       </script>
 <?php }

  }
get_footer(); ?>