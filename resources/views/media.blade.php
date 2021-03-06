@extends('layouts.master')

@section('head')
@endsection

@section('content')
  <?php
  define('MEDIA_CATEGORY', 'media-category-');
  ?>

  @include('includes.header', [
    'class' => 'media',
    'title' => 'แหล่งข้อมูลระดมทุน',
    'imageSrc' => 'images/header-media.svg',
    'bottom' => -15,
  ])

  <section class="container">
    <div class="row">
      <!--ข้อมูลที่ต้องรู้-->
      <div class="col-12 headpage">
        <h2>ข้อมูลที่ต้องรู้</h2>
        <p>ข้อมูลสำคัญสำหรับผู้ระดมทุนและผู้ลงทุน</p>
        <div class="row">
          @for ($i = 0; $i < count($mediaCategoryList); $i++)
            @if ($mediaCategoryList[$i]->id === 2)
              @foreach ($mediaCategoryList[$i]->media as $media)
                <figure class="col-12 col-md-4 item_fundraising">
                  <a href="media/{{ $media->id }}">
                    <div><img src="{{ Storage::url($media->cover_image) }}"></div>
                    <figcaption>
                      <h4>{{ $media->title }}</h4>
                      <p>{{ $media->description }}</p>
                    </figcaption>
                  </a>
                </figure>
              @endforeach
            @endif
          @endfor
        </div>
      </div>

      <div class="col-12 headpage">
        <h2>สื่อการเรียนรู้ระดมทุน</h2>
        <p>ท่านสามารถรับชมคลิปวิดีโอที่มีเนื้อหาเกี่ยวข้องกับการระดมทุนในรูปแบบต่าง ๆ ตามที่ท่านต้องการได้ โดยในแต่ละหัวข้อจะแบ่งออกเป็นเรื่องย่อยที่มีเนื้อหาเกี่ยวข้องกัน
          เพื่อท่านเห็นภาพกระบวนการระดมทุนในหลากหลายรูปแบบได้อย่างชัดเจนมากยิ่งขึ้น รวมถึงมีความเข้าใจและนำไปสู่การเตรียมความพร้อมในการเข้าระดมทุนผ่านตลาดทุนได้ในที่สุด</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-4 isp_sidebar">
        <ul>
          @for ($i = 0; $i < count($mediaCategoryList); $i++)
            @if (count($mediaCategoryList[$i]->media) > 0 && $mediaCategoryList[$i]->id > 2)
              <li class="{{ $mediaCategoryList[$i]->sort_index === 1 ? 'active' : '' }}">
                <a href="#{{ MEDIA_CATEGORY.$mediaCategoryList[$i]->id }}">
                  {{ $mediaCategoryList[$i]->title }}
                  <span class="chevron-down" style="float: right"><i class="fa fa-chevron-down"></i></span>
                </a>
              </li>
            @endif
          @endfor
        </ul>
      </div>

      @for ($i = 0; $i < count($mediaCategoryList); $i++)
        @if (count($mediaCategoryList[$i]->media) > 0 && $mediaCategoryList[$i]->id > 2)
          <div class="col-12 col-md-8 detail_fundraising detail_hide" id="{{ MEDIA_CATEGORY.$mediaCategoryList[$i]->id }}">
            <div class="row">
              @foreach ($mediaCategoryList[$i]->media as $media)
                <figure class="col-12 col-md-6 item_fundraising">
                  <a href="media/{{ $media->id }}">
                    <div><img src="{{ Storage::url($media->cover_image) }}"></div>
                    <figcaption>
                      <h4>{{ $media->title }}</h4>
                      <p>{{ $media->description }}</p>
                    </figcaption>
                  </a>
                </figure>
              @endforeach
            </div>
          </div>
        @endif
      @endfor
    </div>

    <div class="row all_relate">
      <!--บทความที่เกี่ยวข้อง-->
      <div class="col-12 relate_fd">
        <h3>บทความที่เกี่ยวข้อง</h3>
        <p>แหล่งรวมสาระและความรู้ที่จะทำให้ทุกเรื่องของการระดมทุนผ่านตลาดทุนเป็นเรื่องที่เข้าใจง่าย</p>
        <div class="row">
          @for ($i = 0; $i < count($mediaCategoryList); $i++)
            @if ($mediaCategoryList[$i]->id === 1)
              @foreach ($mediaCategoryList[$i]->media as $media)
                <figure class="col-12 col-md-4 item_fundraising">
                  <a href="media/{{ $media->id }}">
                    <div><img src="{{ Storage::url($media->cover_image) }}"></div>
                    <figcaption>
                      <h4>{{ $media->title }}</h4>
                      <p>{{ $media->description }}</p>
                    </figcaption>
                  </a>
                </figure>
              @endforeach
            @endif
          @endfor
        </div>
      </div>
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
  <script>
    $(document).ready(function () {
      const $chevronDown = $('.chevron-down');

      function handleResizeWindow() {
        if (Modernizr.mq('(max-width: 767px)')) {
          $chevronDown.show();
        } else {
          $chevronDown.hide();
        }
      }

      handleResizeWindow();
      $(window).resize(function () {
        handleResizeWindow();
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
        if ($('.detail_fundraising' + targetId).is(':hidden')) {
          $('.detail_fundraising').hide();
          $('.detail_fundraising' + targetId).fadeIn();
          $('.isp_sidebar ul li').removeClass('active');
          $(this).parent('li').addClass('active');
        } else {

        }
        event.preventDefault();
      });
    });
  </script>
@endsection
