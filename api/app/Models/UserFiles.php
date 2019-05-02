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

}
