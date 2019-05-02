<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilePost;
use App\Mail\FileUploaded;
use App\Models\UserFiles;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class SimpleMediaStorage extends Controller
{
    use Storable;

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $userHash = $request->route('user_hash');
        $fileHash = $request->route('file_hash');
        $headers = [
            'Set-Cookie' => 'fileDownload=true; path=/',
        ];
        $file = UserFiles::where(
            [
                'user_hash' => $userHash,
                'file_hash' => $fileHash,
            ]
        )->firstOrFail();

        return Storage::download(self::uploadedPath()."/".$userHash."/".$fileHash, $file->filename, $headers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreFilePost $request
     * @return array
     */
    public function store(StoreFilePost $request)
    {
        DB::beginTransaction();
        $userFileModel = null;
        try {
            /**
             * @var $file UploadedFile
             */
            $file = $request->fileContent;
            $fileHash = hash_file('md5', $file);
            $userHash = hash('md5', $request->input('fileSenderEmail'));
            $file->storeAs(self::uploadedPath().'/'.$userHash, $fileHash);
            $userFileModel = new UserFiles();
            $userFileModel->description = $request->input('fileDescription');
            $userFileModel->email = $request->input('fileSenderEmail');
            $userFileModel->file_hash = $fileHash;
            $userFileModel->user_hash = $userHash;
            $userFileModel->filename = $file->getClientOriginalName();
            $userFileModel->save();
            Mail::to($userFileModel->email)
                ->send(new FileUploaded(self::uploadedPath().'/'.$userHash.'/'.$fileHash));
        } catch (Exception $exception) {
            DB::rollBack();

            abort(500, 'Internal Server Error');
        }
        DB::commit();

        return ['status' => true];
    }
}
