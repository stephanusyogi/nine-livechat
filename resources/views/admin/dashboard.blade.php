@extends('admin.layout.app')

@section('head_title', 'Dashboard')

@section('main')
    <!-- container-scroller -->
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.partials.sidebar')
        <!-- partial:partials/_sidebar.html -->
        <!-- page-body-wrapper starts -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_navbar.html -->
            @include('admin.partials.navbar')
            <!-- partial:partials/_navbar.html -->
            <!-- main-panel starts -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-12 grid-margin stretch-card">
                            <div class="card corona-gradient-card">
                                <div class="card-body py-0 px-0 px-sm-3">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-sm-3 col-xl-2">
                                            <img src="{{ asset('template/assets/images/dashboard/Group126@2x.png') }}"
                                                class="gradient-corona-img img-fluid" alt="">
                                        </div>
                                        <div class="col-5 col-sm-7 col-xl-8 p-0">
                                            <h4 class="mb-1 mb-sm-0">Who's up for a great time? Let's start the party!
                                            </h4>
                                            <p class="mb-0 font-weight-normal d-none d-sm-block">Lets connect with
                                                livechats...
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Total Administrator</h4>
                                    <canvas id="adminChart" style="height:250px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Total Event</h4>
                                    <canvas id="eventChart" style="height:250px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Event By Month</h4>
                                    <canvas id="eventMonthChart" style="height:130px"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                @include('admin.partials.footer')
                <!-- partial:partials/_footer.html -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
@endsection

@section('custom_script')
    <!-- Plugin js for this page -->
    <script src="{{ asset('template/assets/vendors/chart.js/Chart.min.js') }}"></script>
    <!-- End plugin js for this page -->
    <script>
        $(document).ready(function() {
            if ($("#adminChart").length) {
                $.ajax({
                    url: '{{ route('chart.admin') }}',
                    method: 'GET',
                    success: function(response) {
                        var ctx = $("#adminChart").get(0).getContext("2d");
                        var data = {
                            labels: ["Basic", "Super"],
                            datasets: [{
                                data: [response.basic, response.super],
                                backgroundColor: ['#FF6384', '#36A2EB'],
                            }]
                        };
                        var options = {
                            responsive: true,
                            legend: {
                                position: 'top',
                            },
                            animation: {
                                animateScale: true,
                                animateRotate: true
                            }
                        };
                        new Chart(ctx, {
                            type: 'doughnut',
                            data: data,
                            // options: options
                        });
                    }
                });
            }
            if ($("#eventChart").length) {
                $.ajax({
                    url: '{{ route('chart.event') }}',
                    method: 'GET',
                    success: function(response) {
                        var ctx = $("#eventChart").get(0).getContext("2d");
                        var data = {
                            labels: ["Total Events", "Finished Events", "Not Started Events"],
                            datasets: [{
                                data: [response.total, response.finished, response
                                    .not_started
                                ],
                                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'],
                            }]
                        };
                        var options = {
                            responsive: true,
                            legend: {
                                position: 'top',
                            },
                            animation: {
                                animateScale: true,
                                animateRotate: true
                            }
                        };
                        new Chart(ctx, {
                            type: 'doughnut',
                            data: data,
                            options: options
                        });
                    }
                });
            }
            if ($("#eventMonthChart").length) {
                $.ajax({
                    url: '{{ route('chart.eventByMonth') }}',
                    method: 'GET',
                    success: function(response) {
                        var ctx = $("#eventMonthChart").get(0).getContext("2d");
                        var data = {
                            labels: ["January", "February", "March", "April", "May", "June", "July",
                                "August", "September", "October", "November", "December"
                            ],
                            datasets: [{
                                label: 'Events',
                                data: Object.values(response),
                                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        };
                        var options = {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        };
                        new Chart(ctx, {
                            type: 'bar',
                            data: data,
                            options: options
                        });
                    }
                });
            }
        })
    </script>
@endsection
