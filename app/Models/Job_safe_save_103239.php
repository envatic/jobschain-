<?php
/**Envatic Crypto APP
* Adapted by
 *Stephen Isaac:  ofuzak@gmail.com>.
 *Skype: ofuzak
 *www.evatic.com (Deploy Scripts , Apps , coins in One click)
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use App\Traits\LoggerTrait;
//use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    
	//use LoggerTrait ,HasUuid;
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'jobs';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
	
	/**
     * Attributes that should be cast to native types.
     *
     * @var string
     */
    protected $casts = [
		'active'=>'boolean'
	];
	
	protected $dates = [
		'expiry'
	];

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id', 
		'country', 
		'address', 
		'publickey', 
		'company_name', 
		'title', 
		'qualifications', 
		'description', 
		'expirience', 
		'count', 
		'expiry', 
		'status', 
		'active'
	];

    public function jcountry()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_id', 'id');
    }
	
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    
	public function msgs()
    {
        return $this->morphMany(\App\Models\Msg::class, 'entity');
    }
    
}
