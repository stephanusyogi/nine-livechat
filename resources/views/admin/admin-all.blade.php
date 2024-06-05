@extends('admin.layout.app')

@section('head_title', 'All Administrators')

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
                            <h3 class="page-title"> All Administrators </h3>
                            @if ($admin->hasRole('super'))
                                <!-- Button trigger add modal -->
                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center"
                                    data-toggle="modal" data-target="#addModal" style="padding: 8px!important;">
                                    <i class="mdi mdi-account-plus" style="margin-right:unset!important;"></i>
                                </button>
                                <!-- Add Modal -->
                                <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form id="addAdminForm" class="modal-content"
                                            action="{{ route('all-administrators.add') }}" method="POST"
                                            autocomplete="off">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLabel">Add New Administrator</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="forms-sample">
                                                    <div class="form-group">
                                                        <label for="name"
                                                            class="@if ($errors->has('name')) text-danger @elseif(old('name') && !$errors->has('name'))
                                                      text-success @endif">Full
                                                            Name</label>
                                                        <input type="text"
                                                            class="form-control @if ($errors->has('name')) is-invalid text-danger @elseif(old('name') && !$errors->has('name'))
                                                    is-valid text-success @endif"
                                                            id="name" value="{{ old('name') }}" name="name"
                                                            placeholder="Name">
                                                        @error('name')
                                                            <small class="mt-2 text-danger float-start">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email"
                                                            class="@if ($errors->has('email')) text-danger @elseif(old('email') && !$errors->has('email'))
                                                      text-success @endif">Email
                                                            Address</label>
                                                        <input type="email"
                                                            class="form-control @if ($errors->has('email')) is-invalid text-danger @elseif(old('email') && !$errors->has('email'))
                                                    is-valid text-success @endif"
                                                            id="email" value="{{ old('email') }}" name="email"
                                                            placeholder="Email Address">
                                                        @error('email')
                                                            <small class="mt-2 text-danger float-start">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="username"
                                                            class="@if ($errors->has('username')) text-danger @elseif(old('username') && !$errors->has('username'))
                                                      text-success @endif">Username</label>
                                                        <input type="text"
                                                            class="form-control @if ($errors->has('username')) is-invalid text-danger @elseif(old('username') && !$errors->has('username'))
                                                    is-valid text-success @endif"
                                                            id="username" value="{{ old('username') }}" name="username"
                                                            placeholder="Username">
                                                        @error('username')
                                                            <small class="mt-2 text-danger float-start">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="type"
                                                            class="@if ($errors->has('type')) text-danger @elseif(old('type') && !$errors->has('type'))
                                                      text-success @endif">Type</label>
                                                        <select
                                                            class="form-control form-control @if ($errors->has('type')) border-danger @elseif(old('type') && !$errors->has('type'))
                                                      border-success @endif"
                                                            id="type" name="type">
                                                            <option value="">Choose Type...</option>
                                                            <option value="super"
                                                                {{ old('type') == 'super' ? 'selected' : '' }}>Super
                                                            </option>
                                                            <option value="basic"
                                                                {{ old('type') == 'basic' ? 'selected' : '' }}>Basic
                                                            </option>
                                                        </select>
                                                        @error('type')
                                                            <small class="mt-2 text-danger float-start">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password"
                                                            class="@if ($errors->has('password')) text-danger @elseif(old('password') && !$errors->has('password'))
                                                      text-success @endif">Password</label>
                                                        <input type="password"
                                                            class="form-control @if ($errors->has('password')) is-invalid text-danger @elseif(old('password') && !$errors->has('password')) is-valid text-success @endif"
                                                            id="password" placeholder="Password" name="password"
                                                            value="{{ old('password') }}">
                                                        @error('password')
                                                            <small class="mt-2 text-danger float-start">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password_confirmation"
                                                            class="@if ($errors->has('password_confirmation')) text-danger @elseif(old('password_confirmation') && !$errors->has('password_confirmation'))
                                                      text-success @endif">Password
                                                            Confirmation</label>
                                                        <input type="password"
                                                            class="form-control @if ($errors->has('password_confirmation')) is-invalid text-danger @elseif(old('password_confirmation') && !$errors->has('password_confirmation')) is-valid text-success @endif""
                                                            id="password_confirmation" placeholder="Password"
                                                            name="password_confirmation"
                                                            value="{{ old('password_confirmation') }}">
                                                        @error('password_confirmation')
                                                            <small class="mt-2 text-danger float-start">
                                                                {{ $message }}
                                                            </small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                            class="mdi mdi-home"></i></a></li>
                                <li class="breadcrumb-item active" aria-current="page">All Administrators</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="adminTable" class="table table-striped table-bordered" cellspacing="0"
                                            width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    @if ($admin->hasRole('super'))
                                                        <th>Action</th>
                                                    @endif
                                                    <th>Full Name</th>
                                                    <th>Email</th>
                                                    <th>Username</th>
                                                    <th>Type</th>
                                                    @if ($admin->hasRole('super'))
                                                        <th>Actice / Deleted</th>
                                                        <th>Created By</th>
                                                    @endif
                                                    <th>Created At</th>
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
    @if ($errors->any())
        <script type="text/javascript">
            $(document).ready(function() {
                @if (session('form_type') === 'addAdmin')
                    $('#addModal').modal('show');
                @else
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        showCloseButton: true,
                        allowEscapeKey: false,
                        type: 'error',
                        timer: 5000,
                        title: 'Update data failed, please check again your data.',
                        customClass: {
                            popup: 'custom-swal-popup',
                            title: 'custom-swal-title',
                            icon: 'custom-swal-icon',
                        }
                    });
                @endif
            });
        </script>
    @endif

    <script type="text/javascript">
        $(document).ready(function() {
            $('#addAdminForm').on('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to submit the form?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, submit it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.value) {
                        this.submit();
                    }
                });
            });
        });

        function updateAdmin(event, element) {
            const action = element.getAttribute('action');
            event.preventDefault();

            var form = (element.tagName.toLowerCase() === 'form') ? element : element.closest('form');

            var csrfToken = "{{ csrf_token() }}";
            var csrfInput = document.createElement('input');
            csrfInput.setAttribute('type', 'hidden');
            csrfInput.setAttribute('name', '_token');
            csrfInput.setAttribute('value', csrfToken);

            form.appendChild(csrfInput);

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to submit the form?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    form.submit();
                }
            });
        }

        function deleteAdmin(event, element) {
            event.preventDefault();
            const href = element.getAttribute('href');

            Swal.fire({
                title: 'Confirm Your Choice',
                text: "Are you sure about your choice?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete Admin',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    window.location.href = href;
                }
            });
        }

        function restoreAdmin(event, element) {
            event.preventDefault();
            const href = element.getAttribute('href');

            Swal.fire({
                title: 'Confirm Your Choice',
                text: "Are you sure about your choice?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Restore Inactive Admin',
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
            var table = $('#adminTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columnDefs: [{
                    className: "text-center",
                    targets: "_all"
                }],
                serverSide: true,
                columns: getColumns()
            });
            table.on('draw', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        });

        function getColumns() {
            @if ($admin->hasRole('super'))
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
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'username',
                        name: 'username',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return type === 'display' ? $('<div/>').html(data).text() : data;
                        }
                    },
                    {
                        data: 'created_by',
                        name: 'created_by',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                const date = new Date(data);
                                return date.toLocaleString();
                            }
                            return data;
                        },
                        orderable: false,
                        searchable: false,
                    },
                ];
            @else
                var columns = [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'name',
                        name: 'name',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'email',
                        name: 'email',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'username',
                        name: 'username',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'type',
                        name: 'type',
                        orderable: true,
                        searchable: true,
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                const date = new Date(data);
                                return date.toLocaleString();
                            }
                            return data;
                        },
                        orderable: false,
                        searchable: false,
                    },
                ];
            @endif
            return columns;
        }
    </script>
@endsection
