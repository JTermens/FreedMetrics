(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 72)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 75
  });

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-scrolled");
    } else {
      $("#mainNav").removeClass("navbar-scrolled");
    }
  };
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);

  // Magnific popup calls
  $('#portfolio').magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: 'Loading image #%curr%...',
    mainClass: 'mfp-img-mobile',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1]
    },
    image: {
      tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    }
  });

})(jQuery); // End of use strict

(function($) {
  "use strict"; // Start of use strict

  // Floating label headings for the contact form
  $("body").on("input propertychange", ".floating-label-form-group", function(e) {
    $(this).toggleClass("floating-label-form-group-with-value", !!$(e.target).val());
  }).on("focus", ".floating-label-form-group", function() {
    $(this).addClass("floating-label-form-group-with-focus");
  }).on("blur", ".floating-label-form-group", function() {
    $(this).removeClass("floating-label-form-group-with-focus");
  });

  // Show the navbar when the page is scrolled up
  var MQL = 992;

  //primary navigation slide-in effect
  if ($(window).width() > MQL) {
    var headerHeight = $('#mainNav').height();
    $(window).on('scroll', {
        previousTop: 0
      },
      function() {
        var currentTop = $(window).scrollTop();
        //check if user is scrolling up
        if (currentTop < this.previousTop) {
          //if scrolling up...
          if (currentTop > 0 && $('#mainNav').hasClass('is-fixed')) {
            $('#mainNav').addClass('is-visible');
          } else {
            $('#mainNav').removeClass('is-visible is-fixed');
          }
        } else if (currentTop > this.previousTop) {
          //if scrolling down...
          $('#mainNav').removeClass('is-visible');
          if (currentTop > headerHeight && !$('#mainNav').hasClass('is-fixed')) $('#mainNav').addClass('is-fixed');
        }
        this.previousTop = currentTop;
      });
  }

})(jQuery); // End of use strict

function warnings(){
  // This function toggles the warnings for the form
  var special_characters = /[ `!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?~]/;
  var email = document.getElementById("reg_email");
  var email_warning = document.getElementById("wrong_email");

  var name = document.getElementById("reg_name");
  var name_warning = document.getElementById("wrong_name");

  var pass = document.getElementById("reg_pass");
  var pass_warning = document.getElementById("wrong_pass");

  var rep_pass = document.getElementById("rep_pass");
  var rep_warning = document.getElementById("wrong_repeat");

  var email_ok = 0;
  var pass_ok = 0;
  var name_ok = 0;
  var rep_ok = 0;


  if (email.value == ""){
    email_warning.style.display = "none";
    e_check.style.display = "none";
  }else{
    if (email.value.includes("@") && email.value.includes(".")){
      email_warning.style.display = "none";
      var email_ok = 1;
      e_check.style.display = "block";
    }else{
      e_check.style.display = "none";
      email_warning.style.display = "block";
    }
  }

  if (pass.value == ""){
    pass_warning.style.display = "none";
    p_check.style.display = "none";
  }else{
    if (pass.value.length >= 8 && /[0-9]/.test(pass.value) == true && special_characters.test(pass.value) == true){
      pass_warning.style.display = "none";
      p_check.style.display = "block";
      var pass_ok = 1;
    }else{
      p_check.style.display = "none";
      pass_warning.style.display = "block";
    }
  }
  if (rep_pass.value == ""){
    rep_warning.style.display = "none";
    rp_check.style.display = "none";
  }else{
    if (rep_pass.value == pass.value){
      rep_warning.style.display = "none";
      rp_check.style.display = "block";
      var rep_ok = 1;
    }else{
      rp_check.style.display = "none";
      rep_warning.style.display = "block";
    }
  }

  if (name.value.length > 0){
    name_warning.style.display = "none";
    n_check.style.display = "block";
    name_ok = 1;
  }else{
    n_check.style.display = "none";
    name_warning.style.display = "block";
  }

  if (email_ok == 1 && name_ok == 1 && pass_ok == 1 && rep_ok == 1){
    document.getElementById("reg_submit").disabled = false;
  }else{
    document.getElementById("reg_submit").disabled = true;
  }
}

