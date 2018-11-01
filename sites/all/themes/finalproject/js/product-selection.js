(function($) {
  Drupal.behaviors.productSelection = {
    attach: function(context, settings) {
      console.log("ProductSelection");

      if (typeof window.selectedProducts == "undefined") {
        window.selectedProducts = [];
        console.log("ProductSelection", "Undefined");
      }

      $(context)
        .find(".product-selection-row")
        .once("product-click", function() {
          // $(this) refers to the current instance of $(".some_element")
          $(this).click(function() {
            $model = $(".product-model", this).text();
            console.log($model);
            if ($.inArray($model, window.selectedProducts) != -1) {
              window.selectedProducts = jQuery.grep(
                window.selectedProducts,
                function(value) {
                  return value != $model;
                }
              );
              $(this).css("color", "black");
            } else {
              window.selectedProducts.push($model);
              $(this).css("color", "red");
            }

            console.log(window.selectedProducts);
          });
        });

      $("#btn-reset-id").click(function() {
        window.selectedProducts = []; 
        resetProduct();
      });

      $(context)
        .find("#btn-product-selection-id")
        .once("products-submit", function() {
          $(this).click(function() {

            this.classList.add('spinning');
            this.innerHTML = "Processing";

            postData = {
              doctorId: Drupal.settings.my_hospital.user.uid,
              patientId: window.patientId,
              problemId: window.problemId,
              selectedData: window.selectedProducts
            };
            $.post(
              "../sites/all/themes/finalproject/php/saveUserMedicalItem.php",
              {
                postData: postData
              },
              function(data, status) {
                console.log(status, data);
                if(data == '200') {
                  //resetProduct();
                  //$( "#close-form-id" ).trigger( "click");
                  location.reload();
                }
              }
            );
            window.selectedProducts = [];
          });
        });

        function resetProduct() {
          $(".product-selection-row").each(function( index ) {
            console.log( index + ": " + $( this ).text() );
            $model = $(".product-model", this).text();
            if ($.inArray($model, window.selectedProducts) != -1) {
              $(this).css("color", "red");
            } else {
              $(this).css("color", "black");
            }
  
          });
        }

        resetProduct();
        
    }
  };
})(jQuery);
