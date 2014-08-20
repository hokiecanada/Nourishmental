$(document).ready(function() {
  $(".fancybox").fancybox();
  
  $(document).on("submit", "form", function(e) {
    e.preventDefault();
    $.post(window.location.pathname, $(this).serialize(), function(data) {
      response = JSON.parse(data);
      if (response.success) {
        $("#main_content").html(response.body);
        $.fancybox.close();
      }
    });
  });
  
  $(document).on("reset", "form", function() {
    $.fancybox.close();
  });
});