@props([
    'label',
    'name',
    'options' => [],
    'selected' => [],
])

<div class="mb-3">
    <label class="form-label d-block">{{ $label }}</label>
    @foreach($options as $option)
        <div class="form-check">
            <input
                class="form-check-input"
                type="checkbox"
                id="{{ $name }}_{{ \Illuminate\Support\Str::slug($option, '_') }}"
                name="{{ $name }}[]"
                value="{{ $option }}"
                @checked(in_array($option, old($name, $selected), true))
            >
            <label class="form-check-label" for="{{ $name }}_{{ \Illuminate\Support\Str::slug($option, '_') }}">
                {{ $option }}
            </label>
        </div>
    @endforeach
</div>
