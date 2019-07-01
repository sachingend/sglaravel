<?php

/**
 * The class for managing blog comments specific actions.
 * 
 * 
 * @author Sachin Gend <saching@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Http\Controllers;

use Auth;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Admin\Models\Blogs;
use Modules\Admin\Models\BlogComments;
use Modules\Admin\Repositories\BlogCommentsRepository;
use Modules\Admin\Http\Requests\BlogCommentsCreateRequest;
use Modules\Admin\Http\Requests\BlogCommentsDeleteRequest;
use Modules\Admin\Http\Requests\BlogCommentsUpdateRequest;

class BlogCommentsController extends Controller {

    /**
     * The BlogCommentsRepository instance.
     *
     * @var Modules\Admin\Repositories\BlogCommentsRepository
     */
    protected $repository;

    /**
     * Create a new BlogCommentsController instance.
     *
     * @param  Modules\Admin\Repositories\BlogCommentsRepository $repository,
     *
     * @return void
     */
    public function __construct(BlogCommentsRepository $repository) {
        parent::__construct();
//        $this->middleware('acl');
        $this->repository = $repository;
    }

    /**
     * List all the data
     * 
     * @return view
     */
    public function show($blog_id) {
        $blog_data = Blogs::find($blog_id);
        return view('admin::blog_comments.index', ['blog_id' => $blog_id, 'blog_data' => $blog_data]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return datatable
     */
    public function getData($blog_id) {
        $request = new Request();
        $blog_comments = $this->repository->data($blog_id);
        //filter to display own records     

        return Datatables::of($blog_comments)
                        ->addColumn('status', function ($blog_comment) {
                            $status = ($blog_comment->status) ? '<span class="label label-sm label-success">' . trans('admin::messages.active') . '</span>' : '<span class="label label-sm label-danger">' . trans('admin::messages.inactive') . '</span>';
                            return $status;
                        })
                        ->addColumn('action', function ($blog_comment) {
                            $actionList = '';
                            $actionList .= '<a href="javascript:;" data-action="edit" data-id="' . $blog_comment->id . '" id="' . $blog_comment->id . '" class="btn btn-xs default margin-bottom-5 yellow-gold edit-form-link" title="Edit" data-form-url = "' . route('admin.blog_comments.edit', $blog_comment->id) . '"><i class="fa fa-pencil"></i></a>';

                            $actionList .= '<a href="javascript:;" class="btn btn-xs default delete red-thunderbird margin-bottom-5" title="Delete" id =' . $blog_comment->id . ' created_by = ' . $blog_comment->user_id . '  data-form-url = "' . route('admin.blog_comments.delete') . '"><i class="fa fa-trash-o"></i></a>';


                            return $actionList;
                        })
                        ->filter(function ($instance) use ($request) {

                            //to display own records                           
                            if ($request->has('comment')) {

                                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                    return Str::contains(strtolower($row['blog_comment_name']), strtolower($request->get('comment'))) ? true : false;
                                });
                            }
                            if ($request->has('status')) {
                                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                    return Str::equals($row['status'], $request->get('status')) ? true : false;
                                });
                            }
                        })
                        ->make(true);
    }

    /**
     * Display a form to create new blog_comment comment.
     *
     * @return view as response
     */
    public function create() {

        return view('admin::blog_comments.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\BlogCommentsCreateRequest $request
     * @return json encoded Response
     */
    public function store(BlogCommentsCreateRequest $request) {
        $response = $this->repository->create($request->all());

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified BlogComments.
     *
     * @param  Modules\Admin\Models\BlogComments $blog_comment
     * @return json encoded Response
     */
    public function edit($comment_id) {
        $blog_comment = BlogComments::find($comment_id);
        $response['success'] = true;
        $response['form'] = view('admin::blog_comments.edit', compact('blog_comment'))->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\BlogCommentsUpdateRequest $request, Modules\Admin\Models\BlogComments $blog_comment
     * @return json encoded Response
     */
    public function update($comment_id, BlogCommentsUpdateRequest $request) {
        $blog_comment = BlogComments::find($comment_id);
        $response = $this->repository->update($request->all(), $blog_comment);
        return response()->json($response);
    }

    /**
     * Delete resource from storage.
     *
     * @param  Modules\Admin\Http\Requests\BlogCommentsDeleteRequest $request
     * @return json encoded Response
     */
    public function destroy(BlogCommentsDeleteRequest $request, BlogComments $blog_comment) {
        $response = [];
        $result = $this->repository->deleteAction($request->all());
        if ($result) {
            $response = ['status' => 'success', 'message' => trans('admin::messages.deleted', ['name' => trans('admin::controller/blog_comments.comment')])];
        } else {
            $response = ['status' => 'fail', 'message' => trans('admin::messages.not-deleted', ['name' => trans('admin::controller/blog_comments.comment')])];
        }

        return response()->json($response);
    }

}
