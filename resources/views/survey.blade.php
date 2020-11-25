@extends('layouts.master')

@section('head')
  <link href="css/survey.css" rel="stylesheet">
@endsection

@section('content')
  <div id="app" class="main-container pl-3 pl-md-4 pl-lg-5 pr-3 pr-md-4 pr-lg-5 pt-4">
    <!--<div class="step-container mt-5">
      <div class="step-text">
        <h3 class="color-active">< กลับไปก่อนหน้า</h3>
        <h3><span class="color-active">01 /</span> <span class="color-inactive">04</span></h3>
        <h3 class="color-active">ยกเลิก / เริ่มใหม่</h3>
      </div>
      <ul class="step-line">
        <li class="active"></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>-->

    <div class="survey-form-container">
      <div class="survey-begin" style="display: flex">
        <div class="survey-begin-content">
          <div class="pt-4 pt-sm-4 pt-lg-5 pl-3 pl-sm-4 pl-lg-5 pr-3 pr-sm-4 pr-md-0 mb-3"
               style="border: 0px solid blue; display: flex; flex: 1; flex-direction: column; justify-content: space-between">
            <div style="display: flex; flex-direction: column; border: 0px solid red">
              <h3><a href="/"><span style="color: #3877A0">หน้าแรก > </span></a><span style="color: black">สำรวจตัวเอง</span></h3>
              <img src="images/survey_start.svg" class="pt-3 pb-3 pl-4 pr-4 d-flex d-md-none align-self-center" style="width: 100%; max-width: 260px">
              <h1 class="mt-3" style="font-weight: 700; line-height: 1.4em;">
                <span style="color: black">สำรวจตัวเอง</span><br>
                <span style="color: #003558; font-size: 0.8em">เพื่อค้นพบช่องทางระดมทุน</span>
              </h1>
              <p class="mt-2 mb-1">ช่องทางระดมทุนไหนที่ตอบโจทย์ความต้องการของท่านมากที่สุด ?
                ท่านสามารถหาคำตอบได้ด้วยตัวของท่านเอง โดยใช้เวลาเพียงน้อยนิดผ่านการตอบคำถามเพียงไม่กี่ข้อ ถ้าพร้อมแล้ว มาหาคำตอบช่องทางระดมทุนของท่านกันเลย
              </p>
            </div>
            <div style="display: flex; flex: 1; align-items: center;">
              <button class="mt-3 mt-md-4 mt-lg-4 mt-xl-4 mb-3 mb-md-4 mb-lg-4 mb-xl-4" v-on:click="handleClickStartSurvey">
                <h5>เริ่มกันเลย&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
              </button>
            </div>
          </div>
          <div class="d-none d-md-flex" style="display: flex; flex: 1; justify-content: center; align-items: center">
            <img src="images/survey_start.svg" class="pt-5 pb-5 pl-3 pr-5" style="width: 100%">
          </div>
        </div>
        <p class="mt-3 mb-3 pt-1 pb-1 text-center" style="align-self: center">การทำแบบสำรวจนี้ไม่ถือเป็นข้อบังคับที่สามารถใช้ในการประเมินผลทางกฎหมายได้</p>
      </div>

      <survey-form :on-end-survey="handleEndSurvey"></survey-form>

      <div class="survey-end" style="display: none">
        <div class="survey-end-content">
          <div class="pt-3 pt-sm-3 pt-lg-4 pl-3 pl-sm-4 pl-lg-5 pr-3 pr-sm-4 pr-lg-5 mb-3" style="display: flex; flex: 1; flex-direction: column; justify-content: space-between; align-items: center">
            <img src="images/survey_start.svg" class="mt-2" style="width: 40%">

            <div class="d-flex flex-column align-items-center">
              <h2 class="mt-3" style="font-weight: bold; line-height: 1.5em; color: #003558">ผลลัพธ์ของท่านคือ</h2>
              <p class="mt-2 ml-2 mr-2 text-center"
                 v-if="resultText != null"
              >
                @{{resultText}}
              </p>
              <a href="javascript:void(0)"
                 v-on:click.prevent="handleClickReadMore(item)"
                 v-for="item in resultPageList"
                 :key="item.id"
                 class="mt-2 d-flex"
              >
                <img :src="`images/survey-results/button-${item.id}.png`">
              </a>
            </div>

            <button
                v-if="buttonText != null"
                class="mt-2"
                v-on:click="window.open(buttonClickUrl, '_blank')"
            >
              <h5>@{{buttonText}}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
            </button>

            {{--<button
                v-for="item in resultPageList"
                :key="item.id"
                class="mt-2"
                v-on:click="() => handleClickReadMore(item)"
            >
              <h5>@{{item.text}}&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
            </button>--}}
            {{--<button class="mt-2" v-on:click="handleClickReadMore">
              <h5>อ่านต่อ 2&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
            </button>--}}
            <div class="mt-3 mt-md-4 mb-3 mb-md-4" style="display: flex; flex: 1; align-items: center;">
              <!--<div class="mr-2"></div>-->
              <button id="share-button" class="mr-2" v-on:click="handleClickShare">
                <h5>แชร์&nbsp;&nbsp;<i class="fa fa-share-alt"></i></h5>
              </button>
              <!--<div class="mr-2"></div>-->
              <button id="try-again-button" v-on:click="handleClickSurveyAgain">
                <h5>ลองอีกครั้ง&nbsp;&nbsp;<i class="fa fa-repeat"></i></h5>
              </button>
            </div>
          </div>
        </div>
        <p class="mt-3 mb-3 pt-1 pb-1 text-center" style="align-self: center">การทำแบบสำรวจนี้ไม่ถือเป็นข้อบังคับที่สามารถใช้ในการประเมินผลทางกฎหมายได้</p>
      </div>
    </div>

    <div class="survey-footer p-3 mr-0 color-inactive text-center">
      <div class="container">
        <div class="row mb-2">
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2" style="opacity: 0"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2" style="opacity: 0"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2" style="opacity: 0"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2" style="opacity: 0"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2" style="opacity: 0"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2" style="opacity: 0"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2" style="opacity: 0"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2" style="opacity: 0"><a href="#">Link goes here</a></div>
        </div>
      </div>
    </div>

    <div v-if="imageVisible">
      <img id="curve-image" src="images/curve.svg">
      <img id="man-image" src="images/man.svg">
    </div>
  </div>
@endsection

@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.0/axios.min.js"
          integrity="sha512-DZqqY3PiOvTP9HkjIWgjO6ouCbq+dxqWoJZ/Q+zPYNHmlnI2dQnbJ5bxAHpAMw+LXRm4D72EIRXzvcHQtE8/VQ=="
          crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>

  <script>
    const fundraisingPageList = [
      {id: 'a', text: 'หุ้นกู้ CFD', pageId: 12},
      {id: 'b', text: 'หุ้น CFD', pageId: 15},
      {id: 'c', text: 'PP หุ้นกู้แปลงสภาพ', pageId: 13},
      {id: 'd', text: 'PP หุ้น', pageId: 18},
      {id: 'e', text: 'PO SME', pageId: 0, url: null}, //todo: **********
      {id: 'f', text: 'IPO SET', pageId: 0, url: 'https://www.sec.or.th/TH/Pages/LawandRegulations/SharePO.aspx'},
      {id: 'g', text: 'ออกหุ้นกู้', pageId: 0, url: 'https://www.sec.or.th/TH/Pages/LawandRegulations/DebtInstrument.aspx'},
      {id: 'h', text: 'ออกหุ้นเพิ่มทุน', pageId: 0, url: 'https://www.sec.or.th/TH/Pages/LAWANDREGULATIONS/EQITYINSTRUMENT.aspx'},
      {id: 'k', text: 'PP for non-listed', pageId: 0, url: 'https://www.sec.or.th/TH/Pages/LAWANDREGULATIONS/SHAREPP.aspx'},
      {id: 'l', text: 'การเสนอขายหุ้นสำหรับวิสาหกิจเพื่อสังคม', pageId: 0, url: 'https://www.sec.or.th/TH/Pages/LAWANDREGULATIONS/SE-OFFERING.aspx#summary'},
      {
        id: 'x',
        text: 'เพื่อเริ่มต้นเข้าสู่กระบวนการระดมทุนภายใต้โครงการส่งเสริมการระดมทุนผ่านตลาดทุน อย่างน้อยกิจการของท่านจำเป็นต้องจัดตั้งเป็น “บริษัทจำกัด” โดยท่านสามารถเริ่มต้นศึกษารายละเอียดการจดทะเบียนจัดตั้งบริษัทได้ที่ กรมพัฒนาธุรกิจการค้า กระทรวงพาณิชย์',
        buttonText: 'ศึกษาเพิ่มเติม',
        url: 'https://www.dbd.go.th/news_view.php?nid=369',
      },
    ];

    const questionList = [
      { // 0
        questionText: 'การจัดตั้งธุรกิจของท่านเป็นแบบใด ?',
        choiceList: [
          {text: 'จัดตั้ง\nเป็นบริษัท', value: false, nextQuestion: 1},
          {text: 'ไม่จด\nทะเบียนบริษัท', value: false, nextQuestion: -1, resultList: ['x']},
          /*
          เพื่อเริ่มต้นเข้าสู่กระบวนการระดมทุนภายใต้โครงการส่งเสริมการระดมทุนผ่านตลาดทุน อย่างน้อยกิจการของท่านจำเป็นต้องจัดตั้งเป็น “บริษัทจำกัด” โดยท่านสามารถเริ่มต้นศึกษารายละเอียดการจดทะเบียนจัดตั้งบริษัทได้ที่ กรมพัฒนาธุรกิจการค้า กระทรวงพาณิชย์”
ศึกษาข้อมูลเพิ่มเติมได้ที่ (Link ไปที่ >>> https://www.dbd.go.th/news_view.php?nid=369)
          */

          {text: 'วิสาหกิจ\nเพื่อสังคม', value: false, nextQuestion: -1, resultList: ['l']},
        ],
      },
      { // 1
        questionText: 'รูปแบบบริษัทของท่านคือ ?',
        choiceList: [
          {text: 'บริษัทจำกัด', value: false, nextQuestion: 2},
          {text: 'บริษัท\nมหาชนจำกัด', value: false, nextQuestion: 6},
        ],
      },
      { // 2
        questionText: 'โปรดเลือกขนาดธุรกิจของท่าน',
        remark: [
          '* SME ขนาดเล็ก (วิสาหกิจขนาดย่อม) • ภาคการผลิต : จ้างงานไม่เกิน 50 คน หรือ รายได้ไม่เกิน 100 ล้านบาทต่อปี • ภาคการค้าและการบริการ : จ้างงานไม่เกิน 30 คน / รายได้ไม่เกิน  50 ล้านบาทต่อปี',
          '** SME ขนาดกลาง (วิสาหกิจขนาดกลาง) • ภาคการผลิต : จ้างงานไม่เกิน 51-200 คน / รายได้เกิน 100 ล้านบาท แต่ไม่เกิน 500 ล้านบาทต่อปี • ภาคการค้าและการบริการ : จ้างงานไม่เกิน 30-100 คน / รายได้เกิน 50 ล้านบาท แต่ไม่เกิน 300 ล้านบาทต่อปี',
          '*** กิจการขนาดใหญ่ • จ้างงานมากกว่า 200 คน / รายได้มากกว่า 500 ล้านบาท'
        ],
        choiceList: [
          {
            text: 'SME ขนาดเล็ก*',
            value: false,
            nextQuestion: 3,
            remark: '* SME ขนาดเล็ก (วิสาหกิจขนาดย่อม)\nภาคการผลิต : จ้างงานไม่เกิน 50 คน หรือ รายได้ไม่เกิน 100 ล้านบาทต่อปี\nภาคการค้าและการบริการ : จ้างงานไม่เกิน 30 คน / รายได้ไม่เกิน  50 ล้านบาทต่อปี'
          },
          {
            text: 'SME ขนาดกลาง**',
            value: false,
            nextQuestion: 4,
            remark: '** SME ขนาดกลาง (วิสาหกิจขนาดกลาง)\nภาคการผลิต : จ้างงานไม่เกิน 51-200 คน / รายได้เกิน 100 ล้านบาท แต่ไม่เกิน 500 ล้านบาทต่อปี\nภาคการค้าและการบริการ : จ้างงานไม่เกิน 30-100 คน / รายได้เกิน 50 ล้านบาท แต่ไม่เกิน 300 ล้านบาทต่อปี'
          },
          {text: 'กิจการขนาดใหญ่***', value: false, nextQuestion: 5, remark: '*** กิจการขนาดใหญ่\\nจ้างงานมากกว่า 200 คน / รายได้มากกว่า 500 ล้านบาท'},
        ],

        /*
        * SME ขนาดเล็ก (วิสาหกิจขนาดย่อม)\nภาคการผลิต : จ้างงานไม่เกิน 50 คน หรือ รายได้ไม่เกิน 100 ล้านบาทต่อปี\nภาคการค้าและการบริการ : จ้างงานไม่เกิน 30 คน / รายได้ไม่เกิน  50 ล้านบาทต่อปี
        ** SME ขนาดกลาง (วิสาหกิจขนาดกลาง)\nภาคการผลิต : จ้างงานไม่เกิน 51-200 คน / รายได้เกิน 100 ล้านบาท แต่ไม่เกิน 500 ล้านบาทต่อปี\nภาคการค้าและการบริการ : จ้างงานไม่เกิน 30-100 คน / รายได้เกิน 50 ล้านบาท แต่ไม่เกิน 300 ล้านบาทต่อปี
        *** กิจการขนาดใหญ่\nจ้างงานมากกว่า 200 คน / รายได้มากกว่า 500 ล้านบาท
        */
      },
      { // 3
        questionText: 'ท่านต้องการหาเงินทุนด้วยวิธีการใด ?',
        choiceList: [
          {text: 'อยากกู้ยืม', value: false, nextQuestion: -1, resultList: ['a', 'c']},
          {text: 'อยากหาคน\nร่วมลงทุน', value: false, nextQuestion: -1, resultList: ['b', 'd']},
        ],
      },
      { // 4
        questionText: 'ท่านต้องการหาเงินทุนด้วยวิธีการใด ?',
        choiceList: [
          {text: 'อยากกู้ยืม', value: false, nextQuestion: -1, resultList: ['a', 'c']},
          {text: 'อยากหาคน\nร่วมลงทุน', value: false, nextQuestion: -1, resultList: ['b', 'd', 'e']},
        ],
      },
      { // 5
        questionText: 'ท่านต้องการหาเงินทุนด้วยวิธีการใด ?',
        choiceList: [
          {text: 'อยากกู้ยืม', value: false, nextQuestion: -1, resultList: ['a']},
          {text: 'อยากหาคน\nร่วมลงทุน', value: false, nextQuestion: -1, resultList: ['b', 'f']},
        ],
      },
      { // 6
        questionText: 'ปัจจุบันท่านจดทะเบียนเข้าซื้อขายอยู่ในตลาดหลักทรัพย์หรือไม่ ?',
        choiceList: [
          {text: 'จดทะเบียนซื้อขาย\nอยู่ในตลาดหลักทรัพย์', value: false, nextQuestion: 7},
          {text: 'ยังไม่ได้จดทะเบียน\nเข้าซื้อขาย\nในตลาดหลักทรัพย์', value: false, nextQuestion: 8},
        ],
      },
      { // 7
        questionText: 'ท่านต้องการหาเงินทุนด้วยวิธีการใด ?',
        choiceList: [
          {text: 'อยากกู้ยืม', value: false, nextQuestion: -1, resultList: ['g']},
          {text: 'อยากหาคน\nร่วมลงทุน', value: false, nextQuestion: -1, resultList: ['h']},
        ],
      },
      { // 8
        questionText: 'ท่านต้องการหาเงินทุนด้วยวิธีการใด ?',
        choiceList: [
          {text: 'อยากกู้ยืม', value: false, nextQuestion: -1, resultList: ['a', 'g']},
          {text: 'อยากหาคน\nร่วมลงทุน', value: false, nextQuestion: -1, resultList: ['b', 'f', 'k']},
        ],
      },
    ];

    Vue.component('surveyForm', {
      template: `
      <div
        :id="'survey-form'"
        class="survey-form"
        :style="'display: none'"
      >
      <h3 class="color-inactive mt-3 text-center">คำถามที่ @{{ (questionHistoryList.length + 1).toString() }}</h3>
      <h1 class="text-center">@{{ currentQuestion.questionText }}</h1>
      <ul class="survey-options mt-4">
        <div class="empty" v-if="currentQuestion.choiceList.length === 2"></div>
        <li
          v-for="(choice, optionIndex) in currentQuestion.choiceList"
          :class="getClass(optionIndex, choice.value, currentQuestion.choiceList)"
          v-on:click="() => handleClickOption(optionIndex)"
        >
          <h2 class="mt-3 mb-3"><span style="white-space: pre;">@{{ choice.text }}</span></h2>
          <div class="survey-option-badge" v-if="choice.value">
            <i class="fa fa-check" style="color: white"></i>
          </div>
        </li>
        <div class="empty" v-if="currentQuestion.choiceList.length === 2"></div>
      </ul>
      <div v-if="currentQuestion.remark != null" class="mt-3">
        <p
          v-for="remark in currentQuestion.remark"
          class="mb-1 ml-2 mr-2"
          style="font-size: 0.9em"
        >@{{ remark }}</p>
      </div>
      <div class="button-container">
        <button
          v-bind:style="{zIndex: 1000, display: questionHistoryList.length === 0 ? 'none' : 'block'}"
          v-on:click="handleClickPrevious"
        >
          <h5><i class="fa fa-chevron-left"></i>
            &nbsp;&nbsp;ย้อนกลับ
          </h5>
        </button>
        <div class="m-2"></div>
        <button
          class="mt-4 mt-lg-5 mb-4 mb-lg-5"
          style="z-index: 1000"
          v-on:click="handleClickNext"
          :disabled="currentQuestion.choiceList.find(choice => choice.value) == null"
        >
          <h5>@{{ currentQuestion.buttonText == null ? 'ถัดไป' : currentQuestion.buttonText }}&nbsp;&nbsp;
            <i :class="currentQuestion.buttonIconClass == null ? 'fa fa-chevron-right' : currentQuestion.buttonIconClass"></i>
          </h5>
        </button>
      </div>
      </div>
    `,
      props: {
        onEndSurvey: Function,
      },
      data: function () {
        return {
          questionList,
          questionHistoryList: [],
          currentQuestion: questionList[0],
          questionNumber: 1,
        }
      },
      methods: {
        getClass(index, value, choiceList) {
          let cl = '';
          if (value) {
            cl += 'on'
          }
          if (index !== choiceList.length - 1) {
            cl += ' mr-lg-4 mb-3 mb-sm-3 mb-md-4 mb-lg-0';
          }
          return cl;
        },
        handleClickOption(optionIndex) {
          this.currentQuestion.choiceList.forEach(choice => choice.value = false);
          this.currentQuestion.choiceList[optionIndex].value = true;
        },
        handleClickPrevious() {
          if (this.questionHistoryList.length === 0) {
            return;
          }

          this.changeQuestion(() => {
            this.currentQuestion = this.questionHistoryList.pop();
          });
        },
        handleClickNext() {
          const selectedChoice = this.currentQuestion.choiceList.find(choice => choice.value);

          if (selectedChoice == null) {
            alert('กรุณาเลือกคำตอบ');
            return;
          } else if (selectedChoice.nextQuestion === -1) {
            //alert('จบ flow, หน้าผลลัพธ์ยังทำไม่เสร็จ - coming soon :D');

            if (selectedChoice.resultList == null) {
              alert('Under construction!');
              return;
            }

            if (this.onEndSurvey != null) {
              this.onEndSurvey(selectedChoice.resultList);
            }
            return;
          }

          this.changeQuestion(() => {
            this.questionHistoryList.push(this.currentQuestion);
            this.currentQuestion = this.questionList[selectedChoice.nextQuestion];
          });
        },
        changeQuestion(func) {
          const surveyForm = $('#survey-form');
          surveyForm.fadeOut(300, () => {
            window.scrollTo(0, 0);
            func();
            surveyForm.fadeIn(300, () => {
            })
          });
        },
      }
    });

    const app = new Vue({
      el: '#app',
      data: {
        message: 'Vue.js is working!',
        resultText: null,
        imageVisible: false,
        resultPageList: [],
        buttonText: null,
        buttonClickUrl: null,
        isSubmitting: false,
      },
      methods: {
        handleClickStartSurvey() {
          const surveyBegin = $('.survey-begin');
          const surveyForm = $('#survey-form');
          surveyBegin.fadeOut(300, () => {
            $('.survey-footer').removeClass('mr-0');
            window.scrollTo(0, 0);
            surveyForm.fadeIn(300, () => {
              this.imageVisible = true;
            });
          });
        },
        handleClickReadMore(item) {
          if (item.pageId > 0) {
            window.open(`/fundraising/${item.pageId}`);
          } else {
            if (item.url != null) {
              window.open(item.url, '_blank');
            } else {
              alert('ขออภัย ยังไม่มีหน้ารายละเอียดของหัวข้อนี้');
            }
          }
        },
        handleClickSurveyAgain() {
          location.reload();
        },
        handleClickShare() {
          alert('Coming soon');
        },
        handleEndSurvey(resultList) {
          const surveyEnd = $('.survey-end');
          const surveyForm = $('#survey-form');
          surveyForm.fadeOut(300, () => {
            $('.survey-footer').addClass('mr-0');

            if (resultList[0] === 'x') {
              const resultPage = resultList.map(item => {
                return fundraisingPageList.filter(o => o.id === item)[0];
              })[0];
              this.resultText = resultPage.text;
              this.buttonText = resultPage.buttonText;
              this.buttonClickUrl = resultPage.url;
            } else {
              this.resultPageList = resultList.map(item => {
                return fundraisingPageList.filter(o => o.id === item)[0];
              });
              this.resultText = null;
              this.buttonText = null;
              /*this.resultText = this.resultPageList.reduce((total, item) => {
                return total + (total === '' ? '' : ' หรือ ') + item.text;
              }, '');*/
            }

            this.imageVisible = false;
            window.scrollTo(0, 0);
            surveyEnd.fadeIn(300, () => {
            });

            const result = resultList.reduce((total, item, index) => {
              return total += (index === 0 ? '' : ',') + item;
            }, '');
            this.submitResult(result);
          });
        },
        submitResult(result) {
          this.isSubmitting = true;
          axios.post(`/api/survey`, {
            result,
          })
            .then(response => {
            })
            .catch(error => {
              console.log(error);
            })
            .then(() => { // always executed
              this.isSumitting = false;
            });
        }
      }
    });
  </script>
@endsection
