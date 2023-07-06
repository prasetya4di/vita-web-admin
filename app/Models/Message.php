<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'message',
        'message_type',
        'file_type',
        'energy_usage'
    ];

    public function users() {
    	return $this->belongsTo('App\Models\User', 'user_id');
    }
}
