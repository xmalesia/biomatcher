<div class="wrapper">
<div id="content">
    <?php
    foreach($project_title as $p_title){
    ?>
    <h2 style="float: left;"><?php echo $p_title->name; ?></h2>  
    
    <div style="float: right;">
        <span>
            <a href="<?php echo base_url(); ?>index.php/pages/view/projects" style="float: right;">
                <img style="height: 36px; float:left" src="<?php echo base_url(); ?>style/img/arrow-left.png" />
                <p style="float: right; margin-top: 7px;">Back to project</p>
            </a>
        </span>
    </div>
    
    <div class="separator" style="float: left;"></div>
    <div class="clear"></div>
    
    <div class="project_table" id="files">
        <table style="width: 100%;text-align: center;" id="projectTable">
            <thead>
                <tr>
                    <td>
                        <p>Image A</p>
                    </td>
                    <td>
                        <p>Image B</p>
                    </td>
                    <td>
                        <p>Total</p>
                    </td>                    
                    <td>
                        <p>Same</p>
                    </td>
                    <td>
                        <p>(%) Same</p>
                    </td>                    
                    <td>
                        <p>Different</p>
                    </td>
                    <td>
                        <p>(%) Different</p>
                    </td>                    
                </tr>
            </thead>
            
            <tbody id="test">
            <?php
            foreach ($matches as $match){            
            ?>
                <tr>
                    <td>
                        <p><?php echo $match['filenameA']; ?></p>
                    </td>
                    <td>
                        <p><?php echo $match['filenameB']; ?></p>
                    </td>
                    <td>
                        <p><?php echo $totalMatches; ?></p>
                    </td>                    
                    <td>
                        <p><?php echo $match['same']; ?></p>                                                     
                    </td>
                    <td>
                        <p><?php echo $match['same_probability']; ?> %</p>                       
                    </td>                    
                    <td>
                        <p><?php echo $match['different']; ?></p>                       
                    </td>
                    <td>
                        <p><?php echo $match['different_probability']; ?> %</p>                       
                    </td>                    
                </tr>
            <?php
            }
            ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="<?php echo base_url(); ?>index.php/pages/download_stats/<?php echo $project_id; ?>/same" ><img title="Download Same Statistic CSV" style="height: 25px;" src="<?php echo base_url(); ?>style/img/download.png" /></a></td>
                    <td><a href="#"><img title="Download CSV" style="height: 25px;" src="<?php echo base_url(); ?>style/img/download.png" /></a></td>
                    <td><a href="<?php echo base_url(); ?>index.php/pages/download_stats/<?php echo $project_id; ?>/different" ><img title="Download CSV" style="height: 25px;" src="<?php echo base_url(); ?>style/img/download.png" /></a></td>
                    <td><a href="#"><img title="Download Different Statistic CSV" style="height: 25px;" src="<?php echo base_url(); ?>style/img/download.png" /></a></td>
                </tr>
            </tbody> 
        </table>
    </div>
    <br /><br />
    
    
    
</div>
<?php
    }
    ?>
</div>