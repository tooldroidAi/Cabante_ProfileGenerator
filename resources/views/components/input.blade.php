@props([
    'label',
    'name',
    'type' => 'text',
    'value' => '',
    'required' => false,
])

<div class="mb-3">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        class="form-control"
    >
</div>
