@extends('admin.layout.app')

@section('head_title', 'All Events')

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
                    <div class="page-header">
                        <div class="d-flex align-items-center flex-wrap" style="gap: 0.5rem">
                            <h3 class="page-title"> All Events </h3>
                            <a href="{{ route('events.create-new') }}"
                                class="btn btn-sm btn-primary d-flex align-items-center" style="padding: 8px!important;">
                                <i class="mdi mdi-calendar-plus" style="margin-right:unset!important;"></i>
                            </a>
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="mdi mdi-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Events</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="eventTable" class="table table-striped table-bordered" cellspacing="0"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Action</th>
                                                    <th>Live Chat</th>
                                                    <th>Event Name</th>
                                                    <th>Date & Time</th>
                                                    <th>Status<br>Started / Stopped</th>
                                                    <th>Renmark</th>
                                                    <th>Status<br>Active / Deleted</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
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
    <script type="text/javascript">
        function startLivechat(event, element) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to start the livechat?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    window.location.href = element.getAttribute('href');
                }
            });
        }

        function btnStopLivechat(event, element) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to stop the livechat?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    window.location.href = element.getAttribute('href');
                }
            });
        }

        function btnHistoryLivechat(event, element) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to see the history?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    window.open(element.getAttribute('href'));
                }
            });
        }

        function deleteEvent(event, element) {
            event.preventDefault();
            const href = element.getAttribute('href');

            Swal.fire({
                title: 'Confirm Your Choice',
                text: "Are you sure about your choice?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete Event',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    window.location.href = href;
                }
            });
        }

        function restoreEvent(event, element) {
            event.preventDefault();
            const href = element.getAttribute('href');

            Swal.fire({
                title: 'Confirm Your Choice',
                text: "Are you sure about your choice?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Restore Deleted Event',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    window.location.href = href;
                }
            });
        }
    </script>

    {{-- DataTables --}}
    <script src="{{ asset('template/assets/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            var table = $('#eventTable').DataTable({
                processing: true,
                // sScrollX: '100%',
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columnDefs: [{
                    className: "text-center",
                    targets: "_all"
                }],
                columns: getColumns()
            });
            table.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });

        function getColumns() {
            var columns = [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'livechat',
                    name: 'livechat',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return type === 'display' ? $('<div/>').html(data).text() : data;
                    }
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, row) {
                        return data.toUpperCase();
                    }
                },
                {
                    data: 'date_time',
                    name: 'date_time',
                    orderable: true,
                    searchable: true,
                    render: function(data, type, full, meta) {
                        return type === 'display' ? $('<div/>').html(data).text() : data;
                    }
                },
                {
                    data: 'status_start_stop',
                    name: 'status_start_stop',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return type === 'display' ? $('<div/>').html(data).text() : data;
                    }
                },
                {
                    data: 'renmark',
                    name: 'renmark',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return type === 'display' ? $('<div/>').html(data).text() : data;
                    }
                },
                {
                    data: 'status_deleted',
                    name: 'status_deleted',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, full, meta) {
                        return type === 'display' ? $('<div/>').html(data).text() : data;
                    }
                },
            ];
            return columns;
        }
    </script>
@endsection
