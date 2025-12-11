<?php

namespace App\Helper;

use Illuminate\Support\Carbon;

class DateFormat {

    public function date($date){
        return  Carbon::parse($date)->format('Y-m-d');
    }
     public function datetime($date){
        return  Carbon::parse($date)->format('Y-m-d h:m:s');
    }
}
