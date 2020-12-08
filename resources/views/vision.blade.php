@extends('layouts.master')

@section('head')
@endsection

@section('content')
  @include('includes.header', [
    'class' => 'vision',
    'title' => 'ก.ล.ต. กับ SMEs',
    'imageSrc' => 'images/header-vision.svg',
    'bottom' => -50,
  ])

  <section class="container mt-5">
    <div class="row">
      <div class="col-12 detailfd_text">
        {!! $data->content !!}
      </div>
    </div>
  </section>

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
