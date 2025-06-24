@extends('layouts.template')
@section('base.css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.4/css/responsive.bootstrap5.css">
    <link href="{{ asset('vendors/choices/choices.min.css') }}" rel="stylesheet" />
@endsection
@section('content')
    <div class="row g-3 mb-3">
        <div class="col-xl-7 col-lg-12">
            <div class="card h-100">
                <div class="bg-holder bg-card"
                    style="background-image:url(../asset/img/icons/spot-illustrations/corner-3.png);">
                </div>
                <!--/.bg-holder-->

                <div class="card-header z-index-1">
                    <h5 class="text-primary">Welcome to {{ Auth::user()->fullname }}! </h5>
                    <h6 class="text-600">Here are some quick links for you to start </h6>
                </div>
                <div class="card-body z-index-1">
                    <div class="row g-2 h-100 align-items-end">
                        <div class="col-sm-6 col-md-5">
                            <div class="d-flex position-relative">
                                <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><svg
                                        class="svg-inline--fa fa-chess-rook fa-w-12 text-primary" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="chess-rook" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M368 32h-56a16 16 0 0 0-16 16v48h-48V48a16 16 0 0 0-16-16h-80a16 16 0 0 0-16 16v48H88.1V48a16 16 0 0 0-16-16H16A16 16 0 0 0 0 48v176l64 32c0 48.33-1.54 95-13.21 160h282.42C321.54 351 320 303.72 320 256l64-32V48a16 16 0 0 0-16-16zM224 320h-64v-64a32 32 0 0 1 64 0zm144 128H16a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h352a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z">
                                        </path>
                                    </svg><!-- <span class="fas fa-chess-rook text-primary"></span> Font Awesome fontawesome.com -->
                                </div>
                                <div class="flex-1"><a class="stretched-link" href="#!">
                                        <h6 class="text-800 mb-0">General</h6>
                                    </a>
                                    <p class="mb-0 fs--2 text-500">Customize with a few clicks</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5">
                            <div class="d-flex position-relative">
                                <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><svg
                                        class="svg-inline--fa fa-crown fa-w-20 text-warning" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="crown" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M528 448H112c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h416c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm64-320c-26.5 0-48 21.5-48 48 0 7.1 1.6 13.7 4.4 19.8L476 239.2c-15.4 9.2-35.3 4-44.2-11.6L350.3 85C361 76.2 368 63 368 48c0-26.5-21.5-48-48-48s-48 21.5-48 48c0 15 7 28.2 17.7 37l-81.5 142.6c-8.9 15.6-28.9 20.8-44.2 11.6l-72.3-43.4c2.7-6 4.4-12.7 4.4-19.8 0-26.5-21.5-48-48-48S0 149.5 0 176s21.5 48 48 48c2.6 0 5.2-.4 7.7-.8L128 416h384l72.3-192.8c2.5.4 5.1.8 7.7.8 26.5 0 48-21.5 48-48s-21.5-48-48-48z">
                                        </path>
                                    </svg><!-- <span class="fas fa-crown text-warning"></span> Font Awesome fontawesome.com -->
                                </div>
                                <div class="flex-1"><a class="stretched-link" href="#!">
                                        <h6 class="text-800 mb-0">Upgrade to pro</h6>
                                    </a>
                                    <p class="mb-0 fs--2 text-500">Try Pro for 14 days free! </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5">
                            <div class="d-flex position-relative">
                                <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><svg
                                        class="svg-inline--fa fa-video fa-w-18 text-success" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="video" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M336.2 64H47.8C21.4 64 0 85.4 0 111.8v288.4C0 426.6 21.4 448 47.8 448h288.4c26.4 0 47.8-21.4 47.8-47.8V111.8c0-26.4-21.4-47.8-47.8-47.8zm189.4 37.7L416 177.3v157.4l109.6 75.5c21.2 14.6 50.4-.3 50.4-25.8V127.5c0-25.4-29.1-40.4-50.4-25.8z">
                                        </path>
                                    </svg><!-- <span class="fas fa-video text-success"></span> Font Awesome fontawesome.com -->
                                </div>
                                <div class="flex-1"><a class="stretched-link" href="#!">
                                        <h6 class="text-800 mb-0">Create a meeting</h6>
                                    </a>
                                    <p class="mb-0 fs--2 text-500">Manage and update your meetings</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-5">
                            <div class="d-flex position-relative">
                                <div class="icon-item icon-item-sm border rounded-3 shadow-none me-2"><svg
                                        class="svg-inline--fa fa-user fa-w-14 text-info" aria-hidden="true"
                                        focusable="false" data-prefix="fas" data-icon="user" role="img"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg="">
                                        <path fill="currentColor"
                                            d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z">
                                        </path>
                                    </svg><!-- <span class="fas fa-user text-info"></span> Font Awesome fontawesome.com -->
                                </div>
                                <div class="flex-1"><a class="stretched-link" href="#!">
                                        <h6 class="text-800 mb-0">Members activity</h6>
                                    </a>
                                    <p class="mb-0 fs--2 text-500">Monitor activity and supervise</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-md-6">
            <div class="card h-100">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col">
                            <p class="mb-1 fs--2 text-500">Upcoming schedule</p>
                            <h5 class="text-primary fs-0">MCU Prosess</h5>
                        </div>
                        <div class="col-auto">
                            <div class="bg-soft-primary px-3 py-3 rounded-circle text-center"
                                style="width:60px;height:60px;">
                                <h5 class="text-primary mb-0 d-flex flex-column mt-n1"><span>09</span><small
                                        class="text-primary fs--2 lh-1">MAR</small></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body d-flex align-items-end">
                    <div class="row g-3 justify-content-between">
                        <div class="col-10 mt-0">
                            <p class="fs--1 text-600 mb-0">The very first general meeting for planning Falcon’s design and
                                development roadmap</p>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success w-100 fs--1" type="button"><span
                                    class="fas fa-hourglass-start"></span> Run Progress</button>
                        </div>
                        <div class="col-auto ps-0">
                            <div class="avatar-group avatar-group-dense">
                                <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                                    <img class="rounded-circle" src="../asset/img/team/1-thumb.png" alt="">

                                </div>
                                <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                                    <img class="rounded-circle" src="../asset/img/team/2-thumb.png" alt="">

                                </div>
                                <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                                    <img class="rounded-circle" src="../asset/img/team/3-thumb.png" alt="">

                                </div>
                                <div class="avatar avatar-xl border border-3 border-light rounded-circle">
                                    <div class="avatar-name rounded-circle "><span>+50</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Frequently asked questions</h5>
        </div>
        <div class="card-body bg-light pb-0">
            <div class="row">
                <div class="col-lg-6">
                    <h5 class="fs-0">How does Falcon's pricing work?</h5>
                    <p class="fs--1">The free version of Falcon is available for teams of up to 15 people. Our Falcon
                        Premium plans of 15 or fewer qualify for a small team discount. As your team grows to 20 users or
                        more and gets more value out of Falcon, you'll get closer to our standard monthly price per seat.
                        The price of a paid Falcon plan is tiered, starting in groups of 5 and 10 users, based on the number
                        of people you have in your Team or Organization.</p>
                    <h5 class="fs-0">What forms of payment do you accept?</h5>
                    <p class="fs--1">You can purchase Falcon with any major credit card. For annual subscriptions, we can
                        issue an invoice payable by bank transfer or check. Please contact us to arrange an invoice
                        purchase. Monthly purchases must be paid for by credit card.</p>
                    <h5 class="fs-0">We need to add more people to our team. How will that be billed?</h5>
                    <p class="fs--1">You can add as many new teammates as you need before changing your subscription. We
                        will subsequently ask you to correct your subscription to cover current usage.</p>
                    <h5 class="fs-0">How secure is Falcon?</h5>
                    <p class="fs--1">Protecting the data you trust to Falcon is our first priority. Falcon uses physical,
                        procedural, and technical safeguards to preserve the integrity and security of your information. We
                        regularly back up your data to prevent data loss and aid in recovery. Additionally, we host data in
                        secure SSAE 16 / SOC1 certified data centers, implement firewalls and access restrictions on our
                        servers to better protect your information, and work with third party security researchers to ensure
                        our practices are secure.</p>
                </div>
                <div class="col-lg-6">
                    <h5 class="fs-0">Will I be charged sales tax?</h5>
                    <p class="fs--1">As of May 2016, state and local sales tax will be applied to fees charged to
                        customers with a billing address in the State of New York.</p>
                    <h5 class="fs-0">Do you offer discounts?</h5>
                    <p class="fs--1">We've built in discounts at each tier for teams smaller than 15 members. We also
                        offer two months for free in exchange for an annual subscription.</p>
                    <h5 class="fs-0">Do you offer academic pricing?</h5>
                    <p class="fs--1">We're happy to work with student groups using Falcon. Contact Us</p>
                    <h5 class="fs-0">Is there an on-premise version of Falcon?</h5>
                    <p class="fs--1">We are passionate about the web. We don't plan to offer an internally hosted version
                        of Falcon. We hope you trust us to provide a robust and secure service so you can do the work only
                        your team can do.</p>
                    <h5 class="fs-0">What is your refund policy?</h5>
                    <p class="fs--1">We do not offer refunds apart from exceptions listed below. If you cancel your plan
                        before the next renewal cycle, you will retain access to paid features until the end of your
                        subscription period. When your subscription expires, you will lose access to paid features and all
                        data associated with those features. Exceptions to our refund policy: canceling within 48 hours of
                        initial charge will result in a full refund. If you cancel within this timeframe, you will lose
                        access to paid features and associated data immediately upon canceling.</p>
                </div>
            </div>
        </div>
        <div class="card-footer py-3">
            <div class="text-center">
                <h6 class="fs-0 fw-normal">Have more questions?</h6><a class="btn btn-falcon-primary btn-sm"
                    href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Ask us anything</a>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content border-0">
                        <div class="modal-header bg-card-gradient light">
                            <h5 class="modal-title text-white" id="exampleModalLabel">Ask your question</h5>
                            <button class="btn-close btn-close-white text-white" type="button" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input class="form-control" id="name" type="text">
                                </div>
                                <div class="mb-3">
                                    <label for="emailModal">Email</label>
                                    <input class="form-control" id="emailModal" type="email">
                                </div>
                                <div class="mb-3">
                                    <label for="question">Question</label>
                                    <textarea class="form-control" id="question" rows="4"></textarea>
                                </div>
                            </form>
                            <button class="btn btn-primary btn-sm px-4" type="submit"><svg
                                    class="svg-inline--fa fa-paper-plane fa-w-16 me-2" aria-hidden="true"
                                    focusable="false" data-prefix="fas" data-icon="paper-plane" role="img"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg="">
                                    <path fill="currentColor"
                                        d="M476 3.2L12.5 270.6c-18.1 10.4-15.8 35.6 2.2 43.2L121 358.4l287.3-253.2c5.5-4.9 13.3 2.6 8.6 8.3L176 407v80.5c0 23.6 28.5 32.9 42.5 15.8L282 426l124.6 52.2c14.2 6 30.4-2.9 33-18.2l72-432C515 7.8 493.3-6.8 476 3.2z">
                                    </path>
                                </svg><!-- <span class="fas fa-paper-plane me-2" aria-hidden="true"> </span> Font Awesome fontawesome.com -->Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('base.js')
    <div class="modal fade" id="modal-user" data-bs-keyboard="false" data-bs-backdrop="static" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="false">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0">
                <div class="position-absolute top-0 end-0 mt-3 me-3 z-index-1">
                    <button class="btn-close btn btn-sm btn-circle d-flex flex-center transition-base"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="menu-user"></div>
            </div>
        </div>
    </div>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.4/js/responsive.bootstrap5.js"></script>
    <script src="{{ asset('vendors/choices/choices.min.js') }}"></script>
    <script>
        new DataTable('#example', {
            responsive: true
        });
    </script>
    {{-- <script>
        $(document).on("click", "#button-add-data-user", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-user').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('masteradmin_user_add') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-user').html(data);
            }).fail(function() {
                $('#menu-user').html('eror');
            });
        });
        $(document).on("click", "#button-edit-data-user", function(e) {
            e.preventDefault();
            var code = $(this).data("code");
            $('#menu-user').html(
                '<div class="spinner-border my-3" style="display: block; margin-left: auto; margin-right: auto;" role="status"><span class="visually-hidden">Loading...</span></div>'
            );
            $.ajax({
                url: "{{ route('masteradmin_user_edit') }}",
                type: "POST",
                cache: false,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "code": code
                },
                dataType: 'html',
            }).done(function(data) {
                $('#menu-user').html(data);
            }).fail(function() {
                $('#menu-user').html('eror');
            });

        });
    </script> --}}
@endsection
