@if (session('success'))
    <script>
        let successToastr = '{{ session('success') }}';
    </script>
@elseif(session('error'))
    <script>
        let errorToastr = '{{ session('error') }}';
    </script>
@endif