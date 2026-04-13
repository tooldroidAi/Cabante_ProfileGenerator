<!-- 
    Name: [REDACTED - THIS REPO IS PUBLIC]
    Course Code: 4561
    Course Number: IT 9a/L

    Description: 1st Laravel Activity - Bootstrap

    Date Created: April 11, 2026
    GitHub: https://github.com/ToolDroidYT
-->

@php
    $profile = is_array($profile ?? null) ? $profile : [];
    $birthday = $profile['birthday'] ?? null;
    $gender = $profile['gender'] ?? null;

    $profile_picture_path = $profile['profilepicture'] ?? null;
    $banner_picture_path = $profile['bannerpicture'] ?? null;

    $has_profile_image = !empty($profile_picture_path) && file_exists(public_path($profile_picture_path));
    $has_banner_image = !empty($banner_picture_path) && file_exists(public_path($banner_picture_path));

    $profile_picture_file = $has_profile_image ? asset($profile_picture_path) : null;
    $banner_picture_file = $has_banner_image ? asset($banner_picture_path) : null;


    $birthday_formatted = null;
    $birthday_distance_text = null;
    $age_text = '?';

    if (!empty($birthday)) {
        try {
            $birth_date = new DateTime($birthday);
            $today = new DateTime();
            $birthday_formatted = $birth_date->format('F j, Y');

            $this_year_birthday = new DateTime($today->format('Y') . '-' . $birth_date->format('m-d'));
            $next_birthday = clone $this_year_birthday;
            if ($this_year_birthday < $today) {
                $next_birthday->modify('+1 year');
            }

            $days_until_next_birthday = $today->diff($next_birthday)->days;
            $birthday_distance_text = $days_until_next_birthday . ' days from now';

            $interval = $today->diff($birth_date);
            $age_text = $interval->format('%y years %m months and %d days');
        } catch (Throwable $e) {
            $birthday_formatted = null;
            $birthday_distance_text = null;
            $age_text = '?';
        }
    }

    if (!function_exists('generate_random_number')) {
        function generate_random_number($min, $max)
        {
            return rand($min, $max);
        }
    }

    if (!function_exists('formatNumber')) {
        function formatNumber($number)
        {
            if ($number < 1000) {
                return (string) $number;
            }

            if ($number < 1000000) {
                $formatted = $number / 1000;
                return (round($formatted, 1) == (int) $formatted ? (int) $formatted : round($formatted, 1)) . 'K';
            }

            return number_format($number);
        }
    }

    $friends_count = $friends_count ?? generate_random_number(100, 1000);
    $mutual_friends_count = $mutual_friends_count ?? generate_random_number(10, min($friends_count, 100));
    $posts_count = max(0, (int) ($posts_count ?? generate_random_number(8, 24)));

    $reactions = $reactions ?? ['like', 'heart', 'care', 'wow'];
    if (count($reactions) === 0) {
        $reactions = ['like'];
    }
@endphp

<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pisbok - {{ $profile['fullname'] ?? 'Profile' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans+Flex:opsz,wght@6..144,1..1000&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar bg-body shadow-sm border-bottom border-opacity-25 sticky-top">
        <div class="flex-row flex-nowrap d-flex w-100 align-items-center overflow-hidden">
            <!-- 1 -->
            <div class="d-flex align-items-center justify-content-start flex-fill ms-4">
                <a href="javascript:history.back()"
                    class="me-3 btn-outline-secondary text-decoration-none text-body d-flex flex-row align-items-center justify-content-center d-none d-md-flex"><i
                        class="bi bi-chevron-left fs-5 text-body"></i><small style="margin-top: -2px;">Back</small></a>
                <a href="#" class="navbar-brand fw-bold">Pisbok</a>
                <!-- Search -->
                <form class="form-inline position-relative mb-0">
                    <input class="form-control rounded-pill d-lg-block d-none bg-body-tertiary border-0" type="search"
                        placeholder="      Search" aria-label="Search">
                    <i class="bi bi-search position-absolute d-lg-block d-none"
                        style="left: 0.8rem; top: 50%; transform: translateY(-50%); font-size: 14px;"></i>
                    <i class="bi bi-search d-lg-none d-block bg-body-tertiary fs-6 d-flex justify-content-center align-items-center rounded-circle"
                        style="width: 2.5rem; height: 2.5rem; font-size: 14px;"></i>
                </form>
            </div>

            <!-- 2 -->
            <div class="d-flex align-items-center justify-content-center flex-fill d-none d-sm-block">
                <nav>
                    <ul class="navbar-nav flex-row gap-5 align-items-center justify-content-center">
                        <li class="nav-item d-flex justify-content-center align-items-center fs-5">
                            <i class="bi bi-house-door"></i>
                        </li>
                        <li class="nav-item d-flex justify-content-center align-items-center fs-5">
                            <i class="bi bi-collection-play"></i>
                        </li>
                        <li class="nav-item d-flex justify-content-center align-items-center fs-5">
                            <i class="bi bi-shop-window"></i>
                        </li>
                        <li class="nav-item d-flex justify-content-center align-items-center fs-5">
                            <i class="bi bi-people"></i>
                        </li>
                        <li class="nav-item d-flex justify-content-center align-items-center fs-5">
                            <i class="bi bi-controller"></i>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- 3 -->
            <div class="flex-column align-items-end flex-fill justify-content-end">
                <nav>
                    <ul class="navbar-nav flex-row gap-2 align-items-end justify-content-end me-4">
                        <li class="nav-item ratio ratio-1x1" style="width: 2.5rem; height: 2.5rem;">
                            <i
                                class="bg-body-tertiary fs-6 d-flex justify-content-center align-items-center rounded-circle bi bi-grid-3x3-gap-fill"></i>
                        </li>
                        <li class="nav-item ratio ratio-1x1" style="width: 2.5rem; height: 2.5rem;">
                            <i
                                class="bg-body-tertiary fs-6 d-flex justify-content-center align-items-center rounded-circle bi bi-chat-dots-fill"></i>
                        </li>
                        <li class="nav-item ratio ratio-1x1" style="width: 2.5rem; height: 2.5rem;">
                            <i
                                class="bg-body-tertiary fs-6 d-flex justify-content-center align-items-center rounded-circle bi bi-bell-fill"></i>
                        </li>
                        <li class="nav-item ratio ratio-1x1 position-relative d-flex"
                            style="width: 2.5rem; height: 2.5rem;">
                            <img class="bg-body-tertiary fs-6 d-flex justify-content-center align-items-center rounded-circle object-fit-cover"
                                src="{{ $has_profile_image ? $profile_picture_file : 'https://picsum.photos/800/400' ?? '' }}"
                                alt="Profile picture">
                            <!-- The arrow down icon thingy -->
                            <i class="bi bi-chevron-down rounded-circle d-flex justify-content-center align-items-center position-absolute align-self-end bg-body-secondary text-light"
                                style="width: 0.8rem; height: 0.8rem; bottom: 0; right: 0; font-size: 8px; justify-self: end;"></i>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </nav>

    <section class="container position-relative overflow-x-hidden" id="profile">
        <!-- Backdrop banner -->
        <img class="h-auto object-fit-cover rounded-3 position-absolute top-0 start-50 translate-middle-x opacity-50"
            style="pointer-events: none; filter: blur(32px) grayscale(25%); width: 85%; aspect-ratio: 2.5/1.2; border-top-left-radius: 0 !important; border-top-right-radius: 0 !important;"
            src="{{ $has_banner_image ? $banner_picture_file : 'https://picsum.photos/800/400' ?? '' }}"
            alt="Banner image">

        <!-- Banner -->
        <header class="d-flex w-100 justify-content-center position-relative">
            <img class="h-auto object-fit-cover rounded-3 banner-width"
                style="aspect-ratio: 2.5/1; border-top-left-radius: 0 !important; border-top-right-radius: 0 !important; {{ !empty($profile["bannerpicture"]) ? '' : 'filter: blur(2px) grayscale(85%);' }}"
                src="{{ $has_banner_image ? $banner_picture_file : 'https://picsum.photos/800/400' ?? '' }}"
                alt="Banner image">
            @if(empty($profile["bannerpicture"]))
                <div class="position-absolute top-0 d-flex justify-content-start align-items-end w-100 h-100 rounded-3 d-none d-md-flex"
                    style="left: 9%">
                    <p class="bg-info-subtle text-info py-1 px-2 rounded-2 opacity-50">No banner provided</p>
                </div>
            @endif
        </header>

        <!-- Profile Info -->
        <div class="d-flex flex-column align-items-center text-center mt-3">
            <!-- PFP -->
            <div class="d-inline-flex align-items-center justify-content-center bg-secondary-subtle rounded-circle"
                style="width: 168px; height: 168px; margin-top: -100px; border: 4px solid var(--bs-body); z-index: 1;">
                <img src="{{ $has_profile_image ? $profile_picture_file : 'https://picsum.photos/800/400' ?? '' }}"
                    alt="Profile picture" class="img w-100 rounded-circle h-100 object-fit-cover">
            </div>
            <!-- Name -->
            <h1 class="mt-3 mb-0 fw-bold d-flex align-items-center justify-content-center">
                {!! !empty($profile["fullname"]) ? e($profile["fullname"]) : "<em>Not Provided</em>" !!}<i
                    class="bi bi-patch-check-fill text-info fs-5 ms-2" style="margin-top: 0.5rem;"></i>
            </h1>
            <!-- Course -->
            <p class="text-muted mb-0">
                {!! !empty($profile["course"]) ? e($profile["course"]) : "<em>Course not specified</em>" !!}
            </p>
            <!-- Friends, Mutuals, and Posts -->
            <p class="text-muted mb-0">
                {{ $friends_count ?? '' }} friends
                @if(true)
                    &middot; {{ $mutual_friends_count ?? '' }} mutual friends
                @endif
                &middot; {{ $posts_count ?? '' }} posts
            </p>

            @if(!empty($profile["biography"]))
                <div class="container d-flex flex-wrap justify-content-center mt-2">
                    <p class="text-muted py-2 px-3 bg-body-tertiary bg-opacity-75 rounded-3 mt-2 overflow-auto"
                        style="max-height: 100px; max-width: 600px; scrollbar-width: thin;">
                        {!! !empty($profile["biography"]) ? e($profile["biography"]) : '<em>No biography provided</em>' !!}
                    </p>
                </div>
            @endif
        </div>

        <!-- Horizontal divider thingy -->
        <div class="container px-4">
            <hr>
        </div>
    </section>

    <section class="w-100 d-flex justify-content-center mb-5 position-relative" id="content">
        <div class="container row justify-content-center px-0 px-md-5 position-relative">
            <div class="col-lg-6 col-md-8 align-self-start mb-3 position-relative">
                <div class="card border-0 shadow-sm rounded-4 bg-body-tertiary p-4">
                    <h3 class="fs-5 fw-bold mb-3">Personal Details</h3>

                    <!-- Birthday -->
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="nav-item ratio ratio-1x1 bg-secondary-subtle text-secondary rounded p-2"
                            style="width: 2.5rem; height: 2.5rem;">
                            <i
                                class="fs-5 d-flex justify-content-center align-items-center rounded-circle bi bi-cake"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Birthday</small>
                            <span class="fw-medium text-break">
                                {!! $birthday_formatted ?: '<em>None</em>' !!}
                                @if($birthday_distance_text)
                                    <small class="text-muted">({{ $birthday_distance_text }})</small>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Age -->
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="nav-item ratio ratio-1x1 bg-secondary-subtle text-secondary rounded p-2"
                            style="width: 2.5rem; height: 2.5rem;">
                            <i
                                class="fs-5 d-flex justify-content-center align-items-center rounded-circle bi bi-hourglass-split"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Age</small>
                            <span class="fw-medium text-break">{{ $age_text ?? '' }}</span>
                        </div>
                    </div>

                    <!-- Gender -->
                    @php
                        $gender_icon = null;
                        if ($gender) {
                            switch (strtolower($gender)) {
                                case 'male':
                                    $gender_icon = 'bi bi-gender-male';
                                    break;
                                case 'female':
                                    $gender_icon = 'bi bi-gender-female';
                                    break;
                                default:
                                    $gender_icon = 'bi bi-gender-ambiguous';
                            }
                        }
                    @endphp
                    @if(strtolower($profile["gender"] ?? "") !== 'pnts')
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="nav-item ratio ratio-1x1 bg-secondary-subtle text-secondary rounded p-2"
                                style="width: 2.5rem; height: 2.5rem;">
                                <i
                                    class="fs-5 d-flex justify-content-center align-items-center rounded-circle {{ $gender_icon ?: 'bi bi-gender-ambiguous' ?? '' }}"></i>
                            </div>
                            <div>
                                <small class="text-muted d-block">Gender</small>
                                <span
                                    class="fw-medium text-break">{{ !empty($profile["gender"]) ? ucwords($profile["gender"]) : 'Unknown' }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Email -->
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="nav-item ratio ratio-1x1 bg-secondary-subtle text-secondary rounded p-2"
                            style="width: 2.5rem; height: 2.5rem;">
                            <i
                                class="fs-5 d-flex justify-content-center align-items-center rounded-circle bi bi-envelope"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Email</small>
                            <span
                                class="fw-medium text-break">{!! !empty($profile["email"]) ? e($profile["email"]) : '<em>None</em>' !!}</span>
                        </div>
                    </div>

                    <h3 class="fs-5 fw-bold my-3">Hobbies</h3>

                    <!-- Hobbies -->
                    <div class="d-flex align-items-start gap-3 mb-3">
                        <div class="nav-item ratio ratio-1x1 bg-secondary-subtle text-secondary rounded p-2 flex-shrink-0"
                            style="width: 2.5rem; height: 2.5rem;">
                            <i
                                class="fs-5 d-flex justify-content-center align-items-center rounded-circle bi bi-dice-3"></i>
                        </div>
                        <div class="d-flex flex-row flex-wrap gap-2">
                            @php
                                // Map of hobbies to Bootstrap icons
                                $hobby_icons = [
                                    'programming' => 'bi-code-slash',
                                    'music' => 'bi-music-note-beamed',
                                    'basketball' => 'bi-dribbble',
                                    'singing' => 'bi-mic',
                                    'dancing' => 'bi-person-walking',
                                    'social media' => 'bi-share',
                                    'sleeping' => 'bi-moon-stars',
                                    'gaming' => 'bi-controller',
                                    'reading' => 'bi-book',
                                    'traveling' => 'bi-airplane',
                                    'cooking' => 'bi-egg-fried',
                                    'photography' => 'bi-camera',
                                    'drawing' => 'bi-palette',
                                    'working out' => 'bi-lightning-charge'
                                ];
                            @endphp
                            @forelse ((array) ($profile['hobbies'] ?? []) as $hobby)
                                <span
                                    class="badge bg-secondary-subtle text-secondary border border-secondary border-opacity-25">
                                    <i class="bi {{ $hobby_icons[$hobby] ?? 'bi-star' }}"></i>
                                    {{ ucwords($hobby) }}
                                </span>
                            @empty
                                <span class="text-muted"><em>No hobbies provided</em></span>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Photos -->
                <div class="card border-0 shadow-sm rounded-4 bg-body-tertiary p-4 mt-3 position-relative">
                    <h3 class="fs-5 fw-bold mb-3">Photos</h3>
                    <div class="d-flex flex-column g-2">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="d-flex flex-row gap-1 mb-1">
                                @for ($j = 0; $j < 3; $j++)
                                    <div class="m-0 p-0 ratio ratio-1x1">
                                        <img src="https://picsum.photos/100?random={{ $i . $j }}" alt="Picture"
                                            class="rounded object-fit-cover">
                                    </div>
                                @endfor
                            </div>
                        @endfor
                    </div>

                </div>
            </div>

            <div class="col-lg-6 col-md-8">
                <!-- What's on your mind thingy -->
                <div
                    class="col-lg-6 col-md-8 card border-0 shadow-sm rounded-4 bg-body-tertiary p-3 d-flex flex-column w-100">
                    <div class="d-flex flex-row">
                        <img class="bg-body-tertiary fs-6 d-flex justify-content-center align-items-center rounded-circle object-fit-cover flex-shrink-0"
                            src="{{ $has_profile_image ? $profile_picture_file : 'https://picsum.photos/800/400' ?? '' }}"
                            style="width: 3rem; height: 3rem;" alt="Profile picture">
                        <input type="text" class="form-control rounded-pill bg-body-secondary border-0 ms-2"
                            placeholder="What's on your mind?">
                    </div>
                    <hr style="opacity: 0.15;">
                    <div class="d-flex flex-row">
                        <button
                            class="btn btn-sm rounded-3 flex-fill d-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-camera-video fs-5 text-danger"></i>
                            Live Video
                        </button>
                        <button
                            class="btn btn-sm rounded-3 flex-fill d-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-images fs-5 text-success"></i>
                            Photo/Video
                        </button>
                        <button
                            class="btn btn-sm rounded-3 flex-fill d-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-flag fs-5 text-info"></i>
                            Life update
                        </button>
                    </div>
                </div>

                <h3 class="fs-5 fw-bold my-3 ms-2">Posts</h3>

                @php
                    $getFuzzyTime = static function ($timestamp) {
                        $now = new DateTime();
                        $ago = new DateTime();
                        $ago->setTimestamp($timestamp);
                        $diff = $now->diff($ago);

                        $days = $diff->d;
                        $hours = $diff->h;
                        $mins = $diff->i;

                        if ($days == 0) {
                            if ($hours == 0) {
                                if ($mins <= 1)
                                    return "Just now";
                                return $mins . " mins ago";
                            }
                            return $hours . " " . ($hours == 1 ? "hr" : "hrs") . " ago";
                        } elseif ($days == 1) {
                            return "Yesterday at " . $ago->format('g:i A');
                        } elseif ($days < 7) {
                            return $ago->format('l \a\t g:i A'); // like: Tuesday at 8:00 PM
                        }

                        return $ago->format('F j \a\t g:i A'); // like: March 7 at 10:18 PM
                    };
                @endphp

                <!-- Posts -->
                <div class="d-flex flex-column gap-3">
                    @php
                        // Random timestamps for posts
                        $timestamps = [];
                        for ($i = 0; $i < $posts_count; $i++) {
                            $seconds = 6 * 30 * 24 * 60 * 60; // 6 months in seconds
                            $timestamps[] = time() - rand(0, $seconds);
                        }

                        rsort($timestamps);
                    @endphp

                    @for ($post_idx = 0; $post_idx < $posts_count; $post_idx++)
                        @php
                            $current_time = $timestamps[$post_idx];
                            $display_time = $getFuzzyTime($current_time);

                            // Calculate random dimensions and stuff
                            $img_height = rand(300, 450);
                            $likes = generate_random_number(0, 2000);
                            $shares = generate_random_number(0, min($likes, rand(1, 500)));
                            $comments = generate_random_number(0, $likes * 2);

                            $reaction_keys = array_rand($reactions, min(3, count($reactions)));
                        @endphp

                        <div class="card border-0 shadow-sm rounded-4 bg-body-tertiary p-3 pb-2">
                            <!-- Header -->
                            <div class="d-flex flex-row gap-2 mb-3">
                                <img class="bg-body-tertiary d-flex justify-content-center align-items-center rounded-circle"
                                    src="{{ $has_profile_image ? $profile_picture_file : 'https://picsum.photos/100/100?random=' . $post_idx }}"
                                    style="width: 2.5rem; height: 2.5rem; object-fit: cover;" alt="Profile picture">
                                <div class="d-flex flex-column gap-0">
                                    <span class="fw-medium d-block m-0 p-0">
                                        {!! !empty($profile["fullname"]) ? e($profile["fullname"]) : '<em>Unknown User</em>' !!}
                                    </span>
                                    <small class="text-muted">{{ $display_time ?? '' }} &middot; <i
                                            class="bi bi-globe-americas" style="font-size: 0.8rem;"></i></small>
                                </div>
                            </div>

                            <!-- Post content -->
                            <div class="mb-2">
                                <img src="https://picsum.photos/800/{{ $img_height ?? '' }}?random={{ $post_idx ?? '' }}"
                                    alt="Post content" loading="lazy"
                                    class="w-100 rounded-3 bg-body-secondary object-fit-cover"
                                    style="height: {{ $img_height ?? '' }}px; min-height: 200px;">
                            </div>

                            <!-- Reactions and Stuff -->
                            <div class="d-flex flex-row align-items-center gap-2 px-1 mb-2" style="font-size: 0.9rem;">
                                <div class="d-flex flex-row-reverse justify-content-end">
                                    @foreach((array) $reaction_keys as $key)
                                        <img src="{{ asset('assets/images/reactions/' . ($reactions[$key] ?? '') . '.png') }}"
                                            width="18" height="18" class="rounded-circle border border-2 ms-n2 object-fit-cover"
                                            style="margin-left: -5px; position: relative; z-index: 1; border-color: var(--bs-tertiary-bg) !important;"
                                            alt="reaction">
                                    @endforeach
                                </div>
                                <span class="text-muted flex-grow-1">{{ formatNumber($likes) }}</span>

                                @if($comments > 0)
                                    <span class="text-muted">{{ formatNumber($comments) }} comments</span>
                                @endif

                                @if($shares > 0)
                                    <span class="text-muted">{{ formatNumber($shares) }} shares</span>
                                @endif
                            </div>

                            <!-- Like, Comment, Share -->
                            <div class="d-flex border-top pt-2">
                                <button
                                    class="btn btn-sm rounded-3 flex-fill d-flex align-items-center justify-content-center gap-1 hover-bg">
                                    <i class="bi bi-hand-thumbs-up fs-5"></i> Like
                                </button>
                                <button
                                    class="btn btn-sm rounded-3 flex-fill d-flex align-items-center justify-content-center gap-1 hover-bg">
                                    <i class="bi bi-chat fs-5"></i> Comment
                                </button>
                                <button
                                    class="btn btn-sm rounded-3 flex-fill d-flex align-items-center justify-content-center gap-1 hover-bg">
                                    <i class="bi bi-share fs-5"></i> Share
                                </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
</body>

</html>