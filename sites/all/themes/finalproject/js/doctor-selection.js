(function($) {
  Drupal.behaviors.doctorSelection = {
    attach: function(context, settings) {
      function goToByScroll(id) {
        // Scroll
        $("html,body").animate(
          {
            scrollTop: $("#" + id).offset().top
          },
          "slow"
        );
      }
      var doctorId = "";

      $(".doctor-selection-list").click(function() {
        doctorId = $(this).data("uid");
        $.get(
          "../sites/all/themes/finalproject/php/doctorSelection.php/?uid=" +
            doctorId,
          function(data, status) {
            $("#doctor-selection-form-id").html(data);
            document.getElementById("doctor-detail-footer").style.visibility =
              "visible";
            goToByScroll("doctor-selection-form-id");
          }
        );

        document.getElementById("myForm").style.display = "block";
        document.getElementById("myForm").style.visibility = "visible";
      });

      $("#btn-appointment-id").click(function() {
        appointmentData = {
          patientId: Drupal.settings.my_hospital.user.uid,
          doctorId: doctorId,
          message: $("#appointment-message-id").val()
        };
        $.post(
          "../sites/all/themes/finalproject/php/doctorSelection.php",
          {
            appointmentData: appointmentData
          },
          function(data, status) {
            console.log(status, data);
            window.location = "/";
          }
        );
      });

      $("#close-form-id").click(function() {
        console.log("Closed Clicked");
        document.getElementById("myForm").style.display = "none";
        document.getElementById("myForm").style.visibility = "hidden";
        document.getElementById("doctor-detail-footer").style.visibility =
          "hidden";
        $("#doctor-selection-form-id").html("");
      });
    }
  };
})(jQuery);
