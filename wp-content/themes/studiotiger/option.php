<?php
add_action('wp_ajax_on_step2_multiple', 'on_step2_multiple');
add_action('wp_ajax_nopriv_on_step2_multiple', 'on_step2_multiple');

function on_step2_multiple(){
    
    if(isset($_POST['data1']) && !isset($_POST['data2'])){
        if($_POST['data1'] == 'web'){
    echo   '
        <ul id="website-serices" class="">
                <li class="service-one multy-services">
                    <input type="hidden" name="ecom" value="ecom" id="ecom" >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>ECOM</p>
                                </div>
                                
                        </div>
                </li>
                <li class="service-two multy-services" >
                   <input type="hidden" name="onepager" value="onepager" id="onepager" >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>ONE PAGER</p>
                                </div>
                                
                        </div>
                </li>

                <li class="service-three multy-services">
                    <input type="hidden" name="multipager"  value="multipager" id="multipager" >
                  <div class="service-rounded-box">	
                                <div class="service-name">
                                        <p>MUTLI PAGER</p>
                                </div>
                                
                        </div>
                </li>
                <li class="service-four multy-services">
                    <input type="hidden" name="noidea"  value="noidea" id="noidea" >
                  <div class="service-rounded-box">	
                                <div class="service-name">
                                        <p>NO IDEA</p>
                                </div>
                                
                        </div>
                </li>

        </ul>';
        }
        if($_POST['data1'] == 'app'){
            echo   '
      
        <ul id="website-serices">
                <li class="service-one multy-services">
                    <input type="hidden" name="ios" value="ios" id="ios" >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>IOS</p>
                                </div>
                                
                        </div>
                </li>
                <li class="service-two multy-services" >
                   <input type="hidden" name="android" value="android" id="android">
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>ANDROID</p>
                                </div>
                                
                        </div>
                </li>

                <li class="service-three multy-services">
                    <input type="hidden" name="both"  value="both" id="both">
                  <div class="service-rounded-box">	
                                <div class="service-name">
                                        <p>BOTH</p>
                                </div>
                                
                        </div>
                </li>
                

        </ul>';
        }
        if($_POST['data1'] == 'cons'){
            echo  ' ';
        }
    }

    if(isset($_POST['data2']) && $_POST['data2'] != 'noidea'){
  echo   '
      
      
        <ul id="web_option1" class="sub_option">
        <p> Do people Have Log in?</p>
        <li class="service-one multy-services">
                    <input type="hidden" name="emailwo1" value="email" id="emailwo1" >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>Email</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>
                <li class="service-two multy-services" >
                   <input type="hidden" name="socialwo1" value="social" id="socialwo1">
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>Social</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>

                <li class="service-three multy-services">
                    <input type="hidden" name="nowo1"  value="no" id="nowo1" >
                  <div class="service-rounded-box">	
                                <div class="service-name">
                                        <p>No</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>
                <li class="service-three multy-services">
                    <input type="hidden" name="noideawo1"  value="noidea" id="noideawo1">
                  <div class="service-rounded-box">	
                                <div class="service-name">
                                        <p>No Idea</p>
                                </div>
                                <div class="service-description">
                                       
                                </div>
                        </div>
                </li>

        </ul>
        
    '; }
        if(isset($_POST['data2'])){
                
    echo '
        
        <ul id="web_option2" class="sub_option">
        <p> Do people Create Pesonal Profile?</p>
                <li class="service-one multy-services">
                    <input type="hidden" name="yeswo2" value="yes" id="yeswo2" >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>YES</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>
                <li class="service-two multy-services" >
                   <input type="hidden" name="nowo2" value="no" id="nowo2"  >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>No</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>

                <li class="service-three multy-services">
                    <input type="hidden" name="idntkwo2"  value="I dont know" id="idntkwo2" >
                  <div class="service-rounded-box">	
                                <div class="service-name">
                                        <p>I dont Know</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>
                

        </ul>
            
         
        <ul id="web_option3" class="sub_option">
        <p> Does Your Website Connect api?</p>
                <li class="service-one multy-services">
                    <input type="hidden" name="yeswo3" value="yes" id="yeswo3">
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>YES</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>
                <li class="service-two multy-services" >
                   <input type="hidden" name="nowo3" value="no" id="nowo3"  >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>No</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>

                <li class="service-three multy-services">
                    <input type="hidden" name="idntkwo3"  value="I dont know" id="idntkwo3" >
                  <div class="service-rounded-box">	
                                <div class="service-name">
                                        <p>I dont Know</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>
                

        </ul>
            '; }
            
            if( $_POST['data1'] != 'app' && isset($_POST['data2'])){
                
        echo '
            
        <ul id="web_option4" class="sub_option">
        <p> SEO CMC is for you?</p>
                <li class="service-one multy-services">
                    <input type="hidden" name="yeswo4" value="yes" id="yeswo4" >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>YES</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>
                <li class="service-two multy-services" >
                   <input type="hidden" name="nowo4" value="no" id="nowo4">
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>No</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>
                
                <li class="service-three multy-services">
                    <input type="hidden" name="idntkwo4"  value="I dont know" id="idntkwo4" >
                  <div class="service-rounded-box">	
                                <div class="service-name">
                                        <p>I dont Know</p>
                                </div>
                                <div class="service-description">
                                       
                                </div>
                        </div>
                </li>
                

        </ul>';
            }
        if(isset($_POST['data2'])){
        
       echo  '<ul id="web_option5" class="sub_option">
        <p> Do You Want To Design?</p>
                <li class="service-one multy-services">
                    <input type="hidden" name="yeswo5" value="yes" id="yeswo5" >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>YES</p>
                                </div>
                                <div class="service-description">
                                       
                                </div>
                        </div>
                </li>
                <li class="service-two multy-services" >
                   <input type="hidden" name="nowo5" value="no" id="nowo5"  >
                  <div class="service-rounded-box">
                                <div class="service-name">
                                        <p>No</p>
                                </div>
                                <div class="service-description">
                                        
                                </div>
                        </div>
                </li>

                
               

        </ul>

';
    }

wp_die();
    } ?>