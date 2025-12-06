@extends('admin.layout')

@section('title', __('Partners'))

@section('content')
<div class="px-6 py-4 space-y-4">
  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
    <div>
      <h1 class="text-xl font-semibold text-white">{{ __('Partners') }}</h1>
      <p class="text-sm text-gray-400">{{ __('Manage partner cards used on the home page slider and partners page.') }}</p>
    </div>
    <a href="{{ route('admin.partners.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition">
      <span class="text-lg leading-none">＋</span>
      <span>{{ __('Add Partner') }}</span>
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
          <th class="px-3 py-3 text-left">{{ __('Name (EN)') }}</th>
          <th class="px-3 py-3 text-left">{{ __('Type') }}</th>
          <th class="px-3 py-3 text-left">{{ __('Published') }}</th>
          <th class="px-3 py-3 text-right">{{ __('Actions') }}</th>
        </tr>
      </thead>
      <tbody id="partner-sortable-body" class="divide-y divide-neutral-800">
        @forelse($partners as $partner)
          <tr data-id="{{ $partner->id }}" class="bg-neutral-900/40">
            <td class="px-3 py-3">
              <input type="number" class="w-24 bg-neutral-800 text-gray-200 rounded px-2 py-1 partner-sort-input" value="{{ $partner->sort_order }}">
            </td>
            <td class="px-3 py-3 text-gray-200">{{ data_get($partner->name, 'en') ?: '—' }}</td>
            <td class="px-3 py-3 text-gray-400">{{ ucfirst($partner->media_type) }}</td>
            <td class="px-3 py-3">
              <span class="inline-flex items-center px-2 py-1 rounded text-xs {{ $partner->is_published ? 'bg-green-700/70 text-white' : 'bg-neutral-700 text-gray-300' }}">
                {{ $partner->is_published ? __('Yes') : __('No') }}
              </span>
            </td>
            <td class="px-3 py-3 text-right space-x-2">
              <a href="{{ route('admin.partners.edit', $partner->getKey()) }}" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded transition">{{ __('Edit') }}</a>
              <form action="{{ route('admin.partners.destroy', $partner->getKey()) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Delete this partner?') }}');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white rounded transition">{{ __('Delete') }}</button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="px-3 py-12 text-center text-gray-400">
              {{ __('No partners yet.') }} <a href="{{ route('admin.partners.create') }}" class="text-blue-400 hover:underline">{{ __('Create the first partner') }}</a>.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($partners->hasPages())
    <div>
      {{ $partners->links() }}
    </div>
  @endif

  @if($partners->count())
    <div class="flex justify-end">
      <button id="partner-save-order" type="button" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">
        {{ __('Save Order') }}
      </button>
    </div>
  @endif
</div>
@endsection

@push('scripts')
<script>
(function() {
  const saveButton = document.getElementById('partner-save-order');
  if (!saveButton) return;

  saveButton.addEventListener('click', async () => {
    const rows = Array.from(document.querySelectorAll('#partner-sortable-body tr[data-id]'));
    const orders = rows.map((row, index) => {
      const input = row.querySelector('.partner-sort-input');
      const fallback = index + 1;
      const sortValue = parseInt(input?.value ?? fallback, 10);
      return {
        id: Number(row.dataset.id),
        sort_order: Number.isNaN(sortValue) ? fallback : sortValue,
      };
    });

    try {
      const response = await fetch(@json(route('admin.partners.reorder')), {
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
})();
</script>
@endpush
