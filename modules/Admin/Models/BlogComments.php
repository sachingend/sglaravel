<?php namespace Modules\Admin\Models;
   
use Modules\Admin\Models\BaseModel;

class BlogComments extends BaseModel {

   protected $table = 'blog_comments';
    
    protected $fillable = ['comment', 'status'];

}