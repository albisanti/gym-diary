<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserCustomer extends Pivot
{
    use HasFactory;

    const STATUS_ACCEPTED = 'accepted';
    const STATUS_REFUSED = 'refused';

    public $incrementing = true;
}
