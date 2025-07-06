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

@endsection
@section('base.js')


@endsection
