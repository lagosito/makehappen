<?php get_header(); ?>
<section class=" project-wizard-section multistep-section">
    <div class="top-content">
        <div class="container">
            <div class="row">
                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form role="form" action="<?php echo site_url(); ?>/lets-sum" method="post" class="f1" name="pform">
                        <fieldset id="step1" class="step">
                            <div class="wizard-title text-center">
                                <h2>Type of project would you <br>like to start?</h2>	
                                <hr class="border-blue">
<!--									<p>Studio Tigres offers a continuum of design, development, strategy and consulting.</p>-->
                            </div>

                            <div class="row">
                                <input type="hidden" name="st1" id="st1" value="undefined"  >
                                <ul class="type-project" id="select-fruit">

                                    <li id="1">
                                        <input type="hidden" name="STRATEGY" value="STRATEGY">
                                        <div class="icon-text-box strategy-box">
                                            <div class="pro-tit-icon">
                                                <div class="icon-box">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-1.png" class="img-responsive withouthover">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-1-white.png" class="img-responsive hoverd-img">
                                                </div>
                                                <div class="pro-tit">
                                                    <h3>STRATEGY</h3>
                                                </div>
                                            </div>	

                                            <div class="details-box">

                                                <p>From Beratung to brand strategy, campaign design and channel strategy.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="2">
                                        <input type="hidden" name="DESIGN" value="DESIGN">
                                        <div class="icon-text-box strategy-box">
                                            <div class="pro-tit-icon">
                                                <div class="icon-box">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-2.png" class="img-responsive withouthover">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-2-white.png" class="img-responsive hoverd-img">
                                                </div>
                                                <div class="pro-tit">
                                                    <h3>design</h3>
                                                </div>
                                            </div>
                                            <div class="details-box">
                                                <p>From branding to web and product design. No code. Just design.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="3">
                                        <input type="hidden" name="DIGITAL_INNOVATION" value="DIGITAL INNOVATION">
                                        <div class="icon-text-box strategy-box">
                                            <div class="pro-tit-icon">
                                                <div class="icon-box">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-3.png" class="img-responsive withouthover">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-3-white.png" class="img-responsive hoverd-img">
                                                </div>
                                                <div class="pro-tit">
                                                    <h3>web & mobile</h3>
                                                </div>
                                            </div>

                                            <div class="details-box">
                                                <p>Development for a web / mobile applications or innovation product</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li id="4">
                                        <input type="hidden" name="SOCIAL_MEDIA" value="SOCIAL MEDIA">
                                        <div class="icon-text-box strategy-box">
                                            <div class="pro-tit-icon">
                                                <div class="icon-box">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-4.png" class="img-responsive withouthover">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-4-white.png" class="img-responsive hoverd-img">
                                                </div>
                                                <div class="pro-tit">
                                                    <h3>SOCIAL MEDIA</h3>
                                                </div>
                                            </div>

                                            <div class="details-box">
                                                <p>From Social Media Konzept to Targeting and community Building.</p>
                                            </div>
                                        </div>
                                    </li>

                                </ul>

                            </div>


                            <div class="f1-buttons">
                                <button type="button" id="bts1" class="btn btn-next cus-next-btn">Next</button>
                            </div>



                        </fieldset>

                        <fieldset id="step2" class="step">
                            <div id="result1" style="display:none;">					
                                <div class="wizard-title-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-2-title-img.png" class="img-responsive">
                                </div>
                                <div class="wizard-title text-center">
                                    <h2>What services will you require?</h2>	
                                    <hr class="border-blue">
<!--									<p>We design & develop strategic, digital platforms that empower brands.</p>-->
                                </div>
                                <div class="wizard-price-box">
                                    <p class="price">
                                        400.00€
                                    </p>

                                    <p class="estimate-cost">rough cost estimate</p>
                                </div>
                                <div class="row">
                                    <ul id="strategy-serices" class="main_option">
                                        <li class="service-one multy-services">
                                            <input type="hidden" name="Msa" value="Marketing Strategy Aligment">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Marketing <br> strategy aligment</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Validating and aligning the business goals with the communication goals</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input type="hidden" name="bs" value="Brand strategy">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Brand strategy</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining the overarching positioning of the brand</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-three multy-services">
                                            <input type="hidden" name="cs" value="Communications Strategy">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>Communications <br> strategy</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining a consistent communications platform for all content</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-four multy-services">
                                            <input type="hidden" name="Channel_strategy" value="Channel Strategy">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Channel strategy</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining the relevant future channelmix</p>
                                                </div>
                                            </div>
                                        </li>


                                    </ul>

                                </div>
                            </div>
                            <div id="result2" style="display:none;">					
                                <div class="wizard-title-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-2-title-img.png" class="img-responsive">
                                </div>
                                <div class="wizard-title text-center">
                                    <h2>What services will you require?</h2>	
                                    <hr class="border-blue">
<!--									<p>We design & develop strategic, digital platforms that empower brands.</p>-->
                                </div>
                                <div class="wizard-price-box">
                                    <p class="price">
                                        400.00€
                                    </p>

                                    <p class="estimate-cost">rough cost estimate</p>
                                </div>
                                <div class="row">
                                    <ul id="design-serices" class="main_option">
                                        <li class="service-one multy-services">
                                            <input type="hidden" name="branding" value="Branding">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Branding</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Validating and aligning the business goals with the communication goals</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input type="hidden" name="UI/UX" value="UI/UX">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>UI/UX</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining the overarching positioning of the brand</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-three multy-services">
                                            <input type="hidden" name="smd" value="Social Media Design">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>Social Media Design</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining a consistent communications platform for all content</p>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>

                                </div>
                            </div>                
                            <div id="result3" style="display:none;">					
                                <div class="wizard-title-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-2-title-img.png" class="img-responsive">
                                </div>

                                <div class="wizard-title text-center">
                                    <h2>What services will you require?</h2>	
                                    <hr class="border-blue">
<!--									<p>We design & develop strategic, digital platforms that empower brands.</p>-->
                                </div>
                                <div class="wizard-price-box">
                                    <p class="price">
                                        400.00€
                                    </p>

                                    <p class="estimate-cost">rough cost estimate</p>
                                </div>
                                <div class="row step2option">
                                    <input type="hidden" name="main" value="undefined" id="main" >
                                    <input type="hidden" name="subfield" id="subfield" value="undefined">
                                    <ul id="select-serices" >

                                        <li class="service-one multy-services">
                                            <input type="hidden" name="web" value="web" id="web">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Website</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Validating and aligning the business goals with the communication goals</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services" >
                                            <input type="hidden" name="app" value="app" id="app">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>App</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining the overarching positioning of the brand</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-three multy-services">
                                            <input type="hidden" name="cons"  value="cons" id="cons">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>Consulting</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining a consistent communications platform for all content</p>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                    <div class="row col-md-offset-1" id="web_option">


                                    </div>

                                </div>

                                <div class="webform" id="webform"></div>
                            </div> 
                            <div id="result4" style="display:none;">					
                                <div class="wizard-title-img">
                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-2-title-img.png" class="img-responsive">
                                </div>
                                <div class="wizard-title text-center">
                                    <h2>What services will you require?</h2>	
                                    <hr class="border-blue">
<!--									<p>We design & develop strategic, digital platforms that empower brands.</p>-->
                                </div>
                                <div class="wizard-price-box">
                                    <p class="price">
                                        400.00€
                                    </p>

                                    <p class="estimate-cost">rough cost estimate</p>
                                </div>
                                <div class="row">
                                    <ul id="social-serices" class="main_option">

                                        <li class="service-two multy-services">
                                            <input type="hidden" name="bsr4" value="Brand strategy">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Brand strategy</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining the overarching positioning of the brand</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-three multy-services">
                                            <input type="hidden" name="cor4" value="Concept">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>Concept</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining a consistent communications platform for all content</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-four multy-services">
                                            <input type="hidden" name="smd" value="Social Media Design">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Social Media Design</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>Defining the relevant future channelmix</p>
                                                </div>
                                            </div>
                                        </li>




                                    </ul>

                                </div>
                            </div>                                  
                            <div class="f1-buttons">

                                <button type="button" id="bts2" class="btn btn-next cus-next-btn">Next</button>
                            </div>
                        </fieldset>

                        <fieldset id="step3" class="step">

                            <div class="wizard-title-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-3-title-img.png" class="img-responsive">
                            </div>
                            <div class="wizard-title text-center">
                                <h2>What's your timeline?</h2>	
                                <hr class="border-blue">
                                <p>Give us a rough idea of when you'd like to begin working together, and when you'd like to have the work delivered.</p>
                            </div>

                            <div class="wizard-price-box">
                                <p class="price">
                                    800.00€
                                </p>

                                <p class="estimate-cost">rough cost estimate</p>
                            </div>

                            <div class="row">
                                <div class="timeline-wrapper">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="select-date-box">

                                            <div class="label-box">
                                                <label>Start Date</label>
                                            </div>

                                            <div class="select-year">

                                                <a class="btn btn-default btn-select year-sel sdate">
                                                    <input type="hidden" class="btn-select-input" id="sd1" name="sd1" value="" />
                                                    <span class="btn-select-value">Select an Item</span>
                                                    <span class='btn-select-arrow fa fa-angle-down'></span>
                                                    <ul class="sdate">
                                                        <li class="selected">Select Option</li>
                                                        <li>2016</li>
                                                        <li>2017</li>
                                                        <li>2018</li>
                                                        <li>2019</li>
                                                    </ul>
                                                </a>


                                            </div>
                                            <div class="select-month">
                                                <a class="btn btn-default btn-select syear ">
                                                    <input type="hidden" class="btn-select-input" id="sy1" name="sy1" value="" />
                                                    <span class="btn-select-value">Select an Item</span>
                                                    <span class='btn-select-arrow fa fa-angle-down'></span>
                                                    <ul class="syear">

                                                        <li class="selected">Select Option</li>
                                                        <li>January</li>   
                                                        <li>February</li>
                                                        <li>March</li>
                                                        <li>april</li>
                                                        <li>may</li>
                                                        <li>june</li>
                                                        <li>july</li>
                                                        <li>august</li>
                                                        <li>September</li>
                                                        <li>Nevember</li>
                                                        <li>December</li>
                                                    </ul>
                                                </a>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="select-date-box">

                                            <div class="label-box">
                                                <label>End Date</label>
                                            </div>

                                            <div class="select-year">

                                                <a class="btn btn-default btn-select year-sel edate">
                                                    <input type="hidden" class="btn-select-input" id="ed1" name="ed1" value="" />
                                                    <span class="btn-select-value">Select an Item</span>
                                                    <span class='btn-select-arrow fa fa-angle-down'></span>
                                                    <ul class="edate">
                                                        <li class="selected">Select Option</li>
                                                        <li>2017</li>
                                                        <li>2018</li>
                                                        <li>2019</li>
                                                    </ul>
                                                </a>


                                            </div>
                                            <div class="select-month">
                                                <a class="btn btn-default btn-select eyear">
                                                    <input type="hidden" class="btn-select-input" id="ey1" name="ey1" value="" />
                                                    <span class="btn-select-value">Select an Item</span>
                                                    <span class='btn-select-arrow fa fa-angle-down'></span>
                                                    <ul class="eyear">
                                                        <li class="selected">Select Option</li>
                                                        <li>January</li>   
                                                        <li>February</li>
                                                        <li>March</li>
                                                        <li>april</li>
                                                        <li>may</li>
                                                        <li>june</li>
                                                        <li>july</li>
                                                        <li>august</li>
                                                        <li>September</li>
                                                        <li>Nevember</li>
                                                        <li>December</li>
                                                    </ul>
                                                </a>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="f1-buttons">

                                <button type="button" class="btn btn-next cus-next-btn" id="bts3">Next</button>
                            </div>
                        </fieldset>
                        <fieldset id="step4" class="step">

                            <div class="wizard-title-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-4-title-img.png" class="img-responsive">
                            </div>

                            <div class="wizard-title text-center">
                                <h2>Your contact details, <br>por favor.</h2>	
                                <hr class="border-blue">
                                <p>Let us know how to get in touch, and provide a few concise notes about your project. <br> This additional context helps us respond quickly.</p>
                            </div>



                            <div class="row">
                                <div class="information-wrapper">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">Your name</label>
                                            <input type="text" name="pfirstname" id="pfname" class="input-design" required>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">your email</label>
                                            <input type="email" name="pemail" id="pemail" class="input-design" required>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">Phone</label>
                                            <input type="tel" name="pphone" id="pphone" class="input-design" required>
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">Company name</label>
                                            <input type="text" name="pcomname" id="pcomname" class="input-design" required>
                                        </div>

                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">Message</label>

                                            <textarea rows="50" cols="10" name="pmsg" id="pmsg" class="input-design-textarea" required></textarea>
                                        </div>

                                    </div>

                                </div>
                            </div>


                            <div class="f1-buttons">		
                                <button type="submit" class="btn btn-next cus-next-btn" id="bts4">Next</button>
                            </div>
                        </fieldset>





                        <div class="f1-steps">
                            <div class="f1-progress">
                                <div class="f1-progress-line" data-now-value="33.33" data-number-of-steps="3" style="width: 33.33%;"></div>
                            </div>
                            <div class="f1-step active" id="step_1">
                                <a class="f1-step-icon step-back" onClick="fistclick(1);">
                                    <i class="check-sign"></i>
                                    <p>1</p>
                                </a>
                                <p class="step-tit">Project Type</p>
                            </div>
                            <div class="f1-step dishable step2" id="step_2">
                                <a class="f1-step-icon step-back" onClick="fistclick(2);">
                                    <i class="check-sign"></i>
                                    <p>2</p>
                                </a>
                                <p class="step-tit">Services</p>
                            </div>
                            <div class="f1-step dishable step3" id="step_3">
                                <a class="f1-step-icon step-back" onClick="fistclick(3);">
                                    <i class="check-sign"></i>
                                    <p>3</p>
                                </a>
                                <p class="step-tit">timeline</p>
                            </div>

                            <div class="f1-step dishable step4" id="step_4">
                                <a class="f1-step-icon step-back" onClick="fistclick(4);">
                                    <i class="check-sign"></i>
                                    <p>4</p>
                                </a>
                                <p class="step-tit">Information</p>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php get_footer(); ?>
