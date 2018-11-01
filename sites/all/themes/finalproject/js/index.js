(function($) {
  Drupal.behaviors.problemList = {
    attach: function(context, settings) {
      $("#medical-problem-list-button-id").click(function() {
        var value = $("#medical-problems-list-id").val();
        if (value == -1) {
            alert("Please select a problem");
          return false;
        }

        window.location.href =  '/node/' + value.toString();



      });
    }
  };
})(jQuery);
