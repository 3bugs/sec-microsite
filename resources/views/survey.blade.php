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
          <div class="pt-4 pt-sm-4 pt-lg-5 pl-3 pl-sm-4 pl-lg-5 pr-3 pr-sm-4 pr-md-0 mb-3" style="border: 0px solid blue; display: flex; flex: 1; flex-direction: column; justify-content: space-between">
            <div style="display: flex; flex-direction: column; border: 0px solid red">
              <h3><span style="color: #3877A0">หน้าแรก > </span><span style="color: black">สำรวจตัวเอง</span></h3>
              <img src="images/survey_start.svg" class="pt-3 pb-3 pl-4 pr-4 d-flex d-md-none align-self-center" style="width: 100%; max-width: 260px">
              <h1 class="mt-3" style="font-weight: 700; line-height: 1.4em;">
                <span style="color: black">ทำไมต้อง</span><br>
                <span style="color: #003558">สำรวจตัวเอง</span>
              </h1>
              <p class="mt-2 mb-1">ทำไมต้องสำรวจตัวเอง ไม่ต้องสำรวจหรอก ทำไมต้องสำรวจตัวเอง ไม่ต้องสำรวจหรอก ทำไมต้องสำรวจตัวเอง ไม่ต้องสำรวจหรอก ทำไมต้องสำรวจตัวเอง ไม่ต้องสำรวจหรอก
                ทำไมต้องสำรวจตัวเอง ไม่ต้องสำรวจหรอก ทำไมต้องสำรวจตัวเอง ไม่ต้องสำรวจหรอก
              </p>
            </div>
            <div style="display: flex; flex: 1; align-items: center;">
              <button class="mt-3 mt-md-4 mt-lg-4 mt-xl-4 mb-3 mb-md-4 mb-lg-4 mb-xl-4" v-on:click="handleClickStartSurvey">
                <h5>เริ่มแบบสำรวจ&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
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
          <div class="pt-4 pt-sm-4 pt-lg-5 pl-3 pl-sm-4 pl-lg-5 pr-3 pr-sm-4 pr-lg-5 mb-3" style="display: flex; flex: 1; flex-direction: column; justify-content: space-between; align-items: center">
            <img src="images/survey_start.svg" class="mt-2" style="width: 40%">

            <div style="display: flex; flex-direction: column; align-items: center">
              <h2 class="mt-3" style="font-weight: bold; line-height: 1.5em; color: #003558">@{{resultText}}</h2>
              <p class="mt-2 ml-5 mr-5 text-center d-none">ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์
                ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์ ผลลัพธ์
              </p>
            </div>
            <button class="mt-2" v-on:click="handleClickReadMore">
              <h5>อ่านต่อ 1&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
            </button>
            <button class="mt-2" v-on:click="handleClickReadMore">
              <h5>อ่านต่อ 2&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
            </button>
            <div class="mt-3 mt-md-4 mb-3 mb-md-4" style="display: flex; flex: 1; align-items: center;">
              <button class="mr-2 d-none" v-on:click="handleClickReadMore">
                <h5>อ่านต่อ&nbsp;&nbsp;<i class="fa fa-chevron-right"></i></h5>
              </button>
              <!--<div class="mr-2"></div>-->
              <button class="mr-2" v-on:click="handleClickShare" style="background-color: #8DC63F">
                <h5>แชร์&nbsp;&nbsp;<i class="fa fa-share-alt"></i></h5>
              </button>
              <!--<div class="mr-2"></div>-->
              <button v-on:click="handleClickSurveyAgain" style="background-color: #8DC63F">
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
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2"><a href="#">Link goes here</a></div>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2"><a href="#">Link goes here</a></div>
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
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>

  <script>
    const questionList = [
      {
        questionText: 'โปรดเลือกข้อมูลที่ตรงกับท่าน',
        choiceList: [
          {text: 'คุณได้ทำการ\nจดทะเบียนบริษัท', value: false, nextQuestion: 1},
          {text: 'คุณไม่เคย\nจดทะเบียนบริษัท', value: false, nextQuestion: 1},
          {text: 'คุณคือวิสาหกิจ\nเพื่อสังคม', value: false, nextQuestion: 1},
        ],
        buttonText: null,
        buttonIconClass: null,
      },
      {
        questionText: 'ประเภทสิ่งมีชีวิต',
        choiceList: [
          {text: 'คน', value: false, nextQuestion: 2},
          {text: 'สัตว์', value: false, nextQuestion: 3},
          {text: 'พืช', value: false, nextQuestion: -1},
        ],
        buttonText: null,
        buttonIconClass: null,
      },
      {
        questionText: 'เพศ',
        choiceList: [
          {text: 'ผู้หญิง', value: false, nextQuestion: -1},
          {text: 'ผู้ชาย', value: false, nextQuestion: -1},
        ],
        buttonText: null,
        buttonIconClass: null,
      },
      {
        questionText: 'ประเภทสัตว์',
        choiceList: [
          {text: 'สัตว์เลี้ยงลูก\nด้วยนม', value: false, nextQuestion: 4},
          {text: 'สัตว์สะเทินน้ำ\nสะเทินบก', value: false, nextQuestion: 5},
          {text: 'สัตว์เลื้อยคลาน', value: false, nextQuestion: 6},
        ],
        buttonText: null,
        buttonIconClass: null,
      },
      {
        questionText: 'สัตว์เลี้ยงลูกด้วยนม',
        choiceList: [
          {text: 'กระต่าย', value: false, nextQuestion: -1},
          {text: 'ช้าง', value: false, nextQuestion: -1},
          {text: 'โลมา', value: false, nextQuestion: -1},
        ],
        buttonText: null,
        buttonIconClass: null,
      },
      {
        questionText: 'สัตว์สะเทินน้ำสะเทินบก',
        choiceList: [
          {text: 'กบ', value: false, nextQuestion: -1},
          {text: 'ซาลามานเดอร์', value: false, nextQuestion: -1},
          {text: 'ตัวเงินตัวทอง', value: false, nextQuestion: -1},
        ],
        buttonText: null,
        buttonIconClass: null,
      },
      {
        questionText: 'สัตว์เลื้อยคลาน',
        choiceList: [
          {text: 'งู', value: false, nextQuestion: -1},
          {text: 'กิ้งก่า', value: false, nextQuestion: -1},
          {text: 'เต่า', value: false, nextQuestion: -1},
        ],
        buttonText: null,
        buttonIconClass: null,
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

            if (this.onEndSurvey != null) {
              this.onEndSurvey(selectedChoice.text);
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
        resultText: '',
        imageVisible: false,
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
        handleClickReadMore() {
          alert('Under construction.');
        },
        handleClickSurveyAgain() {
          location.reload();
        },
        handleClickShare() {
          alert('Coming soon');
        },
        handleEndSurvey(result) {
          const surveyEnd = $('.survey-end');
          const surveyForm = $('#survey-form');
          surveyForm.fadeOut(300, () => {
            $('.survey-footer').addClass('mr-0');
            this.resultText = result;
            this.imageVisible = false;
            window.scrollTo(0, 0);
            surveyEnd.fadeIn(300, () => {
            });
          });
        }
      }
    });
  </script>
@endsection
