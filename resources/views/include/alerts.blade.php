@if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire('Errore!', '{{ session('error') }}', 'error');
        });
    </script>
@endif
