<?php

/**
 * The class for managing blogs specific actions.
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
use Modules\Admin\Repositories\BlogRepository;
use Modules\Admin\Http\Requests\BlogCreateRequest;
use Modules\Admin\Http\Requests\BlogDeleteRequest;
use Modules\Admin\Http\Requests\BlogUpdateRequest;

class BlogsController extends Controller {

    /**
     * The BlogRepository instance.
     *
     * @var Modules\Admin\Repositories\BlogRepository
     */
    protected $repository;

    /**
     * Create a new BlogCommentsController instance.
     *
     * @param  Modules\Admin\Repositories\BlogCommentsRepository $repository,
     *
     * @return void
     */
    public function __construct(BlogRepository $repository) {
        parent::__construct();
        $this->middleware('acl');
        $this->repository = $repository;
    }

    /**
     * List all the data
     * 
     * @return view
     */
    public function index() {
        return view('admin::blogs.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return datatable
     */
    public function getData(Request $request) {
        $blogs = $this->repository->data();
        //filter to display own records
        if (Auth::user()->hasOwnView && (empty(Auth::user()->hasEdit) || empty(Auth::user()->hasDelete))) {
            $blogs = $blogs->filter(function ($row) {
                return (Str::equals($row['created_by'], Auth::user()->id)) ? true : false;
            });
        }

        return Datatables::of($blogs)
                        ->addColumn('status', function ($blog) {
                            $status = ($blog->status) ? '<span class="label label-sm label-success">' . trans('admin::messages.active') . '</span>' : '<span class="label label-sm label-danger">' . trans('admin::messages.inactive') . '</span>';
                            return $status;
                        })
                        ->addColumn('action', function ($blog) {
                            $actionList = '';
                            if (!empty(Auth::user()->hasEdit) || (!empty(Auth::user()->hasOwnEdit) && ($blog->created_by == Auth::user()->id))) {
                                $actionList .= '<a href="javascript:;" data-action="edit" data-id="' . $blog->id . '" id="' . $blog->id . '" class="btn btn-xs default margin-bottom-5 yellow-gold edit-form-link" title="Edit"><i class="fa fa-pencil"></i></a>';
                            }

                            if (!empty(Auth::user()->hasDelete) || (!empty(Auth::user()->hasOwnDelete) && ($blog->created_by == Auth::user()->id))) {
                                $actionList .= '<a href="javascript:;" class="btn btn-xs default delete red-thunderbird margin-bottom-5" title="Delete" id =' . $blog->id . ' created_by = ' . $blog->created_by . ' ><i class="fa fa-trash-o"></i></a>';
                            }
                            
                            if ($blog->created_by == Auth::user()->id) {
                                $actionList .= '<a href="javascript:;" class="btn btn-xs comments default btn-success margin-bottom-5" title="Comments" id="'.$blog->id.'"><i class="fa fa-comments"></i></a>';
                            }

                            return $actionList;
                        })
                        ->filter(function ($instance) use ($request) {

                            //to display own records
                            if (Auth::user()->hasOwnView) {
                                $instance->collection = $instance->collection->filter(function ($row) {
                                    return (Str::equals($row['created_by'], Auth::user()->id)) ? true : false;
                                });
                            }
                            if ($request->has('blog_name')) {

                                $instance->collection = $instance->collection->filter(function ($row) use ($request) {
                                    return Str::contains(strtolower($row['blog_name']), strtolower($request->get('blog_name'))) ? true : false;
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
     * Display a form to create new blog.
     *
     * @return view as response
     */
    public function create() {

        return view('admin::blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\BlogCreateRequest $request
     * @return json encoded Response
     */
    public function store(BlogCreateRequest $request) {
        $response = $this->repository->create($request->all());

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified Blog.
     *
     * @param  Modules\Admin\Models\Blog $blog
     * @return json encoded Response
     */
    public function edit(Blogs $blog) {
        $response['success'] = true;
        $response['form'] = view('admin::blogs.edit', compact('blog'))->render();
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Modules\Admin\Http\Requests\BlogUpdateRequest $request, Modules\Admin\Models\Blogs $blog
     * @return json encoded Response
     */
    public function update(BlogUpdateRequest $request, Blogs $blog) {
        $response = $this->repository->update($request->all(), $blog);
        return response()->json($response);
    }
    
    
     /**
     * Delete resource from storage.
     *
     * @param  Modules\Admin\Http\Requests\BlogDeleteRequest $request
     * @return json encoded Response
     */
    public function destroy(BlogDeleteRequest $request, Blogs $blog)
    {       
        $response = [];
        $result = $this->repository->deleteAction($request->all());
        if ($result) {
            $response = ['status' => 'success', 'message' => trans('admin::messages.deleted', ['name' => trans('admin::controller/blog.blog')])];
        } else {
            $response = ['status' => 'fail', 'message' => trans('admin::messages.not-deleted', ['name' => trans('admin::controller/blog.blog')])];
        }

        return response()->json($response);
    }

}
