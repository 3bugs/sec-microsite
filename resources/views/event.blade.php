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
            <h1>SEC EVENT</h1>
            <img src="/images/bc-event.png" class="img_breadcrumb">
          </div>
        </div>
      </div>
    </div>
  </section>

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
                <input checked type="checkbox" id="seminar"><label for="seminar">Seminar</label>
              </div>
              <div>
                <input checked type="checkbox" id="webinar"><label for="webinar">Webinar</label>
              </div>
              <div>
                <input checked type="checkbox" id="business_matching"><label for="business_matching">Business Matching</label>
              </div>
              <div>
                <input checked type="checkbox" id="information"><label for="information">Information</label>
              </div>
            </div>
          </div>
          <div id="event-list" class="col-12 col-lg-5 bg_right_calendar">
            <div id="event-list-content">
              <div
                  v-if="isLoading"
                  style="position: absolute; right: 10px; top: 10px; justify-content: center; align-items: center"
              >
                รอสักครู่...
              </div>

              <template v-if="filteredDataList == null">
                <h4 class="mb-3">เลือกวันจากปฏิทิน เพื่อแสดงรายการอีเวนต์ในวันนั้น</h4>
              </template>

              <template v-if="filteredDataList != null">
                <h4>@{{ filteredDataList.length > 0 ? filteredDataList.length : 'No' }} Event@{{ filteredDataList.length > 1 ? 's' : ''}} on</h4>
                <h1>@{{ dateText }}</h1>
                <div
                    v-for="item in filteredDataList"
                    :class="'item_right_event ' + getClassName(item.category_id)"
                    v-on:click="handleClickItem(item)"
                >
                  <p>@{{ dateText }}</p>
                  <h4>@{{ item.title }}</h4>
                  <p>@{{ item.description }}</p>
                </div>
              </template>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 select_event">
        <h3>Highlight</h3>
        <select class="form-control">
          <option>All</option>
        </select>
      </div>
      <div class="col-12 item_hlevent">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>16</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h3>วิธีการระดมทุนให้
              ได้ตามเป้าต้องทำ
              อย่างไร</h3>
            <p>In oculis quidem se esse admonere interesse enim maxime placeat, facere possimus, omnis. Et quidem faciunt, ut labore et accurate disserendum et harum quidem exercitus quid.</p>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a class="btn_registerevent" href="#">ลงทะเบียนเข้าร่วม<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-3 item_eventpage">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>17</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h5>วิธีการระดมทุนให้ได้ตามเป้าต้องทำอย่างไร</h5>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
      <div class="col-12 col-md-6 col-lg-3 item_eventpage">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>18</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h5>วิธีการระดมทุนให้ได้ตามเป้าต้องทำอย่างไร</h5>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
      <div class="col-12 col-md-6 col-lg-3 item_eventpage">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>19</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h5>วิธีการระดมทุนให้ได้ตามเป้าต้องทำอย่างไร</h5>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
      <div class="col-12 col-md-6 col-lg-3 item_eventpage">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>20</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h5>วิธีการระดมทุนให้ได้ตามเป้าต้องทำอย่างไร</h5>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
    </div>
    <div class="row mt-5">
      <div class="col-12 headmore_event">
        <h3>All SEC event</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-3 item_eventpage">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>17</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h5>วิธีการระดมทุนให้ได้ตามเป้าต้องทำอย่างไร</h5>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
      <div class="col-12 col-md-6 col-lg-3 item_eventpage">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>18</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h5>วิธีการระดมทุนให้ได้ตามเป้าต้องทำอย่างไร</h5>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
      <div class="col-12 col-md-6 col-lg-3 item_eventpage">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>19</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h5>วิธีการระดมทุนให้ได้ตามเป้าต้องทำอย่างไร</h5>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
      <div class="col-12 col-md-6 col-lg-3 item_eventpage">
        <figure>
          <a href="#">
            <img src="/images/event.jpg">
            <div class="date_hlevent">
              <h6>SCE event</h6>
              <div>SEP</div>
              <span>20</span>
            </div>
          </a>
          <figcaption>
            <h6>Sun ・ Sep 16 2020, 8PM</h6>
            <h5>วิธีการระดมทุนให้ได้ตามเป้าต้องทำอย่างไร</h5>
            <p class="author">โดย : นายวรายุทธ แสนสิทธิเวช</p>
            <a href="#">อ่านต่อ<i class="fa fa-chevron-right"></i></a>
          </figcaption>
        </figure>
      </div>
    </div>
    <div class="row">
      <div class="col-12 wrap_btn_viewmore">
        <button class="btn_viewmore">ดูเพิ่ม</button>
      </div>
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js" integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ=="
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>
  <script src="js/bootstrap-datepicker.min.js"></script>

  <script>
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

    function filterClass(cl) {
      for (const category in categoryEnableValue) {
        if (categoryEnableValue[category] === false) {
          cl = cl.replace(category, '');
        }
      }
      return cl;
    }

    const calendar = $('#calendar-container div');
    calendar.datepicker({
      todayHighlight: false,
      format: "mm/dd/yyyy",
      weekStart: 0,
      beforeShowDay: function (date) {
        const formattedDate = getFormattedDate(date);
        @foreach($categoryListByDate as $row)
        if (formattedDate === '{{ $row->event_date }}') {
          return filterClass('event_date {{ $row->classes }}');
        }
        @endforeach
      },
    }).on('changeDate', function (e) {
      //console.log(getFormattedDate(e.date));
      eventList.fetchEventByDate(getFormattedDate(e.date));
    });

    $(function () { //document ready
      $('.filter_calendar input').each(function () {
        $(this).change(function () {
          categoryEnableValue[$(this).attr('id')] = $(this).is(':checked');
          //console.log(categoryEnableValue);
          calendar.datepicker('update');
          eventList.updateCategoryEnableValue();
        });
      });
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
          this.isLoading = true;

          axios.get(`/api/event/date/${date}?t=${Date.now()}`)
            .then(response => {
              this.isLoading = false;

              if (response.data.status === 'ok') {
                const $eventList = $('#event-list-content');
                $eventList.fadeOut(300, () => {
                  const datePart = date.split('-');
                  const day = parseInt(datePart[2]);
                  let monthNameList = [
                    'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC',
                  ];
                  this.dateText = `${day} ${monthNameList[datePart[1] - 1]} ${datePart[0]}`;
                  this.dataList = response.data.data_list;

                  $eventList.fadeIn(300, () => {
                  });
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
        },
        getClassName(categoryId) {
          return categoryNameList[categoryId - 1];
        },
        handleClickItem(item) {
          alert('Under construction!');
        },
        updateCategoryEnableValue() {
          this.categoryEnableValue = categoryEnableValue;
        }
      }
    });
  </script>
@endsection
