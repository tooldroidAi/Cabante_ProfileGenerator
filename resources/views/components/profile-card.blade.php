@props(['profile', 'id'])

@php
    $profilePicPath = $profile['profilepicture'] ?? null;
    $bannerPicPath = $profile['bannerpicture'] ?? null;

    $profilePicSrc = (!empty($profilePicPath) && file_exists(public_path($profilePicPath)))
        ? asset($profilePicPath)
        : 'https://picsum.photos/100/100?random=' . $id;

    $bannerPicSrc = (!empty($bannerPicPath) && file_exists(public_path($bannerPicPath)))
        ? asset($bannerPicPath)
        : null;
@endphp

<div class="card h-100 shadow-sm border-0 position-relative">
    <div class="position-absolute top-0 end-0 p-2" style="z-index: 10;">
        <div class="dropdown">
            <button class="btn btn-sm btn-light rounded-circle shadow-lg" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                <i class="bi bi-three-dots-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li><a class="dropdown-item" href="{{ route('profile.view', $id) }}"><i
                            class="bi bi-eye me-2 text-primary"></i>View Full Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('profile.edit', $id) }}"><i
                            class="bi bi-pencil-square me-2 text-warning"></i>Edit</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form action="{{ route('profile.delete', $id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item text-danger"
                            onclick="return confirm('Are you sure?')">
                            <i class="bi bi-trash me-2"></i>Delete
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>

    @if($bannerPicSrc)
        <img src="{{ $bannerPicSrc }}" class="card-img-top" alt="Banner" style="height: 200px; object-fit: cover;">
    @else
        <div class="card-img-top bg-secondary" style="height: 200px;"></div>
    @endif

    <div class="card-body text-center position-relative pt-0" style="margin-top: -40px;">
        <div class="mb-3 mt-n4">
            <img src="{{ $profilePicSrc }}" class="rounded-circle border border-3 border-white bg-white shadow-lg"
                alt="Profile" style="width: 100px; height: 100px; object-fit: cover;">
        </div>
        <h5 class="card-title fw-bold mb-1">{{ $profile['fullname'] }}</h5>
        <p class="text-muted mb-2 small">{{ $profile['course'] }}</p>

        <div class="d-flex justify-content-center gap-2 flex-wrap mb-3">
            <span class="badge bg-primary-subtle text-primary border border-primary-subtle">{{ $profile['age'] }} years
                old</span>
            <span
                class="badge bg-info-subtle text-info border border-info-subtle">{{ ucfirst($profile['gender']) }}</span>
            <span class="badge bg-success-subtle text-success border border-success-subtle text-truncate"
                style="max-width: 100px;" title="{{ $profile['email'] }}">{{ $profile['email'] }}</span>

        </div>

        <p class="card-text text-start small border-top pt-3 text-truncate" style="max-height: 4.5em;">
            "{{ $profile['biography'] }}"
        </p>

        <a href="{{ route('profile.view', $id) }}" class="btn btn-outline-primary btn-sm w-100 mt-auto">View Full
            Profile</a>
    </div>
</div>