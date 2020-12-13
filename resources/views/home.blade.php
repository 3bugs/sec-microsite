@extends('layouts.master')

@section('head')
  <link href="{{ asset('css/home.css?v=1') }}" rel="stylesheet">
  <link href="{{ asset('css/my_carousel_style.css') }}" rel="stylesheet">
@endsection

@section('content')
  <div id="app">
    <!--hero banner-->
    <div id="hero-banner" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">

        @for ($i = 0; $i < count($bannerList); $i++)
          <div class="carousel-item {{ $i === 0 ? 'active' : '' }}" onclick="handleClickBannerItem('{{ $bannerList[$i]->url }}')">
            <img class="d-block w-100" src="{{ Storage::url($bannerList[$i]->image) }}"
                 title="{{ $bannerList[$i]->title }}"
                 alt="{{ $bannerList[$i]->title }}">
          </div>
        @endfor
      </div>

      @if (count($bannerList) > 1)
        <a class="carousel-control-prev" href="#hero-banner" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">ก่อนหน้า</span>
        </a>
        <a class="carousel-control-next" href="#hero-banner" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">ถัดไป</span>
        </a>
      @endif
    </div>

  <!--<div class="carousel-item active" onclick="handleClickBannerItem('/survey')">
          <img class="d-block w-100" src="{{ asset('images/big-banner.jpg') }}" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="{{ asset('images/banner.jpg') }}" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block w-100" src="{{ asset('images/big-banner.jpg') }}" alt="Third slide">
        </div>-->

    <!--<div class="hero-container">
      <div class="container">
        <div class="row">
          <div class="col-10 offset-1 text-center">
            <h1>สำรวจตัวเอง</h1>
            <p class="mt-4">ใช้เวลาเพียงเล็กน้อยด้วยการตอบคำถามเพียงไม่กี่ข้อ เพื่อค้นหาช่องทางระดมทุนที่เข้ากับความต้องการของท่าน
              และเมื่อได้รู้แล้วว่าช่องทางไหนที่เหมาะกับท่านก็เริ่มลงมือศึกษากระบวนการระดมทุนเพื่อสานฝันให้เป็นจริงกันได้เลย !</p>
            <button onclick="window.location = '/survey'" style="padding-left: 30px; padding-right: 30px"><h5>เริ่มแบบสำรวจ&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></button>
          </div>
        </div>
      </div>
    </div>-->

    <!--6 flip cards-->
    <div id="flip-card-container">
      <div class="container d-none d-sm-block" style="border: 0px solid red">
        <div class="row">

          @foreach ($cardDataList as $cardData)
            <div class="col-lg-4 col-sm-6 col-12" style="border: 0px solid blue">
              <div class="flip-card mb-4 mb-md-5"
                   style="margin-bottom: 0"
                   onclick="handleClickCard({{ $cardData['id'] }})"
              >
                <div class="flip-card-inner">
                  <div class="flip-card-front">
                    <img
                        src="images/menu0{{ $cardData['id'] }}.svg"
                        alt="menu {{ $cardData['id'] }}"
                        style="width: 100%"
                    >
                    <button style="margin-top: {{ $cardData['buttonMarginTop'] }}px">
                      <h5>{{ $cardData['title'] }}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
                    </button>
                  </div>
                  <div class="flip-card-back">
                    <h5>{{ $cardData['title'] }}&nbsp;<i class="fa fa-chevron-circle-right"></i></h5>
                    <p class="mt-3">
                      {!! $cardData['text'] !!}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <div class="container d-sm-none d-xs-block" style="border: 0px solid red">
        <div class="row">
          @foreach ($cardDataList as $cardData)
            <div class="col-12 d-flex flex-column mb-2">
              <div class="accordion-card">
                <div class="d-flex align-items-center" style="font-size: 24px">
                  <img
                      class="mr-4"
                      src="images/menu0{{ $cardData['id'] }}.svg"
                      alt="menu {{ $cardData['id'] }}"
                      style="width: 65px; height: 65px"
                  >
                  <h3 style="flex: 1; font-size: 1.2rem">{{ $cardData['title'] }}</h3>
                  <i class="fa fa-chevron-circle-down ml-2" style="font-size: 24px"></i>
                </div>
                <div class="accordion-card-hidden flex-column" style="padding: 0; margin: 0 0 12px">
                  <p>{!! $cardData['text'] !!}</p>
                  <button
                      onclick="handleClickCard({{ $cardData['id'] }})"
                  ><h5>{{ $cardData['buttonText'] }}</h5></button>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <!--<div style="display: flex; width: 100%; justify-content: space-evenly">
        <card-item button-text="สำรวจตัวเอง" img-src="images/menu01.svg" img-alt="menu 1"></card-item>
        <card-item button-text="เครื่องมือระดมทุน" img-src="images/menu02.svg" img-alt="menu 2"></card-item>
        <card-item button-text="สื่อการเรียนรู้ระดมทุน" img-src="images/menu03.svg" img-alt="menu 3"></card-item>
      </div>
      <div style="display: flex; width: 100%; justify-content: space-evenly">
        <card-item button-text="SEC Event" img-src="images/menu04.svg" img-alt="menu 4" :margin-bottom="0"></card-item>
        <card-item button-text="คลินิกระดมทุน" img-src="images/menu05.svg" img-alt="menu 5" :button-margin-top="5" :margin-bottom="0"></card-item>
        <card-item button-text="พันธกิจ พันธมิตร" img-src="images/menu06.svg" img-alt="menu 6" :margin-bottom="0"></card-item>
      </div>-->
    </div>

    <!--SEC events-->
    <div id="section-event" style="width: 100%; background: #fff">
      <div class="container mt-md-4 mt-2 mb-md-4 mb-2">
        <div class="row align-items-center no-gutters">
          <div class="col-8 col-md-9 col-lg-10">
            <div class="sec-event-header" style="display: flex; align-items: center">
              <h1>SEC EVENT</h1>
              <div class="d-none d-lg-block">
                @for ($i = 0; $i < 4; $i++)
                  <button
                      :class="selectedEventCategory === {{ $i }} ? 'sec-event-button-active' : 'sec-event-button-inactive'"
                      @click="handleClickCategoryButton({{ $i }})"
                      style="margin-left: {{ $i === 0 ? 30 : 10 }}px"
                  >{{ strtoupper($eventCategoryList[$i]->title) }}</button>
                @endfor
              </div>
            </div>
          </div>
          <!--<div class="sec-event-header col-8 d-block d-xl-none text-right">
            <button class="active" style="margin-left: 30px">SEMINAR</button>
            <button class="inactive" style="margin-left: 10px">WEBINAR</button>
            <button class="inactive" style="margin-left: 10px">BUSINESS MATCHING</button>
            <button class="inactive" style="margin-left: 10px">INFORMATION</button>
          </div>-->
          <div class="col-4 col-md-3 col-lg-2 text-right">
            <a href="/event"><h5 style="color: #8DC63F">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-12">
            <div class="d-none d-sm-block d-lg-none">
              @for ($i = 0; $i < 4; $i++)
                <button
                    :class="(selectedEventCategory === {{ $i }} ? 'sec-event-button-active' : 'sec-event-button-inactive') + ' mr-sm-2 mr-0'"
                    @click="handleClickCategoryButton({{ $i }})"
                >{{ strtoupper($eventCategoryList[$i]->title) }}</button>
              @endfor
            </div>
          </div>
        </div>
        <div class="d-block d-sm-none">
          <div class="row mt-2 no-gutters">
            <div class="col-6 d-flex flex-column mb-2">
              <button
                  :class="selectedEventCategory === 0 ? 'sec-event-button-active mr-1' : 'sec-event-button-inactive mr-1'"
                  @click="handleClickCategoryButton(0)"
              >{{ strtoupper($eventCategoryList[0]->title) }}</button>
            </div>
            <div class="col-6 d-flex flex-column mb-2">
              <button
                  :class="selectedEventCategory === 1 ? 'sec-event-button-active ml-1' : 'sec-event-button-inactive ml-1'"
                  @click="handleClickCategoryButton(1)"
              >{{ strtoupper($eventCategoryList[1]->title) }}</button>
            </div>
            <div class="col-6 d-flex flex-column">
              <button
                  :class="selectedEventCategory === 2 ? 'sec-event-button-active mr-1' : 'sec-event-button-inactive mr-1'"
                  @click="handleClickCategoryButton(2)"
              >{{ strtoupper($eventCategoryList[2]->title) }}</button>
            </div>
            <div class="col-6 d-flex flex-column">
              <button
                  :class="selectedEventCategory === 3 ? 'sec-event-button-active ml-1' : 'sec-event-button-inactive ml-1'"
                  @click="handleClickCategoryButton(3)"
              >{{ strtoupper($eventCategoryList[3]->title) }}</button>
            </div>
          </div>
        </div>
        <div class="row mt-4" id="event-container">
          <div class="col-12" v-if="highlightEvent == null">
            <img src="/images/no_activity.jpg" style="width: 100%">
          </div>

          <div class="col-12" v-if="highlightEvent != null">
            <div class="sec-event-image d-none d-md-block"
                 :style="`backgroundImage: url(${highlightEvent.coverImage})`">
              <div class="sec-event-content">
                <div class="sec-event-date">
                  <div style="font-size: 14px; line-height: 21px; opacity: 0.5">SEC EVENT</div>
                  <div style="font-size: 35px; font-weight: bold; line-height: 45px">@{{ highlightEvent.beginMonth }}</div>
                  <div style="font-size: 72px; font-weight: bold; line-height: 70px">@{{ highlightEvent.beginDay }}</div>
                </div>
                <div
                    class="sec-event-details-container mt-0 mt-sm-1 mt-md-2 mt-lg-3 mr-0 mr-sm-2 mr-md-3 mr-lg-4"
                    @click="handleClickEvent(highlightEvent.id)"
                >
                  <div style="flex: 1; flex-direction: column; padding: 25px 30px 0; border: 0px solid red">
                    <h3 class="mb-3">@{{ highlightEvent.title }}</h3>
                    <p>@{{ highlightEvent.description }}</p>
                    <p>@{{ highlightEvent.beginDate === highlightEvent.endDate ? highlightEvent.beginDateDisplay : `${highlightEvent.beginDateDisplay} - ${highlightEvent.endDateDisplay}` }}</p>
                  </div>
                  <button style="align-self: flex-start; padding: 20px 30px;">
                    <h5>อ่านรายละเอียดเพิ่มเติม&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
                  </button>
                </div>
              </div>
            </div>
            <div class="d-xs-block d-md-none">
              <div class="info-item mb-sm-0">
                <div class="info-item-image-container"
                     :style="`backgroundImage: url(${highlightEvent.coverImage})`">
                  <div class="sec-event-date" style="position: absolute; width: 90px; height: 110px">
                    <div style="font-size: 10px; line-height: 14px; opacity: 0.5">SEC EVENT</div>
                    <div style="font-size: 18px; font-weight: bold; line-height: 25px">@{{ highlightEvent.beginMonth }}</div>
                    <div style="font-size: 36px; font-weight: bold; line-height: 35px">@{{ highlightEvent.beginDay }}</div>
                  </div>
                </div>
                <div
                    class="info-item-text"
                    style="padding: 14px 0 0 0"
                    @click="handleClickEvent(highlightEvent.id)"
                >
                  <h3>@{{ highlightEvent.title }}</h3>
                  <p>@{{ highlightEvent.description }}</p>
                  <p>@{{ highlightEvent.beginDate === highlightEvent.endDate ? highlightEvent.beginDateDisplay : `${highlightEvent.beginDateDisplay} - ${highlightEvent.endDateDisplay}` }}</p>
                  <button>
                    <h5>อ่านรายละเอียดเพิ่มเติม&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--<div class="row">
          <div class="col-12 text-center d-block d-sm-none">
            <a href="#"><h5 style="color: #8DC63F">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
          </div>
        </div>-->
      </div>
    </div>

    <!--แหล่งข้อมูลระดมทุน-->
    <div style="width: 100%; background: url('{{ asset('images/bg-media.png') }}') no-repeat; background-size: cover; padding: 30px 0">
      <div class="container mt-md-4 mt-2 mb-md-4 mb-2">
        <div class="row align-items-center no-gutters">
          <!--<div class="col-12">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px">
              <h1>สื่อการเรียนรู้ระดมทุน</h1>
              <a href="#"><h5 style="color: #8DC63F">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
            </div>
          </div>-->
          <div class="col-sm-9 col-12">
            <h1 style="color: rgba(255, 255, 255, 1)">แหล่งข้อมูลระดมทุน</h1>
          </div>
          <div class="col-sm-3 col-12 d-none d-sm-block text-right">
            <a href="/media"><h5 style="color: white">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
          </div>
        </div>
        <div class="row mt-4">
          @for ($i = 0; $i < sizeof($mediaList); $i++)
            <div class="col-lg-4 col-sm-6 {{ $i === 0 ? 'col-12' : ($i < 3 ? 'col-6 pr-2 pr-sm-3' : 'col-12 d-none d-sm-block') }}">
              <div
                  class="info-item mb-3 mb-sm-4"
                  onclick="handleClickMedia({{ $mediaList[$i]->id }})"
              >
                <div class="info-item-image-container"
                     style="background-image: url('{{ $mediaList[$i]->cover_image }}')"
                >
                </div>
                <div class="info-item-text pl-2 pr-2 pt-2 pl-sm-3 pr-sm-3 pt-sm-3">
                  <h4>{{ $mediaList[$i]->title }}</h4>
                  <p>{{ $mediaList[$i]->description }}</p>
                </div>
              </div>
            </div>
          @endfor

          {{--<div class="col-lg-4 col-sm-6 col-6 pr-2 pr-sm-3">
            <info-item img-src="info02.png" title="Minimal Workspace for Inspiration" author="พร้อมเลิศ หล่อวิจิตร"></info-item>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 pl-2 pl-sm-3">
            <info-item img-src="info03.png" author="Promlert Lovichit"></info-item>
          </div>
          <div class="col-lg-4 col-sm-6 col-12 d-none d-sm-block">
            <info-item img-src="info02.png" author="พร้อมเลิศ หล่อวิจิตร"></info-item>
          </div>
          <div class="col-lg-4 col-sm-6 col-12 d-none d-sm-block">
            <info-item img-src="info04.png" title="Minimal Workspace for Inspiration" author="Promlert Lovichit"></info-item>
          </div>
          <div class="col-lg-4 col-sm-6 col-12 d-none d-sm-block">
            <info-item img-src="info01.png" title="Minimal Workspace for Inspiration" author="พร้อมเลิศ หล่อวิจิตร"></info-item>
          </div>--}}
        </div>
        <div class="row mt-2">
          <div class="col-12 text-center d-block d-sm-none">
            <a href="/media"><h5 style="color: white">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>

  <script>
    $(document).ready(function () {
      $('.accordion-card').click(function () {
        $(this).find('.accordion-card-hidden').toggleClass('open');
        $(this).find('i').toggleClass('rotate');
      });
    });
  </script>

  <script>
    function handleClickCard(id) {
      switch (id) {
        case 1:
          window.location = '/survey';
          break;
        case 2:
          window.location = '/fundraising';
          break;
        case 3:
          window.location = '/media';
          break;
        case 4:
          window.location = '/event';
          break;
        case 5:
          window.location = '/contact';
          break;
        case 6:
          window.location = '/vision';
          break;
      }
    }

    function handleClickMedia(id) {
      window.location = `/media/${id}`;
    }

    function handleClickBannerItem(url) {
      window.location = url;
    }
  </script>

  <script>
    Vue.component('infoItem', {
      template: `
      <div class="info-item mb-3 mb-sm-4">
      <div class="info-item-image-container" :style="image">
      </div>
      <div class="info-item-text pl-2 pr-2 pt-2 pl-sm-3 pr-sm-3 pt-sm-3">
        <h4>@{{ title }}</h4>
        <p>@{{ author }}</p>
      </div>
      </div>
    `,
      props: {
        imgSrc: String,
        title: {
          type: String,
          default: 'สื่อการเรียนรู้ระดมทุน สื่อการเรียนรู้ระดมทุน สื่อการเรียนรู้ระดมทุน สื่อการเรียนรู้ระดมทุน สื่อการเรียนรู้ระดมทุน',
        },
        author: String,
      },
      data: function () {
      },
      computed: {
        image() {
          return {
            "background-image": `url('images/${this.imgSrc}')`,
          }
        }
      },
      methods: {}
    });

    Vue.component('accordionCard', {
      template: `
      <div class="accordion-card">
      <div class="d-flex align-items-center" style="font-size: 24px">
        <img class="mr-3" :src="imgSrc" :alt="imgAlt" style="width: 75px; height: 75px">
        <h3 style="flex: 1; font-size: 20px">@{{ title }}</h3>
        <i class="fa fa-chevron-circle-down ml-2" style="font-size: 24px"></i>
      </div>
      <div class="accordion-card-hidden flex-column" style="padding: 0; margin: 0 0 12px">
        <p>@{{ dummyText }}</p>
        <button><h5>@{{ buttonText }}</h5></button>
      </div>
      </div>
    `,
      props: {
        title: String,
        buttonText: String,
        imgSrc: String,
        imgAlt: String,
      },
      data: function () {
      },
      computed: {
        dummyText() {
          let result = '';
          for (let i = 0; i < 10; i++) {
            result += `${this.title} `;
          }
          return result;
        },
      },
      methods: {
        handleClickCard: function () {
          alert(`You clicked ${this.title}`);
        }
      },
    });

    Vue.component('flipCard', {
      template: `
      <div class="flip-card mb-4 mb-md-5" :style="marginBottomStyle" v-on:click="() => handleClickCard(id)">
      <div class="flip-card-inner">
        <div class="flip-card-front">
          <img :src="imgSrc" :alt="imgAlt" style="width: 100%">
          <button :style="buttonMarginTopStyle">
            <h5>@{{ buttonText }}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
          </button>
        </div>
        <div class="flip-card-back">
          <h5>@{{ buttonText }}&nbsp;<i class="fa fa-chevron-circle-right"></i></h5>
          <p style="margin-top: 10px">@{{ dummyText }}</p>
        </div>
      </div>
      </div>
    `,
      props: {
        id: Number,
        buttonText: String,
        imgSrc: String,
        imgAlt: String,
        buttonMarginTop: {
          type: Number,
          default: 25,
        },
        marginBottom: {
          type: Number,
          default: 0,
        },
      },
      data: function () {
      },
      computed: {
        buttonMarginTopStyle() {
          return {
            "margin-top": `${this.buttonMarginTop}px`,
          }
        },
        marginBottomStyle() {
          return {
            "margin-bottom": `${this.marginBottom}px`,
          }
        },
        dummyText() {
          let result = '';
          for (let i = 0; i < 10; i++) {
            result += `${this.buttonText} `;
          }
          return result;
        },
      },
      methods: {
        handleClickCard: function (id) {
          //alert(`You clicked ${this.buttonText}`);
          switch (id) {
            case 0:
              window.location.href = 'survey.html';
              break;
          }
        }
      },
    });

    const eventCategoryIdList = [
        @foreach ($eventCategoryList as $category)
      {
        id: {{ $category->id }},
      },
      @endforeach
    ];

    const eventList = [
        @foreach ($eventList as $event)
      {
        id: {{ $event->id }},
        categoryId: {{ $event->category_id }},
        title: '{{ $event->title }}',
        description: '{{ $event->description }}',
        coverImage: '{{ $event->cover_image }}',
        beginDate: '{{ $event->begin_date }}',
        endDate: '{{ $event->end_date }}',
        beginTime: '{{ $event->begin_time }}',
        endTime: '{{ $event->end_time }}',
        beginDay: '{{ $event->begin_day }}',
        beginMonth: '{{ $event->begin_month }}',
        beginDateDisplay: '{{ $event->begin_date_display }}',
        endDateDisplay: '{{ $event->end_date_display }}',
      },
      @endforeach
    ];

    const app = new Vue({
      el: '#app',
      data: {
        event: null,
        selectedEventCategory: 0,
        $eventContainer: null,
      },
      created() {
      },
      computed: {
        highlightEvent: function () {
          const filteredEventList = eventList.filter(event => event.categoryId === eventCategoryIdList[this.selectedEventCategory].id);
          return filteredEventList.length === 0 ? null : filteredEventList[0];
        },
      },
      methods: {
        handleClickCategoryButton: function (categoryId) {
          this.selectedEventCategory = categoryId;

          /*const $eventContainer = $('#event-container');
          if ($eventContainer) {
            $eventContainer.fadeOut(150, () => {
              this.selectedEventCategory = categoryId;
              Vue.nextTick(() => {
                $eventContainer.fadeIn(150, () => {
                });
              });
            });
          } else {
            this.selectedEventCategory = categoryId;
          }*/
        },
        handleClickEvent: function (id) {
          window.location = `/event/${id}`;
        },
      },
    });
  </script>
@endsection
