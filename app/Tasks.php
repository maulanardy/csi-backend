<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $table = 'tasks';
    protected $fillable = [
    	'driver_id',
    	'car_id',
    	'task_date_start',
    	'task_date_end',
			'task_description',
			'pic_name',
			'pic_phone',
			'is_canceled',
			'canceled_by',
			'canceled_reason',
			'is_started',
			'is_finished',
			'finisihed_date',
			'is_draft',
			'approved_by',
			'created_by'
	];

	public function scopeIsDriver($query, $driverId)
	{
		if(!is_null($driverId) && $driverId !== "all")
			return $query->where('driver_id', $driverId);
	}

	public function scopeIsCar($query, $carId)
	{
		if(!is_null($carId) && $carId !== "all")
			return $query->where('car_id', $carId);
	}
	
  public function driver()
  {
      return $this->belongsTo('App\Drivers');
  }
	
  public function car()
  {
      return $this->belongsTo('App\Cars');
  }

  public function requestedBy()
  {
    return $this->belongsTo('App\User', 'created_by');
  }

  public function approvedBy()
  {
  	return $this->belongsTo('App\User', 'approved_by');
  }

}
