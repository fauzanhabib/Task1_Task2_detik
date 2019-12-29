<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public $table = "inventory";
    //
    protected $fillable = [
        'id', 'nama','harga','deskripsi','created_at','updated_at'
    ];
}
