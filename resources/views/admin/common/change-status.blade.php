<div class="toggle-switch-container pt-2">
    <label class="toggle-switch">
        <input class="change-status" type="checkbox" {{$status}}
            data-url="{{$url}}" data-key="STATUS" data-id="{{ $id }}"
            value="" name="status">
        <span class="toggle-slider"></span>
    </label>
</div>
@once
    @section('scripts')
        @parent
        <script>
            $("body").on("change", ".change-status", function(e) {
                const value = $(this).prop('checked');
                const id = $(this).attr('data-id');
                const url = $(this).attr('data-url');
                const key = $(this).attr('data-key');
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        id: id,
                        status: value,
                        key: key
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            text: "Successfully Change Status!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            text: response.responseJSON.error,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        e.target.checked = true;
                    }
                });

            });
        </script>
    @endsection
@endonce
