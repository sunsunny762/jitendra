<?php
namespace App;

use Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Carbon;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * Overwrite created_by field value with currently logged in user.
     * Set @var has_created_by to false if created_by field does not exist in DB Table.
     *
     * @var boolean
     */
    protected $has_created_by = true;

    /**
     * Overwrite updated_by field value with currently logged in user.
     * Set @var has_updated_by to false if created_by field does not exist in DB Table.
     *
     * @var boolean
     */

    protected $has_updated_by = true;

    /**
     * Define feilds name which have html tags
     * Set @var notStripTags add DB Table column name which column have html tags.
     *
     * @var array
    */

    public static $notStripTags = ['email'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_type_id',
        'email',
        'password',
        'first_name',
        'last_name',
        'profile_image',
        'status',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Save created_by on creating event
            if (!empty($model->has_created_by)) {
                $model->created_by = !empty(Auth::id()) ? Auth::id() : 0;
            }

            // Save updated_by on creating event
            if (!empty($model->has_updated_by)) {
                $model->updated_by = !empty(Auth::id()) ? Auth::id() : 0;
            }
        });

        static::updating(function ($model) {
            // Save updated_by on updating event
            if (!empty($model->has_updated_by)) {
                $model->updated_by = !empty(Auth::id()) ? Auth::id() : 0;
            }
        });
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format(config('app.datetime_format'));
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format(config('app.datetime_format'));
    }

    //get full name
    public function getFullnameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user list .
     * @param  \Illuminate\Http\Request  $request
     * @return object App\User
     */
    public function getResult($request)
    {
        $users = new User;

        if ($request->get('status') !== null) {
            $users = $users->where('status', $request->get('status'));
        }
       
        $per_page = !empty($request->get('per_page')) ? $request->get('per_page') : $users->count();
        $users = $users->orderBy("id");

        $users = $users->paginate($per_page);
        return $users;
    }
}