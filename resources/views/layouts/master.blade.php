<!doctype html>
<html class="no-js" lang="">

<head>
  <meta charset="utf-8">
  <title>Start to Grow</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <meta property="og:title" content="">
  <meta property="og:type" content="">
  <meta property="og:url" content="">
  <meta property="og:image" content="">

  <!--<link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">-->
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
        crossorigin="anonymous">
  <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Prompt|Sarabun|Roboto'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel='stylesheet' href="{{ asset('css/normalize.css') }}">
  <link rel='stylesheet' href="{{ asset('css/main.css?v=2') }}">
  <link rel='stylesheet' href="{{ asset('css/hamburgers.min.css') }}">
  <link rel='stylesheet' href="{{ asset('css/bootstrap-datepicker.min.css') }}">
  <link rel='stylesheet' href="{{ asset('css/insidepage.css?v=3') }}">
  <link rel='stylesheet' href="{{ asset('css/my_bootstrap_style.css?v=1') }}">
<!--  <link rel='stylesheet' href="{{ asset('css/cookie_consent.css') }}">-->
  <link rel='stylesheet' href="{{ asset('css/cookie-consent.css?v=3') }}">
  <link rel='stylesheet' href="{{ asset('css/sidenav.css?v=1') }}">
  <link rel='stylesheet' href="{{ asset('css/chatbot.css?v=1') }}">

  <meta name="theme-color" content="#fafafa">

  @yield('head')
</head>

<body style="overflow-x: hidden">
<!--[if IE]>
<p class="browserupgrade">คุณใช้บราวเซอร์ที่เก่าเกินไป กรุณา<a href="https://browsehappy.com/">อัพเกรดบราวเซอร์</a>เพื่อความปลอดภัยและประสบการณ์ที่ดีในการใช้งานเว็บไซต์นี้</p>
<![endif]-->

{{--<div id="app">--}}
<div class="my-navbar">
  <div style="display: flex; align-items: center">
    <a href="/"><img class="logo" src="{{ asset('images/logo3.png') }}" alt="logo" style="cursor: pointer"></a>
    <!--    <div class="header d-none d-md-block">สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์</div>-->
  </div>
  <div style="display: flex; align-items: center; align-self: stretch">
    <div id="menu-item-search" class="menu-item" data-toggle="modal" data-target="#searchModal">
      <img class="img-search" src="{{ asset('images/ic_search.svg') }}" alt="search icon">
      <div class="icon-label d-none d-md-block" style="color: #005288;">Search</div>
    </div>
    <div id="menu-item-menu" class="menu-item" style="background-color: #8DC63F"
         onclick="toggleSideNav()">
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

<!-- Search modal -->
<div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"
     style="z-index: 9999">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content p-2"
         style="background-image: url( {{ asset('images/bg_search_2.jpg') }} ); background-size: cover;">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">ค้นหา</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="searchForm" action="/search" method="POST">
          {{ csrf_field() }}

          <div class="form-group">
            <label for="searchTerm" class="col-form-label">คำค้น:</label>
            <input type="text" class="form-control" id="searchTerm" name="searchTerm">
          </div>

          <label class="col-form-label">ประเภทเนื้อหา:</label>
          <div class="row">
            <div class="col-12 col-lg-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="fundraisingCheck" name="fundraisingCheck" checked>
                <label class="form-check-label" for="fundraisingCheck">เครื่องมือระดมทุน</label>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="mediaCheck" name="mediaCheck" checked>
                <label class="form-check-label" for="mediaCheck">แหล่งข้อมูลระดมทุน</label>
              </div>
            </div>
            <div class="col-12 col-lg-4">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="eventCheck" name="eventCheck" checked>
                <label class="form-check-label" for="eventCheck">SEC Event</label>
              </div>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-12">
              <button id="searchButton" type="button" class="btn btn-primary pull-right">ค้นหา</button>
              <button type="button" class="btn btn-secondary pull-right mr-2" data-dismiss="modal">ปิด</button>
            </div>
          </div>
        </form>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary">ค้นหา</button>
      </div>-->
    </div>
  </div>
</div>

@php
  {{
    $menuDataList = array(
      array('title' => 'หน้าหลัก', 'url' => '/', 'image' => null, 'imageMarginTop' => 20),
      array('title' => 'สำรวจตัวเอง', 'url' => '/survey', 'image' => 'header-survey.svg', 'imageMarginBottom' => -25),
      array('title' => 'เครื่องมือระดมทุน', 'url' => '/fundraising', 'image' => 'header-fundraising.svg', 'imageMarginBottom' => -15),
      array('title' => 'แหล่งข้อมูลระดมทุน', 'url' => '/media', 'image' => 'header-media.svg', 'imageMarginBottom' => -15),
      array('title' => 'SEC Event', 'url' => '/event', 'image' => 'header-event.svg', 'imageMarginBottom' => -45),
      array('title' => 'คลินิกระดมทุน', 'url' => '/contact', 'image' => 'header-contact.svg', 'imageMarginBottom' => -5),
      array('title' => 'ก.ล.ต. กับ SMEs', 'url' => '/vision', 'image' => 'header-vision.svg', 'imageMarginBottom' => -20),
    );
  }}
@endphp

<div id="sidenav-backdrop"></div>
<div id="sidenav-menu" class="sidenav-menu">
  <a href="javascript:void(0)" id="close-button" onclick="closeNav()">&times;</a>

  @foreach ($menuDataList as $menuData)
    <div class="d-flex justify-content-between align-items-center"
         style="height: 60px; overflow-y: hidden; overflow-x: hidden"
         onclick="handleClickMenuItem('{{ $menuData['url'] }}')">
      <a href="javascript:void(0)">{{ $menuData['title'] }}</a>
      @if ($menuData['image'] === null)
        <span>&nbsp;</span>
      @else
        <img src="{{ asset('images/' . $menuData['image']) }}"
             style="width: 75px; margin-bottom: {{ $menuData['imageMarginBottom'] }}px">
      @endif
    </div>
@endforeach

<!--  <a href="javascript:void(0)" onclick="return handleClickSideNavMenuItem(1)">สำรวจตัวเอง</a>
    <a href="javascript:void(0)" onclick="return handleClickSideNavMenuItem(2)">เครื่องมือระดมทุน</a>
    <a href="javascript:void(0)" onclick="return handleClickSideNavMenuItem(3)">แหล่งข้อมูลระดมทุน</a>
    <a href="javascript:void(0)" onclick="return handleClickSideNavMenuItem(4)">SEC Event</a>
    <a href="javascript:void(0)" onclick="return handleClickSideNavMenuItem(5)">คลินิกระดมทุน</a>
    <a href="javascript:void(0)" onclick="return handleClickSideNavMenuItem(6)">ก.ล.ต. กับ SMEs</a>-->
</div>

<div id="sidenav-main">
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
            <a href="/contact">ติดต่อเรา <img src="/images/ar_ftbtn.svg"></a>
          </div>
        </div>
        <div class="row row_bot_footer">
          <div class="col-12 col-md-5 botlogoandsocial">
            <img src="/images/footer-logo.svg">
            <a target="_blank" href="https://www.facebook.com/sec.or.th"><img src="/images/001-facebook.svg"></a>
            <a target="_blank" href="https://www.youtube.com/user/insideSEC"><img src="/images/002-youtube.svg"></a>
            <a target="_blank" href="https://twitter.com/ThaiSEC_News"><img src="/images/003-twitter.svg"></a>
            <p>สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์
              333/3 ถนนวิภาวดีรังสิต แขวงจอมพล เขตจตุจักร กรุงเทพมหานคร 10900</p>
          </div>
          <div class="col-12 col-md-7">
            <div class="row">
              <div class="col-12 col-md-4">
                <ul class="footer_menu">
                  <li><h4><a href="/fundraising" style="color: white">เครื่องมือระดมทุน</a></h4></li>
                  <li><a href="/fundraising">ต้องการกู้ยืมเงินจากผู้ลงทุน</a></li>
                  <li><a href="/fundraising">ต้องการหาคนร่วมลงทุนเป็นเจ้าของ</a></li>
                  <li><a href="/fundraising">วิสาหกิจเพื่อสังคม</a></li>
                </ul>
              </div>
              <div class="col-12 col-md-4">
                <ul class="footer_menu">
                  <li><h4><a href="/media" style="color: white">แหล่งข้อมูลระดมทุน</a></h4></li>
                  <li><a href="/media">สื่อการเรียนรู้ระดมทุน</a></li>
                  <li><a href="/media">บทความที่เกี่ยวข้อง</a></li>
                  <li><a href="/media">ข้อมูลที่ต้องรู้</a></li>
                </ul>
              </div>
              <div class="col-12 col-md-4">
                <ul class="footer_menu">
                  <li><h4><a href="/event" style="color: white">SEC Event</a></h4></li>
                  <li><a href="/event">Seminar</a></li>
                  <li><a href="/event">Webinar</a></li>
                  <li><a href="/event">Business Matching</a></li>
                  <li><a href="/event">คลินิกระดมทุน</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col-12 cookie-trigger">
            <small>นโยบายความเป็นส่วนตัว</small>
          </div>
        </div>
        <div class="row">
          <div class="col-12 copyright">
            <small>&copy; {{ date('Y') }} Securities & Exchange Commission, Thailand. All rights reserved. เว็บไซต์นี้แสดงผลได้ดีบน Microsoft Edge, Chrome, Safari และ Firefox</small>
          </div>
        </div>
      </div>
    </div>
  </footer>
  {{--</div>--}}
</div>

{{--
  <!--cookie modal-->
  <div id="cookie-modal-backdrop" class="">
    <div class="cookie-modal">
      <div class="cookie-modal-content">
        <h2>การใช้คุกกี้</h2>
        <p>
          ก.ล.ต. ใช้คุกกี้จำเป็นเพื่อการทำงานของเว็บไซต์
          และอาจใช้คุกกี้ชนิดจดจำข้อมูลซึ่งคุณสามารถเลือกเปิดหรือปิดการใช้งานได้
          เพื่อใช้ในการปรับปรุงประสิทธิภาพเว็บไซต์ โดย ก.ล.ต.
          จะไม่ใช้คุกกี้ชนิดนี้หากคุณเลือกปิดการใช้งาน การใช้เครื่องมือนี้
          จะติดตั้งคุกกี้บนอุปกรณ์ของคุณเพื่อที่จะจดจำข้อมูลการตั้งค่าต่างๆ
        </p>
        <p>
          <strong>สำหรับรายละเอียดเพิ่มเติมเกี่ยวกับคุกกี้ที่ ก.ล.ต. ใช้ สามารถดูได้ที่หน้าเว็บ
            <a href="/policy.html" target="_blank">“คุกกี้”</a></strong>
        </p>
        <hr>
        <h2>คุกกี้ที่จำเป็น</h2>
        <p>
          คุกกี้เหล่านี้ที่จำเป็นในการเปิดใช้คุณลักษณะการทำงานพื้นฐานของเว็บไซต์ เช่น
          การรักษาความปลอดภัย การบริหารจัดการเครือข่าย การเข้าสู่ระบบ
          คุณสามารถปิดการใช้งานคุกกี้เหล่านี้ได้ด้วยการตั้งค่าในเว็บเบราว์เซอร์
          แต่การตั้งค่าดังกล่าวอาจส่งผลต่อการทำงานของเว็บไซต์
        </p>
        <hr>
        <div style="display: flex; align-items: center; justify-content: space-between; margin: 0.83em 0;">
          <h2 style="margin: 0">คุกกี้วิเคราะห์</h2>
          <div class="cc-switch" style="color: #fff;">
            <label class="toggle">
              <input
                  id="cc-ga-switch-input"
                  class="toggle-checkbox"
                  type="checkbox"
              >
              <span class="toggle-label -on">เปิด</span>
              <span class="toggle-label -off">ปิด</span>
              <div class="toggle-switch"></div>
            </label>
          </div>
        </div>
        <p>
          ก.ล.ต. ใช้คุกกี้ Google Analytics เพื่อการปรับปรุงประสิทธิภาพของเว็บไซต์
          โดยรวบรวมและรายงานข้อมูลการใช้งานเว็บไซต์ของคุณ
          คุกกี้ดังกล่าวจะเก็บข้อมูลที่ไม่ระบุตัวบุคคลโดยตรง
        </p>
        <p>
          <strong>สำหรับรายละเอียดเพิ่มเติมเกี่ยวกับการทำงานของคุกกี้ชนิดนี้ สามารถดูได้ที่หน้าเว็บ
            <a href="/policy.html" target="_blank">“คุกกี้”</a></strong>
        </p>

        <div style="text-align: center;">
          <button id="cc-save-button">
            บันทึกและปิด
          </button>
        </div>
      </div>
    </div>
  </div>
--}}

<div id="cc-control-panel">
  <div class="cc-container">
    <h2>การใช้คุกกี้</h2>
    <p>
      ก.ล.ต. ใช้คุกกี้จำเป็นเพื่อการทำงานของเว็บไซต์
      และอาจใช้คุกกี้ชนิดจดจำข้อมูลซึ่งคุณสามารถเลือกเปิดหรือปิดการใช้งานได้
      เพื่อใช้ในการปรับปรุงประสิทธิภาพเว็บไซต์ โดย ก.ล.ต.
      จะไม่ใช้คุกกี้ชนิดนี้หากคุณเลือกปิดการใช้งาน การใช้เครื่องมือนี้
      จะติดตั้งคุกกี้บนอุปกรณ์ของคุณเพื่อที่จะจดจำข้อมูลการตั้งค่าต่างๆ
    </p>
    <p>
      สำหรับรายละเอียดเพิ่มเติมเกี่ยวกับคุกกี้ที่ ก.ล.ต. ใช้ สามารถดูได้ที่หน้าเว็บ
      <a href="/privacy-policy">“คุกกี้”</a>
    </p>
    <hr>
    <h2>คุกกี้ที่จำเป็น</h2>
    <p>
      คุกกี้เหล่านี้ที่จำเป็นในการเปิดใช้คุณลักษณะการทำงานพื้นฐานของเว็บไซต์ เช่น
      การรักษาความปลอดภัย การบริหารจัดการเครือข่าย การเข้าสู่ระบบ
      คุณสามารถปิดการใช้งานคุกกี้เหล่านี้ได้ด้วยการตั้งค่าในเว็บเบราว์เซอร์
      แต่การตั้งค่าดังกล่าวอาจส่งผลต่อการทำงานของเว็บไซต์
    </p>
    <hr>
    <div style="display: flex; align-items: center; justify-content: space-between; margin: 0.83em 0; color: #fff;">
      <h2 style="margin: 0">คุกกี้วิเคราะห์</h2>
      <div class="cc-switch" style="color: #fff;">
        <label class="toggle">
          <input
              id="cc-ga-switch-input"
              class="toggle-checkbox"
              type="checkbox"
          >
          <span class="toggle-label -on">เปิด</span>
          <span class="toggle-label -off">ปิด</span>
          <div class="toggle-switch"></div>
        </label>
      </div>
    </div>
    <p>
      ก.ล.ต. ใช้คุกกี้ Google Analytics เพื่อการปรับปรุงประสิทธิภาพของเว็บไซต์
      โดยรวบรวมและรายงานข้อมูลการใช้งานเว็บไซต์ของคุณ
      คุกกี้ดังกล่าวจะเก็บข้อมูลที่ไม่ระบุตัวบุคคลโดยตรง
    </p>
    <p>
      สำหรับรายละเอียดเพิ่มเติมเกี่ยวกับการทำงานของคุกกี้ชนิดนี้ สามารถดูได้ที่หน้าเว็บ
      <a href="/privacy-policy">“คุกกี้”</a>
    </p>
    <hr>
    <div style="text-align: right;">
      <button id="cc-save" class="cc-button">
        บันทึกและปิด
      </button>
    </div>
  </div>
</div>
<div id="cc-backdrop"></div>
<div id="cc-panel-trigger">
  <svg
      xmlns="http://www.w3.org/2000/svg"
      x="0px"
      y="0px"
      viewBox="0 0 72.5 72.5"
      enable-background="new 0 0 72.5 72.5"
      xml:space="preserve"
  ><title>นโยบายความเป็นส่วนตัว</title>
    <g id="cc-icon-triangle">
      <path d="M0,0l72.5,72.5H0V0z"></path>
    </g>
    <g id="cc-icon-star">
      <path
          d="M33.2,51.9l-3.9-2.6l1.6-4.4l-4.7,0.2L25,40.6l-3.7,2.9l-3.7-2.9l-1.2,4.5l-4.7-0.2l1.6,4.4l-3.9,2.6l3.9,2.6l-1.6,4.4l4.7-0.2l1.2,4.5l3.7-2.9l3.7,2.9l1.2-4.5l4.7,0.2l-1.6-4.4L33.2,51.9z M24.6,55.3c-0.3,0.4-0.8,0.8-1.3,1s-1.1,0.3-1.9,0.3c-0.9,0-1.7-0.1-2.3-0.4s-1.1-0.7-1.5-1.4c-0.4-0.7-0.6-1.6-0.6-2.6c0-1.4,0.4-2.5,1.1-3.3c0.8-0.8,1.8-1.1,3.2-1.1c1.1,0,1.9,0.2,2.6,0.7s1.1,1.1,1.4,2L23,50.9c-0.1-0.3-0.2-0.5-0.3-0.6c-0.1-0.2-0.3-0.4-0.5-0.5s-0.5-0.2-0.7-0.2c-0.6,0-1.1,0.2-1.4,0.7c-0.2,0.4-0.4,0.9-0.4,1.7c0,1,0.1,1.6,0.4,2c0.3,0.4,0.7,0.5,1.2,0.5c0.5,0,0.9-0.1,1.2-0.4s0.4-0.7,0.6-1.2l2.3,0.7C25.2,54.3,25,54.8,24.6,55.3z"></path>
    </g>
  </svg>
</div>

{{--@include('includes.chatbot')--}}

<script src="{{ asset('js/vendor/modernizr-3.8.0.min.js') }}"></script>
<!--<script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>-->
<script>window.jQuery || document.write('<script src="{{ asset('js/vendor/jquery-3.5.1.min.js') }}"><\/script>')</script>
<script src="{{ asset('js/plugins.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-RZGG9Z7RZC"></script>
<script src="{{ asset('js/cookie-consent.js?v=2') }}"></script>

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
  const SIDE_NAV_WIDTH_MD = 300;
  const SIDE_NAV_WIDTH_SM = 300;

  let isSideNavOpen = false;
  let $sideNavBackdrop, $sideNavMenu, $sideNavMain, $topNav, $closeButton;
  let $logo, $header, $menuItem, $iconLabel, $imgSearch, $hamburgerInner;

  $(function () {
    $searchForm = $('#searchForm');
    $searchButton = $('#searchButton');
    $searchTerm = $('#searchTerm');
    $checkList = [$('#fundraisingCheck'), $('#mediaCheck'), $('#eventCheck')];
    $searchButton.on('click', () => {
      const isCheckValid = ($checkList[0].is(':checked')
        || $checkList[1].is(':checked')
        || $checkList[2].is(':checked'));

      if ($searchTerm.val().trim() === '' || !isCheckValid) {
        alert('ต้องกรอกคำค้น และเลือกประเภทเนื้อหาอย่างน้อย 1 ประเภท');
        return;
      }
      $searchForm.submit();
    });

    $sideNavBackdrop = $('#sidenav-backdrop');
    $sideNavMenu = $('.sidenav-menu');
    $sideNavMain = $('#sidenav-main');
    $topNav = $('.my-navbar');
    $closeButton = $('#close-button');
    $logo = $('.my-navbar .logo');
    $header = $('.my-navbar .header');
    $menuItem = $('.my-navbar .menu-item');
    $iconLabel = $('.my-navbar .icon-label');
    $imgSearch = $('.my-navbar .img-search');
    $hamburgerInner = $('.hamburger-inner');

    $sideNavBackdrop.on('click', () => {
      closeNav();
      const hamburgerButton = $('#menu-item-menu button')
      if (Modernizr.mq('(min-width: 768px)')) {
        hamburgerButton.toggleClass("is-active");
      }
    });

    if (Modernizr.mq('(min-width: 768px)')) {
      $sideNavMenu.css('top', $topNav.css('height'));
      $closeButton.hide();
    } else {
      $closeButton.show();
    }

    window.onload = function (e) {
      adjustNavBar();
    }
    window.onscroll = function (e) {
      adjustNavBar();
    };
    window.onresize = function (e) {
      if (Modernizr.mq('(min-width: 768px)')) {
        $closeButton.hide();
        adjustNavBar();
      } else {
        $closeButton.show();
      }
    };
  });

  function toggleSideNav() {
    isSideNavOpen ? closeNav() : openNav();
  }

  /* Set the width of the side navigation to 250px and the left margin of the page content to 250px and add a black background color to body */
  function openNav() {
    const sideNavWidth = Modernizr.mq('(min-width: 768px)') ? SIDE_NAV_WIDTH_MD : SIDE_NAV_WIDTH_SM;
    isSideNavOpen = true;

    if (Modernizr.mq('(min-width: 450px)')) {
      $sideNavMenu.css('width', `${sideNavWidth}px`);
    } else {
      $sideNavMenu.css('width', `100%`);
    }

    if (Modernizr.mq('(min-width: 1200px)')) {
      $sideNavMain.css('margin-right', `${sideNavWidth}px`);
    }
    if (Modernizr.mq('(min-width: 768px)')) {
      $sideNavMenu.css('top', $topNav.css('height'));
    }

    $sideNavBackdrop.addClass('-open');
    //document.body.style.backgroundColor = "rgba(0,0,0,0.8)";
  }

  /* Set the width of the side navigation to 0 and the left margin of the page content to 0, and the background color of body to white */
  function closeNav() {
    isSideNavOpen = false;
    $sideNavMenu.css('width', '0');
    $sideNavMain.css('margin-right', '0');
    $sideNavBackdrop.removeClass('-open');
    //document.body.style.backgroundColor = "white";
  }

  const menu = $('#menu-item-menu');
  const hamburgerButton = $('#menu-item-menu button')
  menu.on("click", function (e) {
    if (Modernizr.mq('(min-width: 768px)')) {
      hamburgerButton.toggleClass("is-active");
    }
    // Do something else, like open/close menu
  });

  function adjustNavBar() {
    $logo.css('margin-left', `${$(document).width() * 100 / 1836}px`);

    if (Modernizr.mq('(min-width: 768px)')) {
      if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        $topNav.css('height', '60px');
        //$logo.css('width', '50px');
        $logo.css('height', '38px');
        //$logo.css('margin-left', '72px');
        //$logo.css('margin-top', '14px');
        $header.css('font-size', '16px');
        $header.css('margin', '2px 15px 0');
        $menuItem.css('width', '80px');
        $iconLabel.css('font-size', '12px');
        $iconLabel.addClass('icon-label-hide');
        $imgSearch.css('width', '26px');
        $hamburgerInner.addClass('hamburger-width-small');
      } else {
        $topNav.css('height', '100px');
        //$logo.css('width', '57px');
        $logo.css('height', '60px');
        //$logo.css('margin-left', '72px');
        //$logo.css('margin-top', '18px');
        $header.css('font-size', '20px');
        $header.css('margin', '0 25px');
        $menuItem.css('width', '140px');
        $iconLabel.css('font-size', '14px');
        $iconLabel.removeClass('icon-label-hide');
        $imgSearch.css('width', '34px');
        $hamburgerInner.removeClass('hamburger-width-small');
      }
      setTimeout(() => {
        $sideNavMenu.css('top', $topNav.css('height'));
      }, 100);
    } else {
      $logo.css('height', '38px');
      //$logo.css('margin-top', '14px');
    }
    //$logo.show();
  }

  function handleClickMenuItem(url) {
    closeNav();
    setTimeout(() => {
      window.location.href = url;
    }, 300);
  }
</script>

<script>
  // On ready
  $(document).ready(() => {
    $(".chat_on").click(function () {
      $(".Layout").show();
      $(".chat_on").hide(300);
    });

    $(".chat_close_icon").click(function () {
      $(".Layout").hide();
      $(".chat_on").show(300);
    });

    window.cookieManager = {
      write: (key, value) => {
        document.cookie = `${key}=${encodeURIComponent(JSON.stringify(value))}; path=/`
      },
      read: key => {
        const match = document.cookie.match(`(^|[^;]+)\\s*${key}\\s*=\\s*([^;]+)`)
        if (!match) return undefined
        return JSON.parse(match.pop())
      },
    }

    window.COOKIE_KEYS = {
      AUTO_SHOW: 'CC_AUTO_SHOW',
      ALLOW_GA: 'CC_ALLOW_GA',
    }

    const $ccBackdrop = $('#cookie-modal-backdrop')
    const $ccModal = $('#cookie-modal-backdrop .modal')
    const $ccModalTriggerButton = $('.cookie-trigger small')
    const $ccGaSwitchInput = $('#cc-ga-switch-input')
    const $ccSaveButton = $('#cc-save-button')

    const panel = {
      open: () => {
        $ccBackdrop.addClass('open')
        //window.ccState.panelOpen = true
      },
      close: () => {
        $ccBackdrop.removeClass('open')
        //window.ccState.panelOpen = false

        // Save state that autoShow has been done
        if (!cookieManager.read(COOKIE_KEYS.AUTO_SHOW)) {
          cookieManager.write(COOKIE_KEYS.AUTO_SHOW, true)
        }
      },
      save: () => {
        const allowGa = $ccGaSwitchInput.is(':checked')
        cookieManager.write(COOKIE_KEYS.ALLOW_GA, allowGa)

        // init GA right away if ga is allow and not initialized before
        if (allowGa && typeof ga === 'undefined') {
          initGA()
        }
      },
    }

    $ccModalTriggerButton.on('click', event => {
      panel.open()
    })
    $ccBackdrop.on('click', function (event) {
      if ($(this).is(event.target)) panel.close()
    })
    $ccModal.on('click', () => {
      //alert('no')
    })
    $ccSaveButton.on('click', event => {
      event.preventDefault()
      panel.save()
      panel.close()
    })

    const autoShow = cookieManager.read(COOKIE_KEYS.AUTO_SHOW)
    const allowGA = cookieManager.read(COOKIE_KEYS.ALLOW_GA)

    if (!autoShow) {
      //todo: ถ้าจะให้แสดงหน้า cookie อัตโนมัติตอนเข้าเว็บครั้งแรก ให้ลบ comment บรรทัดนี้ออก
      panel.open()
    }

    if (allowGA) {
      $ccGaSwitchInput.prop('checked', true)
      initGA()
    }
  })

  function initGA() {
    return;
    console.log('Initializing Google Analytics...');

    (function (i, s, o, g, r, a, m) {
      i['GoogleAnalyticsObject'] = r
      i[r] = i[r] || function () {
        (i[r].q = i[r].q || []).push(arguments)
      }, i[r].l = 1 * new Date()
      a = s.createElement(o),
        m = s.getElementsByTagName(o)[0]
      a.async = 1
      a.src = g
      m.parentNode.insertBefore(a, m)
    })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga')

    ga('create', 'UA-XXXXX-Y', 'auto') // todo: change Tracking ID ***********************
    ga('send', 'pageview')
  }
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-191155952-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];

  function gtag() {
    dataLayer.push(arguments);
  }

  gtag('js', new Date());
  gtag('config', 'UA-191155952-1');
</script>

<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

</html>
