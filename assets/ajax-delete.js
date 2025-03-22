/**
 * Ajax Delete Functionality
 *
 * Provides a Bootstrap modal confirmation dialog for delete operations
 * and handles the AJAX request with proper CSRF token handling.
 */

(function ($) {
  "use strict";

  // Helper function to find the active PJAX container
  var findPjaxContainer = function (element) {
    // Start with the element and traverse up to find a parent with data-pjax-container
    var $container = $(element).closest("[data-pjax-container]");

    // If found by data attribute, return its ID
    if ($container.length) {
      return "#" + $container.attr("id");
    }

    // If not found, look for any elements with 'pjax-' prefix in their ID
    var $pjaxContainers = $('[id^="pjax-"]');
    if ($pjaxContainers.length) {
      return "#" + $pjaxContainers.first().attr("id");
    }

    // If still not found, return null (will fall back to page reload)
    return null;
  };

  // Create the confirmation modal
  var createConfirmModal = function () {
    // Check if modal already exists
    if ($("#ajax-delete-confirm-modal").length) {
      return;
    }

    // Create modal HTML
    var modalHtml =
      '<div class="modal fade" id="ajax-delete-confirm-modal" tabindex="-1" role="dialog">' +
      '  <div class="modal-dialog" role="document">' +
      '    <div class="modal-content">' +
      '      <div class="modal-header">' +
      '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
      '        <h4 class="modal-title">Confirm Delete</h4>' +
      "      </div>" +
      '      <div class="modal-body">' +
      '        <p>Are you sure you want to delete <span id="delete-item-name"></span>?</p>' +
      "      </div>" +
      '      <div class="modal-footer">' +
      '        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>' +
      '        <button type="button" class="btn btn-danger" id="confirm-delete-btn">Delete</button>' +
      "      </div>" +
      "    </div>" +
      "  </div>" +
      "</div>";

    $("body").append(modalHtml);

    var $modal = $("#ajax-delete-confirm-modal");
    $modal.data("deleteUrl", "");
    $modal.data("deleteItemName", "");
    $modal.data("sourceElement", null);

    $("#confirm-delete-btn").on("click", function () {
      var deleteUrl = $modal.data("deleteUrl");
      var deleteItemName = $modal.data("deleteItemName");
      var sourceElement = $modal.data("sourceElement");

      console.log("Delete confirmed for:", deleteItemName);

      $modal.modal("hide");

      // Perform the delete operation using jQuery AJAX
      $.ajax({
        url: deleteUrl,
        type: "DELETE",
        dataType: "json",
        data: {}, // CSRF token will be added automatically by jQuery via the yii.js
        beforeSend: function (xhr) {
          console.log("Making delete request to:", deleteUrl);
        },
        success: function (response) {
          console.log("Delete request successful:", response);

          // Find the appropriate PJAX container
          var pjaxContainer = findPjaxContainer(sourceElement);
          console.log("Found PJAX container:", pjaxContainer);

          // Reload the appropriate container or the page
          if ($.pjax && pjaxContainer) {
            $.pjax.reload({ container: pjaxContainer });
          } else {
            window.location.reload();
          }
        },
        error: function (xhr, status, error) {
          console.error("Delete request failed:", status, error);
          console.error("Server response:", xhr.responseText);
          alert("Error deleting: " + error);
        },
      });
    });
  };

  // Setup delete links to use the confirmation modal
  var setupDeleteLinks = function () {
    console.log("Setting up delete links with Bootstrap modal confirmation");

    // Find all delete links
    var links = $(".l8ajax-delete");
    console.log(
      "Found " + links.length + " delete links with class .l8ajax-delete"
    );

    // Remove any existing click handlers to avoid duplicates
    links.off("click");

    // Add our click handler to each link
    links.on("click", function (e) {
      e.preventDefault();
      e.stopPropagation();

      var url = $(this).data("url") || $(this).attr("data-url");
      var name =
        $(this).data("name") || $(this).attr("data-name") || "this item";

      console.log("Delete link clicked. URL:", url, "Name:", name);

      // Store data directly in the modal
      var $modal = $("#ajax-delete-confirm-modal");
      $modal.data("deleteUrl", url);
      $modal.data("deleteItemName", name);
      $modal.data("sourceElement", this); // Store the source element for later container detection

      // Update the modal content
      $("#delete-item-name").text(name);

      // Show the modal
      $modal.modal("show");

      return false;
    });
  };

  // Initialize when document is ready
  $(document).ready(function () {
    createConfirmModal();
    setupDeleteLinks();
  });

  // Handle PJAX updates
  $(document).on("pjax:complete", function () {
    console.log("PJAX completed, reattaching delete handlers");
    setupDeleteLinks();
  });
})(jQuery);
