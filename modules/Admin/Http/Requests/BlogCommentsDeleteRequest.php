<?php

/**
 * The class for handling validation requests from BlogsComntroller::deleteAction()
 * 
 * 
 * @author Sachin Gend <saching@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;

class BlogCommentsDeleteRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $this->sanitize();
        return [
            'ids' => 'required|numeric',
        ];
    }

    public function messages() {
        return [
            'ids.required' => trans('admin::messages.required-select', ['name' => trans('admin::controller/blog_comments.comment')]),
            'ids.numeric' => trans('admin::messages.error-numeric-id', ['name' => trans('admin::controller/blog_comments.comment')]),
        ];
    }

    public function sanitize() {
        $input = $this->all();

        $input['ids'] = filter_var($input['ids'], FILTER_SANITIZE_NUMBER_INT);

        $this->replace($input);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
         return true;
       
    }

}
