<x-app-layout>
    <div class="row">
        <div class="col-12 text-end">
            <a href="{{route('training-assessment.index')}}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left icon-13 me-1"></i>Back
            </a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8 col-xl-6">
            <div class="card mb-3">
                <div class="card-body p-0">
                    <div class="p-3" style="border-bottom: 1px solid #dee2e6">
                        <div class="row align-items-center">
                            <div class="col-12">
                                <h5 class="mb-3">TRAINING ASSESSMENT FORM</h5>
                                <p class="mb-1">Course Title: {{$trainingAssessment->form_title}}</p>
                                <p class="mb-1">Course Venue: {{$trainingAssessment->form_venue ?? ''}}</p>
                                <p class="mb-0">Course Provider: {{$trainingAssessment->form_provider ?? ''}}</p>
                            </div>
                        </div>                
                    </div>
                </div>
            </div>
            <form id="assessmentForm">
                @php
                    $groupedQuestions = $trainingAssessment->post_questions->groupBy('question_category');
                    $questionNo = 1;
                @endphp

                @foreach ($groupedQuestions as $category => $questions)
                    <div class="mb-3">
                        <h5 class="fw-bold">{{ $category }}</h5>
                    </div>

                    @foreach ($questions as $question)
                        <div class="card card-detail mb-3">
                            <div class="card-body">
                                <div class="row align-items-center question-row">
                                    <div class="col-12 mb-2">
                                        <input type="hidden" name="answers[{{$question->id}}][question_id]" value="{{$question->id}}">
                                        <input type="hidden" name="answers[{{$question->id}}][question_type]" value="{{$question->question_type}}">

                                        {{ $questionNo++ }}. {{ $question->question_text }}
                                    </div>

                                    <div class="col-12 mb-0">
                                        @if ($question->question_type == 'scale')
                                            <div class="d-flex justify-content-between align-items-center my-2">
                                                <div>Strongly disagree</div>
                                                <div>Strongly agree</div>
                                            </div>
                                            <div class="d-flex justify-content-evenly align-items-center my-2">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <div class="form-check form-check-inline">
                                                        <input
                                                            class="form-check-input"
                                                            type="radio"
                                                            name="answers[{{$question->id}}][answer_value]"
                                                            id="q{{$question->id}}_{{$i}}"
                                                            value="{{$i}}"
                                                            @if($question->answer_value == $i) checked @endif
                                                            @if($trainingAssessment->status != 2 || $trainingAssessment->user_id != request()->user()->id) disabled @endif
                                                        >
                                                        <label class="form-check-label" for="q{{$question->id}}_{{$i}}">
                                                            {{$i}}
                                                        </label>
                                                    </div>
                                                @endfor
                                            </div>
                                        @endif

                                        @if ($question->question_type == 'text')
                                            <input
                                                type="text"
                                                name="answers[{{$question->id}}][answer_text]"
                                                class="form-control"
                                                value="{{$question->answer_text}}"
                                                @if($trainingAssessment->status != 1 || $trainingAssessment->user_id != request()->user()->id) disabled @endif
                                            >
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                @if ($trainingAssessment->post_submitted_on)
                    <div class="row">
                        <div class="col-12 text-end">
                            <p style="font-style: italic">Form Submitted At: {{$trainingAssessment->post_submitted_on->format('d/m/Y H:i:s')}}</p>
                        </div>
                    </div>
                @endif
                @if ($trainingAssessment->status == 2 && $trainingAssessment->user_id == request()->user()->id)
                    <div class="row">
                        <div class="col-12 text-end">
                            <button type="button" class="btn btn btn-success submit-btn">Submit Form</button>
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).on('click', '.submit-btn', function (e) {
                let form = $('#assessmentForm')[0];
                let formData = new FormData(form);
                $(e.currentTarget).prop('disabled', true);

                $.ajax({
                    url: "/training-assessment/" + {{$trainingAssessment->id}} + "/post/submit",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        toastr.success('Training Assessment submitted successfully!', '', { timeOut: 8000 });

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
        </script>
    @endpush
</x-app-layout>
