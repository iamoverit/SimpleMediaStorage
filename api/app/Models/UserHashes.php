<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserHashes extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_hashes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_hash'];
}
