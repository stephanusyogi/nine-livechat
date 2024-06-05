<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nine - Livechat | @yield('head_title')</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/jvectormap/jquery-jvectormap.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/owl-carousel-2/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/owl-carousel-2/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/sweetalert2/dist/sweetalert2.min.css') }}">
    <link href="{{ asset('template/assets/vendors/datatables.net-bs4/css/dataTables.bootstrap4.css') }}"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/datetimepicker/jquery.datetimepicker.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/user.jpg') }}" />
    <!-- plugins:js -->
    <script src="{{ asset('template/assets/vendors/js/vendor.bundle.base.js') }}"></script>

    <style>
        .custom-swal-popup {
            height: auto !important;
            padding: 5px !important;
        }

        .custom-swal-title {
            font-size: 12px !important;
        }

        .dataTables_paginate {
            font-size: 0.875rem !important;
        }

        .form-control:disabled {
            background-color: #2a3038 !important;
        }

        input::placeholder {
            color: #d6d6d6 !important;
        }

        input:focus {
            color: #d6d6d6 !important;
        }

        select::placeholder {
            color: #d6d6d6 !important;
        }

        select:focus {
            color: #d6d6d6 !important;
        }
    </style>
    @yield('custom_css')
</head>

<body>
    @if (session('error_flash'))
        <script type="text/javascript">
            $(function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    showCloseButton: true,
                    allowEscapeKey: false,
                    type: 'error',
                    timer: 5000,
                    title: '{{ session('error_flash') }}',
                    customClass: {
                        popup: 'custom-swal-popup',
                        title: 'custom-swal-title',
                        icon: 'custom-swal-icon',
                    }
                });
            });
        </script>
    @endif
    @if (session('success_flash'))
        <script type="text/javascript">
            $(function() {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    showCloseButton: true,
                    allowEscapeKey: false,
                    type: 'success',
                    timer: 5000,
                    title: '{{ session('success_flash') }}',
                    customClass: {
                        popup: 'custom-swal-popup',
                        title: 'custom-swal-title',
                        icon: 'custom-swal-icon',
                    }
                });
            });
        </script>
    @endif

    @yield('main')

    {{-- Modal My Profile --}}
    <div class="modal fade" id="myProfileModal" tabindex="-1" aria-labelledby="myProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="myProfileForm" class="modal-content" action="{{ route('my-profile.update', $admin->id) }}"
                method="POST" autocomplete="off">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="myProfileModalLabel">My Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="forms-sample">
                        <div class="form-group text-left">
                            <label for="name_my"
                                class="@if ($errors->has('name_my')) text-danger @elseif(old('name_my') && !$errors->has('name_my'))
                              text-success @endif">Full
                                Name</label>
                            <input type="text"
                                class="form-control @if ($errors->has('name_my')) is-invalid text-danger @elseif(old('name_my') && !$errors->has('name_my'))
                            is-valid text-success @endif"
                                id="name_my" value="{{ old('name_my') ? old('name_my') : $admin->name }}"
                                name="name_my" placeholder="Name" required>
                            @error('name_my')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="email_my"
                                class="@if ($errors->has('email_my')) text-danger @elseif(old('email_my') && !$errors->has('email_my'))
                              text-success @endif">Email
                                Address</label>
                            <input type="email"
                                class="form-control @if ($errors->has('email_my')) is-invalid text-danger @elseif(old('email_my') && !$errors->has('email_my'))
                            is-valid text-success @endif"
                                id="email_my" value="{{ old('email_my') ? old('email_my') : $admin->email }}"
                                name="email_my" placeholder="Email Address" required>
                            @error('email_my')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="username_my"
                                class="@if ($errors->has('username_my')) text-danger @elseif(old('username_my') && !$errors->has('username_my'))
                              text-success @endif">Username</label>
                            <input type="text"
                                class="form-control @if ($errors->has('username_my')) is-invalid text-danger @elseif(old('username_my') && !$errors->has('username_my'))
                            is-valid text-success @endif"
                                id="username_my"
                                value="{{ old('username_my') ? old('username_my') : $admin->username }}"
                                name="username_my" placeholder="Username" required>
                            @error('username_my')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="type_my"
                                class="@if ($errors->has('type_my')) text-danger @elseif(old('type_my') && !$errors->has('type_my'))
                              text-success @endif">Type</label>
                            <select
                                class="form-control form-control text-light @if ($errors->has('type_my')) border-danger @elseif(old('type_my') && !$errors->has('type_my'))
                              border-success @endif"
                                id="type_my" name="type_my" required disabled>
                                <option value="">Choose Type...</option>
                                <option value="super"
                                    {{ old('type_my') ? (old('type_my') == 'super' ? 'selected' : '') : ($admin->type == 'super' ? 'selected' : '') }}>
                                    Super
                                </option>
                                <option value="basic"
                                    {{ old('type_my') ? (old('type_my') == 'basic' ? 'selected' : '') : ($admin->type == 'basic' ? 'selected' : '') }}>
                                    Basic
                                </option>
                            </select>
                            @error('type_my')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="password_my">Password</label>
                            <input type="password" class="form-control" id="password_my"
                                placeholder="Keep it Blank, if not changing password." name="password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- endinject -->
    @yield('custom_script')
    <script>
        $(document).ready(function() {
            $('#myProfileForm').on('submit', function(e) {
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
    </script>
    <!-- inject:js -->
    <script src="{{ asset('template/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('template/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('template/assets/js/misc.js') }}"></script>
    <script src="{{ asset('template/assets/js/settings.js') }}"></script>
    <script src="{{ asset('template/assets/js/todolist.js') }}"></script>
    <!-- Sweetalert -->
    <script src="{{ asset('template/assets/vendors/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <!-- endinject -->
</body>

</html>
