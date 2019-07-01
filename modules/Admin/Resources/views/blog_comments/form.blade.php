<div class="form-body">  
    <div class="form-group">
        <label class="col-md-3 control-label">{!! trans('admin::controller/blog_comments.comment') !!} <span class="required" aria-required="true">*</span></label>
        <div class="col-md-4">
            {!! Form::textarea('comment', null, ['class'=>'editme form-control']) !!}
        </div>    
    </div>    
    <div class="form-group">
        <label class="col-md-3 control-label">{!! trans('admin::controller/blog_comments.status') !!} </label>
        <div class="col-md-4">
            <div class="radio-list">
                <label class="radio-inline">{!! Form::radio('status', '1', true) !!} {!! trans('admin::messages.active') !!}</label>
                <label class="radio-inline">{!! Form::radio('status', '0') !!} {!! trans('admin::messages.inactive') !!}</label>
            </div>
        </div>
    </div>
</div>
