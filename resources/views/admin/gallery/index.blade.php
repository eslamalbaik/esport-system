@extends('admin.layout')

@section('title', __('Gallery Items'))

@section('content')
<div class="space-y-5">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <h2 class="text-xl font-semibold text-white">{{ __('Gallery Items') }}</h2>
      <p class="text-sm text-gray-400">{{ __('Manage the media displayed on the public gallery page.') }}</p>
    </div>
    <a
      href="{{ route('admin.gallery-items.create') }}"
      class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition"
    >
      <span class="text-lg leading-none">＋</span>
      <span>{{ __('Add Gallery Item') }}</span>
    </a>
  </div>

  @if(session('ok'))
    <div class="px-4 py-3 bg-green-900/30 border border-green-700 text-green-200 rounded">
      {{ session('ok') }}
    </div>
  @endif

  <div class="overflow-hidden rounded border border-neutral-800">
    <table class="min-w-full divide-y divide-neutral-800 text-sm">
      <thead class="bg-neutral-900 text-gray-300 uppercase tracking-wide text-xs">
        <tr>
          <th class="px-3 py-3 text-left">{{ __('Order') }}</th>
          <th class="px-3 py-3 text-left">{{ __('Title (EN)') }}</th>
          <th class="px-3 py-3 text-left">{{ __('Source') }}</th>
          <th class="px-3 py-3 text-left">{{ __('Published') }}</th>
          <th class="px-3 py-3 text-right">{{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody id="gallery-sortable" class="divide-y divide-neutral-800">
        @forelse($items as $item)
          <tr data-id="{{ $item->id }}" class="bg-neutral-900/40">
            <td class="px-3 py-3">
              <input
                type="number"
                class="w-24 bg-neutral-800 text-gray-200 rounded px-2 py-1 sort-input"
                value="{{ $item->sort_order }}"
              >
            </td>
            <td class="px-3 py-3 text-gray-200">{{ $item->title['en'] ?? '' }}</td>
            <td class="px-3 py-3 text-gray-400">{{ $item->sourceLabel() }}</td>
            <td class="px-3 py-3">
              <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $item->is_published ? 'bg-green-700/70 text-white' : 'bg-neutral-700 text-gray-300' }}">
                {{ $item->is_published ? __('Yes') : __('No') }}
              </span>
            </td>
            <td class="px-3 py-3 text-right space-x-2">
              <a
                href="{{ route('admin.gallery-items.edit', $item) }}"
                class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded transition"
              >
                {{ __('Edit') }}
              </a>
              <form
                action="{{ route('admin.gallery-items.destroy', $item) }}"
                method="POST"
                class="inline"
                onsubmit="return confirm('{{ __('Delete this gallery item?') }}');"
              >
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded transition">
                  {{ __('Delete') }}
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-3 py-12 text-center text-gray-400">
              {{ __('No gallery items yet.') }}
              <a href="{{ route('admin.gallery-items.create') }}" class="text-blue-400 hover:underline">{{ __('Create the first item') }}</a>.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($items->count())
    <div class="flex justify-end">
      <button
        id="save-order"
        type="button"
        class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition"
      >
        {{ __('Save Order') }}
      </button>
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
document.getElementById('save-order')?.addEventListener('click', async () => {
  const rows = Array.from(document.querySelectorAll('#gallery-sortable tr[data-id]'));
  const orders = rows.map((row, index) => {
    const input = row.querySelector('.sort-input');
    const fallback = index + 1;
    const sortOrder = parseInt((input && input.value) ? input.value : fallback, 10);
    return {
      id: Number(row.dataset.id),
      sort_order: Number.isNaN(sortOrder) ? fallback : sortOrder,
    };
  });

  try {
    const response = await fetch(@json(route('admin.gallery-items.reorder')), {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': @json(csrf_token()),
      },
      body: JSON.stringify({ orders }),
    });

    if (!response.ok) {
      throw new Error(@json(__('Failed to save order.')));
    }

    window.location.reload();
  } catch (error) {
    alert(@json(__('Unable to save order. Please try again.')));
    console.error(error);
  }
});
</script>
@endpush
