@extends('admin.layout')

@section('title', __('Account Settings'))

@section('content')
<div class="max-w-3xl space-y-6">
  <div class="bg-neutral-900/50 border border-neutral-800 rounded-lg shadow">
    <div class="px-6 py-4 border-b border-neutral-800">
      <h2 class="text-lg font-semibold text-white">{{ __('Update Login Email') }}</h2>
      <p class="text-sm text-gray-400">{{ __('Keep your contact email current to make sure you can always sign in.') }}</p>
    </div>
    <form method="POST" action="{{ route('admin.account.email.update') }}" class="px-6 py-6 space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label for="email" class="block text-sm font-medium text-gray-300">{{ __('Email address') }}</label>
        <input
          id="email"
          name="email"
          type="email"
          autocomplete="email"
          required
          value="{{ old('email', $user->email) }}"
          class="mt-2 w-full rounded-md border border-neutral-700 bg-neutral-800 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
        />
        @error('email', 'updateEmail')
          <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
      </div>

      <div>
        <label for="email_current_password" class="block text-sm font-medium text-gray-300">{{ __('Current password') }}</label>
        <input
          id="email_current_password"
          name="current_password"
          type="password"
          autocomplete="current-password"
          required
          class="mt-2 w-full rounded-md border border-neutral-700 bg-neutral-800 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
        />
        @error('current_password', 'updateEmail')
          <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end">
        <button
          type="submit"
          class="inline-flex items-center gap-2 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition"
        >
          {{ __('Update Email') }}
        </button>
      </div>
    </form>
  </div>

  <div class="bg-neutral-900/50 border border-neutral-800 rounded-lg shadow">
    <div class="px-6 py-4 border-b border-neutral-800">
      <h2 class="text-lg font-semibold text-white">{{ __('Update Username') }}</h2>
      <p class="text-sm text-gray-400">{{ __('Change how your name appears across the admin dashboard.') }}</p>
    </div>
    <form method="POST" action="{{ route('admin.account.username.update') }}" class="px-6 py-6 space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label for="name" class="block text-sm font-medium text-gray-300">{{ __('Display name') }}</label>
        <input
          id="name"
          name="name"
          type="text"
          required
          value="{{ old('name', $user->name) }}"
          class="mt-2 w-full rounded-md border border-neutral-700 bg-neutral-800 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
        />
        @error('name', 'updateUsername')
          <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
      </div>
      <div class="flex justify-end">
        <button
          type="submit"
          class="inline-flex items-center gap-2 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition"
        >
          {{ __('Save changes') }}
        </button>
      </div>
    </form>
  </div>

  <div class="bg-neutral-900/50 border border-neutral-800 rounded-lg shadow">
    <div class="px-6 py-4 border-b border-neutral-800">
      <h2 class="text-lg font-semibold text-white">{{ __('Update Password') }}</h2>
      <p class="text-sm text-gray-400">{{ __('Use a strong password that you have not used elsewhere.') }}</p>
    </div>
    <form method="POST" action="{{ route('admin.account.password.update') }}" class="px-6 py-6 space-y-4">
      @csrf
      @method('PUT')
      <div>
        <label for="current_password" class="block text-sm font-medium text-gray-300">{{ __('Current password') }}</label>
        <input
          id="current_password"
          name="current_password"
          type="password"
          autocomplete="current-password"
          required
          class="mt-2 w-full rounded-md border border-neutral-700 bg-neutral-800 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
        />
        @error('current_password', 'updatePassword')
          <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
        @enderror
      </div>

      <div class="grid gap-4 md:grid-cols-2">
        <div>
          <label for="password" class="block text-sm font-medium text-gray-300">{{ __('New password') }}</label>
          <input
            id="password"
            name="password"
            type="password"
            autocomplete="new-password"
            required
            class="mt-2 w-full rounded-md border border-neutral-700 bg-neutral-800 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
          />
          @error('password', 'updatePassword')
            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="password_confirmation" class="block text-sm font-medium text-gray-300">{{ __('Confirm new password') }}</label>
          <input
            id="password_confirmation"
            name="password_confirmation"
            type="password"
            autocomplete="new-password"
            required
            class="mt-2 w-full rounded-md border border-neutral-700 bg-neutral-800 text-white px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
          />
        </div>
      </div>

      <div class="flex justify-end">
        <button
          type="submit"
          class="inline-flex items-center gap-2 rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-700 transition"
        >
          {{ __('Update Password') }}
        </button>
      </div>

      @if($errors->updatePassword->any())
        <p class="text-xs text-gray-400">
          {{ __('Make sure your new password meets the minimum requirements and matches the confirmation field.') }}
        </p>
      @endif
    </form>
  </div>
</div>
@endsection
