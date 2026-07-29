$(function () {
  /* =========================================================
     MOBILE SIDEBAR — dropdown open/close
     ========================================================= */
  $(document).on("click", ".sidebar-nav .dropdown-trigger", function () {
    $(this).closest("li").toggleClass("open");
  });

  /* =========================================================
     MOBILE SIDEBAR — nested submenu open/close
     ========================================================= */
  $(document).on("click", ".submenu-trigger", function (e) {
    e.stopPropagation();
    $(this).closest("li").toggleClass("open");
  });

  /* =========================================================
     BANNER SLIDER (smooth translateX sliding)
     ========================================================= */
  var $slider = $("#bannerSlider");
  var $track = $slider.find(".banner-track");
  var $slides = $slider.find(".banner-slide");
  var $dotsWrap = $slider.find(".banner-dots");
  var current = 0;
  var autoplayDelay = 4000;
  var timer = null;

  // if only one banner image exists, hide arrows/dots and stop here
  if ($slides.length <= 1) {
    $slider.addClass("single-slide");
  } else {
    // build dots
    $slides.each(function (i) {
      var $dot = $("<span></span>").attr("data-index", i);
      if (i === 0) $dot.addClass("active");
      $dotsWrap.append($dot);
    });
    var $dots = $dotsWrap.find("span");

    function render() {
      $track.css("transform", "translateX(-" + current * 100 + "%)");
      $dots.removeClass("active").eq(current).addClass("active");
    }

    function goToSlide(index) {
      current = (index + $slides.length) % $slides.length;
      render();
    }

    function nextSlide() {
      goToSlide(current + 1);
    }
    function prevSlide() {
      goToSlide(current - 1);
    }

    function startAutoplay() {
      stopAutoplay();
      timer = setInterval(nextSlide, autoplayDelay);
    }
    function stopAutoplay() {
      if (timer) clearInterval(timer);
    }

    $slider.find(".banner-next").on("click", function () {
      nextSlide();
      startAutoplay();
    });
    $slider.find(".banner-prev").on("click", function () {
      prevSlide();
      startAutoplay();
    });
    $dots.on("click", function () {
      goToSlide($(this).data("index"));
      startAutoplay();
    });

    // pause on hover (desktop)
    $slider.on("mouseenter", stopAutoplay);
    $slider.on("mouseleave", startAutoplay);

    // basic touch swipe support
    var touchStartX = 0;
    $slider.on("touchstart", function (e) {
      touchStartX = e.originalEvent.touches[0].clientX;
    });
    $slider.on("touchend", function (e) {
      var touchEndX = e.originalEvent.changedTouches[0].clientX;
      var diff = touchStartX - touchEndX;
      if (Math.abs(diff) > 40) {
        diff > 0 ? nextSlide() : prevSlide();
        startAutoplay();
      }
    });

    // set initial position and start
    render();
    startAutoplay();
  }
});

// STATS COUNTER js
/* =========================================================
   STATS COUNTER — animate on scroll into view
   ========================================================= */
function toBanglaDigits(num) {
  var enToBn = {
    0: "০",
    1: "১",
    2: "২",
    3: "৩",
    4: "৪",
    5: "৫",
    6: "৬",
    7: "৭",
    8: "৮",
    9: "৯",
  };
  return String(num).replace(/[0-9]/g, function (d) {
    return enToBn[d];
  });
}

function animateCounter($el) {
  var target = parseInt($el.attr("data-count"), 10);
  var suffix = $el.attr("data-suffix") || "";
  var duration = 1600;
  var startTime = null;

  function step(timestamp) {
    if (!startTime) startTime = timestamp;
    var progress = Math.min((timestamp - startTime) / duration, 1);
    var eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
    var current = Math.floor(eased * target);

    $el.text(toBanglaDigits(current.toLocaleString("en-US")) + suffix);

    if (progress < 1) {
      requestAnimationFrame(step);
    } else {
      $el.text(toBanglaDigits(target.toLocaleString("en-US")) + suffix);
    }
  }

  requestAnimationFrame(step);
}

$(function () {
  var counted = false;
  var $statsSection = $(".stats-section");

  if ($statsSection.length) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting && !counted) {
            counted = true;
            $(".stat-number").each(function () {
              animateCounter($(this));
            });
          }
        });
      },
      { threshold: 0.4 },
    );

    observer.observe($statsSection[0]);
  }
});

// 
