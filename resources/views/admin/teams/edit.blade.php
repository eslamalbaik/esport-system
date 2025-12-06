@extends('admin.layout')

@section('title', __('Edit Team Member'))

@section('content')
<div class="px-6 py-4 space-y-4">
  <div>
    <h1 class="text-xl font-semibold text-white">{{ __('Edit Team') }}</h1>
    <p class="text-sm text-gray-400">{{ __('Update profile information for the selected team member.') }}</p>
  </div>

  <form action="{{ route('admin.teams.update', $team) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @method('PUT')

    @include('admin.teams._form', ['team' => $team, 'defaultSortOrder' => $defaultSortOrder ?? $team->sort_order])

    <div class="flex items-center gap-3">
      <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition">{{ __('Save Changes') }}</button>
      <a href="{{ route('admin.teams.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('Cancel') }}</a>
    </div>
  </form>
</div>
@endsection
