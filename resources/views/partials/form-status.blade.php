@if (session('message'))
  <div class="col-md-12 col-lg-12">
    <div class="alert alert-{{ Session::get('status') }} border-{{ Session::get('status') }} py-4">
        <button type="button" class="close"
            data-dismiss="alert" aria-label="Close">
            <i
                class="icofont icofont-close-line-circled"></i>
        </button>
        <strong>{{ Session::get('status') }}!</strong> {{ session('message') }}
    </div>
</div>
@endif

@if (session('success'))
  <div class="col-md-12 col-lg-12">
    <div class="alert alert-success border-success py-4">
        <button type="button" class="close"
            data-dismiss="alert" aria-label="Close">
            <i
                class="icofont icofont-close-line-circled"></i>
        </button>
        <strong>Success !</strong> {{ session('success') }}
    </div>
</div>
@endif

@if (session()->has('status'))
  @if(session()->get('status') == 'wrong')
    <div class="col-md-12 col-lg-12">
      <div class="alert alert-danger border-danger py-4">
          <button type="button" class="close"
              data-dismiss="alert" aria-label="Close">
              <i
                  class="icofont icofont-close-line-circled"></i>
          </button>
           {{ session('success') }}
      </div>
    </div>
  @endif
@endif

@if (session('error'))
  <div class="col-md-12 col-lg-12">
    <div class="alert alert-danger border-danger py-4">
        <button type="button" class="close"
            data-dismiss="alert" aria-label="Close">
            <i
                class="icofont icofont-close-line-circled"></i>
        </button>
        <h5>
            <strong style="font-weight: bold;">System Error ! : </strong> {{ session('error') }}
        </h5>
    </div>
</div>
@endif

@if (session('warning'))
  <div class="col-md-12 col-lg-12">
    <div class="alert alert-warning border-warning py-4">
        <button type="button" class="close"
            data-dismiss="alert" aria-label="Close">
            <i
                class="icofont icofont-close-line-circled"></i>
        </button>
        <h5>
            <strong>Warning !</strong> {{ session('warning') }}
        </h5>
    </div>
</div>
@endif


@if (session('errors') && count($errors) > 0)
  <div class="col-md-12 col-lg-12">
    <div class="alert alert-danger border-danger py-4">
      <button type="button" class="close"
              data-dismiss="alert" aria-label="Close">
              <i
                  class="icofont icofont-close-line-circled"></i>
          </button>
      <h4>
        <i class="icon fa fa-warning fa-fw" aria-hidden="true"></i>
        <strong>Whoops ! </strong> There were some problems with your input.
      </h4>
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
