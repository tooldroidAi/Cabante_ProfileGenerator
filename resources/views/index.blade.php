<!-- 
    Name: [REDACTED - THIS REPO IS PUBLIC]
    Course Code: 4561
    Course Number: IT 9a/L

    Description: 1st Laravel Activity - Bootstrap

    Date Created: April 11, 2026
    GitHub: https://github.com/ToolDroidYT
-->

<x-layout title="Profile Manager">
    <div class="row g-4 mt-2">
        <div class="col-md-12 text-end mb-0 mb-md-2">
            <form action="{{ route('profiles.clear') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete all profiles?')">
                    <i class="bi bi-trash-fill me-1"></i>Delete All Profiles
                </button>
            </form>
        </div>

        <div class="col-md-5 col-lg-4 order-md-2">
            <div class="card shadow-sm border rounded-3 p-0 overflow-hidden sticky-md-top"
                style="top: 1.5rem; z-index: 10;">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h5 class="mb-0 fw-bold"><i
                            class="bi bi-person-plus-fill me-2"></i>{{ isset($editProfile) ? 'Edit Profile' : 'Add Profile' }}
                    </h5>
                </div>
                <div class="card-body p-3 p-md-4">
                    @if ($errors->any())
                        <div class="alert alert-danger p-2 mb-3 small">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger p-2 mb-3 small">{{ session('error') }}</div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success p-2 mb-3 small">{{ session('success') }}</div>
                    @endif

                    <form action="{{ isset($editProfile) ? route('profile.update', $editId) : route('profile.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf

                        <h6 class="mb-2 text-secondary border-bottom pb-1">Personal Info</h6>
                        <div class="row g-2">
                            <div class="col-12">
                                <div class="form-floating text-body">
                                    <input name="fullname" type="text" class="form-control" id="fullNameField"
                                        placeholder="Full name"
                                        value="{{ old('fullname', $editProfile['fullname'] ?? '') }}" required>
                                    <label for="fullNameField">Full Name</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating text-body">
                                    <input name="birthday" type="date" class="form-control" id="ageField"
                                        placeholder="Birthday"
                                        value="{{ old('birthday', $editProfile['birthday'] ?? '') }}" required>
                                    <label for="ageField">Birthday</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating text-body">
                                    <input name="course" type="text" class="form-control" id="courseField"
                                        placeholder="Program/Course"
                                        value="{{ old('course', $editProfile['course'] ?? '') }}" required>
                                    <label for="courseField">Course</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-floating text-body">
                                    <input name="email" type="email" class="form-control" id="emailField"
                                        placeholder="Email" value="{{ old('email', $editProfile['email'] ?? '') }}"
                                        required>
                                    <label for="emailField">Email address</label>
                                </div>
                            </div>
                        </div>

                        <h6 class="mt-3 mb-2 text-secondary border-bottom pb-1">Additional Details</h6>
                        <div class="row g-2 mb-2">
                            <div class="col-12">
                                <label class="form-label fw-semibold small">Gender</label>
                                <div class="p-2 border rounded text-body bg-body-tertiary">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderMale"
                                            value="male" required {{ old('gender', $editProfile['gender'] ?? '') == 'male' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="genderMale">Male</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="genderFemale"
                                            value="female" {{ old('gender', $editProfile['gender'] ?? '') == 'female' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="genderFemale">Female</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold small">Hobbies</label>
                                @php $selectedHobbies = old('hobbies', $editProfile['hobbies'] ?? []); @endphp
                                <div class="p-2 border rounded text-body bg-body-tertiary d-flex flex-wrap gap-2 small">
                                    @foreach(['programming', 'music', 'basketball', 'singing', 'dancing', 'social media', 'sleeping', 'gaming', 'reading', 'traveling', 'cooking', 'drawing'] as $hobby)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="hobbies[]"
                                                value="{{ $hobby }}" id="hobby_{{ $loop->index }}" {{ in_array($hobby, $selectedHobbies) ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="hobby_{{ $loop->index }}">{{ ucfirst($hobby) }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="biographyField" class="form-label fw-semibold small">Biography</label>
                            <textarea class="form-control" style="height: 80px;" placeholder="Short biography..."
                                id="biographyField" name="biography"
                                required>{{ old('biography', $editProfile['biography'] ?? '') }}</textarea>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold small">Profile Picture</label>
                            <input class="form-control form-control-sm" type="file" accept="image/*"
                                name="profilepicture" {{ isset($editProfile) ? '' : 'required' }}>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Banner Picture <sub>(Optional)</sub></label>
                            <input class="form-control form-control-sm" type="file" accept="image/*"
                                name="bannerpicture">
                        </div>

                        <div class="d-flex justify-content-end w-100 gap-2">
                            @if(isset($editProfile))
                                <a href="{{ route('index') }}" class="btn btn-sm btn-outline-secondary px-3"><i
                                        class="bi bi-x me-1"></i>Cancel</a>
                            @else
                                <button type="reset" class="btn btn-sm btn-outline-danger px-3"><i
                                        class="bi bi-arrow-counterclockwise me-1"></i>Reset</button>
                            @endif
                            <button type="submit" class="btn btn-sm btn-primary px-3 shadow-sm"><i
                                    class="bi bi-check2-circle me-1"></i>{{ isset($editProfile) ? 'Update' : 'Generate' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7 col-lg-8 order-md-1 mt-5 mt-md-0">
            <h4 class="mb-3">Saved Profiles</h4>
            <div class="row row-cols-1 row-cols-lg-2 g-3">
                @forelse($profiles as $id => $profile)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <x-profile-card :profile="$profile" :id="$id" />
                        </div>
                    </div>
                @empty
                    <div class="col-12 py-5 text-center text-muted">
                        <i class="bi bi-person-x display-1 d-block mb-3"></i>
                        <p class="fs-5">No profiles found. Create one to get started!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="col-12 text-center mt-4 mb-2">
        <small>Repurposed profile viewer from <a
                href="https://github.com/ToolDroidYT/IT-9a-Personal-Profile-Generator/">4th Lab Activity</a></small>
        <br>
        <small class="text-muted">&copy; {{ date('Y') }} ToolDroid. All rights reserved.</small>
    </div>
</x-layout>