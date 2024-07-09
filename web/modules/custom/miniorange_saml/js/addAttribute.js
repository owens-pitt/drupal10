var countRoleAttributes = 0;
var countRole = 0;
var countAttrs = 0;
var multipleCheckArr = {};
var countProfileAttributes = 0;

document.addEventListener('DOMContentLoaded', function(){

    var existingVariable2 = jQuery('select[name^=user_sp_role_name]');
    countRoleAttributes = existingVariable2.length;
    countRole = countRoleAttributes;

    if (countRoleAttributes == 0)
        add_role();

    var profile_mapping = jQuery('select[name^=user_profile_field_name]');
    countProfileAttributes = profile_mapping.length;
    countProfile = countProfileAttributes;
    if(countProfileAttributes == 0){
      add_profile_attribute();
    }

    // take count of custom attribute map row already present
    countAttrs=document.getElementsByClassName('mo_idp_attr_map_row').length;
    // add one custom attribute map row if no. of custom attribute map row is 0.
    if ( countAttrs==0 ){
        add_custom_attr();
    }
    // declare onclick event for + button of custom attribute mapping
    document.getElementById('add_custom_attr').onclick =function(){
        add_custom_attr();
    }
  var strSep = document.getElementById('mo_attr_sep_string').innerHTML;
  var strArray = strSep.split("=&gt;");
  for (var i =0; i < (strArray.length-1); i++) {
    multipleCheckArr[strArray[i]] = strArray[++i];
  }

});

function showSeparator(rowid) {
  let fieldName = document.getElementById(rowid).value;
  let sepId     =  rowid.replace("edit-mo-idp-user-sp-attr-name-", "edit-mo-idp-user-idp-attr-separator-");
  let seperratorField = document.getElementById(sepId);
  seperratorField.disabled=multipleCheckArr[fieldName]=="false";
  if(document.getElementById(sepId).disabled){
    let classArr = seperratorField.className.split(" ");
    if (classArr.indexOf("form-disabled") == -1) {
      seperratorField.className += " " + "form-disabled";
      seperratorField.style.backgroundColor="hsla(0, 0%, 0%, 0.08)";
    }
  }
  else{
    seperratorField.className = seperratorField.className.replace(/\bform-disabled\b/g, "");
    seperratorField.style.backgroundColor="hsla(0, 0%, 0%, 0%)";
  }

}

// function to add 1 custom attribute mapping row
function add_custom_attr(){
  var strr = document.getElementById('mo_attr_string').innerHTML;
  var strArray = strr.split("=&gt;");
  var str = '';
  for (var i =0; i < (strArray.length-1); i++) {
    str += '<option value=' + strArray[i] + '>' + strArray[++i] + '</option>';
  }

  // the html string for 1 row of custom attribute mapping
    var sel='<div class="mo_idp_attr_map_row" id="mo_idp_attr_map_'+countAttrs+'"><div class="mo_idp_attr_map_sp_name"><div class="js-form-item form-item js-form-type-select form-type-select js-form-item-mo-idp-user-sp-attr-name-'+countAttrs+' form-item-mo-idp-user-sp-attr-name-'+countAttrs+' form-no-label"><select class="mo_idp_attr_map_sp_name_textfield form-select" data-drupal-selector="edit-mo-idp-user-sp-attr-name-'+countAttrs+'"  id="edit-mo-idp-user-sp-attr-name-'+countAttrs+'" name="mo_idp_user_sp_attr_name['+countAttrs+']" onchange="showSeparator(this.id)" >'+str+'</select></div></div><div class="mo_idp_attr_map_idp_name"><div class="js-form-item form-item js-form-type-textfield form-type-textfield js-form-item-mo-idp-user-idp-attr-name-'+countAttrs+' form-item-mo-idp-user-idp-attr-name-'+countAttrs+' form-no-label"><input placeholder="Idp Attribute name" class="mo_idp_attr_map_idpnames mo_saml_form_text" data-drupal-selector="edit-mo-idp-user-idp-attr-name-'+countAttrs+'" type="text" id="edit-mo-idp-user-idp-attr-name-'+countAttrs+'" name="mo_idp_user_idp_attr_name['+countAttrs+']" value="" size="60" maxlength="128" /></div></div><div class="mo_idp_attr_map_delete"><input class="button button--primary button--small" onclick="javascript:remove_custom_attr(this.id);" data-drupal-selector="edit-mo-idp-user-attr-delete-'+countAttrs+'" type="submit" id="edit-mo-idp-user-attr-delete-'+countAttrs+'" name="op" value="-" /></div>';

   var sep=
    '<div class="mo_idp_attr_map_sep_name"><div class="js-form-item form-item js-form-type-textfield form-type-textfield js-form-item-mo-idp-user-idp-attr-separator-'+countAttrs+ ' form-item-mo-idp-user-idp-attr-separator-'+countAttrs+' form-no-label">'+
    '<input placeholder="Separator" class="mo_idp_attr_map_sep form-text" data-drupal-selector="edit-mo-idp-user-idp-attr-separator-'+countAttrs+'" type="text" id="edit-mo-idp-user-idp-attr-separator-'+countAttrs+'" name="mo_idp_user_idp_attr_separator['+countAttrs+']" value="" size="60" maxlength="128"> </div></div>';
    sel=sel+sep;
    //take decision where to add, if 0 row is there  then insert after custom attribute header, otherwise insert after last row
    document.getElementsByClassName('mo_idp_attr_map_row').length!=0 ? jQuery(sel).insertAfter(jQuery(".mo_idp_attr_map_row:last")):jQuery(sel).insertAfter(jQuery("#before_attr_list_upa"));
    countAttrs += 1;
}
function remove_custom_attr(id){
    var res = id.replace("edit-mo-idp-user-attr-delete-", "mo_idp_attr_map_");
    jQuery('#'+res).remove();
}

document.getElementById('add_role').onclick = function(){
    add_role();
}

document.getElementById('add_profile_attribute').onclick = function(){
  add_profile_attribute();
};

function add_role(){
    var strr = document.getElementById('role_string').innerHTML;
    var strArray = strr.split("=&gt;");
    var str = '';
    for (var i =0; i < (strArray.length-1); i++) {
        str += '<option value=' + strArray[i] + '>' + strArray[++i] + '</option>';
    }

    var sel = '<div class="mo_saml_otp_row" id="otp_'+countRole+'"><div class="mo_saml_otp_sp_name"><div class="js-form-item form-item js-form-type-select form-type-select js-form-item-user-sp-role-name-' + countRole + ' form-item-user-sp-role-name-' + countRole + 'form-no-label"><select style="width:80%;" data-drupal-selector="edit-user-sp-role-name-' + countRole + '" id="edit-user-sp-role-name-' + countRole + '" name="user_sp_role_name[' + countRole + ']" class="mo_saml_form_select">' + str + '</select></div></div><div class="mo_saml_otp_idp_name"><div class="js-form-item form-item js-form-type-textfield form-type-textfield js-form-item-user-idp-role-name-' + countRole + ' form-item-user-idp-role-name-' + countRole + ' form-no-label"><input placeholder="semi-colon(;) separated" style="width:80%;" data-drupal-selector="edit-user-idp-role-name-' + countRole + '" type="text" id="edit-user-idp-role-name-' + countRole + '" name="user_idp_role_name[' + countRole + ']" value="" size="20" maxlength="128" class="mo_saml_form_text" /></div></div><div class="mo_saml_otp_delete"><input onclick="javascript:remove_role(this.id);" data-drupal-selector="edit-user-delete-' + countRole + '" type="submit" id="edit-user-delete-' + countRole + '" name="op" value="-" class="button button--primary button--small" /></div></div>';
    if(countRoleAttributes!=0){
         jQuery(sel).insertAfter(jQuery(".mo_saml_otp_row:last"));
         countRoleAttributes+=1;
     }
     else{
         jQuery(sel).insertAfter(jQuery("#before_role_list_upa"));
         countRoleAttributes+=1;
     }
     countRole+=1;
}

function remove_role(id){
    var res = id.replace("edit-user-delete-", "otp_");
    jQuery('#'+res).remove();
    countRoleAttributes-=1;
}

function remove_profile(id){
  var res = id.replace("edit-user-profile-delete-", "profile_");
  jQuery('#'+res).remove();
  countProfileAttributes-=1;
}

function add_profile_attribute(){
  var strr = document.getElementById('profile_string').innerHTML;
  var strArray = strr.split("=&gt;");
  var str = '';
  for (var i =0; i < (strArray.length-1); i++) {
    str += '<option value=' + strArray[i] + '>' + strArray[++i] + '</option>';
  }

  var sel = '<div class="mo_saml_profile_otp_row" id="profile_'+countProfile+'">' +
    '<div class="mo_saml_profile_sp_name">' +
    '<div class="js-form-item form-item js-form-type-select form-type-select js-form-item-user-sp-role-name-' + countProfile + ' form-item-user-sp-role-name-' + countProfile + 'form-no-label">' +
    '<select style="width:80%;" data-drupal-selector="edit-user-sp-role-name-' + countProfile + '" id="edit-user-sp-role-name-' + countProfile + '" name="user_profile_field_name[' + countProfile + ']" class="mo_saml_form_select">' + str + '</select>' +
    '</div>' +
    '</div>' +
    '<div class="mo_saml_profile_idp_name">' +
    '<div class="js-form-item form-item js-form-type-textfield form-type-textfield js-form-item-user-idp-role-name-' + countProfile + ' form-item-user-idp-role-name-' + countProfile + ' form-no-label">' +
    '<input style="width:80%;" data-drupal-selector="edit-user-idp-role-name-' + countProfile + '" type="text" id="edit-user-idp-role-name-' + countProfile + '" name="user_profile_idp_attribute_name[' + countProfile + ']" value="" size="20" maxlength="128" class="mo_saml_form_text" />' +
    '</div>' +
    '</div>' +
    '<div class="mo_saml_profile_delete"><input onclick="javascript:remove_profile(this.id);" data-drupal-selector="edit-user-profile-delete-' + countProfile + '" type="submit" id="edit-user-profile-delete-' + countProfile + '" name="op" value="-" class="button button--primary button--small" />' +
    '</div>' +
    '</div>';

  if(countProfileAttributes != 0){
    jQuery(sel).insertAfter(jQuery(".mo_saml_profile_otp_row:last"));
    countProfileAttributes += 1;
  }
  else{
    jQuery(sel).insertAfter(jQuery("#before_profile_list_upa"));
    countProfileAttributes += 1;
  }
  countProfile+=1;
}
