<?php

/**
 * The repository class for managing blog comments specific actions.
 *
 *
 * @author Sachin Gend <saching@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Repositories;

use Modules\Admin\Models\Blogs;
use Modules\Admin\Models\BlogComments;
use DB;
use PDO;
use Cache;

class BlogCommentsRepository extends BaseRepository {

    /**
     * Create a new BlogCommentsRepository instance.
     *
     * @param  Modules\Admin\Models\BlogComments $blog_comments
     * @return void
     */
    public function __construct(BlogComments $blog_comments) {
        $this->model = $blog_comments;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function data($params = []) {
        $blog_id = (int) $params;
        $cacheKey = str_replace(['\\'], [''], __METHOD__) . ':' . md5(json_encode($params));

        $response = Cache::tags(BlogComments::table())->remember($cacheKey, $this->ttlCache, function()use($blog_id) {
            return BlogComments::where('blog_id', $blog_id)->orderBy('id')->get();
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
            $blog_comments = new $this->model;
            $allColumns = $blog_comments->getTableColumns($blog_comments->getTable());
            foreach ($inputs as $key => $value) {
                if (in_array($key, $allColumns)) {
                    $blog_comments->$key = $value;
                }
            }
            $save = $blog_comments->save();

            if ($save) {
                $response['status'] = 'success';
                $response['message'] = trans('admin::messages.added', ['name' => trans('admin::controller/blog_comments.blog_comment')]);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-added', ['name' => trans('admin::controller/blog_comments.blog_comment')]);
            }

            return $response;
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-added', ['name' => trans('admin::controller/blog_comments.blog_comment')]) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error("Blog Comment could not be added.", ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }

    /**
     * Update a blog_comments.
     *
     * @param  Form data posted from ajax $inputs, Modules\Admin\Models\BlogComments $blog_comments
     * @return $result array with status and message elements
     */
    public function update($inputs, $blog_comment) {
        try {

            foreach ($inputs as $key => $value) {
                if (isset($blog_comment->$key)) {
                    $blog_comment->$key = $value;
                }
            }
            $save = $blog_comment->save();
            if ($save) {
                $response['status'] = 'success';
                $response['message'] = trans('admin::messages.updated', ['name' => trans('admin::controller/blog_comments.blog_comment')]);
            } else {
                $response['status'] = 'error';
                $response['message'] = trans('admin::messages.not-updated', ['name' => trans('admin::controller/blog_comments.blog_comment')]);
            }

            return $response;
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-updated', ['name' => trans('admin::controller/blog_comments.blog_comment')]) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-updated', ['name' => trans('admin::controller/blog_comments.blog_comment')]), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);
            return $response;
        }
    }

    /**
     * Delete actions on blogs
     *
     * @param  int  $status
     * @return int
     */
    public function deleteAction($inputs) {
        try {

            $resultStatus = false;

            $id = $inputs['ids'];

            $blog_comment = BlogComments::find($id);
            if (!empty($blog_comment)) {
                $blog_comment->delete();
                $resultStatus = true;
            }

            return $resultStatus;
        } catch (Exception $e) {
            $exceptionDetails = $e->getMessage();
            $response['status'] = 'error';
            $response['message'] = trans('admin::messages.not-deleted', ['name' => trans('admin::controller/blog_comments.comment')]) . "<br /><b> Error Details</b> - " . $exceptionDetails;
            Log::error(trans('admin::messages.not-deleted', ['name' => trans('admin::controller/blog_comments.comment')]), ['Error Message' => $exceptionDetails, 'Current Action' => Route::getCurrentRoute()->getActionName()]);

            return $response;
        }
    }

}
