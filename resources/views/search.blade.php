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
      </div>
    </div>

    @php
    {{
    $searchResultList = array(
      array(
        'title' => 'เครื่องมือระดมทุน',
        'model' => 'fundraising',
        'dataList' => $fundraisingList,
      ),
      array(
        'title' => 'แหล่งข้อมูลระดมทุน',
        'model' => 'media',
        'dataList' => $mediaList,
      ),
      array(
        'title' => 'SEC Event',
        'model' => 'event',
        'dataList' => $eventList,
      ),
    );
    }}
    @endphp

    <div class="row all_relate">
      @foreach ($searchResultList as $result)
        @if ($result['dataList'] !== null)
          <div class="col-12 relate_fd">
            <h3>{{ $result['title'] }}</h3>
            <p>ผลการค้นหา <strong>‘{{ $searchTerm }}’</strong> ใน ‘{{ $result['title'] }}’</p>
            @if (count($result['dataList']) === 0)
              <p>ไม่พบข้อมูล</p>
            @else
              <div class="row">
                @foreach ($result['dataList'] as $item)
                  <figure class="col-12 col-md-4 item_fundraising">
                    <a href="{{ $result['model'] }}/{{ $item->id }}">
                      <div><img src="{{ Storage::url($item->cover_image) }}"></div>
                      <figcaption>
                        <h4>{{ $item->title }}</h4>
                        <p>{{ $item->description }}</p>
                      </figcaption>
                    </a>
                  </figure>
                @endforeach
              </div>
            @endif
          </div>
        @endif
      @endforeach
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
@endsection
