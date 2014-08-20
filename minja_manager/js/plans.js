$(document).ready(function() {
  $(".fancybox").fancybox();
  
  $(".container").on("click", ".edit", function() {
    $("#edit input[name=plan_id]").val($(this).closest(".plan").data("plan-id"));
    $("#edit input[name=name]").val($(this).closest(".plan").find(".name").html());
    $("#edit textarea[name=description]").val($(this).closest(".plan").find(".description").html());
    $("#edit input[name=monthly_cost]").val($(this).closest(".plan").find(".monthly_cost").html());
  });
  
  $(".container").on("click", ".delete", function() {
    $("#delete input[name=plan_id]").val($(this).closest(".plan").data("plan-id"));
    $("#delete ul li").html($(this).closest(".plan").find(".name").html());
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