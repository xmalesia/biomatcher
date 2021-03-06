<div class="wrapper">
    <div id="content">
        <div style="float: left;">
            <a class="box-button" onclick="regenerate_token(<?php echo $this->uri->segment(4); ?>)" >Re-Generate Code</a><br />
        </div>
    
        <div style="float: right;">
        
            <span>
                <a href="<?php echo base_url(); ?>index.php/download" style="float: right;">
                    <p style="float: left; margin-top: 7px;">Go to Download Page</p>
                    <img style="height: 36px; float:right" src="<?php echo base_url(); ?>style/img/arrow-right.png" />
                </a>
            </span>
            <span>
                <a href="<?php echo base_url(); ?>index.php/pages/view/my_website" style="float: right;margin-right: 20px">
                    <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                    <p style="float: right; margin-top: 7px;">Back to My Website</p>
                </a>
            </span>
            
        </div>
        
        <div class="separator" style="float: left;"></div>
        <div style="float: left;margin-bottom: 40px;"></div>
        
        <div class="clear"></div>
        
        <?php echo form_error('url', '<div class="errorbox">', '</div>'); ?>
        
        <div>
            <div class="group"><p>STEP 1</p></div>
            <p>Biomatcher needs jquery to work!</p>
            <script type="syntaxhighlighter" class="brush: js"><![CDATA[
              <script type="text/javascript" src="<?php echo base_url(); ?>captcha/jquery.js">
            ]]>
            </script>
        </div>
        <div class="separator"></div>
        <div style="margin-bottom: 40px;"></div>
        
        <div>
            <div class="group"><p>STEP 2</p></div>
            <p>Include biomatcher script to your site! Download <a href="<?php echo base_url(); ?>captcha/biomatcher.js">here.</a></p><br />
            <p>If you are in <b>Development</b> mode, please consider to use <b>Development</b> version of biomatcher <a href="<?php echo base_url(); ?>captcha/biomatcher_for_development.js">here.</a></p>
            <script type="syntaxhighlighter" class="brush: js"><![CDATA[
              <script type="text/javascript" src="<?php echo base_url(); ?>captcha/biomatcher.js">
            ]]>
            </script>
        </div>
        <div class="separator"></div>
        <div style="margin-bottom: 40px;"></div>
        
        <div>
            <div class="group"><p>STEP 3</p></div>
            <p>Include this script into your html page where you placed your form.</p>
            <pre class="brush: js">
                <script type="text/javascript">
                    window.addEventListener( "message",
                    function (e) {
                        if(e.data == 'verified'){
                            //do something with your form ex. submit
                            document.forms["myForm"].submit();    
                        } 
                    },
                    false);
                    var yourURL = '<?php echo $url; ?>'; //this is used to send a message to your site.
                    var token = '<?php echo $token; ?>'; //this token will allow you to use biomatcher captcha.
                </script>
            </pre>
        </div>
        <div class="separator"></div>
        <div style="margin-bottom: 40px;"></div>
        
        <div>
            <div class="group"><p>STEP 4</p></div>
            <p>Add onclick function to your submit button</p>
            <pre class="brush: js">
                <button onclick="biomatcher(yourURL,token)">Verify</button>
            </pre>
        </div>
        <div class="separator"></div>
        <div style="margin-bottom: 40px;"></div>
        
        <div>
            <div class="group"><p>Example</p></div>
            <p>This would be your form code looks like.</p>
            <pre class="brush: js">
                <p>This is an example form to use biomatcher captcha. Do not forget to include jquery and biomatcher.js into your html header.</p>
            
                <form method="post" action="action.php" id="captcha_form" name="myForm">
                  <p>
                    <strong>Name*:</strong>&nbsp; &nbsp;<br />
                    <input type="text" name="name" size="35" value="" />
                  </p>
                
                  <p>
                    <strong>Email*:</strong>&nbsp; &nbsp;<br />
                    <input type="text" name="email" size="35" value="" />
                  </p>
                  
                  <p>
                    <input type="button" value="Verify" onclick="biomatcher(yourURL,token)" /> 
                  </p>
                
                </form>
                
                <script type="text/javascript">
                    window.addEventListener( "message",
                    function (e) {
                        if(e.data == 'verified'){
                            //do something with your form ex. submit
                            document.forms["myForm"].submit();    
                        } 
                    },
                    false);
                    var yourURL = '<?php echo $url; ?>'; //this is used to send a message to your site.
                    var token = '<?php echo $token; ?>'; //this token will allow you to use biomatcher captcha.
                </script>
            </pre>
        </div>
        
        
    
        <div class="separator"></div>
        <div style="margin-bottom: 40px;"></div>
    </div>
</div>