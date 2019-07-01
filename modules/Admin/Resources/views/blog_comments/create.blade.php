<div class="portlet box blue add-form-main">
    <div class="portlet-title togglelable">
        <div class="caption">
            <i class="fa fa-plus"></i>{!! trans('admin::messages.add-name',['name'=>trans('admin::controller/blog_comments.blog_comment')]) !!} 
        </div>
        <div class="tools">
            <a href="javascript:;" class="expand box-expand-form"></a>
        </div>
    </div>
    <div class="portlet-body form display-hide">
        {!! Form::open(['route' => ['admin.blog_comments.store'], 'method' => 'post', 'class' => 'form-horizontal blog-comment-form',  'id' => 'create-blog-comment', 'msg' => 'Blog comment added successfully.']) !!}
        @include('admin::blog_comments.form')
        <input type="hidden" name="blog_id" id="blog_name_id" value="{{ $blog_id }}"/>
        <div class="form-actions">
            <div class="col-md-6">
                <div class="col-md-offset-6 col-md-9">
                    <button type="submit" class="btn green">{!! trans('admin::messages.save') !!}</button>
                    <button type="button" class="btn default btn-collapse btn-collapse-form-edit">{!! trans('admin::messages.cancel') !!}</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>