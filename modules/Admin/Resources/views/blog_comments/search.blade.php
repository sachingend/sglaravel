<tr role="row" class="filter">
    <td>
    </td>   
    <td>
    </td>   
    <td>
        {!! Form::text('comment', null, ['class'=>'form-control form-filter']) !!}
    </td>
    <td>
        {!!  Form::select('status', ['' => 'Select',0 => trans('admin::messages.inactive'), 1 => trans('admin::messages.active')], null, ['id' => 'status-drop-down-search', 'class'=>'form-control form-filter'])!!}
    </td>
    <td>
        <button class="btn btn-sm yellow filter-submit margin-bottom-5" title="{!! trans('admin::messages.search') !!}"><i class="fa fa-search"></i></button>
        <button class="btn btn-sm red filter-cancel margin-bottom-5" title="{!! trans('admin::messages.reset') !!}"><i class="fa fa-times"></i></button>
    </td>
</tr>