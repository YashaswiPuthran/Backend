(function($, Drupal) {
  // alert("yes");
  $(document).ready(function() {
      var $hasLast = $('#has_last');
    var $lastName = $(".js-form-item-last-name");

      if($hasLast.is(':checked')) {
        $lastName.hide();
      }

      $hasLast.on('change', function() {
        if($(this).is(':checked')) {
          $lastName.hide();
        }
        else
        {
          $lastName.show();
        }
      });
    });

} (jQuery, Drupal));

