<section class="container-fluid bg_breadcrumb">
  <div class="row">
    <div class="container">
      <div class="row">
        <div class="col-12 pagebreadcrumb" style="overflow-y: hidden">
          <a href="/">&#60; กลับหน้าแรก</a>
          <h1>{{ $title }}</h1>
          @if ($imageSrc !== '')
            <img src="{{ $imageSrc }}" class="img_breadcrumb {{ $class }}"
                 style="width: 340px; bottom: {{ $bottom }}px">
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
