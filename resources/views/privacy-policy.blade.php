@extends('layouts.master')

@section('head')
@endsection

@section('content')
  @include('includes.header', [
    'class' => 'cookie',
    'title' => 'นโยบายความเป็นส่วนตัว',
    'imageSrc' => 'images/cookie.svg',
    'bottom' => -100,
  ])

  <section class="container mt-5">
    <div class="row">
      <div class="col-12 detailfd_text">
        <h2>การใช้คุกกี้ของ ก.ล.ต.</h2>
        <p>คุกกี้ คือไฟล์ข้อความขนาดเล็กที่เว็บไซต์ที่คุณเข้าเยี่ยมชมวางไว้บนคอมพิวเตอร์ของคุณ
          คุกกี้ได้ถูกใช้อย่างมากมาย เพื่อที่จะทำให้เว็บไซต์ทำงาน หรือเพิ่มประสิทธิภาพการทำงาน รวมทั้งเก็บข้อมูลให้กับเจ้าของเว็บไซต์
          ตารางด้านล่างนี้แสดงคุกกี้และวัตถุประสงค์การใช้งานของคุกกี้แต่ละชนิดที่ ก.ล.ต. ใช้</p>

        <table style="width: 90%; margin-left: auto; margin-right: auto">
          <thead>
          <tr>
            <th style="vertical-align: top; padding: 5px 20px">คุกกี้</th>
            <th style="vertical-align: top; padding: 5px 20px">ชื่อ</th>
            <th style="vertical-align: top; padding: 5px 20px">วัตถุประสงค์การใช้งาน</th>
          </tr>
          </thead>
          <tbody>
          <tr>
            <td style="vertical-align: top; padding: 5px 20px"><p>Universal Analytics (Google)</p></td>
            <td style="vertical-align: top; padding: 5px 20px"><p><pre>_ga<br>_gali<br>_gat<br>_gid</pre></p></td>
            <td style="vertical-align: top; padding: 5px 20px"><p>คุกกี้เหล่านี้ถูกใช้เพื่อเก็บรวบรวมข้อมูลการใช้งานของผู้เข้าชมเว็บไซต์
                ก.ล.ต. ใช้ข้อมูลเหล่านี้มาประมวลผลจัดทำรายงานเพื่อพัฒนาปรับปรุงเว็บไซต์
                คุกกี้เหล่านี้จะเก็บข้อมูลที่ไม่ระบุตัวตนของบุคคล ตัวอย่างข้อมูลที่จัดเก็บ เช่น
                จำนวนผู้เข้าชมเว็บไซต์ หน้าเว็บไซต์ที่เข้าเยี่ยมชม เป็นต้น</p>
              <p>ข้อมูลเพิ่มเติม: <a href="https://support.google.com/analytics/answer/6004245">การรักษาความปลอดภัยและความเป็นส่วนตัวของข้อมูลของ Google</a></p>
            </td>
          </tr>
          </tbody>
        </table>

        <h2>จะเปลี่ยนการตั้งค่าคุกกี้ได้อย่างไร</h2>
        <p>คุณสามารถเปลี่ยนการตั้งค่าคุกกี้ของคุณได้ทุกเวลา โดยการกดที่ไอคอน “C” ที่มุมล่างซ้ายของหน้าเว็บไซต์
          จากนั้นเลื่อนปุ่ม เพื่อเลือก “เปิด” หรือ “ปิด” แล้วคลิก “บันทึกและปิด”
          โดยคุณอาจต้อง refresh หน้าจออีกครั้ง เพื่อให้การเปลี่ยนแปลงตัวเลือกของคุณทำงาน</p>
        <p>นอกจากนี้ เว็บเบราว์เซอร์ส่วนใหญ่ยอมให้คุณควบคุมคุกกี้ส่วนใหญ่ผ่านการกำหนดค่าที่เว็บเบราว์เซอร์เอง
          หากคุณต้องการศึกษาข้อมูลเพิ่มเติมเกี่ยวกับคุกกี้หรือวิธีการดูการกำหนดค่าคุกกี้ สามารถดูได้ที่</p>
        <p style="text-align: center"><a href="https://www.aboutcookies.org">www.aboutcookies.org</a> หรือ <a href="https://www.allaboutcookies.org">www.allaboutcookies.org</a></p>

        <h2>ค้นหาวิธีการจัดการคุกกี้ของเบราว์เซอร์ต่างๆ ได้จากลิงก์เหล่านี้</h2>
        <ul>
          <li><a href="https://support.google.com/accounts/answer/61416?co=GENIE.Platform%3DDesktop&hl=en">Google Chrome</a></li>
          <li><a href="https://privacy.microsoft.com/en-us/windows-10-microsoft-edge-and-privacy">Microsoft Edge</a></li>
          <li><a href="https://support.mozilla.org/en-US/kb/enable-and-disable-cookies-website-preferences">Mozilla Firefox</a></li>
          <li><a href="https://support.microsoft.com/en-gb/help/17442/windows-internet-explorer-delete-manage-cookies">Microsoft Internet Explorer</a></li>
          <li><a href="https://www.opera.com/help/tutorials/security/privacy/">Opera</a></li>
          <li><a href="https://support.apple.com/en-gb/safari">Apple Safari</a></li>
        </ul>

        <p>สำหรับเบราว์เซอร์อื่น สามารถค้นหาข้อมูลเพิ่มเติมได้จากเว็บไซต์ของผู้พัฒนาเบราว์เซอร์นั้น</p>
        <p>หากคุณไม่ต้องการให้ Google Analytics ติดตามข้อมูลคุณในเว็บไซต์ต่างๆ ที่คุณเยี่ยมชม โปรดไปที่ <a href="http://tools.google.com/dlpage/gaoptout">http://tools.google.com/dlpage/gaoptout</a>
        </p>
      </div>
    </div>
  </section>

  @include('includes.menu-footer')
@endsection

@section('script')
@endsection
