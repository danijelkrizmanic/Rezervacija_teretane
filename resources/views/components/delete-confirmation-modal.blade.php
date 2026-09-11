@props([
    'id',
    'action',
    'title' => 'Delete item',
    'message' => 'This action cannot be undone.',
    'buttonLabel' => 'Delete',
    'triggerLabel' => 'Delete',
])

<button type="button" class="btn btn-ghost btn-xs text-error" onclick="document.getElementById('{{ $id }}').showModal()">
    {{ $triggerLabel }}
</button>

<dialog id="{{ $id }}" class="modal">
    <div class="modal-box max-w-md">
        <h3 class="text-lg font-bold">{{ $title }}</h3>
        <p class="py-4 text-sm text-base-content/70">{{ $message }}</p>
        <div class="modal-action">
            <form method="dialog">
                <button class="btn btn-ghost btn-sm">Cancel</button>
            </form>
            <form method="POST" action="{{ $action }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-error btn-sm">{{ $buttonLabel }}</button>
            </form>
        </div>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
