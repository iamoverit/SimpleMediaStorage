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
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query, $userHash, $fileHash)
    {
        return $query->where(
            [
                'user_hashz' => $userHash,
                'file_hash' => $fileHash,
            ]);
    }

}
