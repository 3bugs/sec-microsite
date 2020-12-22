@extends('layouts.master')

@section('head')
  <style type="text/css">
    .my-container {
      position: relative;
      height: 400px;
    }

    .vertical-center {
      margin: 0;
      position: absolute;
      top: 50%;
      left: 50%;
      -ms-transform: translate(-50%, -50%);
      transform: translate(-50%, -50%);
      border: 0 solid red;
      color: #999;
    }
  </style>
@endsection

@section('content')
  <!--  <img src="{{ asset('images/under_construction.png') }}">-->
  <div class="my-container">
    <div class="vertical-center"><strong>UNDER CONSTRUCTION</strong></div>
  </div>
@endsection

@section('script')
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>

  <script>
    const app = new Vue({
      el: '#app',
      data: {},
      methods: {
        test() {
        },
      }
    });
  </script>
@endsection
