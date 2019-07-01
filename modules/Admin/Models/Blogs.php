<?php

/**
 * The class to present FaqCategory model.
 * 
 * 
 * @author Sachin Gend <saching@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Models;

class Blogs extends BaseModel {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'blogs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['blog_name', 'blog_seo_string', 'blog_short_desc', 'blog_desc', 'status'];

}
