<section>
    <div class="mb-4">
        <h2 class="h5">{{ __('Update Email & Password') }}</h2>
        <p class="text-muted">{{ __('Use a strong password that includes a combination of alphabets (including capital letters) and numbers.') }}</p>
    </div>

    <form id="updatePasswordForm">
        {{-- Current Email --}}
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
            <div class="invalid-feedback" id="email_error"></div>
        </div>

        {{-- Current Password --}}
        <div class="mb-3">
            <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
            <input type="password" class="form-control" id="current_password" name="current_password" autocomplete="current-password">
            <div class="invalid-feedback" id="current_password_error"></div>
        </div>

        {{-- New Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('New Password') }}</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
            <div class="invalid-feedback" id="password_error"></div>
        </div>

        {{-- Confirm Password --}}
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
            <div class="invalid-feedback" id="password_confirmation_error"></div>
        </div>

        {{-- Buttons & Status --}}
        <div class="d-flex align-items-center gap-3">
            <button type="button" class="btn btn-primary save-btn">Save</button>
            <div class="text-muted small" id="passwordUpdatedMessage" style="display: none;">Saved.</div>
        </div>
    </form>
</section>

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<script>
    $(document).on('click', '.save-btn', function(e) {
        e.preventDefault();

        const form = $('#updatePasswordForm');

        // Clear previous errors
        form.find('.form-control').removeClass('is-invalid');
        form.find('.invalid-feedback').text('');

        $.ajax({
            url: "{{ route('password.update') }}",
            type: "POST",
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            success: function(response) {
                // Show success message
                toastr.success('Password updated successfully', '', { timeOut: 2000 });

                // Redirect to dashboard
                setTimeout(() => {
                    window.location.href = "/dashboard";
                }, 2000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.email) {
                        $('#email').addClass('is-invalid');
                        $('#email_error').text(errors.email[0]);
                    }
                    if (errors.current_password) {
                        $('#current_password').addClass('is-invalid');
                        $('#current_password_error').text(errors.current_password[0]);
                    }
                    if (errors.password) {
                        $('#password').addClass('is-invalid');
                        $('#password_error').text(errors.password[0]);
                    }
                    if (errors.password_confirmation) {
                        $('#password_confirmation').addClass('is-invalid');
                        $('#password_confirmation_error').text(errors.password_confirmation[0]);
                    }
                } else {
                    alert('Something went wrong. Please try again.');
                }
            }
        });
    });
</script>
