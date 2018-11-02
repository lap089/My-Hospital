/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function($, Drupal, window, document) {
  "use strict";

  // To understand behaviors, see https://drupal.org/node/756722#behaviors
  Drupal.behaviors.my_custom_behavior = {
    attach: function(context, settings) {

      //$('#user-login-form input[value="Log in"]').addClass('btn-load');

      $('#user-login-form input[value="Log in"]').click(function() {
        console.log("Login Clicked!");
        this.value = "Logging in";
      });



      $("#form-submit-button-id").click(function() {
        console.log("Clicked!");

        $( this ).find( "button" ).addClass('spinning');
        $( this ).find( "button" ).html('Submitting');

        var formdata = [];
        $(".medical-item").each(function(i, element) {
          var title = $(element)
            .find(".medical-item-field-name")
            .text();
          var radioValue = $(element)
            .find("input[name='" + makeHtmlName(title) + "']:checked")
            .val();
          var symptomData = {
            title: title,
            value: radioValue
          };
          formdata.push(symptomData);
          //console.log("OnSubmit", $(title).text(), radioValue);
        });
      
        var currentNid = Drupal.settings.my_hospital.currentNid;
        console.log(currentNid);

        $.post(
          "../sites/all/themes/finalproject/php/saveSymptomsData.php",
          {
            nodeId : currentNid,
            symptoms : formdata,
            uid: Drupal.settings.my_hospital.user.uid
          },
          function(data, status) {
            window.location.href = '/node/2277';
          }
        );

      });
    }
  };




})(jQuery, Drupal, this, this.document);

function onAssignmentsNodeClick(assignmentNode) {
  console.log(
    assignmentNode.querySelectorAll("#assignments-node-link-id")[0].firstChild
  );
  assignmentNode
    .querySelectorAll("#assignments-node-link-id")[0]
    .firstChild.click();
}

function makeHtmlName(name) {
  String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

  return name.replaceAll(' ','-').toLowerCase();
}
