<form id="deleteForm-{{ $id }}" class="deleteForm" data-id="{{ $id }}" action="{{ $action }}"
    method="POST">
    @csrf
    @if ($isDestroy)
        @method('DELETE')
    @endif
    {{ $slot }}
</form>

@once
    @section('scripts')
        @parent
        <script>
            document.querySelectorAll(".deleteForm").forEach(form => {
                form.addEventListener("submit", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure you want to delete?",
                        text: "If you delete this, it will be gone forever.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#FF0000",
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit(); // Submit the current form directly
                        }
                    });
                });
            });
        </script>
    @endsection
@endonce
