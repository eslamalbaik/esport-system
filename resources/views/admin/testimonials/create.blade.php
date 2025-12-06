@extends('admin.layout')

@section('title', __('Add Testimonial'))

@section('content')
<div class="px-6 py-4 space-y-4">
  <div>
    <h1 class="text-xl font-semibold text-white">{{ __('Add Testimonial') }}</h1>
    <p class="text-sm text-gray-400">{{ __('Create a new testimonial for the home page.') }}</p>
  </div>

  <form action="{{ route('admin.testimonials.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
    @csrf
    @include('admin.testimonials._form', ['testimonial' => null])

    <div class="flex items-center gap-3">
      <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition">{{ __('Create') }}</button>
      <a href="{{ route('admin.testimonials.index') }}" class="px-4 py-2 bg-neutral-700 hover:bg-neutral-600 text-gray-200 rounded transition">{{ __('Cancel') }}</a>
    </div>
  </form>
</div>
@endsection
