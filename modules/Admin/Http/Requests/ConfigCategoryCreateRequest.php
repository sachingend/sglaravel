<?php
/**
 * The class for handling validation requests from ConfigCategoryController::store()
 * 
 * 
 * @author Tushar Dahiwale <tushard@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Http\Requests;

use Modules\Admin\Http\Requests\Request;
use Auth;

class ConfigCategoryCreateRequest extends Request
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
            'category' => 'required|max:50|unique:config_categories', //alphaSpaces
        ];
    }

    public function messages()
    {
        return [
            'category.required' => trans('admin::messages.error-required', ['name' => trans('admin::controller/config-category.name')]),
            'category.max' => trans('admin::messages.error-maxlength-number', ['name' => trans('admin::controller/config-category.name'), 'number' => '50']),
            'category.alpha_spaces' => trans('admin::messages.error-alpha-spaces', ['name' => trans('admin::controller/config-category.name')]),
            'category.unique' => trans('admin::messages.error-taken', ['name' => trans('admin::controller/config-category.name')]),
        ];
    }

    public function sanitize()
    {
        $input = $this->all();

        $input['category'] = filter_var($input['category'], FILTER_SANITIZE_STRING);

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
    public function authorize()
    {
        $action = $this->route()->getAction();

        $status = Auth::user()->can($action['as'], 'store');
        if (empty($status)) {
            abort(403);
        }
        return true;
    }
}
