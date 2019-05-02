<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFilePost;
use App\Mail\FileUploaded;
use App\Models\UserFiles;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class SimpleMediaStorage extends Controller
{
    private static $uploadedPath = '/uploaded';

    public function index(Request $request)
    {
        $user_hash = $request->route('user_hash');
        $file_hash = $request->route('file_hash');
        $headers = [
            'Set-Cookie' => 'fileDownload=true; path=/',
        ];
        $file = UserFiles::where(
            [
                'user_hash' => $user_hash,
                'file_hash' => $file_hash,
            ]
        )->firstOrFail();

        return Storage::download(self::$uploadedPath."/".$user_hash."/".$file_hash, $file->filename, $headers);
    }

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
            $file->storeAs(self::$uploadedPath.'/'.$userHash, $fileHash);
            $userFileModel = new UserFiles();
            $userFileModel->description = $request->input('fileDescription');
            $userFileModel->email = $request->input('fileSenderEmail');
            $userFileModel->file_hash = $fileHash;
            $userFileModel->user_hash = $userHash;
            $userFileModel->filename = $file->getClientOriginalName();
            $userFileModel->save();
            Mail::to($userFileModel->email)
                ->send(new FileUploaded(self::$uploadedPath.'/'.$userHash.'/'.$fileHash));
        } catch (Exception $exception) {
            DB::rollBack();

            abort(500, 'Internal Server Error');
        }
        DB::commit();

        return ['status' => true];
    }
}
