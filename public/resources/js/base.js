document.addEventListener("DOMContentLoaded", function() {
    var navbarLinks = document.querySelectorAll('.navbarLink');
    var sections = document.querySelectorAll('.section');

    sections.forEach(function(section, index) {
      section.addEventListener('mouseover', function() {
        // Supprimer la classe "active" de tous les liens de la navbar
        navbarLinks.forEach(function(link) {
          link.classList.remove('active');
        });

        // Ajouter la classe "active" au lien correspondant dans la navbar
        navbarLinks[index].classList.add('active');
      });
    });
  });




$('.toggle').click(function () {
    "use strict";
    $('nav ul').slideToggle();
});

$(window).resize(function () {
    "use strict";
    if ($(window).width() > 780) {
        $('nav ul').removeAttr('style');
    }
});
