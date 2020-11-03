@extends('layouts.master')

@section('head')
@endsection

@section('content')
  <?php
  define('MEDIA_CATEGORY', 'media-category-');
  ?>
  <section class="container-fluid bg_breadcrumb">
    <div class="row">
      <div class="container">
        <div class="row">
          <div class="col-12 pagebreadcrumb">
            <a href="/">&#60; กลับหน้าแรก</a>
            <h1>แหล่งข้อมูลระดมทุน</h1>
            <img src="/images/bc-media.png" class="img_breadcrumb">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="container">
    <div class="row">
      <div class="col-12 headpage">
        <h2>สื่อการเรียนรู้ระดมทุน</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Netus rutrum facilisi interdum ut pulvinar ut egestas quam eget. Non, consequat at magna scelerisque neque vulputate. Vitae, nec sit
          mauris dui dui eu sed odio. Adipiscing nunc nibh maecenas quam congue tristique amet semper. Turpis felis eu ac tempus, ac. Morbi quis dui at metus purus tincidunt tortor rhoncus. Convallis
          massa pharetra ac lobortis.</p>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-4 isp_sidebar">
        <ul>
          @for ($i = 0; $i < count($mediaCategoryList); $i++)
            @if (count($mediaCategoryList[$i]->media) > 0)
              <li class="{{ $i === 0 ? 'active' : '' }}">
                <a href="#{{ MEDIA_CATEGORY.$mediaCategoryList[$i]->id }}">
                  {{ $mediaCategoryList[$i]->title }}
                </a>
              </li>
            @endif
          @endfor
        </ul>
      </div>

      @foreach ($mediaCategoryList as $mediaCategory)
      <div class="col-12 col-md-8 detail_fundraising detail_hide" id="{{ MEDIA_CATEGORY.$mediaCategory->id }}">
        <div class="row">
          @foreach ($mediaCategory->media as $media)
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
      @endforeach
    </div>

    <div class="row all_relate">
      <!--บทความที่เกี่ยวข้อง-->
      <div class="col-12 relate_fd">
        <h3>บทความที่เกี่ยวข้อง</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Netus rutru</p>
        <div class="row">
          <figure class="col-12 col-md-4 item_fundraising">
            <a href="media-detail.php">
              <div><img src="img/info01.png"></div>
              <figcaption>
                <h4>Minimal workspace for inspirations</h4>
                <p>Anthony Masional</p>
              </figcaption>
            </a>
          </figure>
          <figure class="col-12 col-md-4 item_fundraising">
            <a href="media-detail.php">
              <div><img src="img/info01.png"></div>
              <figcaption>
                <h4>Minimal workspace for inspirations</h4>
                <p>Anthony Masional</p>
              </figcaption>
            </a>
          </figure>
          <figure class="col-12 col-md-4 item_fundraising">
            <a href="media-detail.php">
              <div><img src="img/info01.png"></div>
              <figcaption>
                <h4>Minimal workspace for inspirations</h4>
                <p>Anthony Masional</p>
              </figcaption>
            </a>
          </figure>
        </div>
      </div>

      <!--ลิ้งค์อื่นๆ ที่เกี่ยวข้อง-->
      <div class="col-12 relate_fd">
        <h3>ลิ้งค์อื่นๆ ที่เกี่ยวข้อง</h3>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Netus rutru</p>
        <div class="row">
          <figure class="col-12 col-md-4 item_fundraising">
            <a href="media-detail.php">
              <div><img src="img/info01.png"></div>
              <figcaption>
                <h4>Minimal workspace for inspirations</h4>
                <p>Anthony Masional</p>
              </figcaption>
            </a>
          </figure>
          <figure class="col-12 col-md-4 item_fundraising">
            <a href="media-detail.php">
              <div><img src="img/info01.png"></div>
              <figcaption>
                <h4>Minimal workspace for inspirations</h4>
                <p>Anthony Masional</p>
              </figcaption>
            </a>
          </figure>
          <figure class="col-12 col-md-4 item_fundraising">
            <a href="media-detail.php">
              <div><img src="img/info01.png"></div>
              <figcaption>
                <h4>Minimal workspace for inspirations</h4>
                <p>Anthony Masional</p>
              </figcaption>
            </a>
          </figure>
        </div>
      </div>
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
  <script>
    $(document).ready(function () {
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
