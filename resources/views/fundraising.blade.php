@extends('layouts.master')

@section('head')
@endsection

@section('content')
  <?php
  define('FUNDRAISING_CATEGORY', 'fundraising-category-');
  ?>

  @include('includes.header', [
    'title' => 'เครื่องมือระดมทุน',
    'imageSrc' => 'images/bc-fundraising.png',
  ])

  <section class="container">
    <div class="row">
      <div class="col-12 headpage">
        <h2>รู้จักเครื่องมือระดมทุน</h2>
        <p>สำหรับท่านที่ต้องการระดมเงินทุนผ่านตลาดทุน โดยเฉพาะอย่างยิ่งหากท่านเป็นผู้ประกอบการ SME หรือ Startup ต้องทำความรู้จักกับ “ผลิตภัณฑ์” ซึ่งถือเป็นเครื่องมือที่จะเสนอขายให้แก่ผู้ลงทุน และช่วยให้ท่านได้มาซึ่งเงินทุนสำหรับนำไปใช้ดำเนินธุรกิจหรือขยายกิจการต่อไป โดยปกติแล้วการที่จะออกผลิตภัณฑ์เพื่อการระดมทุนเหล่านี้ได้ อย่างน้อยท่านต้องประกอบธุรกิจในรูปแบบของ “บริษัทจำกัด” และเริ่มต้นศึกษาวิธีการออกและเสนอขายผลิตภัณฑ์ได้ที่นี่ … แล้วท่านจะรู้ว่าการระดมทุนไม่ใช่เรื่องยากอย่างที่คิด :)</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-4 isp_sidebar">
        <ul>
          @for ($i = 0; $i < count($fundraisingCategoryList); $i++)
            @if (count($fundraisingCategoryList[$i]->fundraisings) > 0)
              <li class="{{ $i === 0 ? 'active' : '' }}">
                <a href="#{{ FUNDRAISING_CATEGORY.$fundraisingCategoryList[$i]->id }}">
                  {{ $fundraisingCategoryList[$i]->title }}
                  <span class="chevron-down" style="float: right"><i class="fa fa-chevron-down"></i></span>
                </a>
              </li>
            @endif
          @endfor
        </ul>
      </div>
      <div class="col-12 col-md-8 detail_fundraising">
        @foreach ($fundraisingCategoryList as $fundraisingCategory)
          @if (count($fundraisingCategory->fundraisings) > 0)
            <div class="row">
              <div class="col-12 section" id="{{ FUNDRAISING_CATEGORY.$fundraisingCategory->id }}">
                <h3>{{ $fundraisingCategory->title }}</h3>
                <p>{{ $fundraisingCategory->description }}</p>
              </div>

              @foreach ($fundraisingCategory->fundraisings as $fundraising)
                @if ($fundraising->published === 1)
                  <figure class="col-12 col-md-6 item_fundraising">
                    <a href="fundraising/{{ $fundraising->id }}">
                      <div><img src="{{ Storage::url($fundraising->cover_image) }}"></div>
                      <figcaption>
                        <h4>{{ $fundraising->title }}</h4>
                        <p>{{ $fundraising->description }}</p>
                      </figcaption>
                    </a>
                  </figure>
                @endif
              @endforeach
            </div>
          @endif
        @endforeach
      </div>
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      const $myNavBar = $('.my-navbar');
      const $chevronDown = $('.chevron-down');

      if (Modernizr.mq('(max-width: 767px)')) {
        $chevronDown.show();
      } else {
        $chevronDown.hide();
      }
      
      $(window).resize(function () {
        if (Modernizr.mq('(max-width: 767px)')) {
          $chevronDown.show();
        } else {
          $chevronDown.hide();
        }
      });

      $('.isp_sidebar ul li').click(function (event) {
        if ($('.isp_sidebar ul li:not(".active")').is(':hidden')) {
          if (Modernizr.mq('(max-width: 767px)')) {
            $('.isp_sidebar ul li').slideDown();
          }
          event.preventDefault();
        } else {
          if (Modernizr.mq('(max-width: 767px)')) {
            $('.isp_sidebar ul li').slideUp();
          }
        }
      });

      $('.isp_sidebar ul li a').click(function () {
        targetId = $(this).attr('href');
        if (Modernizr.mq('(max-width: 767px)')) {
          if ($('.isp_sidebar ul').hasClass('sticky')) {
            targetOffset = $(targetId).offset().top - $myNavBar.outerHeight(true) - $('.isp_sidebar ul li.active').outerHeight(true) + 50;
          } else {
            var isbbaropenh = $('.isp_sidebar ul li').outerHeight(true) * ($('.isp_sidebar ul li').length + 1);
            targetOffset = $(targetId).offset().top - $myNavBar.outerHeight(true) - isbbaropenh;
          }
        } else {
          targetOffset = $(targetId).offset().top - $myNavBar.outerHeight(true) - 15;
        }
        $('html,body').animate({scrollTop: targetOffset}, 200);
      });

      function scrollNav() {
        const scrollPosition = $(window).scrollTop() + $myNavBar.outerHeight(true) + 120;
        $('.section').each(function () {
          const sectionTop = $(this).offset().top;
          const id = $(this).attr('id');

          if (scrollPosition >= sectionTop) {
            $('.isp_sidebar ul li a').parent('li').removeClass('active');
            $('.isp_sidebar ul li a[href="#' + id + '"]').parent('li').addClass('active');
          }
        });

        const boxFilter = $(".isp_sidebar ul");
        const offsetTop = $('.detail_fundraising').offset().top - $('.my-navbar').outerHeight(true) + 30;
        if ($(this).scrollTop() > offsetTop) {
          boxFilter.addClass('sticky');
          boxFilter.css({
            //'width': $('.container').outerWidth() - $('.detail_fundraising').outerWidth(),
            //'left': $('.container').offset().left,
            'top': $(this).scrollTop() + $('.my-navbar').height() - offsetTop,
          });
        } else {
          boxFilter.removeClass('sticky');
        }
      }

      $(window).scroll(function () {
        scrollNav();
      });
    });
  </script>
@endsection
