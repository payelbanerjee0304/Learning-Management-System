// ! Pre Loader By Jquery

// $(window).on("load", function () {
//     $("#pre_Loader").fadeOut(2000);
// });

// =======================<<<<<>>>>>=======================


// ! Custom Fixed NavBar

// $(function () {
//     $(window).scroll(function () {
//         if ($(window).scrollTop() > 400) {
//             $("header").addClass("active");
//         } else {
//             $("header").removeClass("active");
//         }
//     });
// });

// =======================<<<<<>>>>>=======================


// ! Back To Top (Jquery)

// let btn = $('#backToTop');
// $(window).on('scroll', function () {
//     if ($(window).scrollTop() > 300) {
//         btn.addClass('show');
//     } else {
//         btn.removeClass('show');
//     }
// });
// btn.on('click', function (e) {
//     e.preventDefault();
//     $('html, body').animate({
//         scrollTop: 0
//     }, '1000');
// });


// =======================<<<<<>>>>>=======================

// ! Easy Responsive Tabs

// $(document).ready(function () {
//     $('#horizontalTab').easyResponsiveTabs({
//         type: 'default',
//         width: 'auto',
//         fit: true,
//         closed: 'accordion',
//         activate: function (event) {
//             var $tab = $(this);
//             var $info = $('#tabInfo');
//             var $name = $('span', $info);
//             $name.text($tab.text());
//             $info.show();
//         }
//     });
// });

// =======================<<<<<>>>>>=======================


// ! Swiper Slider

// var swiper = new Swiper(".mySwiper", {
//     loop: true,
//     // centeredSlides: true,
//     slidesPerView: 3,
//     spaceBetween: 30,
//     autoplay: {
//         delay: 1000,
//         disableOnInteraction: true,
//     },
//     speed: 1500,
//     // direction: "vertical",
//     navigation: {
//         nextEl: ".swiper-button-next",
//         prevEl: ".swiper-button-prev",
//     },
// });

// Autoplay Stop on Hover

/* $(".swiper").mouseenter(function () {
    swiper.autoplay.stop();
});

$(".swiper").mouseleave(function () {
    swiper.autoplay.start();
});

*/
// var swiper = new Swiper(".news_image_slider", {
//   loop: true,
//   slidesPerView: 1,
//   spaceBetween: 20,
//   autoplay: {
//       delay: 3000,
//       disableOnInteraction: true,
//   },
//   speed: 3500,
//   breakpoints: {
//       320: {
//           slidesPerView: 1,
//       },
//       768: {
//           slidesPerView: 1,
//           spaceBetween: 0,
//       },
//       1440: {
//           slidesPerView: 1,
//           spaceBetween: 10,
//       },
//       1441: {
//           slidesPerView: 1,
//           spaceBetween: 10,
//       },
//   },
//   pagination: {
//       el: ".swiper-pagination2",
//       clickable: true,
//   },
// });
// // Autoplay Stop on Hover
// $(".news_image_slider").mouseenter(function() {
//   swiper.autoplay.stop();
// });
// $(".news_image_slider").mouseleave(function() {
//   swiper.autoplay.start();
// });
// =======================<<<<<>>>>>=======================
// moumi left side bar


// document.addEventListener("DOMContentLoaded", () => {
//   const sidebar = document.querySelector(".sidebar");
//   const left_bar = document.querySelector(".left_parent_element");
//   const right_bar = document.querySelector(".right_parent_element");

//   sidebar.addEventListener("click", (event) => {
//       event.preventDefault();
//       left_bar.classList.toggle("active");

//       if (left_bar.classList.contains("active")) {
//           left_bar.style.width = "150px";
//           right_bar.style.width = "93%";
//       } else {
//           left_bar.style.width = ""; // Reset the left bar's width
//           right_bar.style.width = "85%";
//       }
//   });
// });
// document.addEventListener("DOMContentLoaded", () => {
//   const sidebar = document.querySelector(".sidebar");
//   const left_bar = document.querySelector(".left_parent_element");
//   const right_bar = document.querySelector(".right_parent_element");
//   const closeButton = document.querySelector(".left_span_close");

//   sidebar.addEventListener("click", (event) => {
//     event.preventDefault();
//     left_bar.classList.toggle("active");

//     if (left_bar.classList.contains("active")) {
//       right_bar.style.width = "10%";
//     } else {
//       right_bar.style.width = "100%";
//     }
//   });

//   closeButton.addEventListener("click", () => {
//     left_bar.classList.remove("active"); 
//     right_bar.style.width = "100%";
//   });
// });



document.addEventListener("DOMContentLoaded", () => {
  const sidebar = document.querySelector(".sidebar");
  const leftBar = document.querySelector(".left_parent_element");
  const rightBar = document.querySelector(".right_parent_element");
  const closeButton = document.querySelector("#closeBtn"); // Ensure this ID matches the close button

  sidebar.addEventListener("click", (event) => {
      event.preventDefault();
      leftBar.classList.toggle("active");

      if (leftBar.classList.contains("active")) {
          leftBar.style.width = "150px";
          rightBar.style.width = "93%";
          // rightBar.style.position = "fixed";
      } else {
          leftBar.style.width = ""; 
          rightBar.style.width = "85%";
          rightBar.style.position = "relative";
      }
  });

  closeButton.addEventListener("click", () => {
      leftBar.classList.remove("active"); 
      leftBar.style.width = "";
      rightBar.style.width = "100%";
      rightBar.style.position = "relative";
  });
});





// ====================================================================
// moumi attachment file
document.getElementById('icon').addEventListener('click', function() {
    document.getElementById('fileInput').click();
});

document.getElementById('fileInput').addEventListener('change', function() {
    const file = this.files[0];
    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = e.target.result;
                preview.appendChild(img);
            } else {
                const p = document.createElement('p');
                p.textContent = `Attached file: ${file.name}`;
                preview.appendChild(p);
            }
        };

        reader.readAsDataURL(file);
    }
});
// ======================================================================
// moumi summery tab section 2.8.24
function openCity(evt, wiseName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(wiseName).style.display = "block";
    evt.currentTarget.className += " active";
  }
//   ============================
// moumi taskwise subtab 5.8.24
function openTabb(evt, subTab) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent1");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks1");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(subTab).style.display = "block";
    evt.currentTarget.className += " active";
  }
//   ==========================================
// MOUMI CITYWISE TAB 5.8.24
function openCItyW(evt, cityW) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent2");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks2");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityW).style.display = "block";
    evt.currentTarget.className += " active";
  }
  // ===============================================================
    // Change option selected 2
    const label3 = document.querySelector('.dropdown__filter-selected3')
    const options3 = Array.from(document.querySelectorAll('.dropdown__select-option3'))

    options3.forEach((option_three) => {
      option_three.addEventListener('click', () => {
        label3.textContent = option_three.textContent
      })
    })

    // Close dropdown onclick outside
    document.addEventListener('click', (e) => {
      const toggle3 = document.querySelector('.dropdown__switch3')
      const element3 = e.target

      if (element3 == toggle3) return;

      const isDropdownChild = element3.closest('.dropdown__filter3')

      if (!isDropdownChild) {
        toggle3.checked = false
      }
    })
  
// ======================================

// moumi attachment file
document.getElementById('icon111').addEventListener('click', function() {
  document.getElementById('fileInput111').click();
});

document.getElementById('fileInput111').addEventListener('change', function() {
  const file = this.files[0];
  const preview = document.getElementById('preview111');
  preview.innerHTML = '';

  if (file) {
      const reader = new FileReader();

      reader.onload = function(e) {
          if (file.type.startsWith('image/')) {
              const img = document.createElement('img');
              img.src = e.target.result;
              preview.appendChild(img);
          } else {
              const p = document.createElement('p');
              p.textContent = `Attached file: ${file.name}`;
              preview.appendChild(p);
          }
      };

      reader.readAsDataURL(file);
  }
});
