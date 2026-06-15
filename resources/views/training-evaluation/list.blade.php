<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-6">
                        <h5 class="mb-0">
                            ({{$trainingEvaluationGroup->group_name}})
                        </h5>
                    </div>
                    <div class="col-6 text-end">
                        {{-- <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                            <i class="bi bi-plus-lg icon-13 me-1"></i> New Record
                        </button> --}}
                        <a href="{{route('training-evaluation.index')}}" class="btn btn-sm btn-secondary">
                            <i class="bi bi-arrow-left icon-13 me-1"></i> Back
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-3">
                {!! $html->table() !!}
            </div>
        </div>
    </div>

    @push('scripts')
        {!! $html->scripts() !!}
        <script>
            $(document).on('click', '.add-btn', function (e) {
                let form = $('#createForm')[0];
                let formData = new FormData(form);
                $(e.currentTarget).prop('disabled', true);

                $.ajax({
                    url: "training-evaluation/create",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        toastr.success('Training Evaluation created successfully!', '', { timeOut: 8000 });

                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                        $(e.currentTarget).prop('disabled', false);
                    }
                });
            });

            $(document).on('click', '.delete-btn', function () {

                let trainingEvaluationId = $(this).data('id');

                $.ajax({
                    url: "/training-evaluation/" + trainingEvaluationId + "/delete",
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        toastr.success('Training Evaluation removed successfully!', '', { timeOut: 8000 });

                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
