<div class="wrapper">
<div id="content">
    <?php
    foreach($project_title as $p_title){
    ?>
    <h2 style="float: left;"><?php echo $p_title->name; ?></h2>
    <?php
    }
    ?>
    <div style="float: right;">
        <span>
            <a href="<?php echo base_url(); ?>index.php/pages/view/projects" style="float: right;">
                <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                <p style="float: right; margin-top: 7px;">Back to project</p>
            </a>
        </span>
    </div>
    
    <div class="separator" style="float: left;"></div>

    <div class="project_table" id="files">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <td>
                        <p>FILENAME</p>
                    </td>
                    <td>
                        <p>LABEL</p>
                    </td>
                    <td>
                        <p>THUMBNAIL</p>
                    </td>
                    <td style="width: 42px; text-align: center;">
                        <p>EDIT</p>
                    </td>
                    <td style="width: 60px; text-align: center;">
                        <p>DELETE</p>
                    </td>
                </tr>
            </thead>
            
            <?php //echo form_open('pages/do_getIdLabel');?>
            <tbody id="test">
            <?php
            foreach ($list_images as $images){
            ?>
                
                <tr>
                    <td>
                        <p><?php echo $images->nameOri; ?></p>
                    </td>
                    <td><?php echo $images->label; ?></td>
                    <td>
                        <p><img style="width: 100px; height: 100px;" src="<?php echo '../../../../../data/'.$this->session->userdata('username').'/'.$this->uri->segment(4, 0).'/img/'.$images->md5sum; ?>" /></p>
                    </td>
                    <td style="text-align: center;">
                                                                
                        <input type="radio" name="id_label" value="<?php echo $images->id; ?>"/>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" />
                    </td>
                </tr>
                
            <?php
            }
            ?>
            </tbody>

            <tfoot>
                <tr style="height: 50px;">
                    <td>
                        <button class="box-button" id="upl_img">Upload Image</button>
                    </td>
                    <td>
                        <button class="box-button" id="editAll">Edit All</button>  
                    </td>
                    <td>
                        
                    </td>
                    <td>
                        <button class="box-button" id="editLabel">Edit</button>
                        
                    </td>
                    <td>
                        <button class="box-button" id="delete">Delete</button>
                    </td>
                </tr>
            </tfoot> 
       <?php //echo form_close()?>   
        </table>
    </div>
   <br /><br />
    
   <div id="draggable">           
    <?php echo form_open('pages/do_editAllLabel');?>
        <textarea style="margin-bottom: 5px;" id="labelProject" name="csv" rows="5" cols="35"><?php foreach ($get_csv as $csv){ 
                echo $csv->nameOri.",".$csv->label.','.'&#10'; 
                
                }?>
        </textarea> 
        <input class="inputtext-upload" type="hidden" name="project_address" value="<?php echo $this->uri->segment(4, 0); ?>"/>
        <input style="float: right;" id="buttonLabel" type="submit" name="submit" class="box-button" value="Submit" />
        <a style="float: right;" class="box-button" id="cancelLabel" style="margin-right: 5px;">Cancel</a>
        <div class="clear"></div>
    <?php echo form_close();?>                                   
   </div>
     
   
  <div id="addProject_panel">
        <?php echo form_open_multipart('pages/upload_file/?pid='.$this->uri->segment(4, 0).'&unid='.uniqid(),array('id'=>'upload_file')); ?>
            
            <div class="inputbox_Upload">
                <label class="labelinput-upload" for="zipped_file">Zipped File</label>
                <input class="inputtext-upload" id="zipped_file" type="file" name="zipped_file"/><br />
                <input class="inputtext-upload" id="project_id" type="hidden" name="project_id" value="<?php echo $this->uri->segment(4, 0); ?>"/>
                <input type="hidden" id="unid" value="<?php echo uniqid(); ?>"/>
            </div>
            <div class="errorbox" style="padding: 0 !important; width:450px;"></div>
            <div id="progressbar"></div>
            <div id="statustxt">0%</div >          
            <div class="inputbox_Upload">
                <input id="button_Upload" type="submit" name="submit" class="box-button" value="Upload" />
                <a class="box-button" id="button_cancelUpload" style="margin-right: 5px;">Cancel</a>
            </div>
        <?php echo form_close(); ?>
    </div>
   
    <div class="separator"></div>
</div>

</div>