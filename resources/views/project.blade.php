
@extends('templates/main_tpl')

@section('content')
<section class="project-container">
  <div class="project-grid">
  @foreach($projects as $project)
    <div class="item" data-info="{{ json_encode($project) }}">
      <div class="wrapper">
        <a href="#" class="view-more">
          <i class="fas fa-expand"></i>
          &nbsp; ZOOM
        </a>
      </div>
      <img src="{{ asset('images/' . $project['image']) }}" alt="" />
      <div class="project-description">
        <h4>{{ $project['title'] }} ({{ $project['year'] }})</h4>
        <p>{{ $project['description'] }}</p>
      </div>
    </div>
  @endforeach
  </div>
</section>
@endsection