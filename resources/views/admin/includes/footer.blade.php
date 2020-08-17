@guest
@else
<footer class="text-center footer-box bg-dark fixed-bottom py-2">
    Demo 2020
</footer>
@endguest
<script type="text/javascript">
    var csrf_token = "{{ csrf_token() }}";
    var regx_minimum_password_length = /^(.{8,})/;
</script>

<!-- Footer Scripts -->
<script src="{{ asset('assets/common/libraries/jquery-ui/jquery-ui.js') }}"></script>
<script src="{{ asset('assets/admin/js/jquery.form-validation.js') }}"></script>
<script src="{{ asset('assets/admin/js/footer.js') }}"></script>

</script>
