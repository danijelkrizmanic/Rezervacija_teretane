@props([
    'label',
    'name',
    'placeholder' => 'Select an option',
    'required' => false,
])

<label class="form-control w-full">
    <div class="label">
        <span class="label-text font-medium">{{ $label }}</span>
    </div>
    <select
        name="{{ $name }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->class(['select select-bordered w-full bg-base-100', 'select-error' => $errors->has($name)]) }}
    >
        <option value="" disabled {{ old($name) ? '' : 'selected' }}>{{ $placeholder }}</option>
        {{ $slot }}
    </select>
    @error($name)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror
</label>
