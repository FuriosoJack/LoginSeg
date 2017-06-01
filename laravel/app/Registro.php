<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = "registros";
    protected $fillable= ['hascode','tipo_id','created_at'];

    public function user(){
      return $this->belongsTo(User::class);
    }
}
