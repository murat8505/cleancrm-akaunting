<html>
@include('partials.bill.head')

<body onload="window.print();">
<!-- Content Wrapper. Contains page content -->
<div class="wrapper" style="margin-left: 0; page-break-after: always;">
  @yield('content')
</div>
<!-- /.content-wrapper -->
</body>
</html>
