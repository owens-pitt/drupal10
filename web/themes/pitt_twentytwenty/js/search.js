(function ($, Drupal) {
  $(document).ready(function() { 

/*

	$(window).on('load resize',function(){
      w = $( window ).width();
      if (w > 767) {
      
*/
  
  
  
  $( "#searchicon-close" ).hide();
    $( "#searchicon" ).click(function() {
      $( "#search-block-form" ).slideToggle( "fast", function() {
        $( "#searchicon" ).hide();
        $( "#searchicon-close" ).show();
      });
    });
    $( "#search-block-form" ).hide();
    
    $( "#searchicon-close" ).click(function() {
      $( "#search-block-form" ).slideToggle( "fast", function() {
        $( "#searchicon-close" ).hide();
        $( "#searchicon" ).show();
      });
    });
  
  
/*
  }
    });
*/

  
  });
  
})(jQuery, Drupal);
