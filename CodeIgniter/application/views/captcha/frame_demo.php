<?php
    //echo form_open('captcha/si_test',array('id'=>'testajax'));
    //echo form_error('captcha');
?>
    <?php
    $user = $pair_match['username_pre'];
    $pid = $pair_match['projectID_pre'];
    
    $image_A = $pair_match['shuffled_image_pre_A']['md5sum'];
    $image_B = $pair_match['shuffled_image_pre_B']['md5sum'];
    
    $imageIDA = $pair_match['shuffled_image_pre_A']['id'];
    $imageIDB = $pair_match['shuffled_image_pre_B']['id'];
    ?>
    
    <div class="biomatcher">
            
        <div id="match" style="padding: 10px 25px;" >
        
        <h2 align="center">See images below, and choose Same or Different.</h2>
    
        <ul class="biomatcher-ul-image" style="float: left;">
            <li><img class="biomatcher-image" src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/400px/'.$image_A.'.400px.jpg' ?>" /></li>
        </ul>
        
        <ul class="biomatcher-ul-image" style="float: right;">
            <li><img class="biomatcher-image" src="<?php echo base_url().'data/'.$user.'/'.$pid.'/img/400px/'.$image_B.'.400px.jpg' ?>" /></li>
        </ul>
        
        <input id="imageIDA" type="hidden" name="imageA" value="<?php echo $imageIDA; ?>" />
        <input id="imageIDB" type="hidden" name="imageB" value="<?php echo $imageIDB; ?>" />
            
        <div class="clear"></div>
            
        <div style="text-align: center;">
            <input type="radio" name="match" value="yes" id="same" /><label for="same">Same</label>
            <input type="radio" name="match" value="no" id="different" /><label for="different">Different</label>
        </div>
        
        <div align="center">
            <p>
                <?php
                    echo img(array('src' => site_url('captcha/securimage'), 'alt' => 'captcha', 'id' => 'captcha', 'style' => 'border: 1px solid #000; margin-right: 15px;'));
                ?>
                
                <a tabindex="-1" style="position: absolute;border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('captcha').src = '<?php echo base_url();?>index.php/captcha/securimage?sid=' + Math.random(); this.blur(); return false"><img src="<?php echo base_url().'securimage_files/'; ?>images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="top" border="0" /></a>
                
                <a style="cursor: pointer;" onclick="this.firstElementChild.play()">
                    <audio src="<?php echo site_url().'/captcha/securimage_audio/'; ?>"></audio>
                    <img height="32" width="32" src="<?php echo base_url().'securimage_files/'; ?>images/audio_icon.png" />
                </a>
                <br />
                
                <?php
                echo form_input(array('name' => 'captcha', 'class' => 'biomatcher-inputtext-reg', 'type' => 'text', 'maxlength' => '8', 'size' => '12'));
                ?>
         
                <button class="biomatcher-box-button" id="sendMatch">Send Information</button>    
                           
            </p>
                                    
    
        </div>       
        </div>
        
    </div>
<?php
//echo form_close();	?>

    <script type="text/javascript">
        $(document).ready(function(){
            
            var url = '<?php echo base_url(); ?>'+'index.php/captcha/si_test';
            
            
        
        $('#sendMatch').bind( "click",function(e){
            var match = $('input:radio[name="match"]:checked').val();
            var captcha = $('input:text[name="captcha"]').val();
            var imageIDA = $("#imageIDA").val();
            var imageIDB = $("#imageIDB").val();
            
            var token = "<?php echo $_GET['token']; ?>";
            var yourURL = "<?php echo $_GET['yoururl']; ?>";
            var dataMatching = {'imageIDA' : imageIDA, 'imageIDB' : imageIDB, 'same' : match, 'token' : token,'site' : yourURL};
            
            if($('input:radio[name=match]').is(':checked')){
                $.ajax({
                    type: "POST",
                    url: url,
                    data: 'match='+match+'&captcha='+captcha,
                    success: function(status){
                        
                        if(status == 'ok'){
                            top.postMessage('verified', yourURL);
                        }else{
                            alert('The code you entered is invalid');
                            $("#captcha").attr('src', '<?php echo site_url('captcha/securimage');?>');
                        }
                        
                        }                  
                    });
                }
            else{
                alert('Choose same of different');
            }
            
            return false;
        });
        });
    </script>

