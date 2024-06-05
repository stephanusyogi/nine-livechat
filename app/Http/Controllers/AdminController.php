<?php

namespace App\Http\Controllers;

use App\Models\Administrator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function all()
    {
        $admin = auth()->user();
        $url = '/all-administrators';

        if (request()->ajax()) {
            $administrators = (!$admin->hasRole('super')) ? Administrator::get() : Administrator::withTrashed()->get();
            return DataTables::of($administrators)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    return view('admin.admin-update', compact('item'))->render();
                })
                ->addColumn('status', function ($item) {
                    if ($item->deleted_at) {
                        $status = '
                            <a onclick="restoreAdmin(event,this)" href="' . route('all-administrators.restore', $item->id) . '"
                            class="btn btn-danger"
                            data-toggle="tooltip" data-placement="top"
                            title="Click to Restore This Account"><small>Inactive</small></a>
                        ';
                    } else {
                        $status = '
                            <a href="javascript:void(0)"
                            class="btn btn-primary"><small>Active</small></a>
                        ';
                    }
                    return $status;
                })
                ->make();
        }

        return view('admin.admin-all', compact(['admin', 'url']));
    }

    public function create(Request $request)
    {
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('super')) {
            return redirect('all-administrators')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        session()->flash('form_type', 'addAdmin');
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'username' => 'required|string|max:255|unique:administrators',
            'type' => 'required',
            'password' => 'required|confirmed|string|min:8',
        ]);


        $new_admin = new Administrator();
        $new_admin->name = $request->name;
        $new_admin->email = $request->email;
        $new_admin->username = $request->username;
        $new_admin->type = $request->type;
        $new_admin->password = Hash::make($request->password);
        $new_admin->created_by = $logged_admin->username;
        $new_admin->save();

        return redirect('all-administrators')->with([
            'success_flash' => 'New Admin Created Successfully!',
        ]);
    }

    public function update(Request $request, $id)
    {
        $admin = auth()->user();
        if (!$admin->hasRole('super')) {
            return redirect('all-administrators')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        session()->flash('form_type', 'updateAdmin');
        session()->flash('idModal', $id);

        $this->validate($request, [
            'name_edit' => 'required|string|max:255',
            'email_edit' => 'required|email',
            'username_edit' => [
                'required',
                'string',
                'max:255',
                Rule::unique('administrators', 'username')->ignore($id),
            ],
            'type_edit' => 'required',
            'password' => 'nullable|string|min:8',
        ]);

        $update_admin = Administrator::findOrFail($id);
        $update_admin->name = $request->name_edit;
        $update_admin->email = $request->email_edit;
        $update_admin->username = $request->username_edit;
        if ($request->filled('password')) {
            $update_admin->password = Hash::make($request->password);
        }
        $update_admin->type = $request->type_edit;
        $update_admin->save();

        return redirect('all-administrators')->with([
            'success_flash' => 'Admin Updated Successfully!',
        ]);
    }

    public function delete($id)
    {
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('super')) {
            return redirect('all-administrators')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $admin = Administrator::find($id);

        if ($admin) {
            $admin->delete();
            return redirect()->back()->with('success_flash', 'Admin Deleted!');
        } else {
            return redirect()->back()->with('error_flash', 'Admin Not Found.');
        }
    }

    public function restore($id)
    {
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('super')) {
            return redirect('all-administrators')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $admin = Administrator::withTrashed()->find($id);
        if ($admin) {
            $admin->restore();
            return redirect()->back()->with('success', 'Admin Restored Successfully.');
        } else {
            return redirect()->back()->with('error', 'Admin Not Found.');
        }
    }

    public function update_profile(Request $request, $id)
    {
        $logged_admin = auth()->user();
        if ($logged_admin->id != $id) {
            return redirect('all-administrators')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $this->validate($request, [
            'name_my' => 'required|string|max:255',
            'email_my' => 'required|email',
            'username_my' => [
                'required',
                'string',
                'max:255',
                Rule::unique('administrators', 'username')->ignore($id),
            ],
            'type_my' => 'nullable|string',
            'password' => 'nullable|string|min:8',
        ]);

        $my_profile = Administrator::findOrFail($id);
        $my_profile->name = $request->name_my;
        $my_profile->email = $request->email_my;
        $my_profile->username = $request->username_my;
        if ($request->filled('password')) {
            $my_profile->password = Hash::make($request->password);
        }
        if ($request->filled('type_my')) {
            $my_profile->type = $request->type_my;
        }
        $my_profile->save();

        return redirect()->back()->with([
            'success_flash' => 'My Profile Updated Successfully!',
        ]);
    }
}
