<?php

function wpdocs_dequeue_script() {
    wp_dequeue_script('script-script');
    wp_enqueue_script('new-script', get_template_directory_uri() . '/js/new-scripts.js');
}

add_action('wp_enqueue_scripts', 'wpdocs_dequeue_script', 30); ?>
<?php get_header(); ?>
<section class=" project-wizard-section multistep-section">

    <div class="top-content">
        <div class="container">

            <div class="row">
                <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <form role="form" action="" method="post" class="f1">
                        <fieldset id="step1" class="step">

                            <div class="wizard-title text-center">
                                <h2>What does your idea need?</h2>
                                <hr class="border-blue">
<!--                                <p>Studio Tigres offers a continuum of design, development, strategy and consulting.</p>-->
                            </div>

                            <div class="row">
                                <ul id="select-fruit" class="type-project">
                                    <li>
                                        <!--<input type="radio" name="test1">Apple-->
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

                                                <p>I need a solid brand strategy along with a structured campaign design, which should also include channel strategy.After Selection: We gotcha ya!
</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <!--<input type="radio" name="test1">Banana-->
                                        <div class="icon-text-box strategy-box">
                                            <div class="pro-tit-icon">
                                                <div class="icon-box">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-2.png" class="img-responsive withouthover">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-2-white.png" class="img-responsive hoverd-img">
                                                </div>
                                                <div class="pro-tit">
                                                    <h3>DESIGN</h3>
                                                </div>
                                            </div>
                                            <div class="details-box">
                                                <p>I need everything from branding to web and product design. I don't want code though, just design will do. After Selection: Alrighty!</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <!--<input type="radio" name="test1">Mango-->
                                        <div class="icon-text-box strategy-box">
                                            <div class="pro-tit-icon">
                                                <div class="icon-box">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-3.png" class="img-responsive withouthover">
                                                    <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/project-icon-3-white.png" class="img-responsive hoverd-img">
                                                </div>
                                                <div class="pro-tit">
                                                    <h3>DEV</h3>
                                                </div>
                                            </div>

                                            <div class="details-box">
                                                <p>I need help developing web and mobile applications for my idea. After Selection: Now we're talkin'.</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <!--<input type="radio" name="test1">graps-->
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
                                                <p>I need a social media concept around which I can build a community of fans and followers.</p>
                                            </div>
                                        </div>
                                    </li>

                                </ul>

                            </div>

                            <div class="f1-buttons">
                                <button type="button" class="btn btn-previous cus-next-btn">Previous</button>
                                <button type="button" class="btn btn-next cus-next-btn">Next</button>

                            </div>

                        </fieldset>

                        <fieldset id="step2" class="step has-substep">
                            <div class="wizard-title-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-2-title-img.png" class="img-responsive">
                            </div>
                            <div class="wizard-title text-center">
                                <h2>You need Strategy with ?</h2>
                                <hr class="border-blue">
<!--                                <p>We design & develop strategic, digital platforms that empower brands.</p>-->
                            </div>

                            <div class="wizard-price-box">
                                <p class="price">
                                    400.00€
                                </p>

                                <p class="estimate-cost">rough cost estimate, so far.</p>
                            </div>

                            <div id="" class="main-substep">
                                <div class="row">
                                    <ul class="comman-services " id="select-serices">

                                        <li class="service-one multy-services has-substep" data-type="web">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>MARKETING <br>STRATEGY ALIGNMENT</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>I'd like to align my Marketing goals with my Strategy.</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-two multy-services has-substep" data-type="app">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>BRAND STRATEGY</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>I'd like help with defining the overarching positioning of the brand.</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-three multy-services" data-type="next">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>COMMUNICATIONS<br> STRATEGY</p>
                                                </div>
                                                <div class="service-description">
                                                    <p>It would be awesome to have a one-stop communications platform for all my content.</p>
                                                </div>
                                            </div>
                                        </li>
                                        
                                        <li class="service-four multy-services" data-type="next">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                        <p>Channel strategy</p>
                                                </div>
                                                <div class="service-description">
                                                        <p>I need assistance with how and when to use a channel to reach my customers.</p>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>

                                </div>

                            </div>

                            <div class="sub-fild-step">
                                <div class="row" id="web">
                                    <ul class="comman-services" data-index="1">
                                        <li class="service-one multy-services">
                                            <!--<input type="radio" name="test1">Apple-->
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>ECOM</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <!--<input type="radio" name="test1">Apple-->
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>One Page</p>
                                                </div>

                                            </div>
                                        </li>
                                        <li class="service-three multy-services">
                                            <!--<input type="radio" name="test1">Apple-->
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Multi Pager</p>
                                                </div>

                                            </div>
                                        </li>
                                        <li class="service-four multy-services">
                                            <!--<input type="radio" name="test1">Apple-->
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>No Idea</p>
                                                </div>

                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="2">
                                        <p class="questaion"> Do people Have Log in?</p>
                                        <li class="service-one multy-services">
                                            <input name="emailwo1" value="email" id="emailwo1" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Email</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="socialwo1" value="social" id="socialwo1" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Social</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-three multy-services">
                                            <input name="nowo1" value="no" id="nowo1" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-four multy-services">
                                            <input name="noideawo1" value="noidea" id="noideawo1" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>No Idea</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="3">
                                        <p class="questaion"> Do people Create Pesonal Profile?</p>
                                        <li class="service-one multy-services">
                                            <input name="yeswo2" value="yes" id="yeswo2" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>YES</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="nowo2" value="no" id="nowo2" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-three multy-services">
                                            <input name="idntkwo2" value="I dont know" id="idntkwo2" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>I dont Know</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="4">
                                        <p class="questaion"> Does Your Website Connect api?</p>
                                        <li class="service-one multy-services">
                                            <input name="yeswo3" value="yes" id="yeswo3" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>YES</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="nowo3" value="no" id="nowo3" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-three multy-services">
                                            <input name="idntkwo3" value="I dont know" id="idntkwo3" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>I dont Know</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="5">
                                        <p class="questaion"> SEO CMC is for you?</p>
                                        <li class="service-one multy-services">
                                            <input name="yeswo4" value="yes" id="yeswo4" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>YES</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="nowo4" value="no" id="nowo4" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-three multy-services">
                                            <input name="idntkwo4" value="I dont know" id="idntkwo4" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>I dont Know</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="6">
                                        <p class="questaion"> Do You Want To Design?</p>
                                        <li class="service-one multy-services">
                                            <input name="yeswo5" value="yes" id="yeswo5" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>YES</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="nowo5" value="no" id="nowo5" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="row" id="app">
                                    <ul class="comman-services" data-index="1">
                                        <li class="service-one multy-services">
                                            <input name="ios" value="ios" id="ios" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>IOS</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="android" value="android" id="android" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>ANDROID</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-three multy-services">
                                            <input name="both" value="both" id="both" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>BOTH</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="2">
                                        <p class="questaion"> Do people Have Log in?</p>
                                        <li class="service-one multy-services">
                                            <input name="emailwo1" value="email" id="emailwo1" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Email</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="socialwo1" value="social" id="socialwo1" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>Social</p>
                                                </div>
                                            </div>
                                        </li>

                                        <li class="service-three multy-services">
                                            <input name="nowo1" value="no" id="nowo1" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-three multy-services">
                                            <input name="noideawo1" value="noidea" id="noideawo1" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>No Idea</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="3">
                                        <p class="questaion"> Do people Create Pesonal Profile?</p>
                                        <li class="service-one multy-services">
                                            <input name="yeswo2" value="yes" id="yeswo2" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>YES</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="nowo2" value="no" id="nowo2" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-three multy-services">
                                            <input name="idntkwo2" value="I dont know" id="idntkwo2" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>I dont Know</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="4">
                                        <p class="questaion"> Does Your Website Connect api?</p>
                                        <li class="service-one multy-services">
                                            <input name="yeswo3" value="yes" id="yeswo3" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>YES</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="nowo3" value="no" id="nowo3" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-three multy-services">
                                            <input name="idntkwo3" value="I dont know" id="idntkwo3" type="hidden">
                                            <div class="service-rounded-box">	
                                                <div class="service-name">
                                                    <p>I dont Know</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>

                                    <ul class="comman-services" data-index="5">
                                        <p class="questaion"> Do You Want To Design?</p>
                                        <li class="service-one multy-services">
                                            <input name="yeswo5" value="yes" id="yeswo5" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>YES</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="service-two multy-services">
                                            <input name="nowo5" value="no" id="nowo5" type="hidden">
                                            <div class="service-rounded-box">
                                                <div class="service-name">
                                                    <p>No</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </div>


                            <div class="f1-buttons">
                                <button type="button" class="btn btn-previous cus-next-btn">Previous</button>
                                <button type="button" class="btn btn-next cus-next-btn">Next</button>

                            </div>
                        </fieldset>



                        <fieldset id="step3" class="step">

                            <div class="wizard-title-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-3-title-img.png" class="img-responsive">
                            </div>
                            <div class="wizard-title text-center">
                                <h2>You need Strategy with Channel branding starting ?</h2>
                                <hr class="border-blue">
                                <!--<p>Give us a rough idea of when you'd like to begin working together, and when you'd like to have the work delivered.</p>-->
                            </div>

                            <div class="wizard-price-box">
                                <p class="price">
                                    800.00€
                                </p>

                                <p class="estimate-cost">rough cost estimate, so far.</p>
                            </div>

                            <div class="row">
                                <div class="timeline-wrapper">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="select-date-box">

                                            <div class="label-box">
                                                <label>Start Date</label>
                                            </div>

                                            <div class="select-year">

                                                <a class="btn btn-default btn-select year-sel">
                                                    <input type="hidden" class="btn-select-input" id="" name="" value="" />
                                                    <span class="btn-select-value">Select an Item</span>
                                                    <span class='btn-select-arrow fa fa-angle-down'></span>
                                                    <ul>
                                                        <li class="selected">2016</li>
                                                        <li>2017</li>
                                                        <li>2018</li>
                                                        <li>2019</li>
                                                    </ul>
                                                </a>

                                            </div>
                                            <div class="select-month">
                                                <a class="btn btn-default btn-select ">
                                                    <input type="hidden" class="btn-select-input" id="" name="" value="" />
                                                    <span class="btn-select-value">Select an Item</span>
                                                    <span class='btn-select-arrow fa fa-angle-down'></span>
                                                    <ul>

                                                        <li class="selected">January</li>
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

                                                <a class="btn btn-default btn-select year-sel">
                                                    <input type="hidden" class="btn-select-input" id="" name="" value="" />
                                                    <span class="btn-select-value">Select an Item</span>
                                                    <span class='btn-select-arrow fa fa-angle-down'></span>
                                                    <ul>
                                                        <li class="selected">2016</li>
                                                        <li>2017</li>
                                                        <li>2018</li>
                                                        <li>2019</li>
                                                    </ul>
                                                </a>

                                            </div>
                                            <div class="select-month">
                                                <a class="btn btn-default btn-select ">
                                                    <input type="hidden" class="btn-select-input" id="" name="" value="" />
                                                    <span class="btn-select-value">Select an Item</span>
                                                    <span class='btn-select-arrow fa fa-angle-down'></span>
                                                    <ul>

                                                        <li class="selected">January</li>
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
                                <button type="button" class="btn btn-previous cus-next-btn">Previous</button>
                                <button type="button" class="btn btn-next cus-next-btn">Next</button>

                            </div>
                        </fieldset>

                        <fieldset id="step4" class="step">

                            <div class="wizard-title-img">
                                <img src="<?php echo get_template_directory_uri(); ?>/img/web-img/wizard-4-title-img.png" class="img-responsive">
                            </div>

                            <div class="wizard-title text-center">
                                <h2>Your contact details, <br>por favor.</h2>
                                <hr class="border-blue">
                                <p>Let us know how to get in touch, and provide a few concise notes about your project.
                                    <br> This additional context helps us respond quickly.</p>
                            </div>

                            <div class="row">
                                <div class="information-wrapper">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">Your name</label>
                                            <input type="text" name="first-name" class="input-design">
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">your email</label>
                                            <input type="text" name="first-name" class="input-design">
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">Phone</label>
                                            <input type="text" name="first-name" class="input-design">
                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">Company name</label>
                                            <input type="text" name="first-name" class="input-design">
                                        </div>

                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                                        <div class="form-group">
                                            <label class="lable-design" for="f1-first-name">Message</label>

                                            <textarea rows="50" cols="10" class="input-design-textarea"></textarea>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <div class="f1-buttons">
                                <button type="button" class="btn btn-previous cus-next-btn">Previous</button>
                                <a href="#" type="button" class="btn btn-next cus-next-btn">Next</a>

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