<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>กลต.</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
  <link rel="stylesheet" href="/css/normalize.css">
  <link rel="stylesheet" href="/css/main.css">
  <link href='https://fonts.googleapis.com/css?family=Prompt|Sarabun|Roboto' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="/css/hamburgers.min.css" rel="stylesheet">
  <link href="/css/bootstrap-datepicker.min.css" rel="stylesheet">
  <link href="/css/insidepage.css" rel="stylesheet">

  <meta name="theme-color" content="#fafafa">

  @yield('head')
</head>

<body>
<!--[if IE]>
<p class="browserupgrade">คุณใช้บราวเซอร์ที่เก่าเกินไป กรุณา<a href="https://browsehappy.com/">อัพเกรดบราวเซอร์</a>เพื่อความปลอดภัยและประสบการณ์ที่ดีในการใช้งานเว็บไซต์นี้</p>
<![endif]-->

{{--<div id="app">--}}
<div class="my-navbar">
  <div style="display: flex; align-items: center">
    <a href="/"><img class="logo" src="/images/logo.svg" alt="logo" style="cursor: pointer"></a>
    <div class="header d-none d-md-block">สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์</div>
  </div>
  <div style="display: flex; align-items: center; align-self: stretch">
    <div id="menu-item-search" class="menu-item">
      <img class="img-search" src="/images/ic_search.svg" alt="search icon">
      <div class="icon-label d-none d-md-block" style="color: #005288;">Search</div>
    </div>
    <div id="menu-item-menu" class="menu-item" style="background-color: #8DC63F">
      <!--<img class="img-search" src="images/ic_menu.svg" alt="search icon">-->

      <button class="hamburger hamburger--elastic" type="button" style="margin: 0; padding: 0;">
  <span class="hamburger-box" style="margin: 0; padding: 0">
    <span class="hamburger-inner" style="margin: 0; padding: 0"></span>
  </span>
      </button>

      <div class="icon-label d-none d-md-block" style="color: #fff;">Menu</div>
    </div>
  </div>
</div>

<div class="page-content">
  @yield('content')
</div>

<!--footer-->
<footer class="container-fluid footer">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-12 wrap_myd">
          <h2>Make your dreams a <span>reality</span></h2>
          <a href="#">ติดต่อเรา <img src="/images/ar_ftbtn.svg"></a>
        </div>
      </div>
      <div class="row row_bot_footer">
        <div class="col-12 col-md-5 botlogoandsocial">
          <img src="/images/footer-logo.svg">
          <a href="#"><img src="/images/001-facebook.svg"></a><a href="#"><img src="/images/002-youtube.svg"></a><a href="#"><img src="/images/003-twitter.svg"></a>
          <p>สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์
            333/3 ถนนวิภาวดีรังสิต แขวงจอมพล เขตจตุจักร กรุงเทพมหานคร 10900</p>
        </div>
        <div class="col-12 col-md-7">
          <div class="row">
            <div class="col-12 col-md-4">
              <ul class="footer_menu">
                <li><h4>Column Heading</h4></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
              </ul>
            </div>
            <div class="col-12 col-md-4">
              <ul class="footer_menu">
                <li><h4>Column Heading</h4></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
              </ul>
            </div>
            <div class="col-12 col-md-4">
              <ul class="footer_menu">
                <li><h4>Column Heading</h4></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
                <li><a href="#">Link goes here</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 copyright">
          <small>2019 Securities & Exchange Commission, Thailand All rights reserved. เว็บไซต์นี้แสดงผลได้ดีบน Microsoft Edge, Chrome, Safari และ Firefox</small>
        </div>
      </div>
    </div>
  </div>
</footer>
{{--</div>--}}

<script src="/js/vendor/modernizr-3.8.0.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="/js/vendor/jquery-3.5.1.min.js"><\/script>')</script>
<script src="/js/plugins.js"></script>
<script src="/js/main.js"></script>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<!--<script>
  window.ga = function () {
    ga.q.push(arguments)
  };
  ga.q = [];
  ga.l = +new Date;
  ga('create', 'UA-XXXXX-Y', 'auto');
  ga('set', 'transport', 'beacon');
  ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async></script>-->
<!-- development version, includes helpful console warnings -->
<!--<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>-->
<!-- production version, optimized for size and speed -->

@yield('script')

<script>
  const menu = $('#menu-item-menu');
  const hamburgerButton = $('#menu-item-menu button')
  menu.on("click", function (e) {
    hamburgerButton.toggleClass("is-active");
    // Do something else, like open/close menu
  });

  function adjustNavBar() {
    const navBar = $('.my-navbar');
    const logo = $('.my-navbar .logo');
    const header = $('.my-navbar .header');
    const menuItem = $('.my-navbar .menu-item');
    const iconLabel = $('.my-navbar .icon-label');
    const imgSearch = $('.my-navbar .img-search');
    const hamburgerInner = $('.hamburger-inner');

    if (Modernizr.mq('(min-width: 768px)')) {
      if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        navBar.css('height', '60px');
        logo.css('width', '40px');
        logo.css('height', '40px');
        logo.css('margin-left', '25px');
        logo.css('margin-bottom', '2px');
        header.css('font-size', '16px');
        header.css('margin', '2px 15px 0');
        menuItem.css('width', '80px');
        iconLabel.css('font-size', '12px');
        iconLabel.addClass('icon-label-hide');
        imgSearch.css('width', '26px');
        hamburgerInner.addClass('hamburger-width-small');
      } else {
        navBar.css('height', '100px');
        logo.css('width', '57px');
        logo.css('height', '57px');
        logo.css('margin-left', '50px');
        logo.css('margin-bottom', '8px');
        header.css('font-size', '20px');
        header.css('margin', '0 25px');
        menuItem.css('width', '140px');
        iconLabel.css('font-size', '14px');
        iconLabel.removeClass('icon-label-hide');
        imgSearch.css('width', '34px');
        hamburgerInner.removeClass('hamburger-width-small');
      }
    }
  }

  $(function () {
    window.onload = function (e) {
      adjustNavBar();
    }
    window.onscroll = function (e) {
      adjustNavBar();
    };
  });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>
