@extends('pages.landingpage.layouts')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="section properties">
  <div class="container">
    <ul class="properties-filter">
      
    </ul>
    <div class="kostan">

    </div>
    
  </div>
</div>

  <script> 
      @foreach ($varJs as $varjsi)
          {!! $varjsi !!}
      @endforeach
  </script>
  @foreach ($javascriptFiles as $file)
      <script src="{{ $file }}"></script>
  @endforeach
@endsection