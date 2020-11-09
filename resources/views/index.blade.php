@extends('layouts.master')

@section('head')
  <link href="css/index.css" rel="stylesheet">
@endsection

@section('content')
  <div id="app">
    <!--hero banner-->
    <div class="hero-container">
      <!--<div class="hero-content">-->
      <div class="container">
        <div class="row">
          <div class="col-10 offset-1 text-center">
            <h1>สำรวจตัวเอง</h1>
            <p>In oculis quidem se esse admonere interesse enim maxime placeat, facere possimus, omnis. Et quidem faciunt, ut labore et accurate disserendum et harum quidem exercitus quid.</p>
            <button onclick="window.location = '/survey'" style="padding-left: 30px; padding-right: 30px"><h5>เริ่มแบบสำรวจ&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></button>
          </div>
        </div>
      </div>
      <!--</div>-->
    </div>

    <!--6 flip cards-->
    <div id="flip-card-container" style="position: relative; bottom: 40px; display: flex; flex-direction: column; margin:auto; border: 0px solid deeppink">
      <div class="container d-none d-sm-block" style="border: 0px solid red">
        <div class="row">

          @foreach ($cardDataList as $cardData)
            <div class="col-lg-4 col-sm-6 col-12" style="border: 0px solid blue">
              <div class="flip-card mb-4 mb-md-5" style="margin-bottom: 0" onclick="handleClickCard({{ $cardData['id'] }})">
                <div class="flip-card-inner">
                  <div class="flip-card-front">
                    <img src="images/menu0{{ $cardData['id'] }}.svg" alt="menu {{ $cardData['id'] }}" style="width: 100%">
                    <button style="margin-top: {{ $cardData['buttonMarginTop'] }}px">
                      <h5>{{ $cardData['buttonText'] }}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
                    </button>
                  </div>
                  <div class="flip-card-back">
                    <h5>{{ $cardData['buttonText'] }}&nbsp;<i class="fa fa-chevron-circle-right"></i></h5>
                    <p style="margin-top: 10px">
                      @for ($i = 0; $i < 10; $i++)
                        {{ $cardData['buttonText'] }}
                      @endfor
                    </p>
                  </div>
                </div>
              </div>
            </div>
          @endforeach

          {{--<div class="col-lg-4 col-sm-6 col-12" style="border: 0px solid blue">
            <flip-card :id="0" button-text="สำรวจตัวเอง" img-src="images/menu01.svg" img-alt="menu 1"></flip-card>
          </div>
          <div class="col-lg-4 col-sm-6 col-12" style="border: 0px solid blue">
            <flip-card :id="1" button-text="เครื่องมือระดมทุน" img-src="images/menu02.svg" img-alt="menu 2"></flip-card>
          </div>
          <div class="col-lg-4 col-sm-6 col-12" style="border: 0px solid blue">
            <flip-card :id="2" button-text="สื่อการเรียนรู้ระดมทุน" img-src="images/menu03.svg" img-alt="menu 3"></flip-card>
          </div>
          <div class="col-lg-4 col-sm-6 col-12" style="border: 0px solid blue">
            <flip-card :id="3" button-text="SEC Event" img-src="images/menu04.svg" img-alt="menu 4"></flip-card>
          </div>
          <div class="col-lg-4 col-sm-6 col-12" style="border: 0px solid blue">
            <flip-card :id="4" button-text="คลินิกระดมทุน" img-src="images/menu05.svg" img-alt="menu 5" :button-margin-top="5"></flip-card>
          </div>
          <div class="col-lg-4 col-sm-6 col-12" style="border: 0px solid blue">
            <flip-card :id="5" button-text="พันธกิจ พันธมิตร" img-src="images/menu06.svg" img-alt="menu 6"></flip-card>
          </div>--}}
        </div>
      </div>

      <div class="container d-sm-none d-xs-block" style="border: 0px solid red">
        <div class="row">
          <div class="col-12 d-flex flex-column mb-3">
            <accordion-card title="สำรวจตัวเอง" button-text="สำรวจ" img-src="images/menu01.svg" img-alt="menu 1"></accordion-card>
          </div>
          <div class="col-12 d-flex flex-column mb-3">
            <accordion-card title="เครื่องมือระดมทุน" button-text="ดูเพิ่มเติม" img-src="images/menu02.svg" img-alt="menu 2"></accordion-card>
          </div>
          <div class="col-12 d-flex flex-column mb-3">
            <accordion-card title="แหล่งข้อมูลระดมทุน" button-text="ดูเพิ่มเติม" img-src="images/menu03.svg" img-alt="menu 3"></accordion-card>
          </div>
          <div class="col-12 d-flex flex-column mb-3">
            <accordion-card title="SEC Event" button-text="ดูเพิ่มเติม" img-src="images/menu04.svg" img-alt="menu 4"></accordion-card>
          </div>
          <div class="col-12 d-flex flex-column mb-3">
            <accordion-card title="คลินิกระดมทุน" button-text="ดูเพิ่มเติม" img-src="images/menu05.svg" img-alt="menu 5"></accordion-card>
          </div>
          <div class="col-12 d-flex flex-column mb-0">
            <accordion-card title="พันธกิจ พันธมิตร" button-text="ดูเพิ่มเติม" img-src="images/menu06.svg" img-alt="menu 6"></accordion-card>
          </div>
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
    <div style="width: 100%; background: #fff; padding: 30px 0">
      <div class="container mt-md-4 mt-2 mb-md-4 mb-2">
        <div class="row align-items-center no-gutters">
          <div class="col-8 col-md-9 col-lg-10">
            <div class="sec-event-header" style="display: flex; align-items: center">
              <h1>SEC EVENT</h1>
              <div class="d-none d-lg-block">
                <button class="sec-event-button-active" style="margin-left: 30px">SEMINAR</button>
                <button class="sec-event-button-inactive" style="margin-left: 10px">WEBINAR</button>
                <button class="sec-event-button-inactive" style="margin-left: 10px">BUSINESS MATCHING</button>
                <button class="sec-event-button-inactive" style="margin-left: 10px">INFORMATION</button>
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
            <a href="#"><h5 style="color: #8DC63F">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-12">
            <div class="d-none d-sm-block d-lg-none">
              <button class="sec-event-button-active mr-sm-2 mr-0">SEMINAR</button>
              <button class="sec-event-button-inactive mr-sm-2 mr-0">WEBINAR</button>
              <button class="sec-event-button-inactive mr-sm-2 mr-0">BUSINESS MATCHING</button>
              <button class="sec-event-button-inactive">INFORMATION</button>
            </div>
          </div>
        </div>
        <div class="d-block d-sm-none">
          <div class="row mt-2 no-gutters">
            <div class="col-6 d-flex flex-column mb-2">
              <button class="sec-event-button-active mr-1">SEMINAR</button>
            </div>
            <div class="col-6 d-flex flex-column mb-2">
              <button class="sec-event-button-inactive ml-1">WEBINAR</button>
            </div>
            <div class="col-6 d-flex flex-column">
              <button class="sec-event-button-inactive mr-1">BUSINESS MATCHING</button>
            </div>
            <div class="col-6 d-flex flex-column">
              <button class="sec-event-button-inactive ml-1">INFORMATION</button>
            </div>
          </div>
        </div>
        <div class="row mt-4 d-">
          <div class="col-12">
            <div class="sec-event-image d-none d-md-block">
              <div class="sec-event-content">
                <div class="sec-event-date">
                  <div style="font-size: 14px; line-height: 21px; opacity: 0.5;">SEC EVENT</div>
                  <div style="font-size: 35px; font-weight: 500; line-height: 45px; letter-spacing: 6px;">OCT</div>
                  <div style="font-size: 72px; font-weight: 600; line-height: 70px; letter-spacing: 10px;">16</div>
                </div>
                <div class="sec-event-details-container mt-0 mt-sm-1 mt-md-2 mt-lg-3 mr-0 mr-sm-2 mr-md-3 mr-lg-4">
                  <div style="flex: 1; flex-direction: column; padding: 25px 30px 0; border: 0px solid red">
                    <h3 class="mb-3">วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร</h3>
                    <p>วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร
                      วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร</p>
                    <p>Sun ・ Sep 16 2020, 8:40 PM</p>
                  </div>
                  <button style="align-self: flex-start; padding: 20px 30px;">
                    <h5>ลงทะเบียนเข้าร่วม&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
                  </button>
                </div>
              </div>
            </div>
            <div class="d-xs-block d-md-none">
              <div class="info-item mb-sm-0">
                <div class="info-item-image-container" style="background-image: url('images/event.jpg')">
                  <div class="sec-event-date" style="position: absolute; width: 90px; height: 110px">
                    <div style="font-size: 10px; line-height: 14px; opacity: 0.5;">SEC EVENT</div>
                    <div style="font-size: 25px; font-weight: 500; line-height: 30px; letter-spacing: 2px;">OCT</div>
                    <div style="font-size: 50px; font-weight: 600; line-height: 45px; letter-spacing: 5px;">16</div>
                  </div>
                </div>
                <div class="info-item-text" style="padding: 14px 0 0 0">
                  <h3>วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร</h3>
                  <p>วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร
                    วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร วิธีการระดมทุนให้ได้ตามเป้า ต้องทำอย่างไร</p>
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
      </div>
    </div>

    <!--สื่อการเรียนรู้ระดมทุน-->
    <div style="width: 100%; background: #f8f8f8; padding: 30px 0">
      <div class="container mt-md-4 mt-2 mb-md-4 mb-2">
        <div class="row align-items-center no-gutters">
          <!--<div class="col-12">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px">
              <h1>สื่อการเรียนรู้ระดมทุน</h1>
              <a href="#"><h5 style="color: #8DC63F">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
            </div>
          </div>-->
          <div class="col-sm-9 col-12">
            <h1>สื่อการเรียนรู้ระดมทุน</h1>
          </div>
          <div class="col-sm-3 col-12 d-none d-sm-block text-right">
            <a href="#"><h5 style="color: #8DC63F">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-4 col-sm-6 col-12">
            <info-item img-src="info01.png" author="พร้อมเลิศ หล่อวิจิตร"></info-item>
          </div>
          <div class="col-lg-4 col-sm-6 col-6 pr-2 pr-sm-3">
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
          </div>
        </div>
        <div class="row">
          <div class="col-12 text-center d-block d-sm-none">
            <a href="#"><h5 style="color: #8DC63F">ดูทั้งหมด&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5></a>
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
          alert('Under construction!');
          break;
        case 5:
          alert('Under construction!');
          break;
        case 6:
          alert('Under construction!');
          break;
      }
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

    const app = new Vue({
      el: '#app',
      data: {
        message: 'Vue.js is working!',
      },
    });
  </script>
@endsection
