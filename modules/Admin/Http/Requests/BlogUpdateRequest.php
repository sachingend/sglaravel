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

class BlogUpdateRequest extends Request {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $this->sanitize();
        return [
            'blog_name' => 'required|max:50|unique:blogs,blog_name,' . $this->blogs->id, //alphaSpaces
            'blog_seo_string' => 'required|max:50|unique:blogs,blog_seo_string,' . $this->blogs->id, //alphaSpaces
            'blog_short_desc' => 'required|max:200',
            'blog_desc' => 'required|max:500',
            'status' => 'required|numeric'
        ];
    }

    public function messages() {
        return [
            'blog_name.required' => trans('admin::messages.error-required', ['name' => trans('admin::controller/blog.blog_name')]),
            'blog_name.alpha_spaces' => trans('admin::messages.error-alpha-spaces', ['name' => trans('admin::controller/blog.blog_name')]),
            'blog_name.max' => trans('admin::messages.error-maxlength-number', ['name' => trans('admin::controller/blog.blog_name'), 'number' => '50']),
            'blog_name.unique' => trans('admin::messages.error-taken-blog', ['name' => trans('admin::controller/blog.blog_name')]),
            'blog_seo_string.required' => trans('admin::messages.error-required', ['name' => trans('admin::controller/blog.blog_seo_string')]),
            'blog_seo_string.alpha_spaces' => trans('admin::messages.error-alpha-spaces', ['name' => trans('admin::controller/blog.blog_seo_string')]),
            'blog_seo_string.max' => trans('admin::messages.error-maxlength-number', ['name' => trans('admin::controller/blog.blog_seo_string'), 'number' => '50']),
            'blog_seo_string.unique' => trans('admin::messages.error-taken-blog', ['name' => trans('admin::controller/blog.blog_seo_string')]),
            'blog_short_desc.required' => trans('admin::messages.error-required', ['name' => trans('admin::controller/blog.blog_short_desc')]),
            'blog_short_desc.max' => trans('admin::messages.error-maxlength-number', ['name' => trans('admin::controller/blog.blog_short_desc'), 'number' => '200']),
            'blog_desc.required' => trans('admin::messages.error-required', ['name' => trans('admin::controller/blog.blog_desc')]),
            'blog_desc.max' => trans('admin::messages.error-maxlength-number', ['name' => trans('admin::controller/blog.blog_desc'), 'number' => '500']),
            'status.required' => trans('admin::messages.error-required-select', ['name' => trans('admin::controller/blog.status')]),
            'status.numeric' => trans('admin::messages.error-numeric-id', ['name' => trans('admin::controller/blog.status')]),
        ];
    }

    /**
     * Sanitize all input fieds and replace
     */
    public function sanitize() {
        $input = $this->all();

        $input['blog_name'] = filter_var($input['blog_name'], FILTER_SANITIZE_STRING);
        $input['blog_seo_string'] = filter_var($input['blog_seo_string'], FILTER_SANITIZE_STRING);
        $input['blog_short_desc'] = filter_var($input['blog_short_desc'], FILTER_SANITIZE_STRING);
        $input['blog_desc'] = filter_var($input['blog_desc'], FILTER_SANITIZE_STRING);
        $input['status'] = filter_var($input['status'], FILTER_SANITIZE_NUMBER_INT);
        if (Auth::check()) {
            $input['created_by'] = filter_var(Auth::user()->id, FILTER_SANITIZE_NUMBER_INT);
        }
        $this->merge($input);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        $action = $this->route()->getAction();

        $is_edit = Auth::user()->can($action['as'], 'edit');
        $own_edit = Auth::user()->can($action['as'], 'own_edit');

        if ($is_edit == 1 || (!empty($own_edit) && ($this->blogs->created_by == Auth::user()->id))) {
            return true;
        } else {
            abort(403);
        }
    }

}
