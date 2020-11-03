@extends('layouts.master')

@section('head')
@endsection

@section('content')
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
      <div class="col-12 headpage headpage_detail_wol">
        <a href="/media">&#60; กลับ</a>
      </div>
      <div class="col-12 wrap_video wrap_video_wl">
        <div>
          {!! $item->content !!}
        </div>
        <h2>{{ $item->title }}</h2>
        <p>{{ $item->description }}</p>
      </div>

      {{--<div class="col-12 relate_fd">
        <h3>วิดีโอที่เกี่ยวข้อง</h3>
        <div class="row">
          <figure class="col-12 col-md-4 item_fundraising">
            <a href="media-detail.php">
              <div><img src="img/info01.png"></div>
              <figcaption>
                <h4>EP.2 แหล่งเงินทุนของผู้ประกอบการ</h4>
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
  //https://ckeditor.com/docs/ckeditor5/latest/features/media-embed.html#displaying-embedded-media-on-your-website
@endsection
