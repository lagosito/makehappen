<?php get_header(); ?>
<script>
  $(document).ready(function(){
  var ptype = $.cookie("ptype");
  var pservice = $.cookie("pservice");
  var sd1 = $.cookie('sd1');
  var sy1 = $.cookie('sy1');
  var ed1 = $.cookie('ed1');
  var ey1 = $.cookie('ey1');
  var pfname = $.cookie('pfname');
  var pemail = $.cookie('pemail');
  var pphone = $.cookie('pphone');
  var pcomname = $.cookie('pcomname');
  var pmsg= $.cookie("pmsg");
   if(pfname){         
   var pinformation = "Name => "+pfname+","+"Email => "+pemail;
   }
   if(sd1){
   var ptimeline = sd1+"-"+sy1+" "+"To"+" "+ed1+"-"+ey1;
   }
     $('#sptype').val(ptype);
     $('#spservice').val(pservice);
     $('#sptimeline').val(ptimeline);
     $('#spinformation').val(pinformation);
     $('#spmessage').val(pmsg);
  });  
</script>
<section class=" project-wizard-section yello-bg make-happen-lets-sum">

	<div class="top-content">
            <div class="container">
                <div class="row">
                    <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    	<form role="form" action="<?php echo site_url(); ?>/yeah" method="post" class="f1">
							<fieldset>
								
								<div class="wizard-title-img">
									<img src="<?php echo get_template_directory_uri(); ?>/img/web-img/lets-sum.png" class="img-responsive">
								</div>
								
                                <div class="wizard-title text-center ">
									<h2>Ok, Let’s sum this up:</h2>	
									<hr class="border-blue">
									<p>Let us know how to get in touch, and provide a few concise notes about your project. <br>
This additional context helps us respond quickly.</p>
								</div>
								
								
								
								<div class="row">
									<div class="information-wrapper">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										
											<div class="form-group m-b-30">
                    			    			<label class="lable-design" for="f1-first-name">Project type</label>
                                                                <input type="text" name="sptype" id="sptype" class="input-design" disabled>
                                			</div>
											
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											
											<div class="form-group m-b-30">
                    			    			<label class="lable-design" for="f1-first-name">service</label>
                                    			<input type="text" name="spservice" id="spservice" class="input-design" disabled>
                                			</div>
											
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										
											<div class="form-group m-b-30">
                    			    			<label class="lable-design" for="f1-first-name">Timeline</label>
                                    			<input type="text" name="sptimeline" id="sptimeline" class="input-design" disabled>
                                			</div>
											
										</div>
										
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
											
											<div class="form-group m-b-30">
                    			    			<label class="lable-design" for="f1-first-name">information </label>
                                    			<input type="text" name="spinformation" id="spinformation" class="input-design" disabled>
                                			</div>
											
										</div>
										
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											
											<div class="form-group m-b-30">
                    			    			<label class="lable-design" for="f1-first-name">Message</label>
                                    			<textarea rows="50" cols="10" class="input-design-textarea" id="spmessage" name="spmessage" disabled></textarea>
                                			</div>
											
										</div>
										
									</div>
								</div>

							
                                <div class="f1-buttons">
                                    <button type="submit" class="btn btn-next cus-next-btn submit-project-btn" name="lsbtn" id="lsbtn">
									<span class="submit-icon-right"><img class="submit-icon-left" src="<?php echo get_template_directory_uri(); ?>/img/web-img/submit-right-icon.png"></span>
									<span class="text">submit your project</span>
									<span class=icon-arrow><i class="fa fa-angle-right" aria-hidden="true"></i></span>
                                    </button>
                                    <p class="complit-submission-note">Complete your submission <br> & we'll reach out within two business day.</p>
                                </div>
                            </fieldset>
                    	</form>
                    </div>
                </div>
            </div>
        </div>
</section>

<?php get_footer(); ?>