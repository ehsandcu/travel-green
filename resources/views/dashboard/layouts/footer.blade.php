      </div>
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-center text-sm-left d-block d-sm-inline-block">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved.</span>
          </div>
        </footer>
      <!-- partial -->
    </div>
    <!-- main-panel ends -->
  </div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- base:js -->
<script src="{{ asset('assets/dashboard/vendors/js/vendor.bundle.base.js') }}"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="{{ asset('assets/dashboard/js/off-canvas.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/hoverable-collapse.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/template.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/settings.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/todolist.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/dashboard.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendors/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/jquery.validate.js') }}"></script>
<script src="{{ asset('assets/dashboard/js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script>
  jQuery.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
  });
</script>
@yield('dashboard-script')

</body>
</html>