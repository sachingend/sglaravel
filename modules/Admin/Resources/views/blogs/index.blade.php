@extends('admin::layouts.master')

@section('content')
@include('admin::partials.breadcrumb')
<div id="ajax-response-text"></div>

@if(!empty(Auth::user()->hasAdd))
@include('admin::blogs.create')
@endif

{{--*/ $linkIcon = \Modules\Admin\Services\Helper\MenuHelper::getSelectedPageLinkIcon() /*--}}

<div id="edit_form">
</div>
<div class="portlet light col-lg-12">
    <div class="portlet-title">
        <div class="caption">
            <i class="fa {{ $linkIcon }} font-blue-sharp"></i>
            <span class="caption-subject font-blue-sharp bold uppercase">{!! trans('admin::messages.view-name',['name'=>trans('admin::controller/blog.blogs')]) !!}</span>
        </div>
        @if(!empty(Auth::user()->hasAdd))
        <div class="actions">
            <a href="javascript:;" class="btn blue btn-add-big btn-expand-form"><i class="fa fa-plus"></i><span class="hidden-480">{!! trans('admin::messages.add-name',['name'=>trans('admin::controller/blog.blog')]) !!} </span></a>
        </div>
        @endif
    </div>
    <div class="portlet-body">
        <div class="table-container">
            <table class="table table-striped table-bordered table-hover" id="BlogList">
                <thead>
                    <tr role="row" class="heading">
                        <th>#</th>
                        <th width='5%'>{!! trans('admin::controller/blog.id') !!}</th>
                        <th width='10%'>{!! trans('admin::controller/blog.blog_name') !!}</th>
                        <th width='15%'>{!! trans('admin::controller/blog.blog_seo_string') !!}</th>
                        <th width='20%'>{!! trans('admin::controller/blog.blog_short_desc') !!}</th>
                        <th width='25%'>{!! trans('admin::controller/blog.blog_desc') !!}</th>
                        <th width='15%'>{!! trans('admin::controller/blog.status') !!}</th>
                        <th width='10%'>{!! trans('admin::controller/blog.action') !!}</th>
                    </tr>
                    @include('admin::blogs.search')
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
{!! HTML::script( URL::asset('js/admin/blog.js') ) !!}
@stop

@section('scripts')
@parent
<script>
    jQuery(document).ready(function () {
        siteObjJs.admin.blogJs.init();
        siteObjJs.admin.commonJs.boxExpandBtnClick();
    });
</script>
@stop