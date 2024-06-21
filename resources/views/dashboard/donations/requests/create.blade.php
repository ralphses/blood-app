@php use App\Models\User; @endphp
<x-app-layout>
    <x-top-header/>

    <div class="container-fluid">
        <div class="layout-specing">
            <div class="row mt-4">
                <div class="col-xl-6 offset-xl-3">
                    <div class="card border-0">
                        <div class="p-4 shadow rounded-top">
                            <h6 class="fw-bold mb-0">Create New Donation Request</h6>
                        </div>
                        <div class="card-body">
                            <!-- Display Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('dashboard.donations.requests.store') }}" method="POST">
                                @csrf
                                @can('isAdmin', User::class)
                                    <div class="mb-3">
                                        <label for="blood_type" class="form-label">Blood Type</label>
                                        <select class="form-select" id="blood_type" name="blood_type">
                                            @foreach($bloodTypes as $key => $bloodType)
                                                <option value="{{ $key }}" {{ old('blood_type') == $key ? 'selected' : '' }}>{{ $key }} ({{ $bloodType }})</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('blood_type'))
                                            <div class="text-danger">{{ $errors->first('blood_type') }}</div>
                                        @endif
                                    </div>
                                @endcan
                                <div class="mb-3">
                                    <label for="amount" class="form-label">Amount</label>
                                    <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount') }}">
                                    @if ($errors->has('amount'))
                                        <div class="text-danger">{{ $errors->first('amount') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="urgency_level" class="form-label">Urgency Level</label>
                                    <select class="form-select" id="urgency_level" name="urgency_level">
                                        @foreach($urgencyLevels as $level)
                                            <option value="{{ $level }}" {{ old('urgency_level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('urgency_level'))
                                        <div class="text-danger">{{ $errors->first('urgency_level') }}</div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="notes" class="form-label">Notes</label>
                                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                                    @if ($errors->has('notes'))
                                        <div class="text-danger">{{ $errors->first('notes') }}</div>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">Create Request</button>
                                <a href="{{ route('dashboard.donations.requests') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- end container -->

</x-app-layout>
