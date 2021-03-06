$(document).ready(function() {
    
    /*$('#del-image-matched').dataTable({
        "bLengthChange": false,
        "bFilter": false,
        "pageLength": 2,
        "pagingType": "simple"        
    });*/
    
    $("div#toppanel-disable").hide();
    
    function show_panel(id_panel){
        $("div#"+id_panel).fadeIn("normal");
        $("div#toppanel-disable").show();
        $("div.progressbox").hide();
        $("div.errorbox").empty();
        $("div#panel").animate({
			height: "0px"
		}, "fast");
    }
    
    function hide_panel(id_panel){
        $("div#"+id_panel).fadeOut("normal"); 
        $("div#toppanel-disable").hide();       
    }
    
    function addProject(){
        $("div#addProject_panel").fadeIn("normal");
        $("div#toppanel-disable").show();
        $("div#progressbox").hide();
        $("div.errorbox").empty();
        $("div#panel").animate({
			height: "0px"
		}, "fast");
    }
    
    function cancelProject(){
        $("div#addProject_panel").fadeOut("normal"); 
        $("div#toppanel-disable").hide();       
    }
    
    function project_cancel_del(){
        $("div#del_project_panel").fadeOut("normal"); 
        $("div#toppanel-disable").hide();       
    }
    
    function is_del_matched(){
        $("div#matched_image").fadeIn("normal");
        $("div#toppanel-disable").show();
        $("div.progressbox").hide();
        $("div.errorbox").empty();
        $("div#panel").animate({
			height: "0px"
		}, "fast");
    }

    function cancelRename(){
        $("div#renameProject_panel").fadeOut("normal"); 
        $("div#toppanel-disable").hide();       
    }

    function cancelDelWebsite(){
        $("div#del_website_panel").fadeOut("normal"); 
        $("div#toppanel-disable").hide();       
    }
    
    function cancelAllLabel(){
        $("#draggable").fadeOut("normal");
    }
    
    function editAll(){
        $("#draggable").fadeIn("normal");
        $('html,body').animate({scrollTop:$("#content").offset().top},500);
        
        //$( "#draggable" ).draggable({containment: "#content-frame;",scroll: false});
    }
    
    function del_img(){
        var arr_img = $.map($("input[name='id_image']:checked"), function(e,i) {
            return +e.value;
        });
        
        var pID=$("#pid").val();
        var project_link=$("#project_link").val();
        var pagination=$("#paging").val();
        var data_img = { 'id_image' : arr_img, 'pid' : pID, 'pagination' : pagination};
        $.ajax({
            type: "POST",
            url: CI_ROOT+"index.php/project/deleteImage",
            dataType: "json",
            data: data_img,
            cache:false,
            success: function(data){
                if(data.status != 'error')
        		{
                    if(pagination==0){
                        pagination = "";
                    }
                    var url = CI_ROOT+"index.php/"+project_link+"/view/project/"+pID+"/"+pagination;
                    
                    if(data.matched == true){
                        $("#message_matched").html(data.message);
                        is_del_matched();
                        
                        var images = data.data;
                        
                        $("#hidden-input").html('');
                        
                        $("#hidden-input").append(
                            '<input type="hidden" name="project_id" value="' + data.projectID + '" />' +
                            '<input type="hidden" name="url_direct" value="' + url + '" />'
                        );
                        
                        $("#list-matched").html('');
                        images.forEach(function(entry) {
                            $("#list-matched").append(
                                '<tr>' +
                                '<td>' + entry.nameOri + '</td>' +
                                '<td><img src="' + entry.thumbnail + '" />' +
                                '</tr>'
                            );
                               
                            $("#hidden-input").append(
                                '<input type="hidden" name="ids[]" value=' + entry.id + ' /></td>'
                            );
                        });
                        
                        $('#del-image-matched').dataTable().fnDestroy();
                        $('#del-image-matched').dataTable({
                            "bLengthChange": false,
                            "bFilter": false,
                            "pageLength": 2,
                            "pagingType": "simple"        
                        });
                    }else{
                        redirect(url);
                    }
                    
                }
            }
        });
        
    }
    
    function cancel_del(){
        var url_direct = $("form#form_delImgCascade input[name=url_direct]").val();
        redirect(url_direct);
    }
    
    function del_img_cascade(){
        var pID = $("form#form_delImgCascade input[name=project_id]").val();
        var ids = $("form#form_delImgCascade input[name='ids[]']").map(function(){return $(this).val();}).get();
        var url_direct = $("form#form_delImgCascade input[name=url_direct]").val(); 
        //console.log(ids);
        
        var data_img = { 'id_image' : ids, 'pid' : pID };
        $.ajax({
            type: "POST",
            url: CI_ROOT+"index.php/project/delImgCascade",
            dataType: "json",
            data: data_img,
            cache:false,
            success: function(data){
                redirect(url_direct);
            }
        });
    }
    
    function insert_match(same){
        var imageIDA = $("#imageIDA").val();
        var imageIDB = $("#imageIDB").val();
        var data = {'imageIDA' : imageIDA, 'imageIDB' : imageIDB, 'same' : same};
        
        $.ajax({
            type: "POST",
            url: CI_ROOT+"index.php/pages/insert_match",
            dataType: "json",
            data: data,
            cache:false,
            success: function(status){
                if(status != 'error')
        		{
                    redirect('');
                }
            }
        });
    }
    
    $('.project_delete').click(function(){
        var project_id = $(this).attr('title');
        
        var data = {'pid' : project_id};
        
        $.ajax({
            type: "POST",
            url: CI_ROOT+"index.php/project/delete_project",
            dataType: "json",
            data: data,
            cache:false,
            success: function(data){
                if(data.status == 'success')
        		{
                    redirect('');
                }
                else
                {
                    if(data.status == 'not empty' || data.status == 'matched')
                    {
                        $('#alert_delete').html(data.message);
                        $('#hidden-input').html('<input type="hidden" name="project_id" value="' + data.data.project_id + '" />');
                    }
                    
                    show_panel('del_project_panel');
                }
            }
        });
        
    });
    
    function redirect(url)
    {
        window.location.href = url;
    }
    
    $('#delete').click(function() {
        del_img();
    });
    
    $('#img_keep').click(function(){
        cancel_del();
    });
    
    $('#img_del').click(function(){
        del_img_cascade();
    });
    
    $('#sameMatch').click(function(){
        $('#sameMatch').attr("disabled", true);
        $('#differentMatch').attr("disabled", true);
        var same = 'yes';
        insert_match(same);
    });
    
    $('#differentMatch').click(function(){
        $('#sameMatch').attr("disabled", true);        
        $('#differentMatch').attr("disabled", true);
        var same = 'no';
        insert_match(same);
    });
    
    $('a#close, #mask').bind('click', function() { 
        $('#mask , .popup').fadeOut(300 , function() {
            $('#mask').remove();  
        });
        
        $('#toppanel-disable').fadeOut(300 , function() {
            $('#toppanel-disable').remove();  
        });
        return false;
	});
    
    $("#addProject, #upl_img, #site_reg").bind("click",addProject);
    $("#button_cancelProject, #button_cancelUpload").bind("click",cancelProject);
    $("#button_cancelRename").bind("click",cancelRename);
    $("#button_cancelDelWebsite").bind("click",cancelDelWebsite);
    $("#project_cancel_del").bind("click", project_cancel_del);
    
    /*editLabel function*/	
    $("#editAll").bind("click",editAll);
    $("#cancelLabel").bind("click",cancelAllLabel); 
});

$("#buttonLabel").click(function() {
    
    var form_data = {
        csv: $("textarea#labelProject").val(),
        user_id: $("input[name='user_id']").val(),
        project_address: $("input#project_address").val(),
        project_name: $("input#project_name").val()
    };
    
    $.ajax({
    type: "POST",
    url: CI_ROOT+"index.php/pages/do_editAllLabel",
    data: form_data,
    success: function(data){
        //alert(data); 
        $("#draggable").fadeOut("normal");
        //$("#label").html(data);
        location.reload();
        }                  
    });
    return false;
});

$(function() {
    $(".renameProject").click(function() {
        //trigger panel box
        $("div#renameProject_panel").fadeIn("normal");
        $("div#toppanel-disable").show();
        $("div#progressbox").hide();
        $("div.errorbox").empty();
        $("div#panel").animate({
            height: "0px"
        }, "fast");

        var getName = $(this).data("name");
        var getID = $(this).data("id");
        $("#input_renameProject").val(getName);
        $("#input_idProject").val(getID);
        $("#input_oldName").val(getName);

    });
});

$(function() {
    $(".website_delete").click(function() {
        //trigger panel box
        $("div#del_website_panel").fadeIn("normal");
        $("div#toppanel-disable").show();
        $("div#progressbox").hide();
        $("div.errorbox").empty();
        $("div#panel").animate({
            height: "0px"
        }, "fast");

        var getID = $(this).data("id");
        $("#hidden-input").append(
            '<input type="hidden" name="id" value="' + getID + '" />'
        );

    });
});
    
$(function(){
   $("#editLabel").click(function(){
    
    var id_label = $("input[name='id_label']:checked").val();
    var dataString = 'id_label='+ id_label;
    
    $.ajax({
    type: "POST",
    url: CI_ROOT+"index.php/pages/find_IDLabel",
    data: dataString,
    success: function(data){
        //alert(data);
        $('html,body').animate({scrollTop:$("#slide_label"+id_label).offset().top},500);
        $("#label"+id_label).replaceWith('<form id="formLabel'+id_label+'" method="POST" style="min-width:246px"><input id="hide_cancelLabel'+id_label+'" type="text" name="new_label" value="'+data+'" /><input type="hidden" id="label_id'+id_label+'" name="id_label2" value="'+id_label+'"/><a class="button_edit_label" id="cancelLabel'+id_label+'">Cancel</a><a class="button_edit_label" id="editOneLabel'+id_label+'">Submit</a></form>');
        $("#for_close_label"+id_label).css("background","#e6e6e6");       
        
        $("#cancelLabel"+id_label).click(function(){
          $("#for_close_label"+id_label).children().remove();  
          $("#for_close_label"+id_label).html('<p id="label'+id_label+'">'+data+'</p>');
          $("input[name='id_label']").removeAttr("checked");
          $("#for_close_label"+id_label).css("background","none");
        });
        
        $("#editOneLabel"+id_label).click(function(){
            var form_data2 = {
                id_label2: $("#label_id"+id_label).val(),
                new_label: $("#hide_cancelLabel"+id_label).val()
            };
            
            $.ajax({
            type: "POST",
            url: CI_ROOT+"index.php/pages/do_editLabel",
            data: form_data2,
            success: function(data){
                //alert(data);
                $("#for_close_label"+id_label).children().remove();  
                $("#for_close_label"+id_label).html('<p id="label'+id_label+'">'+data+'</p>');
                $("input[name='id_label']").removeAttr("checked");
                $("#for_close_label"+id_label).css("background","none");
            }
            }); 
        });
        
        }
    });
    return false;
   }); 
});

function regenerate_token(site_id){
    
    var site_data = {'site_id' : site_id}
    
    $.ajax({
        type: "GET",
        url: CI_ROOT+"index.php/pages/get_token",
        data: site_data,
        cache: false,
        success: function(data){
            $('#myToken').html('');
            $('#myToken').append(data);
            location.reload();
        }
    });
}
