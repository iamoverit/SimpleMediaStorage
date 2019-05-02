<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserFiles extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_files';
    protected $primaryKey = 'file_hash';
    protected $keyType = 'string';
    public $incrementing = false;


    /**
     * Scope a query to find current file by user and file hashes.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFindFile($query, $userHash, $fileHash)
    {
        return $query->where(
            [
                'user_hash' => $userHash,
                'file_hash' => $fileHash,
            ]);
    }

}
