$(document).ready(function() {
    $(".delete-button").on("click", function() {
      const id = $(this).data("id");
      deleteRow(id);
    });
  
    function deleteRow(id) {
      $.ajax({
        url: `/delete/${id}`,
        type: "POST",
        dataType: "json",
        success: function(data) {
          console.log(data);
          // Odśwież stronę po sukcesie żądania AJAX
          window.location.reload(true);
        },
        error: function(error) {
          console.error("Error:", error);
        },
      });
    }
  });


