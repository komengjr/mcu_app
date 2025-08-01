@extends('layouts.template')
@section('base.css')

@endsection
@section('content')
<div class="row g-3 mb-3">
    <div class="col-xl-12 col-lg-12">
        <div class="card h-100 border border-danger">
            <div class="bg-holder bg-card"
                style="background-image:url(../asset/img/icons/spot-illustrations/corner-3.png);">
            </div>
            <!--/.bg-holder-->

            <div class="card-header z-index-1">
                <h5 class="text-primary">Welcome to {{ Auth::user()->fullname }}! </h5>
                <h6 class="text-600">Here are some quick links for you to start </h6>
            </div>

        </div>
    </div>
</div>
<div class="card mb-3">
    <div class="card-header bg-300">
        <div class="row flex-between-end">
            <div class="col-auto align-self-center">
                <h5 class="mb-0" data-anchor="data-anchor" id="example">Example<a class="anchorjs-link " aria-label="Anchor" data-anchorjs-icon="#" href="#example" style="padding-left: 0.375em;"></a></h5>
            </div>
        </div>
    </div>
    <div class="card-body bg-light">
        <div class="tab-content">
            <div class="tab-pane preview-tab-pane active" role="tabpanel" aria-labelledby="tab-dom-dec8938d-09f8-42ee-9f91-445061b03d85" id="dom-dec8938d-09f8-42ee-9f91-445061b03d85">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <div class="lottie mx-auto" style="width: 120px; height: 120px" data-options='{"path":"../../asset/img/animated-icons/check-primary-light.json"}'></div>
                    </div>
                    <div class="col-lg-4 mt-5 mt-lg-0">
                        <div class="lottie mx-auto" style="width: 130px; height: 130px" data-options='{"path":"../../asset/img/animated-icons/warning-light.json"}'></div>
                    </div>
                    <div class="col-lg-4">
                        <div class="lottie mx-auto" style="width: 220px; height: 220px" data-options='{"path":"../../asset/img/animated-icons/heart.json"}'></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
@section('base.js')
<script src="{{ asset('vendors/lottie/lottie.min.js') }}"></script>

@endsection
