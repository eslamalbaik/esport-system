<!-- Content Edit Modal -->
<div id="contentModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
  <div class="bg-neutral-900 rounded-lg border border-neutral-800 w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto">
    <!-- Modal Header -->
    <div class="flex items-center justify-between p-6 border-b border-neutral-800">
      <div>
        <h3 class="text-lg font-semibold text-white" id="modalTitle">{{ __('Edit Content') }}</h3>
        <p class="text-sm text-gray-400" id="modalKey">{{ __('content.key.here') }}</p>
      </div>
      <button onclick="closeModal()" class="text-gray-400 hover:text-white">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    </div>

    <!-- Modal Body -->
    <div class="p-6">
      <form id="contentForm" enctype="multipart/form-data">
        @csrf
        
        <!-- Content Type Display -->
        <div class="mb-4">
          <span class="inline-flex items-center px-2 py-1 text-xs rounded bg-neutral-800 text-gray-200 border border-neutral-700" id="contentType">
            {{ __('text') }}
          </span>
        </div>

        <!-- Text Content Fields -->
        <div id="textFields" class="space-y-4">
          <div>
            <label for="valueEn" class="block text-sm font-medium text-gray-300 mb-2">
              {{ __('English Content') }}
            </label>
            <textarea 
              id="valueEn" 
              name="value[en]" 
              rows="4" 
              class="w-full px-3 py-2 bg-neutral-800 border border-neutral-700 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
              placeholder="{{ __('Enter English content...') }}"></textarea>
          </div>
          
          <div>
            <label for="valueAr" class="block text-sm font-medium text-gray-300 mb-2">
              {{ __('Arabic Content (Optional)') }}
            </label>
            <textarea 
              id="valueAr" 
              name="value[ar]" 
              rows="4" 
              class="w-full px-3 py-2 bg-neutral-800 border border-neutral-700 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
              placeholder="{{ __('Enter Arabic content...') }}"
              dir="rtl"></textarea>
          </div>
        </div>

        <!-- Datetime Content Fields -->
        <div id="datetimeFields" class="space-y-4 hidden">
          <div>
            <label for="valueDatetime" class="block text-sm font-medium text-gray-300 mb-2">
              {{ __('Event Date & Time') }}
            </label>
            <input
              type="datetime-local"
              id="valueDatetime"
              class="w-full px-3 py-2 bg-neutral-800 border border-neutral-700 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
            >
            <p class="text-xs text-gray-500 mt-1">
              {{ __('Pick the desired date and time. It will be stored in ISO 8601 format for the countdown.') }}
            </p>
          </div>

          <div>
            <label for="valueTimezone" class="block text-sm font-medium text-gray-300 mb-2">
              {{ __('Timezone Offset') }}
            </label>
            <input
              type="text"
              id="valueTimezone"
              class="w-full px-3 py-2 bg-neutral-800 border border-neutral-700 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 font-mono"
              placeholder="+00:00"
              pattern="[+-](0[0-9]|1[0-4]):[0-5][0-9]"
              inputmode="text"
            >
            <p class="text-xs text-gray-500 mt-1">
              {!! __('Enter the offset in <code>±HH:MM</code> format (examples: <code>+00:00</code>, <code>+03:00</code>, <code>-05:30</code>).') !!}
            </p>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-300 mb-2">
              {{ __('ISO 8601 Preview') }}
            </label>
            <div class="bg-neutral-800 border border-neutral-700 rounded-md px-3 py-2">
              <code id="valueIsoPreview" class="text-sm text-green-400 font-mono break-all">--</code>
            </div>
          </div>
        </div>

        <!-- Image Content Fields -->
        <div id="imageFields" class="space-y-4 hidden">
          <!-- Expected Filename Display -->
          <div class="bg-neutral-800 border border-neutral-700 rounded-md p-3">
            <div class="flex items-center gap-2 mb-1">
              <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="text-sm font-medium text-blue-400">{{ __('Expected filename:') }}</span>
            </div>
            <code id="expectedFilename" class="text-sm text-green-400 bg-neutral-900 px-2 py-1 rounded font-mono">content.key.png</code>
            <p class="text-xs text-gray-500 mt-2">{{ __('Your uploaded image will be automatically renamed to match this filename for consistency.') }}</p>
          </div>
          
          <div>
            <label for="imageFile" class="block text-sm font-medium text-gray-300 mb-2">
              {{ __('Upload New Media') }}
            </label>
            <input 
              type="file" 
              id="imageFile" 
              name="image" 
              accept="image/*,video/*"
              class="w-full px-3 py-2 bg-neutral-800 border border-neutral-700 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
            <p class="text-xs text-gray-500 mt-1">
              {{ __('Accepted images: PNG, JPG, JPEG, WebP, GIF. Accepted videos: MP4, MOV, WebM, MKV, OGG.') }}
            </p>
          </div>

          <!-- OR: External video URL (YouTube/Vimeo/CDN) -->
          <div>
            <label for="externalVideoUrl" class="block text-sm font-medium text-gray-300 mb-2">
              {{ __('Or paste external video URL') }}
            </label>
            <input
              type="url"
              id="externalVideoUrl"
              name="external_url"
              placeholder="{{ __('https://youtu.be/xxxx or https://www.youtube.com/watch?v=xxxx or https://cdn.example.com/video.mp4') }}"
              class="w-full px-3 py-2 bg-neutral-800 border border-neutral-700 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
            <p class="text-xs text-gray-500 mt-1">
              {{ __('If provided, this URL will be saved as the media for this slot (no upload needed).') }}
            </p>
          </div>
          
          <!-- Current Media Preview -->
          <div id="currentImagePreview" class="hidden">
            <label class="block text-sm font-medium text-gray-300 mb-2">{{ __('Current Media') }}</label>
            <div class="border border-neutral-700 rounded-md p-4 bg-neutral-800">
              <img id="currentImage" src="" alt="{{ __('Current image') }}" class="max-w-full h-auto max-h-48 rounded">
            </div>
          </div>
        </div>

        <!-- Error Display -->
        <div id="errorDisplay" class="hidden mt-4 p-3 bg-red-900/20 border border-red-700 rounded-md">
          <p class="text-red-400 text-sm" id="errorMessage"></p>
        </div>

        <!-- Success Display -->
        <div id="successDisplay" class="hidden mt-4 p-3 bg-green-900/20 border border-green-700 rounded-md">
          <p class="text-green-400 text-sm" id="successMessage"></p>
        </div>
      </form>
    </div>

    <!-- Modal Footer -->
    <div class="flex items-center justify-end gap-3 p-6 border-t border-neutral-800">
      <button 
        onclick="closeModal()" 
        type="button"
        class="px-4 py-2 text-sm font-medium text-gray-300 bg-transparent border border-neutral-600 rounded-md hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-500">
        {{ __('Cancel') }}
      </button>
      <button 
        onclick="saveContent()" 
        type="button" 
        id="saveButton"
        class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
        <span id="saveButtonText">{{ __('Save Changes') }}</span>
        <svg id="saveButtonSpinner" class="hidden inline w-4 h-4 ml-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
        </svg>
      </button>
    </div>
  </div>
</div>
