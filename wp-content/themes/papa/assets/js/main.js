jQuery(function($) {

/* Open menu */

$('#trigger-overlay').on('click', function(){
    $(".overlay").addClass('open'); 
});

$('#trigger-overlay2').on('click', function(){
    $(".overlay").addClass('open'); 
});

$('.overlay-close').on('click', function(){
    $(".overlay").removeClass('open');  
});

$('.menu-item').on('click', function(){
    $(".overlay").removeClass('open');  
});

$('.contact-menu').on('click', function(){
    $(".overlay").removeClass('open');  
});


/*
$('.mobile__menu .menu-item-6203').click(function() {
        $('.menu-item-6203 .sub-menu').slideToggle();
        //check if all services menu is open and close it on click
        if($('.menu-item-4043 .sub-menu').css('display') !== 'none') {
          $('.menu-item-4043 .sub-menu').slideToggle();
        }
    });

    $('.mobile__menu .menu-item-4043').click(function() {
        $('.menu-item-4043 .sub-menu').slideToggle();
        //check if expertise menu is open and close it on click
        if($('.menu-item-147 .sub-menu').css('display') !== 'none') {
          $('.menu-item-147 .sub-menu').slideToggle();
        }
    });*/


//menu mobile

$(window).scroll(function() {
        var scroll = $(window).scrollTop();

        if (scroll >= 120) {
            $(".scroll-header").removeClass("show");
            
        } else {
            $(".scroll-header").addClass("show");
        }
});
});


var prevScrollpos = window.pageYOffset;
window.onscroll = function() {
var currentScrollPos = window.pageYOffset;
if (prevScrollpos > currentScrollPos) {
    document.getElementsByClassName('scroll-header')[0].style.top = "0";
    } else {
    document.getElementsByClassName('scroll-header')[0].style.top = "-140px";
    }
    prevScrollpos = currentScrollPos;
}



// homepage tabs
function openCity(evt, cityName) {
  var i, x, tablinks;
  x = document.getElementsByClassName("papabowls");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tabbtn");
  for (i = 0; i < x.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active-red", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active-red";
}


//faq accordeon
var acc = document.getElementsByClassName("single__accordion");
var i;

for (i = 0; i < acc.length; i++) {
  acc[i].addEventListener("click", function() {
    this.classList.toggle("single__active");
    var panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
      panel.style.maxHeight = null;
    } else {
      panel.style.maxHeight = panel.scrollHeight + "px";
    } 
  });
}

jQuery(function($) {
          
    $('.quantity').on('click', '.quant-plus', function(e) {
        $input = $(this).prev('input.qty');
        var val = parseInt($input.val());
        $input.val( val+1 ).change();
    });

    $('.quantity').on('click', '.quant-minus', 
        function(e) {
        $input = $(this).next('input.qty');
        var val = parseInt($input.val());
        if (val > 1) {
            $input.val( val-1 ).change();
        } 
    });

          
});