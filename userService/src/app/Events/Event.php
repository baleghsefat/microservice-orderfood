<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use SerializesModels;

    public Model $model;
}
