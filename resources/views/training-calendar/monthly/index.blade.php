<x-app-layout>
    <div class="row mb-2">
        <div class="col-6">
            <a href="{{ route('training-calendar.monthly.index') }}" class="w-100 btn btn-primary">
                Monthly Calendar
            </a>
        </div>
        <div class="col-6">
            <a href="{{ route('training-calendar.yearly.index') }}" class="w-100 btn btn-secondary">
                Yearly Calendar
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-body p-0">
            <div class="px-3 py-2" style="border-bottom: 1px solid #dee2e6">
                <div class="row align-items-center">
                    <div class="col-12 text-end">
                        @if($trainingCalendar && $trainingCalendar->document_path)
                            <a href="{{ asset('storage/' . $trainingCalendar->document_path) }}" download class="btn btn-sm btn-secondary">
                                <i class="bi bi-download icon-13 me-1"></i> Download
                            </a>
                        @endif
                        <a href="{{route('training-calendar.monthly.list')}}" class="btn btn-sm btn-primary">
                            <i class="bi bi-calendar3 icon-13 me-1"></i> {{ auth()->user()->role == 'Admin' ? 'Manage Calendar' : 'View Past Calendar'}}
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-3">
                @if($trainingCalendar && $trainingCalendar->document_path)
                    <div>
                        <iframe src="{{ asset('storage/' . $trainingCalendar->document_path) }}#toolbar=0&zoom=85" width="100%" height="600px"></iframe>
                    </div>
                @else
                    <p>No training calendar PDF available.</p>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')

    @endpush
</x-app-layout>
