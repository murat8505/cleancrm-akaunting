@extends('layouts.install')

@section('header', trans('install.steps.database'))

@section('content')
  {{ Form::textGroup('hostname', trans('install.database.hostname'), 'server', ['required' => 'required'], old('hostname', '127.0.0.1'), 'col-md-12') }}

  {{ Form::textGroup('database', trans('install.database.name'), 'database', ['required' => 'required'], old('database', 'homestead'), 'col-md-12') }}

  {{ Form::textGroup('username', trans('install.database.username'), 'user', ['required' => 'required'], old('username'), 'col-md-12') }}

  {{ Form::passwordGroup('password', trans('install.database.password'), 'key', [], old('password'), 'col-md-12') }}

@endsection

@section('scripts')
  <script type="text/javascript">
    $(document).ready(function () {
      $('#next-button').attr('disabled', true);

      $('#hostname, #username, #database').keyup(function () {
        inputCheck();
      });
    });

    function inputCheck() {
      hostname = $('#hostname').val();
      username = $('#username').val();
      database = $('#database').val();

      if (hostname != '' && username != '' && database != '') {
        $('#next-button').attr('disabled', false);
      } else {
        $('#next-button').attr('disabled', true);
      }
    }
  </script>
@endsection
