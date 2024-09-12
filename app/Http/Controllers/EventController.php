<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Events\MessageSent;
use App\Models\Event;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;
use Pusher\Pusher;

class EventController extends Controller
{
    public function all()
    {
        $admin = auth()->user();
        $url = '/events';

        if (request()->ajax()) {
            $events = Event::withTrashed()->get();
            return DataTables::of($events)
                ->addIndexColumn()
                ->addColumn('action', function ($item) {
                    $action = '<div>';
                    if ($item->deleted_at) {
                        $action .= '-';
                    } else {
                        $action = '
                            <a href="' . route('events.detail', $item->id) . '" class="btn btn-warning text-white m-1" data-toggle="tooltip" data-placement="top"
                            title="Go to Detail">
                            <i class="mdi mdi-eye" style="margin-right:unset!important;"></i>
                            </a>
                        ';
                        $action .= '
                        <br>
                            <a onclick="deleteEvent(event,this)" href="' . route('events.delete', $item->id) . '"
                                class="btn btn-danger text-white m-1" data-toggle="tooltip" data-placement="top"
                                title="Delete This Event">
                                <i class="mdi mdi-trash-can" style="margin-right:unset!important;"></i>
                            </a>
                        ';
                    }
                    $action .= '</div>';
                    return $action;
                })
                ->addColumn('livechat', function ($item) {
                    $livechat = '<div>';

                    if ($item->deleted_at) {
                        $livechat .= '
                            -
                        ';
                    } else {
                        if ($item->flag_started === null) {
                            $livechat .= ' <a href="' . route('events.start-livechat', $item->id) . '" onclick="startLivechat(event,this)" class="btn btn-sm btn-success p-2 d-flex align-items-center justify-content-center" style="gap:5px;"><i class="mdi mdi-rocket mr-0"></i><p class="mb-0"><small> Start Livechat</small></p></a>';
    
    
                            $livechat .= '
                                    <hr style="border:1px solid #fff;">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary p-2 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><small>Demo</small></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item py-1" href="' . route('events.demo-videotron', $item->id) . '" target="_blank"><small>Go To Videotron Display</small></a>
                                        <a class="dropdown-item py-1" href="' . route('events.demo-visitor', $item->id) . '" target="_blank"><small>Go To Visitor Display</small></a>
                                    </div>
                                </div>
                            ';
                        }elseif ($item->flag_started) {
                            $livechat .= '
                                    <a href="javascript:void(0)" class="btn btn-info p-2 dropdown-toggle m-1"
                                        data-toggle="dropdown" aria-expanded="false"><small>Livechat Started</small></a>
                                    <div class="dropdown-menu mt-1">
                                        <a class="dropdown-item py-1"
                                            href="' . route('events.livechat-videotron', $item->id) . '"
                                            target="_blank"><small>Go To Videotron Display</small></a>
                                        <a class="dropdown-item py-1"
                                            href="' . route('events.livechat-visitor', $item->id) . '"
                                            target="_blank"><small>Go To Visitor Display</small></a>
                                    </div>
                                </div>
                                <a onclick="btnStopLivechat(event,this)"  href="' . route('events.stop-livechat', $item->id) . '"
                                    class="btn btn-danger p-2 d-flex align-items-center m-1 justify-content-center" style="gap:5px;"><i
                                        class="mdi mdi-close-network mr-0"></i>
                                    <p class="mb-0">
                                        <small>Stop Livechat</small>
                                    </p>
                                </a>
                            ';
                        }else{
                            $livechat .= '
                                <a onclick="btnHistoryLivechat(event,this)" href="' . route('events.history-livechat', $item->id) . '"
                                    class="btn btn-info p-2 d-flex align-items-center" style="gap:5px;"><i
                                        class="mdi mdi-history mr-0"></i>
                                    <p class="mb-0">
                                        <small>See History Livechat</small>
                                    </p>
                                </a>
                            ';

                            $livechat .= '
                                    <hr style="border:1px solid #fff;">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-secondary p-2 dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><small>Demo</small></a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item py-1" href="' . route('events.demo-videotron', $item->id) . '" target="_blank"><small>Go To Videotron Display</small></a>
                                        <a class="dropdown-item py-1" href="' . route('events.demo-visitor', $item->id) . '" target="_blank"><small>Go To Visitor Display</small></a>
                                    </div>
                            ';
                        }
                    }
                    
                    $livechat .= '</div>';
                    return $livechat;
                })
                ->addColumn('date_time', function ($item) {
                    $date_time = '
                        <div>
                        <p>' . Carbon::parse($item->date)->format('l, Y-m-d') . ' <br> ' . Carbon::parse($item->time_start)->format('H:i') . ' - ' . Carbon::parse($item->time_end)->format('H:i') . '</p>
                        </div>
                    ';
                    return $date_time;
                })
                ->addColumn('status_start_stop', function ($item) {
                    if (!$item->flag_started && $item->flag_started !== NULL) {
                        $status_start_stop = '
                            <a href="javascript:void(0)"
                            class="btn btn-danger"><small>Stopped</small></a>
                        ';
                    } else if ($item->flag_started) {
                        $status_start_stop = '
                            <a href="javascript:void(0)"
                            class="btn btn-info"><small>Started</small></a>
                        ';
                    } else {
                        $status_start_stop = '
                            <a href="javascript:void(0)"
                            class="btn btn-warning"><small>Waiting</small></a>
                        ';
                    }
                    if ($item->flag_expired) {
                        $status_start_stop .= '<p class="mx-0"><small>Auto Expired Activated</small></p>';
                    } else {
                        $status_start_stop .= '<p class="mx-0"><small>Auto Expired Not Activated</small></p>';
                    }

                    return $status_start_stop;
                })
                ->addColumn('renmark', function ($item) {
                    $renmark = '
                        <div class="font-small">
                            <div class="text-center">
                                <p class="mb-0"><strong>Created By:</strong></p>
                                <p class="mb-0">' . $item->created_by . ',<br>' . $item->created_at . '</p>
                            </div>
                            <hr style="border:1px solid #fff;margin:10px 0;">
                            <div class="text-center">
                                <p class="mb-0"><strong>Latest Update By :</strong></p>
                                <p class="mb-0">' . $item->updated_by . ',<br>' . $item->updated_at . '</p>
                            </div>
                        </div>
                    ';
                    return $renmark;
                })
                ->addColumn('status_deleted', function ($item) {
                    if ($item->deleted_at) {
                        $status_deleted = '
                            <a onclick="restoreEvent(event,this)" href="' . url('/events/restore/' . $item->id) . '"
                            class="btn btn-danger"
                            data-toggle="tooltip" data-placement="top"
                            title="Click to Restore This Event"><small>Inactive</small></a>
                        ';
                    } else {
                        $status_deleted = '
                            <a href="javascript:void(0)"
                            class="btn btn-primary"><small>Active</small></a>
                        ';
                    }
                    return $status_deleted;
                })
                ->make();
        }

        return view('admin.event-all', compact(['admin', 'url']));
    }

    public function index_of_create()
    {
        $admin = auth()->user();
        $url = '/events/create-new';
        return view('admin.event-create', compact(['admin', 'url']));
    }

    public function create(Request $request)
    {
        $logged_admin = auth()->user();

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'status_expired' => 'required|in:true,false',
            'videotron_flag_background' => 'required|string',
            'videotron_color_code' => 'nullable|string',
            'videotron_background_image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:3072',
            'visitor_flag_background' => 'required|string',
            'visitor_color_code' => 'nullable|string',
            'visitor_background_image' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:3072',
            'bubble_color_code_message_name' => 'required|string',
            'bubble_color_code_message_time' => 'required|string',
            'bubble_color_code_message_text' => 'required|string',
            'bubble_color_code_message_background' => 'required|string',
        ]);

        // Generate Ecrypted Code
        $encryptedCode = $this->generateUniqueEncryptedCode($request->input('name'));

        // If Videotron BG File Exist
        if ($request->hasFile('videotron_background_image')) {
            $file = $request->file('videotron_background_image');
            $encryptedFileName = $this->encryptFileName($file->getClientOriginalName());
            $filePathVideotron = $file->storeAs('videotron_bg', $encryptedFileName, 'public');
        }

        // If Visitor BG File Exist
        if ($request->hasFile('visitor_background_image')) {
            $file = $request->file('visitor_background_image');
            $encryptedFileName = $this->encryptFileName($file->getClientOriginalName());
            $filePathVisitor = $file->storeAs('visitor_bg', $encryptedFileName, 'public');
        }

        // Add to Database
        $new_event = new Event();
        $new_event->name = $request->input("name");
        $new_event->date = $request->input("date");
        $new_event->time_start = $request->input("time_start");
        $new_event->time_end = $request->input("time_end");
        $new_event->encrypted_code = $encryptedCode;
        $new_event->flag_expired = ($request->input("status_expired") === "true") ? 1 : 0;
        $new_event->videotron_flag_background = $request->input("videotron_flag_background");
        $new_event->videotron_background_image = ($request->hasFile('videotron_background_image')) ? $filePathVideotron : null;
        $new_event->videotron_color_code = ($request->input('videotron_color_code')) ? $request->input('videotron_color_code') : null;
        $new_event->visitor_flag_background = $request->input("visitor_flag_background");
        $new_event->visitor_background_image = ($request->hasFile('visitor_background_image')) ? $filePathVisitor : null;
        $new_event->visitor_color_code = ($request->input('visitor_color_code')) ? $request->input('visitor_color_code') : null;
        $new_event->bubble_color_code_message_name = $request->input("bubble_color_code_message_name");
        $new_event->bubble_color_code_message_time = $request->input("bubble_color_code_message_time");
        $new_event->bubble_color_code_message_text = $request->input("bubble_color_code_message_text");
        $new_event->bubble_color_code_message_background = $request->input("bubble_color_code_message_background");
        $new_event->created_by = $logged_admin->username;
        $new_event->updated_by = $logged_admin->username;

        $new_event->save();

        return redirect(route('events.detail', $new_event->id))->with([
            'success_flash' => 'New Event Created Successfully!',
        ]);
    }

    public function set_default_style(Request $request)
    {
        $constants = Constants::getAllConstants();
        return response()->json($constants);
    }

    private function generateUniqueEncryptedCode($name)
    {
        do {
            $encryptedCode = 'PH_' . substr(md5($name . Str::random()), 0, 5);
        } while (Event::where('encrypted_code', $encryptedCode)->exists());

        return $encryptedCode;
    }

    private function encryptFileName($fileName)
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $encryptedName = md5(Str::random() . microtime()) . '.' . $extension;
        return $encryptedName;
    }

    public function detail($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        $admin = auth()->user();
        $url = '/events/detail';

        return view('admin.event-detail', compact(['admin', 'url', 'event']));
    }

    public function update(Request $request, $id)
    {
        $logged_admin = auth()->user();
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time_start' => 'required|date_format:H:i',
            'time_end' => 'required|date_format:H:i|after:time_start',
            'status_expired' => 'required|in:true,false',
            'videotron_flag_background' => 'required|string',
            'videotron_color_code' => 'nullable|string',
            'videotron_background_image' => 'nullable|file|max:3072',
            'visitor_flag_background' => 'required|string',
            'visitor_color_code' => 'nullable|string',
            'visitor_background_image' => 'nullable|file|max:3072',
            'bubble_color_code_message_name' => 'required|string',
            'bubble_color_code_message_time' => 'required|string',
            'bubble_color_code_message_text' => 'required|string',
            'bubble_color_code_message_background' => 'required|string',
        ]);

        // If Flag Videotron BG Image Activated
        if ($request->videotron_flag_background === 'image') {
            // If Videotron BG File Exist
            if ($request->file('videotron_background_image')) {
                // Delete the existing file directory
                $existingFile = $event->videotron_background_image;
                if ($existingFile) {
                    if (Storage::disk('public')->exists($existingFile)) {
                        Storage::disk('public')->delete($existingFile);
                    }
                }

                $file = $request->file('videotron_background_image');
                $encryptedFileName = $this->encryptFileName($file->getClientOriginalName());
                $newFilePathVideotron = $file->storeAs('videotron_bg', $encryptedFileName, 'public');
            }
        }

        // If Flag Visitor BG Image Activated
        if ($request->visitor_flag_background === 'image') {
            // If Videotron BG File Exist
            if ($request->file('visitor_background_image')) {
                // Delete the existing file directory
                $existingFile = $event->visitor_background_image;
                if ($existingFile) {
                    if (Storage::disk('public')->exists($existingFile)) {
                        Storage::disk('public')->delete($existingFile);
                    }
                }

                $file = $request->file('visitor_background_image');
                $encryptedFileName = $this->encryptFileName($file->getClientOriginalName());
                $newFilePathVisitor = $file->storeAs('visitor_bg', $encryptedFileName, 'public');
            }
        }

        // Add to Database
        $event->name = $request->input("name");
        $event->date = $request->input("date");
        $event->time_start = $request->input("time_start");
        $event->time_end = $request->input("time_end");
        $event->flag_expired = ($request->input("status_expired") === "true") ? 1 : 0;
        $event->videotron_flag_background = $request->input("videotron_flag_background");
        $event->videotron_background_image = ($request->hasFile('videotron_background_image')) ? $newFilePathVideotron : $event->videotron_background_image;
        $event->videotron_color_code = ($request->input('videotron_color_code')) ? $request->input('videotron_color_code') : $event->videotron_color_code;
        $event->visitor_flag_background = $request->input("visitor_flag_background");
        $event->visitor_background_image = ($request->hasFile('visitor_background_image')) ? $newFilePathVisitor : $event->visitor_background_image;
        $event->visitor_color_code = ($request->input('visitor_color_code')) ? $request->input('visitor_color_code') : $event->visitor_color_code;
        $event->bubble_color_code_message_name = $request->input("bubble_color_code_message_name");
        $event->bubble_color_code_message_time = $request->input("bubble_color_code_message_time");
        $event->bubble_color_code_message_text = $request->input("bubble_color_code_message_text");
        $event->bubble_color_code_message_background = $request->input("bubble_color_code_message_background");
        $event->updated_by = $logged_admin->username;

        $event->save();

        return redirect()->back()->with('success_flash', 'Event Updated Succesfully!');
    }

    public function delete($id)
    {
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('super')) {
            return redirect('events')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $event = Event::find($id);

        if ($event) {
            $event->delete();
            return redirect('events')->with('success_flash', 'Event Deleted!');
        } else {
            return redirect('events')->with('error_flash', 'Event Not Found.');
        }
    }

    public function restore($id)
    {
        $logged_admin = auth()->user();
        if (!$logged_admin->hasRole('super')) {
            return redirect('events')->with([
                'error_flash' => 'Permission Denied',
            ]);
        }

        $event = Event::withTrashed()->find($id);
        if ($event) {
            $event->restore();
            return redirect()->back()->with('success_flash', 'Event Restored Successfully.');
        } else {
            return redirect()->back()->with('error_flash', 'Event Not Found.');
        }
    }

    public function qr_code($id)
    {
        $url = route('events.livechat-visitor', $id);
        return response()->streamDownload(function () use ($url) {
            echo QrCode::size(300)
                ->margin(2)
                ->errorCorrection('H')
                ->format('png')
                ->generate($url);
        }, 'qr-code.png', [
            'Content-Type' => 'image/png',
        ]);
    }

    public function start_livechat($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        $event->flag_started = 1;
        $event->save();
        return redirect()->back()->with('success_flash', 'Livechat Started Succesfully!');
    }

    public function stop_livechat($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        $event->flag_started = 0;
        $event->save();
        return redirect()->back()->with('success_flash', 'Livechat Stopped Succesfully!');
    }

    public function history_livechat($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        if ($event->flag_started === null) {
            return redirect(route('events.detail', $event->id))->with([
                'error_flash' => 'Event Not Started Yet',
            ]);
        }

        return view('admin.livechat-history', compact('event'));
    }

    public function demo_videotron($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        return view('admin.livechat-demo-videotron', compact('event'));
    }

    public function demo_visitor($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        return view('admin.livechat-demo-visitor', compact('event'));
    }

    public function livechat_videotron($id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        if ($event->flag_started === null) {
            return redirect(route('events.detail', $event->id))->with([
                'error_flash' => 'Event Not Started Yet',
            ]);
        }

        return view('admin.livechat-videotron', compact('event'));
    }

    public function livechat_visitor(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return redirect('events')->with([
                'error_flash' => 'Event Not Found',
            ]);
        }

        if ($event->flag_started === null) {
            return redirect(route('events.detail', $event->id))->with([
                'error_flash' => 'Event Not Started Yet',
            ]);
        }

        if ($event->flag_started === 0) {
            abort(404);
        }

        return view('admin.livechat-visitor', compact('event'));
    }

    public function send_chat(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return response()->json([
                'error' => 'Event not found'
            ], 500);
        }

        $senderName = $request->input('sender_name');
        $content = $request->input('content');

        $message = new Message();
        $message->id_event = $id;
        $message->sender_name = $senderName;
        $message->content = $content;

        Session::put('senderName', $senderName);

        // Session Logic
        if (Session::has('randomStringSender')) {
            // Get the session to insert to database
            $sessionRandomString = Session::get('randomStringSender');
            $message->sender_unique_char = $sessionRandomString;
        } else {
            // Save the random string to session for the sender
            $randomString = $this->generateUniqueRandomString();
            do {
                $randomString = $this->generateUniqueRandomString();
                $exists = Message::where('sender_unique_char', $randomString)
                    ->where('id_event', $id)
                    ->exists();
            } while ($exists);

            Session::put('randomStringSender', $randomString);
            $sessionRandomString = Session::get('randomStringSender');

            $message->sender_unique_char = $sessionRandomString;
        }

        $message->save();

        // Pusher
        $options = [
            'cluster' => 'ap1',
            'useTLS' => true,
        ];
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = $message;
        $pusher->trigger('chat-' . $id, 'message.sent', $data);

        return response()->json([
            'status' => true,
            'message' => "Message Send Succsesfully!",
        ]);
    }

    public function get_chat_visitor(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return response()->json([
                'error' => 'Event not found'
            ], 500);
        }

        $randomStringSender = Session::get('randomStringSender');

        if (!$randomStringSender) {
            return response()->json(['messages' => []], 200);
        }

        $messages = Message::where('sender_unique_char', $randomStringSender)
            ->where('id_event', $id)
            ->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages], 200);
    }

    public function get_chat_videotron(Request $request, $id)
    {
        $event = Event::where('id', $id)->first();
        if ($event === null) {
            return response()->json([
                'error' => 'Event not found'
            ], 500);
        }

        $messages = Message::where('id_event', $id)->orderBy('created_at', 'asc')->get();

        return response()->json(['messages' => $messages], 200);
    }

    public function delete_chat(Request $request, $id_event, $id_chat)
    {
        $event = Event::where('id', $id_event)->first();
        if ($event === null) {
            return response()->json([
                'error' => 'Event not found'
            ], 500);
        }

        $message = Message::where('id_event', $id_event)->find($id_chat);
        if (!$message) {
            return response()->json([
                'status' => false,
                'message' => 'Message not found'
            ], 404);
        }

        $message->delete();

        // Pusher
        $options = [
            'cluster' => 'ap1',
            'useTLS' => true,
        ];
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data['message'] = "Deleted";
        $pusher->trigger('chatDelete-' . $id_event, 'message.delete', $data);

        return response()->json([
            'status' => true,
            'message' => 'Message deleted successfully'
        ]);
    }

    private function generateUniqueRandomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
