@extends('layouts.master')

@section('head')
@endsection

@section('content')
  @include('includes.header', [
    'title' => 'SEARCH RESULTS',
    'imageSrc' => 'images/bc-media.png',
  ])

  <section class="container">
    <div class="row">
      <!--ข้อมูลที่ต้องรู้-->
      <div class="col-12 headpage">
        <h2>ผลการค้นหา</h2>
        <p style="margin-bottom: 20px">{{ $fundraisingCheck }} {{ $mediaCheck }} {{ $eventCheck }}</p>
      </div>
    </div>

    <div class="row all_relate">
      <div class="col-12 relate_fd">
        <h3>เครื่องมือระดมทุน</h3>
        <p>ผลการค้นหาเนื้อหาประเภท "เครื่องมือระดมทุน"</p>
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
      <div class="col-12 relate_fd">
        <h3>แหล่งข้อมูลระดมทุน</h3>
        <p>ผลการค้นหาเนื้อหาประเภท "แหล่งข้อมูลระดมทุน"</p>
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
      <div class="col-12 relate_fd">
        <h3>SEC Event</h3>
        <p>ผลการค้นหาเนื้อหาประเภท "SEC Event"</p>
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
