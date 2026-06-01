@props([
    'label',
    'name',
    'value' => null,
    'required' => false,
])

<label class="form-control w-full">
    <div class="label">
        <span class="label-text font-medium">{{ $label }}</span>
    </div>
    <input
        type="date"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->class(['input input-bordered w-full bg-base-100', 'input-error' => $errors->has($name)]) }}
    >
    @error($name)
        <div class="label">
            <span class="label-text-alt text-error">{{ $message }}</span>
        </div>
    @enderror
</label>
