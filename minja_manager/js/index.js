$(document).ready(function() {
  $(".fancybox").fancybox();

  $(".container").on("click", ".add_new", function() {
    $("#new #plan_name").html($(this).closest(".plan").data("plan-name"));
    $("#new input[name=plan_id]").val($(this).closest(".plan").data("plan-id"));
  });
  
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