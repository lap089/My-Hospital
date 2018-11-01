(function($) {
  Drupal.behaviors.patientInfo = {
    attach: function(context, settings) {
      console.log("PatientInfo");

      function goToByScroll(id) {
        // Scroll
        $("html,body").animate(
          {
            scrollTop: $("#" + id).offset().top
          },
          "slow"
        );
      }

      $(".btn-prescribe").click(function() {
        var data = $.parseJSON($(this).attr("data-button"));
        window.problemId = data.problemId;
        window.patientId = data.patientId;

        document.getElementById("myForm").style.display = "block";
        document.getElementById("myForm").style.visibility = "visible";
        goToByScroll("product-selection-form-id");
      });

      $("#close-form-id").click(function() {
        console.log("Closed Clicked");
        document.getElementById("myForm").style.display = "none";
        document.getElementById("myForm").style.visibility = "hidden";
        //$("#product-selection-form-id").html("");
      });
    }
  };
})(jQuery);
