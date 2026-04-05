<?php

namespace App\Http\Controllers;

use App\Models\BabyShowerSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BabyShowerController extends Controller
{
    public function index()
    {
        return view('baby-shower.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'nullable|email|max:150',
            'guess'   => 'required|in:boy,girl',
            'message' => 'nullable|string|max:300',
            'video'   => [
                'required',
                'file',
                'max:102400',
                function ($attribute, $value, $fail) {
                    $allowed = [
                        'video/mp4',
                        'video/quicktime',
                        'video/x-quicktime',
                        'video/webm',
                        'video/ogg',
                        'video/x-msvideo',
                        'video/x-matroska',
                        'video/3gpp',
                        'video/3gpp2',
                        'video/mpeg',
                        'video/x-ms-wmv',
                        'application/octet-stream',
                    ];

                    if (!in_array($value->getMimeType(), $allowed)) {
                        $fail("Unsupported video format. Please upload a standard video file under 40 seconds.");
                    }
                },
            ],
        ]);

        $path = $request->file('video')->store('baby-shower/videos', 'private');

        BabyShowerSubmission::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'guess'      => $request->guess,
            'message'    => $request->message,
            'video_path' => $path,
        ]);

        return redirect()->route('baby-shower.thanks');
    }

    public function thanks()
    {
        return view('baby-shower.thanks');
    }

    public function admin()
    {
        $submissions = BabyShowerSubmission::latest()->get();
        $boyCount    = $submissions->where('guess', 'boy')->count();
        $girlCount   = $submissions->where('guess', 'girl')->count();

        return view('baby-shower.admin', compact('submissions', 'boyCount', 'girlCount'));
    }

    public function streamVideo(BabyShowerSubmission $submission)
    {
        abort_unless(Storage::disk('private')->exists($submission->video_path), 404);
        return Storage::disk('private')->response($submission->video_path);
    }
}