@extends('layouts.admin')

@section('title', trans_choice('general.bills', 2))

@permission('create-expenses-bills')
@section('new_button')
  <span class="new-button"><a href="{{ url('expenses/bills/create') }}" class="btn btn-success btn-sm"><span
        class="fa fa-plus"></span> &nbsp;{{ trans('general.add_new') }}</a></span>
  @endsection
  @endpermission

  @section('content')
    <!-- Default box -->
  <div class="box box-success">
    <div class="box-header with-border">
      {!! Form::open(['url' => 'expenses/bills', 'role' => 'form', 'method' => 'GET']) !!}
      <div class="pull-left">
        <span class="title-filter hidden-xs">{{ trans('general.search') }}:</span>
        {!! Form::text('search', request('search'), ['class' => 'form-control input-filter input-sm', 'placeholder' => trans('general.search_placeholder')]) !!}
        {!! Form::select('vendor', $vendors, request('vendor'), ['class' => 'form-control input-filter input-sm']) !!}
        {!! Form::select('status', $status, request('status'), ['class' => 'form-control input-filter input-sm']) !!}
        {!! Form::button('<span class="fa fa-filter"></span> &nbsp;' . trans('general.filter'), ['type' => 'submit', 'class' => 'btn btn-sm btn-default btn-filter']) !!}
      </div>
      <div class="pull-right">
        <span class="title-filter hidden-xs">{{ trans('general.show') }}:</span>
        {!! Form::select('limit', $limits, request('limit', setting('general.list_limit', '25')), ['class' => 'form-control input-filter input-sm', 'onchange' => 'this.form.submit()']) !!}
      </div>
      {!! Form::close() !!}
    </div>
    <!-- /.box-header -->

    <div class="box-body">
      <div class="table table-responsive">
        <table class="table table-striped table-hover" id="tbl-bills">
          <thead>
          <tr>
            <th class="col-md-2">@sortablelink('bill_number', trans_choice('general.numbers', 1))</th>
            <th class="col-md-3">@sortablelink('vendor_name', trans_choice('general.vendors', 1))</th>
            <th class="col-md-1">@sortablelink('amount', trans('general.amount'))</th>
            <th class="col-md-2">@sortablelink('billed_at', trans('bills.bill_date'))</th>
            <th class="col-md-2">@sortablelink('due_at', trans('bills.due_date'))</th>
            <th class="col-md-1">@sortablelink('status.name', trans_choice('general.statuses', 1))</th>
            <th class="col-md-1 text-center">{{ trans('general.actions') }}</th>
          </tr>
          </thead>
          <tbody>
          @foreach($bills as $item)
            @php
            switch ($item->status->code) {
            case 'paid':
            $label = 'label-success';
            break;
            case 'partial':
            $label = 'label-warning';
            break;
            default:
            $label = 'bg-aqua';
            break;
            }
            @endphp
            <tr>
              <td><a href="{{ url('expenses/bills/' . $item->id . ' ') }}">{{ $item->bill_number }}</a></td>
              <td>{{ $item->vendor_name }}</td>
              <td>@money($item->amount, $item->currency_code, true)</td>
              <td>{{ Date::parse($item->billed_at)->format($date_format) }}</td>
              <td>{{ Date::parse($item->due_at)->format($date_format) }}</td>
              <td><span class="label {{ $label }}">{{ $item->status->name }}</span></td>
              <td class="text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                          data-toggle-position="left" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="{{ url('expenses/bills/' . $item->id) }}">{{ trans('general.show') }}</a></li>
                    <li><a href="{{ url('expenses/bills/' . $item->id . '/edit') }}">{{ trans('general.edit') }}</a>
                    </li>
                    @permission('delete-expenses-bills')
                    <li>{!! Form::deleteLink($item, 'expenses/bills') !!}</li>
                    @endpermission
                  </ul>
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
      @include('partials.admin.pagination', ['items' => $bills, 'type' => 'bills'])
    </div>
    <!-- /.box-footer -->
  </div>
  <!-- /.box -->
@endsection

