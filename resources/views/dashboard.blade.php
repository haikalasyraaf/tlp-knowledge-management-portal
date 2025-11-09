<x-app-layout>
    <div class="card">
        <div class="card-body p-0">
            <div class="p-3">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>

    @if ($bulletins->count() > 0)
        <div class="my-3">
            <div class="rounded-2 bg-gradient-blue px-3 py-2">
                <h6 class="mb-0">Internal Bulletins</h6>
            </div>
        </div>
        <div class="d-flex flex-nowrap overflow-x-auto gap-3 mb-4" style="max-width: 1232px;">
            @foreach ($bulletins as $bulletin)
                <div class="flex-shrink-0" style="width: 350px;">
                    <div class="card">
                        <img src="{{ $bulletin->image_path ? asset('storage/' . $bulletin->image_path) : asset('images/default-news.png') }}" class="card-img-top" style="height: 200px" alt="Image">
                        <div class="card-body p-4">
                            <div>
                                <h6>{{ $bulletin->title }}</h6>
                                <div class="form-control" style="border: none; background-color: transparent; padding: 0px; text-align: justify; height: 80px; overflow-y: auto;">
                                    {!! nl2br(e($bulletin->description)) !!}
                                </div>
                            </div>

                            <div class="mt-2">
                                <a href="#" class="w-100 btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewBulletinModal{{$bulletin->id}}">View Bulletin</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="viewBulletinModal{{$bulletin->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content text-start">
                            <div class="modal-header pb-0">
                                <h1 class="modal-title fs-5">View Bulletin</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="edit-wrapper">
                                    <div class="card" style="box-shadow: none !important">
                                        <div class="card-body pb-0">
                                            <div class="row">
                                                <div class="col-6">
                                                    <a class="w-100 btn btn-primary detail-btn active" style="cursor: pointer">Detail</a>
                                                </div>
                                                <div class="col-6">
                                                    <a class="w-100 btn btn-secondary attachment-btn" style="cursor: pointer">Attachment</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <form id="editForm{{$bulletin->id}}">
                                        <div class="card card-detail" style="box-shadow: none !important">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12 mb-3">
                                                        <label for="title{{$bulletin->id}}" class="form-label">Title</label>
                                                        <input id="title{{$bulletin->id}}" type="text" name="title" class="form-control"
                                                            value="{{$bulletin->title}}" placeholder="Title" disabled>
                                                    </div>
                                                    <div class="col-lg-12 mb-3">
                                                        <label for="description{{$bulletin->id}}" class="form-label">Description</label>
                                                        <textarea id="description{{$bulletin->id}}" name="description" class="form-control" rows="15" style="resize: none;" disabled>{!! $bulletin->description !!}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <form id="documentForm{{$bulletin->id}}" enctype="multipart/form-data">
                                        <div class="card card-attachment d-none" style="box-shadow: none !important">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-12 mb-2">
                                                        List of Attachment(s)
                                                    </div>

                                                    <div class="attachments-container" id="document-container-{{ $bulletin->id }}">
                                                        @forelse ($bulletin->documents as $document)
                                                            <div class="col-12 mb-2" id="document-{{ $document->id }}">
                                                                <div class="card">
                                                                    <div class="card-body p-2">
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <div>{{ $document->document_name }}</div>
                                                                            <div>
                                                                                <a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewBulletinDocumentModal{{ $document->id }}" data-file="{{ asset('storage/' . $document->document_path) }}">View</a>
                                                                                <a href="{{ asset('storage/'.$document->document_path) }}" class="btn btn-sm btn-primary" class="text-primary" download="{{ Str::slug(pathinfo($document->document_name, PATHINFO_FILENAME)) }}">Download</a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal fade" id="viewBulletinDocumentModal{{ $document->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                                                <div class="modal-dialog modal-xl">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <button type="button" class="btn-close" onclick="$('#viewBulletinDocumentModal{{ $document->id }}').modal('hide');"></button>
                                                                        </div>
                                                                        <div class="modal-body text-center">
                                                                            {{-- Default iframe preview --}}
                                                                            <iframe id="previewFrame{{ $document->id }}" src="" width="100%" height="600" style="border:none;display:none;"></iframe>

                                                                            {{-- Fallback message --}}
                                                                            <div id="downloadContainer{{ $document->id }}" style="display:none;">
                                                                                <div class="d-flex justify-content-center align-items-center" style="height: 600px">
                                                                                    <div>
                                                                                        <p>File type not support for preview. You can download the file below:</p>
                                                                                        <a id="downloadBtn{{ $document->id }}" href="#" class="btn btn-primary" download>Download File</a>                                                                        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @empty
                                                            <div class="col-12 mb-2" id="empty-document-message">
                                                                <div class="card">
                                                                    <div class="card-body p-2">
                                                                        <div class="d-flex justify-content-center align-items-center">
                                                                            <div class="text-center">No document uploaded</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforelse
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    @if ($top_transfer_of_knowledges->count() > 0)
        <div class="my-3">
            <div class="rounded-2 bg-gradient-blue px-3 py-2">
                <h6 class="mb-0">Top Learner</h6>
            </div>
        </div>
        <div class="d-flex overflow-auto flex-nowrap gap-3 mb-4" style="max-width: 1232px;">
            @foreach ($top_transfer_of_knowledges as $knowledge)
                <div class="flex-shrink-0" style="width: 350px">
                    <div class="card p-4">
                        <div class="card-header rounded-5 mb-4" style="background-color: #FFC107; color: black">
                            <div class="text-center">
                                <h5 class="mb-0">{{ $knowledge->top_learner_month->format('M Y') }} Top Learner</h5>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="d-flex justify-content-center">
                                <img src="{{ $knowledge->owner->profile_photo_path ? asset('storage/' . $knowledge->owner->profile_photo_path) : asset('images/default-profile-photo.png') }}" class="rounded-circle" style="width: 100px; height: 100px; border: 1px solid black; object-fit: cover;">
                            </div>
                            <div>
                                <h6 class="text-center"></h6>
                                <p class="text-center text-muted">
                                    <span class="text-uppercase">{{ $knowledge->owner->name }}</span> <br>
                                    {{ $knowledge->owner->department }}
                                </p>
                            </div>

                            <div>
                                <h6>{{ $knowledge->title }}</h6>
                                <div class="form-control" style="border: none; background-color: transparent; padding: 0px; text-align: justify; height: 80px; overflow-y: auto;">
                                    {!! nl2br(e($knowledge->content)) !!}
                                </div>
                            </div>

                            <div class="mt-2">
                                <a href="#" class="w-100 btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewKnowledgeModal{{$knowledge->id}}">View Transfer of Knowledge</a>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="viewKnowledgeModal{{$knowledge->id}}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content text-start">
                                <div class="modal-header pb-0">
                                    <h1 class="modal-title fs-5">View Transfer of Knowledge</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="edit-wrapper">
                                        <div class="card" style="box-shadow: none !important">
                                            <div class="card-body pb-0">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <a class="w-100 btn btn-primary detail-btn active" style="cursor: pointer">Detail</a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a class="w-100 btn btn-secondary attachment-btn" style="cursor: pointer">Attachment</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="editForm{{$knowledge->id}}">
                                            <div class="card card-detail" style="box-shadow: none !important">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12 mb-3">
                                                            <label for="title{{$knowledge->id}}" class="form-label">Title</label>
                                                            <input id="title{{$knowledge->id}}" type="text" name="title" class="form-control"
                                                                value="{{$knowledge->title}}" placeholder="Title" disabled>
                                                        </div>
                                                        <div class="col-lg-12 mb-3">
                                                            <label for="content{{$knowledge->id}}" class="form-label">Training Output</label>
                                                            <textarea id="content{{$knowledge->id}}" name="content" class="form-control" rows="15" style="resize: none;"
                                                                placeholder="Enter training output..." disabled>{!! $knowledge->content !!}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        <form id="documentForm{{$knowledge->id}}" enctype="multipart/form-data">
                                            <div class="card card-attachment d-none" style="box-shadow: none !important">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-2">
                                                            List of Attachment(s)
                                                        </div>

                                                        <div class="attachments-container" id="document-container-{{ $knowledge->id }}">
                                                            @forelse ($knowledge->documents as $document)
                                                                <div class="col-12 mb-2" id="document-{{ $document->id }}">
                                                                    <div class="card">
                                                                        <div class="card-body p-2">
                                                                            <div class="d-flex justify-content-between align-items-center">
                                                                                <div>{{ $document->document_name }}</div>
                                                                                <div>
                                                                                    <a href="#" class="btn btn-sm btn-info text-white view-doc-btn" data-bs-toggle="modal" data-bs-target="#viewKnowledgeDocumentModal{{ $document->id }}" data-file="{{ asset('storage/' . $document->document_path) }}">View</a>
                                                                                    <a href="{{ asset('storage/'.$document->document_path) }}" class="btn btn-sm btn-primary" class="text-primary" download="{{ Str::slug(pathinfo($document->document_name, PATHINFO_FILENAME)) }}">Download</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="modal fade" id="viewKnowledgeDocumentModal{{ $document->id }}" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                                                                    <div class="modal-dialog modal-xl">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="btn-close" onclick="$('#viewKnowledgeDocumentModal{{ $document->id }}').modal('hide');"></button>
                                                                            </div>
                                                                            <div class="modal-body text-center">
                                                                                {{-- Default iframe preview --}}
                                                                                <iframe id="previewFrame{{ $document->id }}" src="" width="100%" height="600" style="border:none;display:none;"></iframe>

                                                                                {{-- Fallback message --}}
                                                                                <div id="downloadContainer{{ $document->id }}" style="display:none;">
                                                                                    <div class="d-flex justify-content-center align-items-center" style="height: 600px">
                                                                                        <div>
                                                                                            <p>File type not support for preview. You can download the file below:</p>
                                                                                            <a id="downloadBtn{{ $document->id }}" href="#" class="btn btn-primary" download>Download File</a>                                                                        
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @empty
                                                                <div class="col-12 mb-2" id="empty-document-message">
                                                                    <div class="card">
                                                                        <div class="card-body p-2">
                                                                            <div class="d-flex justify-content-center align-items-center">
                                                                                <div class="text-center">No document uploaded</div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforelse
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>            
            @endforeach
        </div>
    @endif

    @push('scripts')
        <script>
            // Handle click on the 'Detail' button
            $(document).on('click', '.detail-btn', function (e) {
                e.preventDefault();

                const $wrapper = $(this).closest('.edit-wrapper');
                const $detailCard = $wrapper.find('.card-detail');
                const $attachmentCard = $wrapper.find('.card-attachment');
                const $attachmentBtn = $wrapper.find('.attachment-btn');

                $detailCard.removeClass('d-none');
                $attachmentCard.addClass('d-none');

                $(this).addClass('active btn-primary').removeClass('btn-secondary');
                $attachmentBtn.removeClass('active btn-primary').addClass('btn-secondary');
            });

            // Handle click on the 'Attachment' button
            $(document).on('click', '.attachment-btn', function (e) {
                e.preventDefault();

                const $wrapper = $(this).closest('.edit-wrapper');
                const $detailCard = $wrapper.find('.card-detail');
                const $attachmentCard = $wrapper.find('.card-attachment');
                const $detailBtn = $wrapper.find('.detail-btn');

                $detailCard.addClass('d-none');
                $attachmentCard.removeClass('d-none');

                $(this).addClass('active btn-primary').removeClass('btn-secondary');
                $detailBtn.removeClass('active btn-primary').addClass('btn-secondary');
            });
        </script>
    @endpush

</x-app-layout>
