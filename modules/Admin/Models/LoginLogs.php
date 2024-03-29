<?php
/**
 * To present Ip Login Fail Model with associated authentication
 *
 * @author Manish S <manishs@gmail.com>
 * @package Admin
 * @since 1.0
 */
namespace Modules\Admin\Models;

use Modules\Admin\Models\BaseModel;

class LoginLogs extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'login_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'ip_address', 'in_time', 'last_access_time', 'out_time'];

    /**
     * The attributes that disable created_at and updated_at in database query
     *
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     * get name of the user from user model when used in join
     * 
     * @return type
     */
    public function user()
    {
        return $this->belongsTo('Modules\Admin\Models\User');
    }

}
