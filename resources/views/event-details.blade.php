@extends('layouts.master')

@section('head')
  <style>
    @media (min-width: 576px) {
      .mw-300 {
        min-width: 140px;
      }
    }
    @media (min-width: 768px) {
      .mw-300 {
        min-width: 200px;
      }
    }
    @media (min-width: 992px) {
      .mw-300 {
        min-width: 300px;
      }
    }
  </style>
@endsection

@section('content')
  @include('includes.header', [
    'class' => 'event',
    'title' => 'SEC EVENT',
    'imageSrc' => '../images/header-event.svg',
    'bottom' => -165,
  ])

  <section class="container">
    <div class="row">
      <div class="col-12 headpage headpage_detail">
        <a href="/event">&#60; กลับ</a>
        <h2>{{ $item->title }}</h2>
        <p>{{ $item->description }}</p>
      </div>
      {{--<div class="col-12 wrap_video">
        <div>
          <iframe src="https://www.youtube.com/embed/ygv5NWJDpz8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen></iframe>
        </div>
      </div>--}}
      <div class="col-12 detailfd_text">
        {!! $item->content !!}
      </div>

      {{--<div class="col-12 relate_fd">
        <h3>เนื้อหาที่เกี่ยวข้อง</h3>
        <div class="row">
          <figure class="col-12 col-md-4 item_fundraising">
            <a href="#">
              <div><img src="img/Rectangle%2039.jpg"></div>
              <figcaption>
                <h4>หุ้น (ไม่มีรายย่อย)</h4>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Netus rutrum facilisi interdum ut </p>
              </figcaption>
            </a>
          </figure>
        </div>
      </div>--}}
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
  <!--https://ckeditor.com/docs/ckeditor5/latest/features/media-embed.html#displaying-embedded-media-on-your-website-->
@endsection
