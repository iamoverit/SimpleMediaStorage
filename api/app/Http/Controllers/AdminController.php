<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminUpdateFileRequest;
use App\Models\UserFiles;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    use Storable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $files = UserFiles::paginate(15);

        return view('admin', ['files' => $files]);
    }

    public function edit(Request $request)
    {
        $userHash = $request->route('user_hash');
        $fileHash = $request->route('file_hash');
        $file = UserFiles::where(
            [
                'user_hash' => $userHash,
                'file_hash' => $fileHash,
            ]
        )->firstOrFail();

        return view('admin.edit', ['file' => $file]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdminUpdateFileRequest $request
     * @return void
     */
    public function update(AdminUpdateFileRequest $request)
    {
        $userHash = $request->route('user_hash');
        $fileHash = $request->route('file_hash');
        UserFiles::where(
            [
                'user_hash' => $userHash,
                'file_hash' => $fileHash,
            ]
        )->update(
            [
                'description' => $request->input('fileDescription'),
                'email' => $request->input('fileSenderEmail'),
                'filename' => $request->input('filename'),
            ]
        );
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return void
     */
    public function destroy(Request $request)
    {
        $userHash = $request->route('user_hash');
        $fileHash = $request->route('file_hash');
        $files = UserFiles::where(
            [
                'user_hash' => $userHash,
                'file_hash' => $fileHash,
            ]
        )->get();
        foreach ($files as $file) {
            Storage::delete(self::uploadedPath()."/".$userHash."/".$fileHash, $file->filename);
        }
        $file->delete();

        return redirect()->back();
    }
}
