<div class="js-flash-messages  respon-sm-6">
@if ($errors->all())
<div class="alert alert-danger" role="alert">
  <center>
      @foreach ($errors->all() as $error)
      <li><strong>{{ $error }}</strong></li>
      @endforeach
  </center>
</div>
@endif

@if (session('status'))
<div class="alert alert-{{session('alert')}}" role="alert">
    <center>
        {{ session('status') }}
    </center>
</div>
@endif

@if(Session::has('error'))
    <div class="alert alert-danger media">
        <button class="close media-object" data-dismiss="alert">
            <b aria-hidden="true">×</b><span class="sr-only">إخفاء</span></button>
        <div class="media-body message__body">{{ Session::get('error') }}</div>
    </div>
@endif
@if(Session::has('success'))
    <div class="alert alert-success media">
        <button class="close media-object" data-dismiss="alert">
            <b aria-hidden="true">×</b><span class="sr-only">إخفاء</span></button>
        <div class="media-body message__body">{{ Session::get('success') }}</div>
    </div>
@endif
</div>
