@extends('admin::layouts.master')

@section('content')
<div id="ajax-response-text"></div>

<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">            
            <span class="caption-subject font-blue-sharp bold uppercase">{!! trans('admin::messages.view-name',['name'=>trans('admin::controller/blog.blog')]) !!}</span>
        </div>        
    </div>
    <div class="portlet-body">
        <div class="form-horrizontal">
            <div class="form-group row">
                <label class="col-md-3 control-label">{!! trans('admin::controller/blog.blog_name') !!}: </label>
                <div class="col-md-4">
                    {{ $blog_data->blog_name }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 control-label">{!! trans('admin::controller/blog.blog_seo_string') !!}:  </label>
                <div class="col-md-4">
                    {{ $blog_data->blog_seo_string }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 control-label">{!! trans('admin::controller/blog.blog_short_desc') !!}: </label>
                <div class="col-md-4">
                    {{ $blog_data->blog_short_desc }}
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-3 control-label">{!! trans('admin::controller/blog.blog_desc') !!}:  </label>
                <div class="col-md-4">
                    {{ $blog_data->blog_desc }}
                </div>    
            </div> 
        </div>
    </div>
</div>
<div class="clearfix"></div>
@include('admin::blog_comments.create')

{{--*/ $linkIcon = \Modules\Admin\Services\Helper\MenuHelper::getSelectedPageLinkIcon() /*--}}

<div id="edit_form">
</div>
<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa {{ $linkIcon }} font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">{!! trans('admin::messages.view-name',['name'=>trans('admin::controller/blog_comments.blog_comments')]) !!}</span>
        </div>
        <div class="actions">
            <a href="javascript:;" class="btn blue btn-add-big btn-expand-form"><i class="fa fa-plus"></i><span class="hidden-480">{!! trans('admin::messages.add-name',['name'=>trans('admin::controller/blog_comments.blog_comment')]) !!} </span></a>
        </div>
    </div>
    <div class="portlet-body">
        <div class="table-container">
            <input type="hidden" value="{{ route('admin.blog_comments.get_data',$blog_id)}}" id="blog_id"/>
            <table class="table table-striped table-bordered table-hover" id="BlogList">
                <thead>
                    <tr role="row" class="heading">
                        <th>#</th>
                        <th width='5%'>{!! trans('admin::controller/blog_comments.id') !!}</th>
                        <th width='50%'>{!! trans('admin::controller/blog_comments.comment') !!}</th>
                        <th width='25%'>{!! trans('admin::controller/blog_comments.status') !!}</th>
                        <th width='20%'>{!! trans('admin::controller/blog_comments.action') !!}</th>
                    </tr>
                    @include('admin::blog_comments.search')
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('template-level-scripts')
@parent
{!! HTML::script( URL::asset('js/admin/blog_comments.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        var blog_id = $("#blog_id").val();
        siteObjJs.admin.blogCommentJs.init(blog_id);
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop