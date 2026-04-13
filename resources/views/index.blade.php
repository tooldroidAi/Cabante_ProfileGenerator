<x-layouts.app>
    <div class="row g-4">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">Add New Profile</div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/add-profile') }}">
                        @csrf

                        <x-input label="Full Name" name="full_name" required="true" />
                        <x-input label="Age" name="age" type="number" required="true" />
                        <x-input label="Program/Study" name="program" required="true" />
                        <x-input label="Email Address" name="email" type="email" required="true" />

                        <div class="mb-3">
                            <label class="form-label d-block">Gender</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_male" value="Male"
                                    @checked(old('gender') === 'Male') required>
                                <label class="form-check-label" for="gender_male">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" id="gender_female"
                                    value="Female" @checked(old('gender') === 'Female') required>
                                <label class="form-check-label" for="gender_female">Female</label>
                            </div>
                        </div>

                        <x-checkbox-group label="Hobbies" name="hobbies" :options="['Reading', 'Music', 'Sports', 'Traveling', 'Gaming', 'Cooking']" />

                        <div class="mb-3">
                            <label for="biography" class="form-label">Short Biography</label>
                            <textarea id="biography" name="biography" rows="4" class="form-control"
                                required>{{ old('biography') }}</textarea>
                        </div>

                        <x-button type="submit" variant="primary">Save Profile</x-button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Saved Profiles</h5>
                <form method="POST" action="{{ url('/clear-profiles') }}">
                    @csrf
                    <x-button type="submit" variant="danger">Clear All Profiles</x-button>
                </form>
            </div>

            @if (empty($profiles))
                <div class="card">
                    <div class="card-body">No profiles</div>
                </div>
            @else
                <div class="d-grid gap-3">
                    @foreach ($profiles as $profile)
                        <div class="card">
                            <div class="card-body">
                                <div><strong>Full Name:</strong> {{ $profile['full_name'] }}</div>
                                <div><strong>Age:</strong> {{ $profile['age'] }}</div>
                                <div><strong>Program/Study:</strong> {{ $profile['program'] }}</div>
                                <div><strong>Email Address:</strong> {{ $profile['email'] }}</div>
                                <div><strong>Gender:</strong> {{ $profile['gender'] }}</div>
                                <div><strong>Hobbies:</strong> {{ implode(', ', $profile['hobbies']) }}</div>
                                <div><strong>Short Biography:</strong> {{ $profile['biography'] }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>