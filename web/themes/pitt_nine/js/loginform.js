(function ($, Drupal) {
  
  $('#user-login-form').hide();
  $('#login_local').click(function(e) {
    $('#user-login-form').show();
    $(this).addClass('active');
}); 
})(jQuery, Drupal);