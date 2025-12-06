@extends('admin.layout')

@section('title', $pageTitle ?? __('Contents'))

@section('content')
<form class="flex flex-wrap gap-2 mb-4">
  <input type="text" name="q" value="{{ $q }}" placeholder="{{ __('Search key…') }}"
         class="border border-gray-700 bg-neutral-900 text-white placeholder-gray-400 px-2 py-1 rounded w-64">
  <select name="group" class="border border-gray-700 bg-neutral-900 text-white px-2 py-1 rounded">
    <option value="">{{ __('All groups') }}</option>
    @foreach($groups as $g)
      <option value="{{ $g }}" @selected($group===$g)>{{ $g }}</option>
    @endforeach
  </select>
  <select name="type" class="border border-gray-700 bg-neutral-900 text-white px-2 py-1 rounded">
    <option value="">{{ __('All types') }}</option>
    @foreach($types as $t)
      <option value="{{ $t }}" @selected($type===$t)>{{ $t }}</option>
    @endforeach
  </select>
  <button class="px-3 py-1 rounded bg-red-600 text-white hover:bg-red-700 transition">{{ __('Filter') }}</button>
</form>

<div class="overflow-x-auto rounded-lg border border-neutral-800">
  <table class="w-full text-sm">
    <thead class="bg-neutral-900">
      <tr class="text-left text-gray-300">
        <th class="p-2 border-b border-neutral-800">{{ __('Key') }}</th>
        <th class="p-2 border-b border-neutral-800">{{ __('Label') }}</th>
        <th class="p-2 border-b border-neutral-800">{{ __('Group') }}</th>
        <th class="p-2 border-b border-neutral-800">{{ __('Type') }}</th>
        <th class="p-2 border-b border-neutral-800">{{ __('Updated') }}</th>
        <th class="p-2 border-b border-neutral-800"></th>
      </tr>
    </thead>
    <tbody>
      @foreach($contents as $row)
        <tr class="bg-neutral-950 odd:bg-neutral-950 even:bg-neutral-900/60">
          <td class="p-2 border-b border-neutral-900 font-mono text-gray-100">{{ $row->key }}</td>
          <td class="p-2 border-b border-neutral-900 text-gray-200">{{ $registry[$row->key]['label'] ?? '' }}</td>
          <td class="p-2 border-b border-neutral-900 text-gray-300">{{ $row->group }}</td>
          <td class="p-2 border-b border-neutral-900">
            <span class="px-2 py-0.5 text-xs rounded bg-neutral-800 text-gray-200 border border-neutral-700">
              {{ $row->type }}
            </span>
          </td>
          <td class="p-2 border-b border-neutral-900 text-gray-400">{{ $row->updated_at?->diffForHumans() }}</td>
          <td class="p-2 border-b border-neutral-900">
            <a class="underline text-red-400 hover:text-red-300 transition" href="{{ route('admin.contents.edit',$row->key) }}">{{ __('Edit') }}</a>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-4">
  {{ $contents->onEachSide(1)->links() }}
</div>
@endsection
