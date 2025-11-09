<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Application Settings</h5>
            </div>

            <div class="p-4">
                <form id="settingsForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        {{-- App Logo --}}
                        <div class="col-lg-12 mb-3">
                            {{-- Logo Preview --}}
                            <div class="mb-3 d-flex justify-content-center">
                                <img id="logoPreview" 
                                    src="{{ !empty($settings['app_logo']) ? asset($settings['app_logo']) : asset('images/tlp-logo.png') }}" 
                                    class="rounded border" 
                                    style="height: 150px; width: 150px;">
                            </div>

                            {{-- File Input --}}
                            <label for="app_logo" class="form-label d-block fw-semibold mb-2">Application Logo</label>
                            <input id="app_logo" type="file" name="app_logo" class="form-control" accept="image/*">
                        </div>

                        {{-- App Name --}}
                        <div class="col-lg-12 mb-3">
                            <label for="app_name" class="form-label fw-semibold">Application Name</label>
                            <input id="app_name" type="text" name="app_name" class="form-control" value="{{ $settings['app_name'] ?? '' }}" placeholder="Enter application name">
                        </div>

                        {{-- User Guideline --}}
                        <div class="col-lg-12 mb-3">
                            <label for="guideline_document_path" class="form-label">User Guideline</label>
                            @php
                                $guideline = \App\Models\Setting::get('guideline_document_path');
                            @endphp

                            @if($guideline && file_exists(public_path($guideline)))
                                <a href="{{ asset($guideline) }}" target="_blank" download="{{ \App\Models\Setting::get('app_name', 'Learning Portal') }} User Guideline">
                                    <i class="bi bi-download icon-13 ms-1"></i>
                                </a>
                            @endif
                            <input id="guideline_document_path" type="file" name="guideline_document_path" class="form-control" accept="application/pdf">
                        </div>

                        {{-- Save Button --}}
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn-primary save-settings-btn">
                                <i class="bi bi-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Live preview when selecting new logo
                $('#app_logo').on('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            $('#logoPreview').attr('src', event.target.result);
                        }
                        reader.readAsDataURL(file);
                    }
                });

                // Handle form save
                $(document).on('click', '.save-settings-btn', function() {
                    const $btn = $(this); // store reference
                    $btn.prop('disabled', true).addClass('disabled'); // disable button

                    let form = $('#settingsForm')[0];
                    let formData = new FormData(form);

                    $.ajax({
                        url: "{{ route('settings.update') }}",
                        type: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            toastr.success('Settings updated successfully!', '', { timeOut: 3000 });
                            setTimeout(() => location.reload(), 1500);
                        },
                        error: function(xhr) {
                            console.error(xhr.responseText);
                            toastr.error(xhr.responseJSON?.message || 'Something went wrong!');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>
