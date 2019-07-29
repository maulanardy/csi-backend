<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    protected $table = 'cars';
    protected $fillable = [
    	'name',
    	'license',
    	'picture',
    	'is_active',
    	'is_ontrip',
    	'is_available',
    	'created_by'
	];

  public function driver()
  {
      return $this->hasOne('App\Drivers', 'default_car_id');
  }

}
