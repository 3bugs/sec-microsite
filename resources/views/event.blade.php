@extends('layouts.master')

@section('head')
  <link href="css/home.css" rel="stylesheet">
@endsection

@section('content')
  @include('includes.header', [
    'title' => 'SEC EVENT',
    'imageSrc' => 'images/bc-event.png',
  ])

  <section class="container">
    <div class="row">
      <div class="col-12 headpage head_secevent">
        <h2>SEC EVENT</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Netus rutrum facilisi interdum ut pulvinar ut egestas quam </p>
      </div>
      <div class="col-12 bg_calendar_event">
        <div class="row">
          <div class="col-12 col-lg-7 wrap_calendar">
            <div id="calendar-container">
              <div></div>
            </div>
            <h6>เลือกหมวดที่สนใจ</h6>
            <div class="filter_calendar">
              <div>
                <input checked type="checkbox" id="seminar"><label for="seminar">{{ $eventCategoryList[0]->title }}</label>
              </div>
              <div>
                <input checked type="checkbox" id="webinar"><label for="webinar">{{ $eventCategoryList[1]->title }}</label>
              </div>
              <div>
                <input checked type="checkbox" id="business_matching"><label for="business_matching">{{ $eventCategoryList[2]->title }}</label>
              </div>
              <div>
                <input checked type="checkbox" id="information"><label for="information">{{ $eventCategoryList[3]->title }}</label>
              </div>
            </div>
          </div>
          <div id="event-list" class="col-12 col-lg-5 bg_right_calendar">
            {{--<div
                v-if="isLoading"
                style="position: absolute; right: 10px; top: 10px; justify-content: center; align-items: center"
            >
              <img src="/images/ic_loading4.gif" style="width: 20px; height: 20px"> รอสักครู่...
            </div>--}}

            <div id="skeleton-loader" v-if="isLoading" style="text-align: center">
              <img src="/images/ic_loading.gif" style="width: 40px; margin-top: 120px">
              {{--<h4>xxx</h4>
              <h1>xxx</h1>
              <div
                  class="item_right_event loading"
              >
                <p>วันที่อีเวนต์</p>
                <h4>หัวข้ออีเวนต์</h4>
                <p>รายละเอียดอีเวนต์</p>
              </div>--}}
            </div>

            <div id="event-list-content">
              <template v-if="filteredDataList == null">
                <h4 class="mb-3">เลือกวันจากปฏิทิน เพื่อแสดงรายการอีเวนต์ในวันนั้น</h4>
              </template>

              <template v-if="filteredDataList != null">
                <h4>@{{ filteredDataList.length > 0 ? filteredDataList.length : 'No' }} Event@{{ filteredDataList.length > 1 ? 's' : ''}} on</h4>
                <h1>@{{ dateText }}</h1>
                <p v-if="filteredDataList.length === 0">ไม่มีอีเวนต์ในหมวดที่เลือกในวันดังกล่าว</p>
                <div
                    v-for="item in filteredDataList"
                    :class="'item_right_event ' + getClassName(item.category_id)"
                    v-on:click="handleClickItem(item)"
                >
                  <h4>@{{ item.title }}</h4>
                  <p class="mt-2">@{{ item.description }}</p>
                  <p class="mt-3 mb-1">@{{ item.begin_date === item.end_date ? item.begin_date_display : `${item.begin_date_display} - ${item.end_date_display}` }}</p>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>

      {{--<div>
        @foreach ($highlightEventList as $event)
          Title: {{ $event->title }} | Cover Image: {{ $event->cover_image }} | Date: {{ $event->begin_date }} - {{ $event->end_date }}<br>
        @endforeach
      </div>--}}

    </div>
  </section>

  <section id="highlight-events" class="container">
    <div class="select_event mb-2">
      <h3>Highlight</h3>
      <select
          id="select-category"
          class="form-control"
          @change="handleSelectCategory($event)"
      >
        <option value="0">ทุกหมวด</option>
        <option disabled>──────────</option>
        @foreach ($eventCategoryList as $category)
          <option value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
      </select>
    </div>

    <div class="row mt-3 mb-4">
      <div class="col-12" v-if="eventList.length > 0">
        <div class="sec-event-image d-none d-md-block"
             :style="{ backgroundImage: `url(${eventList[0].coverImage})` }">
          <div class="sec-event-content">
            <div class="sec-event-date">
              <div style="font-size: 14px; line-height: 21px; opacity: 0.5">SEC event</div>
              <div style="font-size: 35px; font-weight: bold; line-height: 45px">@{{ eventList[0].beginMonth }}</div>
              <div style="font-size: 72px; font-weight: bold; line-height: 70px">@{{ eventList[0].beginDay }}</div>
            </div>
            <div class="sec-event-details-container mt-0 mt-sm-1 mt-md-2 mt-lg-3 mr-0 mr-sm-2 mr-md-3 mr-lg-4">
              <div style="flex: 1; flex-direction: column; padding: 25px 30px 0; border: 0px solid red">
                <h3 class="mb-3">@{{ decodeEntities(eventList[0].title) }}</h3>
                <p>@{{ decodeEntities(eventList[0].description) }}</p>
                <p>@{{ eventList[0].beginDate === eventList[0].endDate ? eventList[0].beginDateDisplay : `${eventList[0].beginDateDisplay} - ${eventList[0].endDateDisplay}` }}</p>
              </div>
              <button style="align-self: flex-start; padding: 20px 30px;">
                <h5>ลงทะเบียนเข้าร่วม&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
              </button>
            </div>
          </div>
        </div>
        <div class="d-xs-block d-md-none">
          <div class="info-item mb-sm-0">
            <div class="info-item-image-container"
                 :style="{ backgroundImage: `url(${eventList[0].coverImage})` }">
              <div class="sec-event-date" style="position: absolute; width: 90px; height: 110px">
                <div style="font-size: 10px; line-height: 14px; opacity: 0.5;">SEC event</div>
                <div style="font-size: 18px; font-weight: bold; line-height: 25px">@{{ eventList[0].beginMonth }}</div>
                <div style="font-size: 36px; font-weight: bold; line-height: 35px">@{{ eventList[0].beginDay }}</div>
              </div>
            </div>
            <div class="info-item-text" style="padding: 14px 0 0 0">
              <h3>@{{ decodeEntities(eventList[0].title) }}</h3>
              <p>@{{ decodeEntities(eventList[0].description) }}</p>
              <button>
                <h5>ลงทะเบียนเข้าร่วม&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
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

    <div
        v-if="eventList.length > 1"
        class="row mb-4"
    >
      <div
          v-for="event in eventList.filter((item, index) => index > 0)"
          class="col-12 col-md-6 col-lg-3 item_eventpage"
      >
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SEC event</h6>
              <div>@{{ event.beginMonth }}</div>
              <span>@{{ event.beginDay }}</span>
            </div>
          </a>
          <figcaption>
            {{--<h6>Sun ・ Sep 16 2020, 8PM</h6>--}}
            <h5>@{{ decodeEntities(event.title) }}</h5>
            <p class="mt-2">@{{ decodeEntities(event.description) }}</p>
            {{--<p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>--}}
            <p class="mt-3 mb-2">@{{ event.beginDate === event.endDate ? event.beginDateDisplay : `${event.beginDateDisplay} - ${event.endDateDisplay}` }}</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"
          integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ=="
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="/js/bootstrap-datepicker.min.js"></script>
  <!-- script src="/skeleton-loader/jquery.scheletrone.js"></script -->

  <script>
    /*$(function () {
      const selectCategory = $('#select-category');
      selectCategory.on('change', function () {
      });
    });*/
  </script>

  <script>
    //const skeletonLoader = $('#skeleton-loader').scheletrone();

    const categoryNameList = [
      'seminar', 'webinar', 'business_matching', 'information',
    ];
    const categoryEnableValue = {
      [categoryNameList[0]]: true,
      [categoryNameList[1]]: true,
      [categoryNameList[2]]: true,
      [categoryNameList[3]]: true,
    };

    function getFormattedDate(date) {
      const offset = date.getTimezoneOffset();
      const selectedDate = new Date(date.getTime() - (offset * 60 * 1000));
      return selectedDate.toISOString().split('T')[0];
    }

    function getClassName(categoryIdList) {
      const className = categoryIdList.reduce((total, categoryId) => {
        return total + ` ${categoryNameList[categoryId - 1]}`;
      }, 'event_date');

      return filterClass(className);
    }

    function filterClass(cl) {
      for (const category in categoryEnableValue) {
        if (categoryEnableValue[category] === false) {
          cl = cl.replace(category, '');
        }
      }
      return cl;
    }

    let selectedDate = null;
    const calendar = $('#calendar-container div');
    calendar.datepicker({
      todayHighlight: false,
      format: "mm/dd/yyyy",
      weekStart: 0,
      beforeShowDay: function (date) {
        const categoryIdList = [];
        const formattedDate = getFormattedDate(date);
        {{--@foreach ($categoryListByDate as $row)
        if (formattedDate === '{{ $row->begin_date }}') {
          return filterClass('event_date {{ $row->classes }}');
        }
        @endforeach--}}

            @foreach ($eventList as $event)
        if (formattedDate < '{{ $event->begin_date }}') {
          return getClassName(categoryIdList);
        }
        if (formattedDate >= '{{ $event->begin_date }}' && formattedDate <= '{{ $event->end_date }}') {
          if (!categoryIdList.includes({{ $event->category_id }})) {
            categoryIdList.push({{ $event->category_id }});
          }
        }
        {{--{{ $event->category_id }} * {{ $event->begin_date }} * {{ $event->end_date }}--}}
        @endforeach

          return getClassName(categoryIdList);
      },
    }).on('changeDate', function (e) {
      selectedDate = e.date;
      //console.log(getFormattedDate(e.date));
      eventList.fetchEventByDate(getFormattedDate(e.date));
    });

    $(function () { //document ready
      $('.filter_calendar input').each(function () {
        $(this).change(function () {
          categoryEnableValue[$(this).attr('id')] = $(this).is(':checked');
          //console.log(categoryEnableValue);
          calendar.datepicker('update');
          if (selectedDate != null) {
            calendar.datepicker('setDate', selectedDate);
          }
          eventList.updateCategoryEnableValue();
        });
      });
    });
  </script>

  <script>
    const $highlightEvents = $('#highlight-events');
    const highlightEventDataList = [
        @foreach ($highlightEventList as $event)
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

    const highlightEvents = new Vue({
      el: '#highlight-events',
      data: {
        selectedCategoryId: 0,
        eventList: highlightEventDataList,
      },
      computed: {},
      created() {

      },
      methods: {
        handleSelectCategory(e) {
          this.selectedCategoryId = parseInt(e.target.value);
          this.eventList = this.selectedCategoryId === 0
            ? highlightEventDataList
            : highlightEventDataList.filter(event => event.categoryId === this.selectedCategoryId);
        },
      }
    });
  </script>

  <script>
    const eventList = new Vue({
      el: '#event-list',
      data: {
        dateText: '',
        dataList: null,
        isLoading: false,
        categoryEnableValue: {},
      },
      computed: {
        filteredDataList() {
          if (this.dataList == null) return null;

          return this.dataList.filter(event => {
            return this.categoryEnableValue[categoryNameList[event.category_id - 1]];
          });
        },
      },
      created() {
        this.updateCategoryEnableValue();
      },
      methods: {
        fetchEventByDate(date) {
          const $eventList = $('#event-list-content');

          $eventList.fadeOut(0, () => {
            this.isLoading = true;

            setTimeout(() => {
              axios.get(`/api/event/date/${date}?t=${Date.now()}`)
                .then(response => {
                  this.isLoading = false;

                  if (response.data.status === 'ok') {
                    const datePart = date.split('-');
                    const day = parseInt(datePart[2]);
                    let monthNameList = [
                      'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC',
                    ];
                    this.dateText = `${day} ${monthNameList[datePart[1] - 1]} ${datePart[0]}`;
                    this.dataList = response.data.data_list;

                    $eventList.fadeIn(300, () => {
                      let scrollTop;
                      if (Modernizr.mq('(max-width: 767px)')) { // hidden menu
                        scrollTop = $eventList.offset().top - 20;
                      } else if (Modernizr.mq('(max-width: 991px)')) { // fixed menu
                        scrollTop = $eventList.offset().top - 80;
                      } else { // fixed menu + layout ซ้าย-ขวา
                        scrollTop = $eventList.offset().top - 80;
                      }
                      $([document.documentElement, document.body]).animate({scrollTop}, 500);
                    });
                  } else {
                    alert('เกิดข้อผิดพลาดในการดึงข้อมูล กรุณาลองใหม่');
                  }
                })
                .catch(error => {
                  console.log(error);
                  this.isLoading = false;
                  alert('เกิดข้อผิดพลาดในการเชื่อมต่อ Server กรุณาลองใหม่\n\n' + error);
                });
            }, 300);
          });
        },
        getClassName(categoryId) {
          return categoryNameList[categoryId - 1];
        },
        handleClickItem(item) {
          window.location = `/event/${item.id}`;
        },
        updateCategoryEnableValue() {
          this.categoryEnableValue = categoryEnableValue;
        }
      }
    });
  </script>
@endsection
