<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debtor extends Model
{
  use SoftDeletes;
  protected $table = 'debtors';
  protected $fillable = [
    'code',
    'description',
    'address',
    'contact_number',
    'owner',
    'debtor_type',
  ];
}