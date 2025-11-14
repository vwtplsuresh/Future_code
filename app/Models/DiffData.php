<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiffData extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id',
        'totalizer',
        'net_flow',
        'is_online',
        'is_panel_lock',
    ];
}
