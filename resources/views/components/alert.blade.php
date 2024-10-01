<div>
    @if (Session::has('success'))
    <div class="col-lg-5 col-md-12 ml-auto">
        <div class="alert alert-success alert-dismissible modal-fade show" role="alert" id="overlay-alert">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @elseif (Session::has('errors'))
    @foreach ($errors->all() as $error)
    <div class="col-lg-5 col-md-12 ml-auto">
        <div class="alert alert-danger alert-dismissible modal-fade show" role="alert" id="overlay-alert">
            {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    @endforeach
    @endif
</div>