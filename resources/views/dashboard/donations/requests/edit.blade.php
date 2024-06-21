<x-app-layout>
    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card border-0">
                        <div class="d-flex justify-content-between p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Edit Donation Request</h6>
                        </div>
                        <div class="p-4">
                            <form action="{{ route('dashboard.donations.requests.update', $donationRequest->id) }}"
                                  method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <label for="blood_type" class="form-label">Blood Type</label>
                                    <select class="form-control" id="blood_type" name="blood_type" required>
                                        <option value="" disabled {{ $donationRequest->blood_type ? '' : 'selected' }}>Select Blood Type</option>
                                        @foreach($bloodType as $key => $type)
                                            <option value="{{$key}}" {{ $donationRequest->blood_type == $key ? 'selected' : '' }}>{{$key}} ({{$type}})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount"
                                           value="{{ $donationRequest->amount }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="urgency_level" class="form-label">Urgency Level</label>
                                    <select class="form-select" id="urgency_level" name="urgency_level" required>
                                        @foreach($urgencyLevels as $level)
                                            <option
                                                value="{{$level}}" {{ $donationRequest->urgency_level === $level ? 'selected' : '' }}>
                                                {{$level}}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes"
                                              name="notes">{{ $donationRequest->notes }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('dashboard.donations.requests.show', $donationRequest->id) }}"
                                   class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
