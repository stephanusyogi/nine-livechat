@extends('admin.layout.app')

@section('head_title', 'Create New Event')

@section('custom_css')
    <style>
        #videotron_background_image_preview,
        #visitor_background_image_preview {
            margin-top: 10px;
            max-width: 100%;
            border-radius: 5px;
        }

        .jscolor {
            border: 1px solid #2c2e33 !important;
            height: calc(2.25rem + 2px) !important;
            font-weight: normal !important;
            font-size: 0.875rem !important;
            padding: 0.625rem 0.6875rem !important;
            background-color: #2a3038 !important;
            border-radius: 2px !important;
            color: #ffffff !important;
            box-shadow: none !important;
            width: 100% !important;
            line-height: 1 !important;
            background-clip: padding-box !important;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
    </style>
@endsection

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
                    <form id="eventForm" action="{{ route('events.add') }}" method="post" autocomplete="off"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="page-header">
                            <div class="d-flex align-items-center flex-wrap" style="gap: 1rem">
                                <h3 class="page-title"> Create New Event </h3>
                                <button type="submit" class="btn btn-sm btn-primary">Save & Create</button>
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i
                                                class="mdi mdi-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('events') }}">Events</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Create New Event</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title">
                                            General Information
                                        </div>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group row">
                                                    <label for="name"
                                                        class="col-sm-3 col-form-label @if ($errors->has('name')) text-danger @elseif(old('name') && !$errors->has('name'))
                                                        text-success @endif">Event
                                                        Name:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text"
                                                            class="form-control @if ($errors->has('name')) is-invalid text-danger @elseif(old('name') && !$errors->has('name'))
                                                        is-valid text-success @endif"
                                                            id="name" name="name" placeholder="Event Name"
                                                            value="{{ old('name') }}">
                                                    </div>
                                                    @error('name')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                                <div class="form-group row">
                                                    <label for="date"
                                                        class="col-sm-3 col-form-label @if ($errors->has('date')) text-danger @elseif(old('date') && !$errors->has('date'))
                                                        text-success @endif">Event
                                                        Date:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text"
                                                            class="form-control @if ($errors->has('date')) is-invalid text-danger @elseif(old('date') && !$errors->has('date'))
                                                        is-valid text-success @endif"
                                                            id="date" name="date" placeholder="Event Date"
                                                            value="{{ old('date') }}">
                                                    </div>
                                                    @error('date')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                                <div class="form-group row">
                                                    <label for="time_start"
                                                        class="col-sm-3 col-form-label @if ($errors->has('time_start')) text-danger @elseif(old('time_start') && !$errors->has('time_start'))
                                                        text-success @endif">Event
                                                        Time Start:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text"
                                                            class="form-control @if ($errors->has('time_start')) is-invalid text-danger @elseif(old('time_start') && !$errors->has('time_start'))
                                                        is-valid text-success @endif"
                                                            id="time_start" name="time_start" placeholder="Event Time Start"
                                                            value="{{ old('time_start') }}">
                                                    </div>
                                                    @error('time_start')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                                <div class="form-group row">
                                                    <label for="time_end"
                                                        class="col-sm-3 col-form-label @if ($errors->has('time_end')) text-danger @elseif(old('time_end') && !$errors->has('time_end'))
                                                        text-success @endif">Event
                                                        Time End:</label>
                                                    <div class="col-sm-9">
                                                        <input type="text"
                                                            class="form-control @if ($errors->has('time_end')) is-invalid text-danger @elseif(old('time_end') && !$errors->has('time_end'))
                                                        is-valid text-success @endif"
                                                            id="time_end" name="time_end" placeholder="Event Time End"
                                                            value="{{ old('time_end') }}">
                                                    </div>
                                                    @error('time_end')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group row">
                                                    <label for=""
                                                        class="col-sm-3 col-form-label @if ($errors->has('status_expired')) text-danger @elseif(old('status_expired') && !$errors->has('status_expired'))
                                                        text-success @endif">Expired
                                                        Status:</label>
                                                    <div class="col-sm-9">
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input"
                                                                    name="status_expired" id="status_expired_true"
                                                                    value="true"
                                                                    {{ old('status_expired') ? (old('status_expired') === 'true' ? 'checked' : '') : '' }}>
                                                                Yes, I want to configure the live chat to stop automatically
                                                                when the end time is reached.</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <label class="form-check-label">
                                                                <input type="radio" class="form-check-input"
                                                                    name="status_expired" id="status_expired_false"
                                                                    value="false"
                                                                    {{ old('status_expired') ? (old('status_expired') === 'false' ? 'checked' : '') : '' }}>
                                                                No, I don't want the live chat to stop automatically when
                                                                the end time is reached.</label>
                                                        </div>
                                                    </div>
                                                    @error('status_expired')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                Videotron View Settings
                                            </div>
                                            <button id="defaultBtnVideotron" type="button"
                                                class="btn btn-sm btn-inverse-secondary">Use Default
                                                Style</button>
                                        </div>
                                        <div class="form-group">
                                            <label for=""
                                                class="@if ($errors->has('videotron_flag_background')) text-danger @elseif(old('videotron_flag_background') && !$errors->has('videotron_flag_background'))
                                                text-success @endif">Background
                                                Image / Background Color:</label>
                                            <div class="d-flex align-items-center" style="gap:0.5rem;">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                            name="videotron_flag_background"
                                                            id="videotron_flag_background_image" value="image">
                                                        Use Image as Background</label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                            name="videotron_flag_background"
                                                            id="videotron_flag_background_color" value="color">
                                                        Use Color as Background</label>
                                                </div>
                                            </div>
                                            @if (old('videotron_flag_background') && !$errors->has('videotron_flag_background'))
                                                <small class="mt-2 text-warning float-start col-sm-12">
                                                    Please re-select again.
                                                </small>
                                            @endif
                                            @error('videotron_flag_background')
                                                <small class="mt-2 text-danger float-start col-sm-12">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                        <div id="videotron-input-container"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div
                                            class="card-title d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                Visitor View Settings
                                            </div>
                                            <button id="defaultBtnVisitor" type="button"
                                                class="btn btn-sm btn-inverse-secondary">Use Default
                                                Style</button>
                                        </div>
                                        <div class="form-group">
                                            <label for=""
                                                class="@if ($errors->has('visitor_flag_background')) text-danger @elseif(old('visitor_flag_background') && !$errors->has('visitor_flag_background'))
                                                text-success @endif">Background
                                                Image / Background Color:</label>
                                            <div class="d-flex align-items-center" style="gap:0.5rem;">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                            name="visitor_flag_background"
                                                            id="visitor_flag_background_image" value="image">
                                                        Use Image as Background</label>
                                                </div>
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input type="radio" class="form-check-input"
                                                            name="visitor_flag_background"
                                                            id="visitor_flag_background_color" value="color">
                                                        Use Color as Background</label>
                                                </div>
                                            </div>
                                            @if (old('visitor_flag_background') && !$errors->has('visitor_flag_background'))
                                                <small class="mt-2 text-warning float-start col-sm-12">
                                                    Please re-select again.
                                                </small>
                                            @endif
                                            @error('visitor_flag_background')
                                                <small class="mt-2 text-danger float-start col-sm-12">
                                                    {{ $message }}
                                                </small>
                                            @enderror
                                        </div>
                                        <div id="visitor-input-container"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <div
                                            class="card-title d-flex align-items-center justify-content-between flex-wrap">
                                            <div>
                                                Message Bubble View Settings
                                            </div>
                                            <button id="defaultBtnBubble" type="button"
                                                class="btn btn-sm btn-inverse-secondary">Use Default
                                                Style</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""
                                                        class="@if ($errors->has('bubble_color_code_message_name')) text-danger @elseif(old('bubble_color_code_message_name') && !$errors->has('bubble_color_code_message_name'))
                                                        text-success @endif">Color
                                                        of Name Message Sender:</label>
                                                    <input id="bubble_color_code_message_name"
                                                        name="bubble_color_code_message_name"
                                                        data-jscolor="{value:'', position:'bottom', height:80, backgroundColor:'#333',
                                                        palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4',
                                                        paletteCols:11, hideOnPaletteClick:true}">
                                                    @error('bubble_color_code_message_name')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""
                                                        class="@if ($errors->has('bubble_color_code_message_time')) text-danger @elseif(old('bubble_color_code_message_time') && !$errors->has('bubble_color_code_message_time'))
                                                        text-success @endif">Color
                                                        of Time Message:</label>
                                                    <input id="bubble_color_code_message_time"
                                                        name="bubble_color_code_message_time"
                                                        data-jscolor="{value:'', position:'bottom', height:80, backgroundColor:'#333',
                                                        palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4',
                                                        paletteCols:11, hideOnPaletteClick:true}">
                                                    @error('bubble_color_code_message_time')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""
                                                        class="@if ($errors->has('bubble_color_code_message_text')) text-danger @elseif(old('bubble_color_code_message_text') && !$errors->has('bubble_color_code_message_text'))
                                                        text-success @endif">Color
                                                        of Message Text:</label>
                                                    <input id="bubble_color_code_message_text"
                                                        name="bubble_color_code_message_text"
                                                        data-jscolor="{value:'', position:'bottom', height:80, backgroundColor:'#333',
                                                        palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4',
                                                        paletteCols:11, hideOnPaletteClick:true}">
                                                    @error('bubble_color_code_message_text')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for=""
                                                        class="@if ($errors->has('bubble_color_code_message_background')) text-danger @elseif(old('bubble_color_code_message_background') && !$errors->has('bubble_color_code_message_background'))
                                                        text-success @endif">Color
                                                        of Message Bubble:</label>
                                                    <input id="bubble_color_code_message_background"
                                                        name="bubble_color_code_message_background"
                                                        data-jscolor="{value:'', position:'bottom', height:80, backgroundColor:'#333', palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4', paletteCols:11, hideOnPaletteClick:true}">
                                                    @error('bubble_color_code_message_background')
                                                        <small class="mt-2 text-danger float-start col-sm-12">
                                                            {{ $message }}
                                                        </small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script src="{{ asset('template/assets/vendors/moment/moment-with-locales.js') }}"></script>
    <script src="{{ asset('template/assets/vendors/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
    <script>
        $('#date').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y-m-d',
            theme: 'dark',
            scrollMonth: false,
            scrollInput: false
        });
        $('#time_start').datetimepicker({
            datepicker: false,
            format: 'H:i',
            step: 1,
            theme: 'dark'
        });
        $('#time_end').datetimepicker({
            datepicker: false,
            format: 'H:i',
            step: 1,
            theme: 'dark'
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Videotron
            $('#defaultBtnVideotron').click(function() {
                $.ajax({
                    url: '{{ route('events.set-default-style') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.videotron_flag_background === 'color') {
                            $('#videotron_flag_background_color').prop('checked', true);
                        }
                        updateInputFieldVideotron(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });

            $('input[name="videotron_flag_background"]').change(function() {
                updateInputFieldVideotron();
            });

            function updateInputFieldVideotron(response = []) {
                const inputContainerVideotron = $('#videotron-input-container');
                inputContainerVideotron.empty();

                if ($('#videotron_flag_background_image').is(':checked')) {
                    inputContainerVideotron.append(`
                    <div class="form-group">
                        <label for="videotron_background_image">File Background Image: <br><small class="text-info">(*file size must be less than 3MB)</small></label>
                        <input type="file" class="form-control" id="videotron_background_image" name="videotron_background_image" placeholder="File Background Image" accept="image/*" onchange="showImagePreviewVideotron(event)">
                        <img id="videotron_background_image_preview" src="#" alt="" style="display: none;" />
                    </div>
                `);
                } else if ($('#videotron_flag_background_color').is(':checked')) {
                    inputContainerVideotron.append(`
                    <div class="form-group">
                        <label for="videotron_background_color">Background Color Code:</label>
                        <input name="videotron_color_code" data-jscolor="{value:'${response.videotron_color_code}', position:'bottom', height:80, backgroundColor:'#333',
                          palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4',
                          paletteCols:11, hideOnPaletteClick:true}">
                    </div>
                `);
                    jscolor.install();
                }
            }

            // Visitor
            $('#defaultBtnVisitor').click(function() {
                $.ajax({
                    url: '{{ route('events.set-default-style') }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.visitor_flag_background === 'color') {
                            $('#visitor_flag_background_color').prop('checked', true);
                        }
                        updateInputFieldVisitor(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });

            $('input[name="visitor_flag_background"]').change(function() {
                updateInputFieldVisitor();
            });

            function updateInputFieldVisitor(response = []) {
                const inputContainerVisitor = $('#visitor-input-container');
                inputContainerVisitor.empty();

                if ($('#visitor_flag_background_image').is(':checked')) {
                    inputContainerVisitor.append(`
                    <div class="form-group">
                        <label for="visitor_background_image">File Background Image: <br><small class="text-info">(*file size must be less than 3MB)</small></label>
                        <input type="file" class="form-control" id="visitor_background_image" name="visitor_background_image" placeholder="File Background Image" accept="image/*" onchange="showImagePreviewVisitor(event)">
                        <img id="visitor_background_image_preview" src="#" alt="" style="display: none;" />
                    </div>
                `);
                } else if ($('#visitor_flag_background_color').is(':checked')) {
                    inputContainerVisitor.append(`
                    <div class="form-group">
                        <label for="visitor_color_code">Background Color Code:</label>
                        <input name="visitor_color_code" data-jscolor="{value:'${response.visitor_color_code}', position:'bottom', height:80, backgroundColor:'#333',
                          palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4',
                          paletteCols:11, hideOnPaletteClick:true}">
                    </div>
                `);
                    jscolor.install();
                }
            }

            // Bubble
            $('#defaultBtnBubble').click(function() {
                $.ajax({
                    url: '{{ route('events.set-default-style') }}',
                    type: 'GET',
                    success: function(response) {
                        $('#bubble_color_code_message_name')[0].jscolor.fromString(response
                            .bubble_color_code_message_name);
                        $('#bubble_color_code_message_time')[0].jscolor.fromString(response
                            .bubble_color_code_message_time);
                        $('#bubble_color_code_message_text')[0].jscolor.fromString(response
                            .bubble_color_code_message_text);
                        $('#bubble_color_code_message_background')[0].jscolor.fromString(
                            response
                            .bubble_color_code_message_background);
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });

        });
    </script>

    <script>
        $('#eventForm').on('submit', function(e) {
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

        function showImagePreviewVideotron(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('videotron_background_image_preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function showImagePreviewVisitor(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('visitor_background_image_preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <script src="{{ asset('template/assets/vendors/jscolor-2.5.2/jscolor.js') }}"></script>
    <script>
        jscolor.presets.default = {
            position: 'right',
            palette: [
                '#000000', '#7d7d7d', '#870014', '#ec1c23', '#ff7e26',
                '#fef100', '#22b14b', '#00a1e7', '#3f47cc', '#a349a4',
                '#ffffff', '#c3c3c3', '#b87957', '#feaec9', '#ffc80d',
                '#eee3af', '#b5e61d', '#99d9ea', '#7092be', '#c8bfe7',
            ],
        };
    </script>
@endsection
