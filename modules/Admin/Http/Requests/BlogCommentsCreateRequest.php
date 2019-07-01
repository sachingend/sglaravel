<?php
/**
 * The class for handling validation requests from BlogsController::store()
 * 
 * 
 * @author Tushar Dahiwale <tushard@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;

class BlogCommentsCreateRequest extends Request
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {        
        $this->sanitize();
        return [   
            'comment' => 'required|max:500',
            'status' => 'required|numeric'
        ];
    }

    public function messages()
    {
        return [           
            'comment.required' => trans('admin::messages.error-required', ['name' => trans('admin::controller/blog_comments.comment')]),
            'comment.max' => trans('admin::messages.error-maxlength-number', ['name' => trans('admin::controller/blog_comments.comment'), 'number' => '500']),
            
            'status.required' => trans('admin::messages.error-required-select', ['name' => trans('admin::controller/blog_comments.status')]),
            'status.numeric' => trans('admin::messages.error-numeric-id', ['name' => trans('admin::controller/blog_comments.status')]),
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize()
    {
        $input = $this->all();
        $input['comment'] = filter_var($input['comment'], FILTER_SANITIZE_STRING);
        $input['status'] = filter_var($input['status'], FILTER_SANITIZE_NUMBER_INT);
        if (Auth::check()) {
            $input['user_id'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
        }
        $this->merge($input);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {    
        return true;
    }
}
