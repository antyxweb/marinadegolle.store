$(function () {
  //
  $html = $("html");
  $body = $("body");
  $header = $("#header");
  $dropdown = $("#dropdown");
  $footer = $("#footer");
  $hero = $("#hero");

  var $screenSize = false;
  if($screenSize) {
    $body.append('<div id="screen-size" style="position:fixed;bottom:0;right:0;z-index:9999;background:#fff;padding:2px 5px;font-size:0.8rem;opacity:0.6"></div>');
  }

  if($('.product-slider')) {
    $productSlider = $('.product-slider').html();
  }

  //RESPONSIVE

  function responsive() {
    //PARAMS
    $wW = $(window).width();
    $wH = $(window).height();

    if($hero.length) {
      $hero.height($wH - $header.height());
    }

    if($screenSize) {
      $("#screen-size").text($wW + "x" + $wH);
    }

    if($productSlider) {
      $('.product-slider').html($productSlider);

      if($wW <= 1600) {
        $settings = {
          gallery: true,
          item: 1,
          thumbItem: 4,
          thumbMargin: 0,
          slideMargin: 0,
        }
      } else {
        $settings = {
          gallery: true,
          item: 1,
          vertical: true,
          verticalHeight: $(window).width() / 2 - 145,
          vThumbWidth: 145,
          thumbItem: 4,
          thumbMargin: 0,
          slideMargin: 0,
        }
      }

      $('#vertical').lightSlider($settings);
    }
  }
  responsive();
  $(window).on("resize", responsive);

  //SCROLLING

  function scrolling() {
    $wW = $(window).width();
    $wH = $(window).height();

    $top1 = $body.scrollTop();
    $top2 = $html.scrollTop();

    if ($top1) {
      $top = $top1;
    } else {
      $top = $top2;
    }
  }
  scrolling();
  $(window).on("scroll", scrolling);

  $body.on('click', '[data-dropdown-toggle]', function (e) {
    e.preventDefault();

    $target = $(this).data('dropdown-toggle');

    if($dropdown.hasClass('is-visible') && $dropdown.hasClass('open-'+$target)) {
      $dropdown.removeClass('is-visible');
      $dropdown.removeClass('open-menu');
      $dropdown.removeClass('open-cart');
    } else {
      $dropdown.addClass('is-visible');
      $dropdown.removeClass('open-menu');
      $dropdown.removeClass('open-cart');
      $dropdown.addClass('open-'+$target);
    }
  });

  $dropdown.on('click', '.dropdown-close', function (e) {
    $dropdown.removeClass('is-visible');
    $dropdown.removeClass('open-menu');
    $dropdown.removeClass('open-cart');
  });

  $dropdown.on('click', '.submenu-open', function (e) {
    $(this).toggleClass('opened');
  });

  $('.main-carousel-50').flickity({
    // options
    cellAlign: 'left',
    contain: true,
    freeScroll: true,
    prevNextButtons: false,
    pageDots: false,
    imagesLoaded: true
  });

  // Закрыть открытое окно, перед открытием нового (простите за тавтологию)
  // $.fancybox.defaults.closeExisting = true;
  // $.fancybox.defaults.hideScrollbar = false;


});
