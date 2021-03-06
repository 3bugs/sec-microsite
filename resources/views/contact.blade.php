@extends('layouts.master')

@section('head')
@endsection

@section('content')
  @include('includes.header', [
    'class' => 'contact',
    'title' => 'คลินิกระดมทุน',
    'imageSrc' => 'images/header-contact.svg',
    'bottom' => 0,
  ])

  <section class="container">
    @if (isset($formSubmitSuccess))
      @if ($formSubmitSuccess === true)
        <div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
          ได้รับข้อมูลการติดต่อเรียบร้อย
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @else
        <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
          เกิดข้อผิดพลาดในการบันทึกข้อมูล
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      @endif
    @endif

    <div class="row">
      <div class="col-12 col-md-6 headpage contact_info">
        <h2>ติดต่อเรา</h2>
        <p>สำนักงานคณะกรรมการกำกับหลักทรัพย์และตลาดหลักทรัพย์ <br>333/3 ถนนวิภาวดีรังสิต แขวงจอมพล เขตจตุจักร กรุงเทพมหานคร 10900</p>
        <h4>Help Center</h4>
        <div class="mb-2"><a href="tel:1207"><img src="images/hotline2.png" style="height: 35px;"></a></div>
        <div><a href="tel:020339999">Tel : 0-2033-9999</a></div>
        <div class="linkmail"><a href="mailto:info@sec.or.th">Email : info@sec.or.th</a></div>
        <div><a href="https://www.facebook.com/sec.or.th" target="_blank"><img src="images/001-facebook.svg"><span>สำนักงาน กลต.</span></a></div>
        <div><a href="https://www.youtube.com/user/insideSEC" target="_blank"><img src="images/002-youtube.svg"><span>ThaiSEC</span></a></div>
        <div><a href="https://twitter.com/ThaiSEC_News" target="_blank"><img src="images/003-twitter.svg"><span>ThaiSEC_News</span></a></div>
      </div>
      <div class="col-12 col-md-6">
        <form
            id="contact-form"
            class="bginquiry_form"
            @submit="handleSubmitForm"
            method="POST"
            novalidate="true"
        >
          {{ csrf_field() }}
          <h3>กรอกข้อมูลติดต่อกลับ</h3>
          <div class="form-group">
            <label for="name">ชื่อ นามสกุล:</label>
            <input
                id="name"
                v-model="name"
                name="name"
                type="text"
                class="form-control"
                maxlength="50"
            >
          </div>
          <div class="form-group">
            <label for="email">อีเมล:</label>
            <input
                id="email"
                v-model="email"
                name="email"
                type="email"
                class="form-control"
                maxlength="255"
            >
          </div>
          <div class="form-group">
            <label for="phone">เบอร์โทรศัพท์:</label>
            <input
                id="phone"
                v-model="phone"
                name="phone"
                type="tel"
                class="form-control"
                maxlength="50"
            >
          </div>
          <div class="form-group">
            <label for="message">ข้อความ:</label>
            <textarea
                id="message"
                v-model="message"
                name="message"
                class="form-control"
                rows="4"
            ></textarea>
          </div>
          <div class="form-group">
            <p v-if="errors.length > 0" style="color: red; margin-top: 1.5em; margin-bottom: 0.5em">
              <b>การกรอกข้อมูลมีข้อผิดพลาด:</b>
            <ul style="font-family: Sarabun; list-style: square; color: red">
              <li v-for="error in errors">@{{ error }}</li>
            </ul>
            </p>
            <button class="btn_submit" type="submit">ส่ง<i class="fa fa-chevron-right ml-3"></i></button>
          </div>
          <img class="img_girlplant" src="images/girlandplants.svg">
        </form>
      </div>
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>

  <script>
    const contactForm = new Vue({
      el: '#contact-form',
      data: {
        errors: [],
        name: '',
        email: '',
        phone: '',
        message: '',
      },
      methods: {
        handleSubmitForm(e) {
          this.errors = [];

          if (!this.isValid(this.name)) {
            this.errors.push('ต้องกรอกชื่อ');
          }
          if (!this.isValid(this.email)) {
            this.errors.push('ต้องกรอกอีเมล');
          } else if (!this.isValidEmail(this.email)) {
            this.errors.push('รูปแบบอีเมลไม่ถูกต้อง');
          }
          if (!this.isValid(this.phone)) {
            this.errors.push('ต้องกรอกเบอร์โทร');
          }
          if (!this.isValid(this.message)) {
            this.errors.push('ต้องกรอกข้อความ');
          }

          if (this.errors.length === 0) {
            return true;
          }

          e.preventDefault();
        },

        isValid(f) {
          return f != null && f.trim().length > 0;
        },

        isValidEmail: function (email) {
          const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
          return re.test(email);
        }
      }
    });
  </script>
@endsection
