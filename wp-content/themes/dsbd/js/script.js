//Scheduled actions

// function launchElements() {
//     var now = new Date();
//     var day = 16;
//     var month = 00;
//     var hours = 10;
//     var minutes = 00;
//     var seconds = 00;
//     var term = new Date(now.getFullYear(), month, day, hours, minutes, seconds, 0);
//     setTimeout(schedulesElements, term - now);
//     var diff = Math.round((term.getTime() - now.getTime()) / 1000);
//     console.log('Now :' + now);
//     console.log('Term :' + term);
//     console.log("L'opération sera déclenchée dans " + diff + " secondes...");
// }

// launchElements();


//Mobile menu

document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
  
    mobileMenuToggle.addEventListener('click', function() {
      mobileMenu.classList.toggle('active');
      const burgerIcon = mobileMenuToggle.querySelector('.burger-icon');
      const closeIcon = mobileMenuToggle.querySelector('.close-icon');
      burgerIcon.style.display = mobileMenu.classList.contains('active') ? 'none' : 'block';
      closeIcon.style.display = mobileMenu.classList.contains('active') ? 'block' : 'none';
    });
  });
//AOS Init

AOS.init();