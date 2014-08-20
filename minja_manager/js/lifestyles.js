$(document).ready(function() {
  $(".fancybox").fancybox();
  
  $(".container").on("click", ".add_new", function() {
    $("#new #plan_name").html($(this).closest(".plan").data("plan-name"));
    $("#new input[name=plan_id]").val($(this).closest(".plan").data("plan-id"));
  });
  
  $(".container").on("click", ".edit", function() {
    $("#edit input[name=lifestyle_id]").val($(this).closest(".lifestyle").data("lifestyle"));
    $("#edit input[name=ordering]").val($(this).closest(".lifestyle").data("ordering"));
    $("#edit input[name=title]").val($(this).closest(".lifestyle").data("title"));
    $("#edit textarea[name=description]").val($(this).closest(".lifestyle").data("description"));
  });
  
  $(".container").on("click", ".delete", function() {
    $("#delete input[name=lifestyle_id]").val($(this).closest(".lifestyle").data("lifestyle"));
    $("#delete ul li").html($(this).closest(".lifestyle").data("title"));
  });
  
  $(".container").on("click", ".edit_lesson", function() {
    $("#edit input[name=lesson_id]").val($(this).closest(".lesson").data("lesson"));
    $("#edit input[name=day]").val($(this).closest(".lesson").find(".day").html());
    $("#edit input[name=subject]").val($(this).closest(".lesson").find(".subject").html());
    $("#edit textarea[name=body]").val($(this).closest(".lesson").find(".body").html());
    $("#edit input[name=survey_id]").val($(this).closest(".lesson").find(".survey_id").html());
  });
  
  $(".container").on("click", ".delete_lesson", function() {
    $("#delete input[name=lesson_id]").val($(this).closest(".lesson").data("lesson"));
    $("#delete ul li").html($(this).closest(".lesson").find(".subject").html());
  });
  
  $(".container").on("click", ".lesson .view", function() {
    $(this).closest(".lesson").find(".body").toggle();
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