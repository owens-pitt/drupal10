/**
 * @file
 * Global utilities.
 *
 */
(function ($, Drupal) {
  $(document).ready(function() { 
    $('.field--name-field-stat-number').html(function(i, h){
      return h.replace(/[0-9]+/, '<span class="stat_figure">$&</span>');
    });
  });
})(jQuery, Drupal);
