<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Nine - Livechat</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('template/assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('images/user.jpg') }}" />
</head>
<style>
    .input-container {
        position: relative;
    }

    .input-container .form-control {
        padding-right: 30px;
        /* Add some right padding to prevent text overlap with the icon */
    }

    .input-container .icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        /* Optional: makes the icon look clickable */
    }

    .card {
        background: #191c24e6 !important;
    }
</style>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
                    <div class="card col-lg-4 mx-auto">
                        <div class="card-body px-5 py-5">
                            <h3 class="card-title text-left mb-3">Welcome Again,</h3>
                            @error('auth')
                                <div class="alert alert-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                            <form method="POST" action="{{ route('signin.action') }}" autocomplete="off">
                                @csrf
                                <div class="form-group">
                                    <label
                                        class="@if ($errors->has('username')) text-danger @elseif(old('username') && !$errors->has('username'))
                                      text-success @endif">Username*</label>
                                    <input type="text"
                                        class="form-control p_input @if ($errors->has('username')) is-invalid text-danger @elseif(old('username') && !$errors->has('username'))
                                        is-valid text-success @endif"
                                        value="{{ old('username') }}" name="username">
                                    @error('username')
                                        <small class="mt-2 text-danger float-start">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label
                                        class="@if ($errors->has('pass')) text-danger @elseif(old('pass') && !$errors->has('pass'))
                                      text-success @endif">Password
                                        *</label>
                                    <div>
                                        <div class="input-container">
                                            <input type="password" id="password"
                                                class="form-control p_input @if ($errors->has('pass')) is-invalid text-danger @elseif(old('pass') && !$errors->has('pass'))
                                            is-valid text-success @endif"
                                                value="{{ old('pass') }}" name="pass">
                                            <span class="icon" onclick="togglePassword()">
                                                <i class="mdi mdi-eye" id="toggleIcon"></i>
                                            </span>
                                        </div>
                                        @error('pass')
                                            <small class="mt-2 text-danger float-start">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                        <script>
                                            function togglePassword() {
                                                var passwordField = document.getElementById('password');
                                                var toggleIcon = document.getElementById('toggleIcon');

                                                if (passwordField.type === 'password') {
                                                    passwordField.type = 'text';
                                                    toggleIcon.classList.remove('mdi-eye');
                                                    toggleIcon.classList.add('mdi-eye-off');
                                                } else {
                                                    passwordField.type = 'password';
                                                    toggleIcon.classList.remove('mdi-eye-off');
                                                    toggleIcon.classList.add('mdi-eye');
                                                }
                                            }
                                        </script>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-secondary btn-block enter-btn">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('template/assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('template/assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('template/assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('template/assets/js/misc.js') }}"></script>
    <script src="{{ asset('template/assets/js/settings.js') }}"></script>
    <script src="{{ asset('template/assets/js/todolist.js') }}"></script>
    <!-- endinject -->
</body>

</html>
