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
    $('.field--name-body iframe:not([class])').wrap('<div class="ratio ratio-16x9"></div>');
//     $('.field--name-body iframe').addClass('embed-responsive-item');
    $('.field--name-body iframe.4x3').wrap('<div class="ratio ratio-4x3"></div>');
    
    $('.paragraph--type--body-text iframe:not([class])').wrap('<div class="ratio ratio-16x9"></div>');
    

// Active nav in the sidebar
/*
if (!$('.region-sidebar-first a.nav-item').hasClass('is-active')) {
  $('#block-pitt-nine-mainnavigation-menu').addClass('active-title');
}
*/
  
// Landing pages breakout
$('a.section_image_link').hover(function() {
    $(this).parent().parent().find('a .field--name-field-section-title').addClass('hover');
}, function() {
    $(this).parent().parent().find('a .field--name-field-section-title').removeClass('hover');
});
$('a .field--name-field-section-title').hover(function() {
    $(this).parent().parent().parent().find('a.section_image_link').addClass('hover');
}, function() {
    $(this).parent().parent().parent().find('a.section_image_link').removeClass('hover');
});

    
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

	var tickcount = $(".card-carousel-nav li").length;
	if (tickcount == 1) {
		$(".card-carousel-nav").addClass("hidden");
	}

  //Add colorbox to youtube links.
  if ( $.isFunction($.fn.colorbox) ) {
    $('.paragraph--type--grid-style-a .field--type-link a[href*="youtube"]').colorbox();
    $(".colorbox-iframe").colorbox({iframe:true, width:"80%", height:"80%"});
  }
  });

/*
  $(".field--name-field-grid-a-item").addClass(function() {
    return "grid-a-item-" + $(this).children(".field__item").length;
  });
*/
  
  $('.paragraph--type--grid-style-a').addClass(function() {
    return 'paragraph--type--grid-style-a' + $(this).find('.grid_group > .field > .field__item').length;
  });
  $('.paragraph--type--icon-set').addClass(function() {
    return 'paragraph--type--icon-set-' + $(this).find('.field--name-field-icon-item > .field__item').length;
  });
  $('.paragraph--type--stat-set').addClass(function() {
    return 'paragraph--type--stat-set-' + $(this).find('.field--name-field-stat-item > .field__item').length;
  });
  
})(jQuery, Drupal);
