<?php

/**
 * The repository class for managing blog specific actions.
 *
 *
 * @author Sachin Gend <saching@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Blogs;
use Exception;
use Route;
use Log;
use Cache;

class BlogRepository extends BaseRepository {

    /**
     * Create a new BlogRepository instance.
     *
     * @param  Modules\Admin\Models\Blog $blog
     * @return void
     */
    public function __construct(Blogs $blogs) {
        $this->model = $blogs;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function data($params = []) {
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));
        $response = Cache::tags(Blogs::table())->remember($cacheKey, $this->ttlCache, function() {
            return Blogs::orderBy('id')->get();
        });

        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Form data posted from ajax $inputs
     * @return $result array with status and message elements
     */
    public function create($inputs) {
        try {

            $blog = new $this->model;
            $allColumns = $blog->getTableColumns($blog->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $blog->$key = $value;
                }
            }

            $save = $blog->save();

            if ($save) {
                $response['status'] = 'success';
                $response['message'] = trans('admin::messages.added', ['name' => 'blog']);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-added', ['name' => 'blog']);
            }

            return $response;
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-added', ['name' => 'blog']) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error("Blog could not be added.", ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);
            return $response;
        }
    }

    /**
     * Update a blog.
     *
     * @param  Form data posted from ajax $inputs, Modules\Admin\Models\Blog $blog
     * @return $result array with status and message elements
     */
    public function update($inputs, $blog) {
        try {
            foreach ($inputs as $key => $value) {
                if (isset($blog->$key)) {
                    $blog->$key = $value;
                }
            }
            $blog->status = isset($blog['status']) ? $inputs['status'] : 0;

            $save = $blog->save();
            if ($save) {
                $response['status'] = 'success';
                $response['message'] = trans('admin::messages.updated', ['name' => 'blog']);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-updated', ['name' => 'blog']);
            }

            return $response;
        } catch (Exception $e) {

            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-updated', ['name' => 'blog']) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-updated', ['name' => 'blog']), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }
    
     /**
     * Delete actions on blogs
     *
     * @param  int  $status
     * @return int
     */
    public function deleteAction($inputs)
    {
        try {

            $resultStatus = false;

            $id = $inputs['ids'];

            $blog = Blogs::find($id);
            if (!empty($blog)) {
                $blog->delete();
                $resultStatus = true;
            }

            return $resultStatus;
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-deleted', ['name' => trans('admin::controller/blog.blog')]) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-deleted', ['name' => trans('admin::controller/blog.blog')]), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }

}
