/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {
  $(document).ready(function() { 
  
    //special formatting 
    $('.field--name-field-stat-number').html(function(i, h){
      return h.replace(/(st)|(nd)|(rd)|(th)/, '<span class="stat_text">$&</span>');
    });
    
    // Add boostrap styles to iframes
    $('.field--name-body iframe:not([class])').wrap('<div class="embed-responsive embed-responsive-16by9"></div>');
    $('.field--name-body iframe').addClass('embed-responsive-item');
    $('.field--name-body iframe.4x3').wrap('<div class="embed-responsive embed-responsive-4by3"></div>');
  //     $('.field--name-body iframe.4x3').addClass('embed-responsive-item');
/*
    $('.field--name-body iframe').wrap('<div class="embed-responsive embed-responsive-16x9"></div>');
    $('.field--name-body iframe').addClass('embed-responsive-item');
*/
        // Except sometimes
/*
    $('#block-system-main .field-body iframe.nonresponsive').unwrap('<div class="embed-responsive embed-responsive-16by9"></div>');
    $('#block-system-main .field-body iframe.nonresponsive').removeClass('embed-responsive-item');
    $('#block-system-main .field-body .nonresponsive iframe').unwrap('<div class="embed-responsive embed-responsive-16by9"></div>');
    $('#block-system-main .field-body .nonresponsive iframe').removeClass('embed-responsive-item');
*/
    

    
    // Feature Image 
    $('flex-control-paging').wrap('<div class="paging_wrapper"></div>');
/*
  //adds style when BG image present on layout sections
  if  ($(".layout").attr("style")) {
    $(this).addClass("layout-bg-image");
  }
  
*/
  //adds classes to layout builder if options present
  $(".layout-builder-configure-section .js-form-wrapper").addClass("active-options");
  $(".layout-builder-configure-section .js-form-wrapper").has("fieldset").addClass("active");
  $('.views-row').has('.field-section-image').addClass('has-image');
  
  //accessible landing page
  $(".section_image_link").attr("aria-hidden","true");
  
  if($('#landing_image').length > 0 ) {
    $("body").addClass("landing_section");
  }
    
  });
})(jQuery, Drupal);
