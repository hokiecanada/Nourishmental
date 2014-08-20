$(document).ready(function(){
  $(".underlay video").removeAttr("controls");

  setTimeout(function() { $(".mind").fadeTo(2000,1) }, 1000);
  setTimeout(function() { $(".body").fadeTo(2000,1) }, 2500);
  setTimeout(function() { $(".life").fadeTo(2000,1) }, 4200);
  setTimeout(function() { $(".cta").fadeTo(1000,1) }, 5500);
  setTimeout(function() { $("header").fadeTo(0,1) }, 5500);
  
  adjustTitleSize();
  adjustOverlay();
  
  $(window).resize(function() {
    adjustTitleSize();
    adjustOverlay();
  });
  
  $(window).scroll(function() {
    if ($(window).scrollTop() > 0) {
      $("header").css("background-color", "rgba(0,0,0,0.7)").css("padding", "5px 25px").css("opacity", 1);
    } else
      $("header").css("background-color", "").css("padding", "25px 25px");
  });
  
  function adjustTitleSize() {
    // Adjust video to fill full width/height
    if (window.innerWidth / window.innerHeight > 1.77) {
      $(".underlay video").css("height", "").css("width", "100%");
      $(".underlay").css("max-height", window.innerHeight);
    } else {
      $(".underlay video").css("height", window.innerHeight).css("width", "");
      $(".underlay").css("max-height", "");
    }
  }
  
  function adjustOverlay() {
    // Figure out how much space is available for the motto and resize motto/padding accordingly
    var spaceAvailable = $(".overlay").outerHeight();
    
    if (spaceAvailable < 300) {
      // Hide it entirely
      $(".overlay .motto").hide();
      $(".cta button").hide();
      $("header").css("opacity",1);
      $(".cta").css("opacity",1);
    } else if (spaceAvailable < 400) {
      // Keep text, hide button
      $(".overlay .motto").show();
      $(".cta button").hide();
      $(".mind,.body,.life").css("font-size","30px");
      $(".mind,.body").css("padding-top", "0");
      $(".life").css("padding-top", "10px");
      $(".cta .arrow").css("padding-top", "0");
    } else if (spaceAvailable < 500) {
      // Show button, reduce text size
      $(".overlay .motto").show();
      $(".cta button").show();
      $(".mind,.body,.life").css("font-size","30px");
      $(".mind,.body").css("padding-top", "0");
      $(".life").css("padding-top", "10px");
      $(".cta .arrow").css("padding-top", "15px");
    } else {
      // Use default
      $(".overlay .motto").show();
      $(".cta button").show();
      $(".mind,.body,.life").css("padding-top", "").css("font-size","");
      $(".cta .arrow").css("padding-top", "");
    }

    // Center motto within available space
    var topPadding = $("header").outerHeight() + ($(".overlay").outerHeight() - $("header").outerHeight() - $(".cta").outerHeight() - $(".overlay .motto").height()) / 2;
    $(".overlay .motto").css("padding-top", topPadding);
  }
});
