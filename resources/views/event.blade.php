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
            <h6>สามารถเลือกเฉพาะหมวดที่สนใจได้</h6>
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
          <div id="event-list" class="col-12 col-lg-5 bg_right_calendar" v-if="dataList != null && dataList.length > 0">
            <h4>@{{ dataList.length }} Events on</h4>
            <h1>@{{ dateText }}</h1>
            <div
                v-for="item in dataList"
                :class="'item_right_event ' + getClassName(item.category_id)"
            >
              <p>@{{ dateText }}</p>
              <h4>@{{ item.title }}</h4>
              <p>@{{ item.description }}</p>
            </div>
            {{--<div class="item_right_event webinar">
              <p>Sun ・ Sep 16 2020, 8PM</p>
              <h4>วิธีการระดมทุนให้ได้ตามเป้า</h4>
              <p>โดย : นายวรายุทธ แสนสิทธิเวช</p>
            </div>
            <div class="item_right_event business_matching">
              <p>Sun ・ Sep 16 2020, 8PM</p>
              <h4>วิธีการระดมทุนให้ได้ตามเป้า</h4>
              <p>โดย : นายวรายุทธ แสนสิทธิเวช</p>
            </div>
            <div class="item_right_event information">
              <p>Sun ・ Sep 16 2020, 8PM</p>
              <h4>วิธีการระดมทุนให้ได้ตามเป้า</h4>
              <p>โดย : นายวรายุทธ แสนสิทธิเวช</p>
            </div>--}}
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
    const categoryEnableValue = {
      seminar: true,
      webinar: true,
      business_matching: true,
      information: true,
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
        });
      });
    });
  </script>

  <script>
    const eventList = new Vue({
      el: '#event-list',
      data: {
        dateText: '',
        dataList: [],
      },
      created() {
      },
      methods: {
        fetchEventByDate(date) {
          axios.get(`/api/event/date/${date}`)
            .then(response => {
              if (response.data.status === 'ok') {
                this.dataList = response.data.data_list;
                console.log(this.dataList.length);

                const datePart = date.split('-');
                const day = parseInt(datePart[2]);
                let monthNameList = [
                  'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC',
                ];
                this.dateText = `${day} ${monthNameList[datePart[1] - 1]} ${datePart[0]}`;
              } else {
                alert('เกิดข้อผิดพลาดในการดึงข้อมูล กรุณาลองใหม่');
              }
            });
        },
        getClassName(categoryId) {
          switch (categoryId) {
            case 1:
              return 'seminar';
              break;
            case 2:
              return 'webinar';
              break;
            case 3:
              return 'business_matching';
              break;
            case 4:
              return 'information';
              break;
          }
        },
      }
    });
  </script>
@endsection
