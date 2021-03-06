<?php

namespace App\Mail;

use App\Models\UserFiles;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FileUploaded extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var UserFiles
     */
    protected $url;

    /**
     * Create a new message instance.
     *
     * @param UserFiles $userFile
     */
    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.file.uploaded')->with('url', $this->url);
    }
}
