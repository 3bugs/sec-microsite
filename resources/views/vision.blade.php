@extends('layouts.master')

@section('head')
@endsection

@section('content')
  @include('includes.header', [
    'title' => 'ก.ล.ต. กับ SMEs',
    'imageSrc' => 'images/bc-vision.png',
  ])

  <div id="app">
    TEST VISION
  </div>

  @include('includes.menu-footer')
@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/vue"></script>

  <script>
    const app = new Vue({
      el: '#app',
      data: {
      },
      methods: {
        test() {
        },
      }
    });
  </script>
@endsection
