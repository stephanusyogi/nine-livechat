<div>
    <a href="javascript:void(0)" class="btn btn-warning text-white" data-toggle="modal"
        data-target="#admin-{{ $item->id }}">
        <i class="mdi mdi-pencil-box" style="margin-right:unset!important;"></i>
    </a>
    @if (!$item->deleted_at)
        <a onclick="deleteAdmin(event,this)" href="{{ route('all-administrators.delete', $item->id) }}"
            class="btn btn-danger text-white" data-toggle="tooltip" data-placement="top" title="Delete This Account">
            <i class="mdi mdi-trash-can" style="margin-right:unset!important;"></i>
        </a>
    @endif
    <div id="admin-{{ $item->id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" onsubmit="updateAdmin(event, this)"
                action="{{ route('all-administrators.edit', $item->id) }}" method="POST" autocomplete="off">
                <div class="modal-header">
                    <h4 class="modal-title">Update Data
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="forms-sample">
                        <div class="form-group text-left">
                            <label for="name_edit-{{ $item->id }}"
                                class="@if ($errors->has('name_edit')) text-danger @elseif(old('name_edit') && !$errors->has('name_edit'))
                              text-success @endif">Full
                                Name</label>
                            <input type="text"
                                class="form-control @if ($errors->has('name_edit')) is-invalid text-danger @elseif(old('name_edit') && !$errors->has('name_edit'))
                            is-valid text-success @endif"
                                id="name_edit-{{ $item->id }}"
                                value="{{ old('name_edit') ? old('name_edit') : $item->name }}" name="name_edit"
                                placeholder="Name" required>
                            @error('name_edit')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="email_edit-{{ $item->id }}"
                                class="@if ($errors->has('email_edit')) text-danger @elseif(old('email_edit') && !$errors->has('email_edit'))
                              text-success @endif">Email
                                Address</label>
                            <input type="email"
                                class="form-control @if ($errors->has('email_edit')) is-invalid text-danger @elseif(old('email_edit') && !$errors->has('email_edit'))
                            is-valid text-success @endif"
                                id="email_edit-{{ $item->id }}"
                                value="{{ old('email_edit') ? old('email_edit') : $item->email }}" name="email_edit"
                                placeholder="Email Address" required>
                            @error('email_edit')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="username_edit-{{ $item->id }}"
                                class="@if ($errors->has('username_edit')) text-danger @elseif(old('username_edit') && !$errors->has('username_edit'))
                              text-success @endif">Username</label>
                            <input type="text"
                                class="form-control @if ($errors->has('username_edit')) is-invalid text-danger @elseif(old('username_edit') && !$errors->has('username_edit'))
                            is-valid text-success @endif"
                                id="username_edit-{{ $item->id }}"
                                value="{{ old('username_edit') ? old('username_edit') : $item->username }}"
                                name="username_edit" placeholder="Username" required>
                            @error('username_edit')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="type_edit-{{ $item->id }}"
                                class="@if ($errors->has('type_edit')) text-danger @elseif(old('type_edit') && !$errors->has('type_edit'))
                              text-success @endif">Type</label>
                            <select
                                class="form-control form-control text-light @if ($errors->has('type_edit')) border-danger @elseif(old('type_edit') && !$errors->has('type_edit'))
                              border-success @endif"
                                id="type_edit-{{ $item->id }}" name="type_edit" required>
                                <option value="">Choose Type...</option>
                                <option value="super"
                                    {{ old('type_edit') ? (old('type_edit') == 'super' ? 'selected' : '') : ($item->type == 'super' ? 'selected' : '') }}>
                                    Super
                                </option>
                                <option value="basic"
                                    {{ old('type_edit') ? (old('type_edit') == 'basic' ? 'selected' : '') : ($item->type == 'basic' ? 'selected' : '') }}>
                                    Basic
                                </option>
                            </select>
                            @error('type_edit')
                                <small class="mt-2 text-danger float-start">
                                    {{ $message }}
                                </small>
                            @enderror
                        </div>
                        <div class="form-group text-left">
                            <label for="password-{{ $item->id }}">Password</label>
                            <input type="password" class="form-control" id="password-{{ $item->id }}"
                                placeholder="Keep it Blank, if not changing password." name="password">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success waves-effect">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
