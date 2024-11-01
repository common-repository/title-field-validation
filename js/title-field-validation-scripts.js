
//--Find validation settings
jQuery(document).ready(function($){

  if( typeof jQuery("#post_type").val() === "undefined"){
  }
  else{
    jQuery.ajax({
            type: "POST",
            data: { 
            action     : 'find_post_type',
            post_type  : jQuery("#post_type").val(),
            tfv_nonce  : jQuery("#tfv_nonce").val()
    },
    url: ajaxurl,
          success: function (data) {
            if(data !== ''){
              result=JSON.parse(data);
              jQuery("#new-post-type").val(result.post_type_label);
              jQuery("#new-title-label").val(result.title_label);
              jQuery("#new-title-error").val(result.title_error_msg);
              jQuery("#new-content-label").val(result.content_label);
              jQuery("#new-content-error").val(result.content_error_msg);          
              if(jQuery("#new-title-label").val() !== ""){
                jQuery("#label-title").html(jQuery("#new-title-label").val()+'<span class="tfv-star">*</span>');
              }
              if(jQuery("#new-content-label").val() !== ""){
                jQuery("#label-content").html(jQuery("#new-content-label").val()+'<span class="tfv-star">*</span>');
              }
            }
          }
    });

  }

  //-- Hide error messages
  jQuery('#success-message-save').hide();
  jQuery('#error-message-save').hide();
  jQuery('#success-message-edit').hide();
  jQuery('#error-message-edit').hide();

  //--Title validation
  $('#title').on('blur' , function() {

    if(jQuery("#new-post-type").val() == jQuery("#post_type").val()){
      //--Title validation
      if(jQuery("#new-title-error").val() !== ""){
          if(jQuery("#title").val() == ''){
            jQuery("#title-error").html(jQuery("#new-title-error").val());
            jQuery("#title").css("border","1px solid red");
          }
          else{
            jQuery("#post_title-error").html('');
            jQuery("#title").css("border","1px solid #ddd");
          }
      }
    }

  });

  //--Content validation
  $('#content').on('blur' , function() {

    if(jQuery("#new-post-type").val() == jQuery("#post_type").val()){
     if(jQuery("#new-content-error").val() !== ""){
        //--Content validation
        if(jQuery("#content").val() == ''){
           jQuery("#content-error").html(jQuery("#new-content-error").val());
           jQuery("#content").css("border","1px solid red");
        }
        else{
           jQuery("#content-error").html('');
           jQuery("#content").css("border","1px solid #ddd");
        }
      }
    }

  });

  //--Hide tfv Validation Edit Div
  jQuery("#tfv-validation-edit-div").hide();

  //--Hide tfv Validation Add Div
  jQuery("#tfv-validation-add-div").show();

  //--Form validation
  jQuery("#post").validate({

    ignore: [],
    //--Validation rules
    rules: {
        post_title: {required: function(element){
                      return jQuery("#new-post-type").val() == jQuery("#post_type").val() && jQuery("#new-title-error").val() !== ""}
                    },
        content   : {required: function(element){
                      return jQuery("#new-post-type").val() == jQuery("#post_type").val() && jQuery("#new-content-error").val() !== ""}
                    }
            },    
    //--Validation error messages
    messages: {
        post_title: {required:function(element){
                            return jQuery("#new-title-error").val()}
                    },
        content   : {required:function(element){
                            return jQuery("#new-content-error").val()}
                    }
        },

  }); 

});

//--Save validation settings
function save_validation(){

 jQuery.ajax({
          type: "POST",
          data: { 
          action            : 'save_validation',
          tfv_post_type     : jQuery("#tfv-post-type").val(),
          tfv_title_label   : jQuery("#tfv-title-label").val(),
          tfv_title_error   : jQuery("#tfv-title-error").val(),
          tfv_content_label : jQuery("#tfv-content-label").val(),
          tfv_content_error : jQuery("#tfv-content-error").val(),
          tfv_nonce         : jQuery("#tfv_nonce").val()
      },
      url: ajaxurl,
      success: function (data) {
        if(data == "error1"){
          jQuery("#success-message-save").hide();
          jQuery("#error-message-save").show();
          jQuery("#error-message-save-p").html("Please select post type !");
        }
        else if(data == "error2"){
          jQuery("#success-message-save").hide();
          jQuery("#error-message-save").show();
          jQuery("#error-message-save-p").html("Please fill all required fields !");
        }
        else if(data == "error3"){
          jQuery("#success-message-save").hide();
          jQuery("#error-message-save").show();
          jQuery("#error-message-save-p").html("Already Exist");
        }
        else if(data == "success"){
          jQuery("#error-message-save").hide();
          jQuery("#success-message-save").show();
          jQuery("#success-message-save-p").html("Saved successfully");
          location.reload();
        }
      }
    });  

  }

  //--Edit validation settings
  function edit_validation(idd){

  //--Hide tfv_validation Add Div
  jQuery("#tfv-validation-add-div").hide();

  //--Show tfv_validation Edit Div
  jQuery("#tfv-validation-edit-div").show();

  jQuery.ajax({
          type: "POST",
          data: { 
          action     : 'edit_validation',
          id         :  idd,
          tfv_nonce  : jQuery("#tfv_nonce").val()
  },
  url: ajaxurl,
        success: function (data) {
          result=JSON.parse(data);
          jQuery("#tfv-validation-id").val(result.validation_id);
          jQuery("#tfv-post-type-e").val(result.post_type);
          jQuery("#tfv-title-label-e").val(result.title_label);
          jQuery("#tfv-title-error-e").val(result.title_error_msg);
          jQuery("#tfv-content-label-e").val(result.content_label);
          jQuery("#tfv-content-error-e").val(result.content_error_msg);
        }
    }); 

  }

  //--Update Validation
  function update_validation(){

    jQuery.ajax({
            type: "POST",
            data: { 
            action             : 'update_validation',
            tfv_validation_id  : jQuery("#tfv-validation-id").val(),
            tfv_post_type_e    : jQuery("#tfv-post-type-e").val(),
            tfv_title_label_e  : jQuery("#tfv-title-label-e").val(),
            tfv_title_error_e  : jQuery("#tfv-title-error-e").val(),
            tfv_content_label_e: jQuery("#tfv-content-label-e").val(),
            tfv_content_error_e: jQuery("#tfv-content-error-e").val(),
            tfv_nonce          : jQuery("#tfv_nonce").val()
    },
    url: ajaxurl,
          success: function (data) {
            if(data == "error"){
              jQuery("#success-message-edit").hide();
              jQuery("#error-message-edit").show();
              jQuery("#error-message-edit-p").html("Please fill error message for title / content field !");
            }
            if(data == "success"){
              jQuery("#error-message-edit").hide();
              jQuery("#success-message-edit").show();
              jQuery("#success-message-edit-p").html("Updated successfully.");
              location.reload();
            }
          }
      });  

  }

//--Cancel Validation update
function cancel_validation(){

  //--Hide tfv Validation Edit Div
  jQuery("#tfv-validation-edit-div").hide();
  //--Hide tfv Validation Add Div
  jQuery("#tfv-validation-add-div").show();

}

//--Delete validation settings
function delete_validation(idd){

  if(confirm("Do you want to delete this validation?")==true)
    {
       jQuery.ajax({
              type: "POST",
              data: { 
              action     : 'delete_validation',
              id         :  idd,
              tfv_nonce  : jQuery("#tfv_nonce").val()
      },
      url: ajaxurl,
            success: function (data) {
              if(data == "success"){
                jQuery("#error-message-save").hide();
                jQuery("#success-message-save").show();
                jQuery("#success-message-save-p").html("Deleted successfully.");
                location.reload();
              }
            }
       }); 
    }  

}