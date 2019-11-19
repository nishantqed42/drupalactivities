(function ($, Drupal) {
  Drupal.behaviors.activitiesBehavior = {
    attach: function (context, settings) {
      $(".card").flip({
        axis: 'x',
        trigger: 'hover'
      });
    }
  };
})(jQuery, Drupal);