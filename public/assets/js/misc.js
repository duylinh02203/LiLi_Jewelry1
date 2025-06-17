// (function ($) {
//   'use strict';
//   $(function () {
//     var body = $('body');
//     var contentWrapper = $('.content-wrapper');
//     var scroller = $('.container-scroller');
//     var footer = $('.footer');
//     var sidebar = $('.sidebar');

//     //Add active class to nav-link based on url dynamically
//     //Active class can be hard coded directly in html file also as required
//     // function addActiveClass(element) {
//     //   // Đóng tất cả các collapse khác trước
//     //   $('.collapse').removeClass('show');
//     // }
//     // $(document).ready(function () {
//     //   // Đóng tất cả các collapse khác khi một menu được nhấp
//     //   $('.nav-link[data-toggle="collapse"]').on('click', function () {
//     //     const currentTarget = $(this).attr('href');
//     //     $('.collapse').not(currentTarget).removeClass('show').attr('aria-expanded', 'false');
//     //   });

//     //   // Đóng collapse nếu không liên quan
//     //   $('a.nav-link').on('click', function () {
//     //     if (!$(this).closest('.collapse').length) {
//     //       $('.collapse').removeClass('show').attr('aria-expanded', 'false');
//     //     }
//     //   });
//     // });
//     function addActiveClass(element) {
//       if (current === "") {
//         //for root url
//         if (element.attr('href').indexOf("index.html") !== -1) {
//           element.parents('.nav-item').last().addClass('active');
//           if (element.parents('.sub-menu').length) {
//             element.closest('.collapse').addClass('show');
//             element.addClass('active');
//           }
//         }
//       } else {
//         //for other url
//         if (element.attr('href').indexOf(current) !== -1) {
//           element.parents('.nav-item').last().addClass('active');
//           if (element.parents('.sub-menu').length) {
//             element.closest('.collapse').addClass('show');
//             element.addClass('active');
//           }
//           if (element.parents('.submenu-item').length) {
//             element.addClass('active');
//           }
//         }
//       }
//     }

//     var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
//     $('.nav li a', sidebar).each(function() {
//       var $this = $(this);
//       addActiveClass($this);
//     })

//     $('.horizontal-menu .nav li a').each(function() {
//       var $this = $(this);
//       addActiveClass($this);
//     })


//     var current = location.pathname.split("/").slice(-1)[0].replace(/^\/|\/$/g, '');
//     $('.nav li a', sidebar).each(function () {
//       var $this = $(this);
//       addActiveClass($this);
//     })

//     $('.horizontal-menu .nav li a').each(function () {
//       var $this = $(this);
//       addActiveClass($this);
//     })

//     //Close other submenu in sidebar on opening any

//     sidebar.on('show.bs.collapse', '.collapse', function () {
//       sidebar.find('.collapse.show').collapse('hide');
//     });


//     //Change sidebar and content-wrapper height
//     applyStyles();

//     function applyStyles() {
//       //Applying perfect scrollbar
//       if (!body.hasClass("rtl")) {
//         if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
//           const settingsPanelScroll = new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');
//         }
//         if ($('.chats').length) {
//           const chatsScroll = new PerfectScrollbar('.chats');
//         }
//         if (body.hasClass("sidebar-fixed")) {
//           var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
//         }
//       }
//     }

//     $('[data-toggle="minimize"]').on("click", function () {
//       if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
//         body.toggleClass('sidebar-hidden');
//       } else {
//         body.toggleClass('sidebar-icon-only');
//       }
//     });

//     //checkbox and radios
//     $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

//     //fullscreen
//     $("#fullscreen-button").on("click", function toggleFullScreen() {
//       if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
//         if (document.documentElement.requestFullScreen) {
//           document.documentElement.requestFullScreen();
//         } else if (document.documentElement.mozRequestFullScreen) {
//           document.documentElement.mozRequestFullScreen();
//         } else if (document.documentElement.webkitRequestFullScreen) {
//           document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
//         } else if (document.documentElement.msRequestFullscreen) {
//           document.documentElement.msRequestFullscreen();
//         }
//       } else {
//         if (document.cancelFullScreen) {
//           document.cancelFullScreen();
//         } else if (document.mozCancelFullScreen) {
//           document.mozCancelFullScreen();
//         } else if (document.webkitCancelFullScreen) {
//           document.webkitCancelFullScreen();
//         } else if (document.msExitFullscreen) {
//           document.msExitFullscreen();
//         }
//       }
//     })
//   });
// })(jQuery);

(function ($) {
  'use strict';
  $(function () {
    var body = $('body');
    var sidebar = $('.sidebar');

    // Lấy full pathname từ URL hiện tại, ví dụ: /admin/product/index
    var currentPath = location.pathname;

    // Hàm gán class active nếu đường dẫn trùng khớp
    function addActiveClass(element) {
      var href = element.attr('href');

      // So sánh toàn bộ pathname
      if (href === currentPath || currentPath.startsWith(href)) {
        element.addClass('active');
        element.closest('.collapse').addClass('show');
        element.parents('.nav-item').addClass('active');
      }
    }

    // Áp dụng cho sidebar
    $('.nav li a', sidebar).each(function () {
      addActiveClass($(this));
    });

    // Áp dụng cho menu ngang nếu có
    $('.horizontal-menu .nav li a').each(function () {
      addActiveClass($(this));
    });

    // Đóng các submenu khác khi mở submenu mới
    sidebar.on('show.bs.collapse', '.collapse', function () {
      sidebar.find('.collapse.show').collapse('hide');
    });

    // Tùy chỉnh giao diện
    applyStyles();

    function applyStyles() {
      if (!body.hasClass("rtl")) {
        if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
          new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');
        }
        if ($('.chats').length) {
          new PerfectScrollbar('.chats');
        }
        if (body.hasClass("sidebar-fixed")) {
          new PerfectScrollbar('#sidebar .nav');
        }
      }
    }

    // Nút thu gọn sidebar
    $('[data-toggle="minimize"]').on("click", function () {
      if (body.hasClass('sidebar-toggle-display') || body.hasClass('sidebar-absolute')) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    // Bổ sung checkbox helper UI
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    // Chức năng toàn màn hình
    $("#fullscreen-button").on("click", function toggleFullScreen() {
      if (!document.fullscreenElement &&
          !document.mozFullScreenElement &&
          !document.webkitFullscreenElement &&
          !document.msFullscreenElement) {
        if (document.documentElement.requestFullscreen) {
          document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
          document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.exitFullscreen) {
          document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    });
  });
})(jQuery);
