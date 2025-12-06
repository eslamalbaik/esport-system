<script>
let currentContentKey = null;
let currentContentType = null;

const COUNTDOWN_TARGET_KEY = 'home.countdown.target_datetime';
const OFFSET_PATTERN = /^[+-](0[0-9]|1[0-4]):[0-5][0-9]$/;

const textFieldsEl = document.getElementById('textFields');
const imageFieldsEl = document.getElementById('imageFields');
const datetimeFieldsEl = document.getElementById('datetimeFields');
const valueEnField = document.getElementById('valueEn');
const valueArField = document.getElementById('valueAr');
const datetimeInputEl = document.getElementById('valueDatetime');
const timezoneInputEl = document.getElementById('valueTimezone');
const isoPreviewEl = document.getElementById('valueIsoPreview');
const previewWrapperEl = document.getElementById('currentImagePreview');
const previewImageEl = document.getElementById('currentImage');
let previewVideoEl = null;
let previewIframeEl = null;

function getPreviewVideoEl() {
    if (previewVideoEl && document.body.contains(previewVideoEl)) {
        return previewVideoEl;
    }
    if (!previewWrapperEl) {
        return null;
    }
    previewVideoEl = document.createElement('video');
    previewVideoEl.id = 'currentVideo';
    previewVideoEl.controls = true;
    if (previewImageEl) {
        previewVideoEl.className = previewImageEl.className;
    } else {
        previewVideoEl.className = 'max-w-full h-auto max-h-48 rounded';
    }
    previewVideoEl.classList.add('hidden');
    previewWrapperEl.appendChild(previewVideoEl);
    return previewVideoEl;
}

function getPreviewIframeEl() {
    if (previewIframeEl && document.body.contains(previewIframeEl)) {
        return previewIframeEl;
    }
    if (!previewWrapperEl) {
        return null;
    }
    previewIframeEl = document.createElement('iframe');
    previewIframeEl.id = 'currentIframe';
    if (previewImageEl) {
        previewIframeEl.className = previewImageEl.className;
    } else {
        previewIframeEl.className = 'w-full h-auto max-h-48 rounded';
    }
    previewIframeEl.classList.add('hidden');
    previewIframeEl.setAttribute('frameborder', '0');
    previewIframeEl.setAttribute('allowfullscreen', 'true');
    previewWrapperEl.appendChild(previewIframeEl);
    return previewIframeEl;
}

function showMediaPreview(contentType, mediaUrl) {
    if (!previewWrapperEl) {
        return;
    }

    const videoEl = getPreviewVideoEl();
    const iframeEl = getPreviewIframeEl();

    if (mediaUrl) {
        previewWrapperEl.classList.remove('hidden');
        if (contentType === 'video') {
            if (previewImageEl) {
                previewImageEl.classList.add('hidden');
                previewImageEl.removeAttribute('src');
            }
            const isExternal = typeof mediaUrl === 'string' && /^https?:\/\//i.test(mediaUrl);
            const isYouTube = isExternal && /(youtube\.com|youtu\.be)/i.test(mediaUrl);
            const isVimeo = isExternal && /(vimeo\.com)/i.test(mediaUrl);

            if (iframeEl) {
                if (isYouTube || isVimeo) {
                    const embedUrl = (function (u) {
                        try {
                            const url = new URL(u);
                            if (/youtu\.be/i.test(url.hostname)) {
                                return `https://www.youtube.com/embed/${url.pathname.replace('/', '')}`;
                            }
                            if (/youtube\.com/i.test(url.hostname)) {
                                const id = url.searchParams.get('v');
                                if (id) {
                                    return `https://www.youtube.com/embed/${id}`;
                                }
                                if (url.pathname.includes('/embed/')) {
                                    return url.toString();
                                }
                            }
                            if (/vimeo\.com/i.test(url.hostname)) {
                                const segments = url.pathname.split('/').filter(Boolean);
                                const id = segments.pop();
                                if (id) {
                                    return `https://player.vimeo.com/video/${id}`;
                                }
                            }
                        } catch (e) {
                            // ignore parsing errors and fallback to provided URL
                        }
                        return u;
                    })(mediaUrl);
                    iframeEl.classList.remove('hidden');
                    iframeEl.src = embedUrl;
                } else {
                    iframeEl.classList.add('hidden');
                    iframeEl.removeAttribute('src');
                }
            }

            if (videoEl) {
                const looksLikeFile = !isYouTube && !isVimeo && /\.(mp4|webm|mov|ogg|mkv)(\?|#|$)/i.test(mediaUrl || '');
                if (looksLikeFile) {
                    videoEl.classList.remove('hidden');
                    videoEl.src = mediaUrl;
                    try {
                        videoEl.load();
                    } catch (e) {
                        console.warn('Unable to load video preview', e);
                    }
                } else {
                    videoEl.pause();
                    videoEl.classList.add('hidden');
                    videoEl.removeAttribute('src');
                    try {
                        videoEl.load();
                    } catch (e) {
                        // ignore
                    }
                }
            }
        } else {
            if (videoEl) {
                videoEl.pause();
                videoEl.classList.add('hidden');
                videoEl.removeAttribute('src');
                try {
                    videoEl.load();
                } catch (e) {
                    // ignore
                }
            }
            if (iframeEl) {
                iframeEl.classList.add('hidden');
                iframeEl.removeAttribute('src');
            }
            if (previewImageEl) {
                previewImageEl.classList.remove('hidden');
                previewImageEl.src = mediaUrl;
            }
        }
    } else {
        previewWrapperEl.classList.add('hidden');
        if (previewImageEl) {
            previewImageEl.classList.remove('hidden');
            previewImageEl.removeAttribute('src');
        }
        if (videoEl) {
            videoEl.pause();
            videoEl.classList.add('hidden');
            videoEl.removeAttribute('src');
            try {
                videoEl.load();
            } catch (e) {
                // ignore
            }
        }
        if (iframeEl) {
            iframeEl.classList.add('hidden');
            iframeEl.removeAttribute('src');
        }
    }
}

function isLikelyJson(value) {
    if (typeof value !== 'string') {
        return false;
    }
    const trimmed = value.trim();
    if (!trimmed) {
        return false;
    }
    if (trimmed.startsWith('{') && trimmed.endsWith('}')) {
        return true;
    }
    if (trimmed.startsWith('[') && trimmed.endsWith(']')) {
        return true;
    }
    return false;
}

function parseContentValue(rawValue, contentType, node) {
    if (rawValue === undefined || rawValue === null) {
        if (contentType === 'text') {
            const fallbackText = node?.textContent?.trim() ?? '';
            return fallbackText ? { en: fallbackText } : {};
        }
        return {};
    }

    if (typeof rawValue !== 'string') {
        return rawValue;
    }

    const trimmed = rawValue.trim();
    if (!trimmed || trimmed.toLowerCase() === 'null') {
        if (contentType === 'text') {
            const fallbackText = node?.textContent?.trim() ?? '';
            return fallbackText ? { en: fallbackText } : {};
        }
        return {};
    }

    if (isLikelyJson(trimmed)) {
        try {
            const parsed = JSON.parse(trimmed);

            if (contentType === 'text' && parsed && typeof parsed === 'object' && !Array.isArray(parsed)) {
                const hasNonEmptyValue = Object.values(parsed).some((value) => {
                    return typeof value === 'string' && value.trim().length > 0;
                });

                if (!hasNonEmptyValue) {
                    const fallbackText = node?.textContent?.trim() ?? '';
                    if (fallbackText) {
                        return {
                            ...parsed,
                            en: parsed.en || fallbackText,
                        };
                    }
                }
            }

            return parsed;
        } catch (error) {
            console.warn('Failed to parse JSON from data-content-value', {
                key: node?.dataset?.contentKey,
                error
            });
            return trimmed;
        }
    }

    return trimmed;
}

function deriveExpectedFilename(contentKey, payload, contentType) {
    if (!contentKey) {
        return '';
    }

    const media = payload && typeof payload === 'object' ? payload : {};
    let filename = media.filename || media.name || null;

    const extractFromPath = (value) => {
        if (!value || typeof value !== 'string') {
            return null;
        }
        const sanitized = value.split(/[?#]/)[0];
        const parts = sanitized.split('/');
        const finalPart = parts.pop() || '';
        return finalPart;
    };

    if (!filename) {
        filename = extractFromPath(media.path) || extractFromPath(media.url);
    }

    const extensionFromMime = (mime) => {
        if (!mime || typeof mime !== 'string') {
            return null;
        }
        const segments = mime.split('/');
        if (segments.length < 2) {
            return null;
        }
        return segments[1];
    };

    const sanitizeExtension = (ext, fallback) => {
        if (!ext || typeof ext !== 'string') {
            return fallback;
        }
        const clean = ext.split(/[?#]/)[0].replace(/[^a-z0-9]/gi, '').toLowerCase();
        return clean || fallback;
    };

    if (!filename) {
        let extension = media.extension || media.ext || extensionFromMime(media.mime);
        if (!extension) {
            const pathExt = extractFromPath(media.path)?.split('.').pop();
            extension = pathExt;
        }
        const fallbackExtension = contentType === 'video' ? 'mp4' : 'png';
        extension = sanitizeExtension(extension, fallbackExtension);
        filename = `${contentKey}.${extension}`;
    }

    return filename;
}

function normalizeTranslations(payload) {
    if (!payload) return {};
    if (typeof payload === 'string') {
        return { en: payload };
    }
    if (typeof payload === 'object') {
        return payload;
    }
    return {};
}

function normalizeImagePayload(payload) {
    if (payload && typeof payload === 'object') {
        return payload;
    }
    if (typeof payload === 'string') {
        return { path: payload };
    }
    return {};
}

function isoToDatetimeLocal(iso) {
    if (!iso) return '';
    const parsed = new Date(iso);
    if (Number.isNaN(parsed.getTime())) {
        return '';
    }
    const tzOffset = parsed.getTimezoneOffset();
    const local = new Date(parsed.getTime() - tzOffset * 60000);
    return local.toISOString().slice(0, 16);
}

function extractOffset(iso) {
    if (!iso || typeof iso !== 'string') {
        return '';
    }
    const match = iso.match(/([+-]\d{2}:\d{2}|Z)$/);
    if (!match) {
        return '';
    }
    return match[1] === 'Z' ? '+00:00' : match[1];
}

function formatOffsetFromMinutes(minutes) {
    if (!Number.isFinite(minutes)) {
        return '';
    }
    const sign = minutes >= 0 ? '+' : '-';
    const abs = Math.abs(minutes);
    const hours = String(Math.floor(abs / 60)).padStart(2, '0');
    const mins = String(abs % 60).padStart(2, '0');
    return `${sign}${hours}:${mins}`;
}

function deriveOffset(datetimeValue) {
    if (!datetimeValue) {
        return '';
    }
    const reference = new Date(datetimeValue);
    if (Number.isNaN(reference.getTime())) {
        return '';
    }
    return formatOffsetFromMinutes(-reference.getTimezoneOffset());
}

function updateIsoPreview(iso) {
    if (!isoPreviewEl) return;
    isoPreviewEl.textContent = iso && iso.trim() ? iso : '--';
}

function resetCountdownFields() {
    if (datetimeInputEl) {
        datetimeInputEl.value = '';
    }
    if (timezoneInputEl) {
        timezoneInputEl.value = '';
        timezoneInputEl.setCustomValidity('');
    }
    updateIsoPreview('--');
}

function getCountdownIso(requireValid = false) {
    if (!datetimeInputEl) {
        return requireValid ? null : '';
    }

    const datetimeValue = datetimeInputEl.value;
    if (!datetimeValue) {
        return requireValid ? null : '';
    }

    const parsed = new Date(datetimeValue);
    if (Number.isNaN(parsed.getTime())) {
        return requireValid ? null : '';
    }

    let offset = timezoneInputEl ? timezoneInputEl.value.trim() : '';
    if (offset) {
        if (!OFFSET_PATTERN.test(offset)) {
            return requireValid ? null : '';
        }
    } else {
        offset = deriveOffset(datetimeValue);
        if (offset && timezoneInputEl) {
            timezoneInputEl.value = offset;
        }
    }

    if (!offset || !OFFSET_PATTERN.test(offset)) {
        return requireValid ? null : '';
    }

    return `${datetimeValue}:00${offset}`;
}

function updateCountdownPreview() {
    if (currentContentKey !== COUNTDOWN_TARGET_KEY) {
        return;
    }

    const iso = getCountdownIso(false);
    updateIsoPreview(iso || '--');
    if (valueEnField) {
        valueEnField.value = iso || '';
    }
    if (valueArField) {
        valueArField.value = iso || '';
    }
}

function activateCountdownFields(initialIso, normalized) {
    if (!datetimeFieldsEl) {
        return;
    }

    datetimeFieldsEl.classList.remove('hidden');
    textFieldsEl?.classList.add('hidden');
    imageFieldsEl?.classList.add('hidden');

    const isoValue = typeof initialIso === 'string' ? initialIso : '';
    const localValue = isoToDatetimeLocal(isoValue);
    if (datetimeInputEl) {
        datetimeInputEl.value = localValue;
    }

    let offset = extractOffset(isoValue);
    if (!offset && localValue) {
        offset = deriveOffset(localValue);
    }

    if (timezoneInputEl) {
        timezoneInputEl.value = offset;
        timezoneInputEl.setCustomValidity('');
    }

    if (valueEnField) {
        valueEnField.value = isoValue;
    }
    if (valueArField) {
        const fallback = isoValue || '';
        valueArField.value = (normalized && normalized.ar) || fallback;
    }

    updateCountdownPreview();
}

function deactivateCountdownFields() {
    datetimeFieldsEl?.classList.add('hidden');
    textFieldsEl?.classList.remove('hidden');
    imageFieldsEl?.classList.add('hidden');
    resetCountdownFields();
}

if (datetimeInputEl) {
    datetimeInputEl.addEventListener('input', () => {
        if (currentContentKey !== COUNTDOWN_TARGET_KEY) {
            return;
        }

        if (timezoneInputEl && !timezoneInputEl.value) {
            const derived = deriveOffset(datetimeInputEl.value);
            if (derived) {
                timezoneInputEl.value = derived;
                timezoneInputEl.setCustomValidity('');
            }
        }

        updateCountdownPreview();
    });
}

if (timezoneInputEl) {
    timezoneInputEl.addEventListener('input', () => {
        if (currentContentKey !== COUNTDOWN_TARGET_KEY) {
            timezoneInputEl.setCustomValidity('');
            return;
        }

        const value = timezoneInputEl.value.trim();
        if (value && !OFFSET_PATTERN.test(value)) {
            timezoneInputEl.setCustomValidity('Offset must match ±HH:MM (maximum ±14:00).');
        } else {
            timezoneInputEl.setCustomValidity('');
        }

        updateCountdownPreview();
    });
}

// Open modal for editing content
function openModal(contentKey, contentType, currentValue, imageUrl = null) {
    currentContentKey = contentKey;
    currentContentType = contentType;
    
    // Set modal title and key
    document.getElementById('modalTitle').textContent = `Edit ${contentType} content`;
    document.getElementById('modalKey').textContent = contentKey;
    document.getElementById('contentType').textContent = contentType;
    
    // Clear previous error/success messages
    hideMessage();
    
    if (contentType === 'text') {
        imageFieldsEl?.classList.add('hidden');

        const normalized = normalizeTranslations(currentValue);
        const isoCandidate = normalized.en ?? normalized.default ?? normalized.ar ?? '';

        if (contentKey === COUNTDOWN_TARGET_KEY) {
            activateCountdownFields(isoCandidate, normalized);
        } else {
            deactivateCountdownFields();
            textFieldsEl?.classList.remove('hidden');
            if (valueEnField) {
                valueEnField.value = normalized.en || '';
            }
            if (valueArField) {
                valueArField.value = normalized.ar || '';
            }
        }
    } else if (contentType === 'image' || contentType === 'video') {
        deactivateCountdownFields();
        textFieldsEl?.classList.add('hidden');
        imageFieldsEl?.classList.remove('hidden');

        const mediaPayload = normalizeImagePayload(currentValue);
        const expectedName = deriveExpectedFilename(contentKey, mediaPayload, contentType);
        const expectedFilenameEl = document.getElementById('expectedFilename');
        if (expectedFilenameEl) {
            expectedFilenameEl.textContent = expectedName;
        }

        const fileInput = document.getElementById('imageFile');
        if (fileInput) {
            fileInput.value = '';
            fileInput.accept = contentType === 'video' ? 'video/*' : 'image/*';
        }
        const urlEl = document.getElementById('externalVideoUrl');
        if (urlEl) {
            urlEl.value = '';
        }

        const resolvedPreviewUrl = imageUrl
            || mediaPayload.url
            || mediaPayload.path
            || null;
        showMediaPreview(contentType, resolvedPreviewUrl);
    } else {
        deactivateCountdownFields();
        textFieldsEl?.classList.add('hidden');
        imageFieldsEl?.classList.add('hidden');
        showMediaPreview(contentType, null);
    }
    
    // Show modal
    document.getElementById('contentModal').classList.remove('hidden');
    document.getElementById('contentModal').classList.add('flex');
    
    // Focus first input
    setTimeout(() => {
        if (contentType === 'text') {
            if (contentKey === COUNTDOWN_TARGET_KEY) {
                datetimeInputEl?.focus();
            } else {
                valueEnField?.focus();
            }
        } else {
            document.getElementById('imageFile').focus();
        }
    }, 100);
}

// Close modal
function closeModal() {
    document.getElementById('contentModal').classList.add('hidden');
    document.getElementById('contentModal').classList.remove('flex');
    currentContentKey = null;
    currentContentType = null;
    deactivateCountdownFields();
}

// Save content via AJAX
async function saveContent() {
    if (!currentContentKey) return;
    
    const saveButton = document.getElementById('saveButton');
    const saveButtonText = document.getElementById('saveButtonText');
    const saveButtonSpinner = document.getElementById('saveButtonSpinner');
    
    // Show loading state
    saveButton.disabled = true;
    saveButtonText.textContent = 'Saving...';
    saveButtonSpinner.classList.remove('hidden');
    
    try {
        const formData = new FormData();
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        if (currentContentType === 'text') {
            if (currentContentKey === COUNTDOWN_TARGET_KEY) {
                const isoValue = getCountdownIso(true);
                if (!isoValue) {
                    showErrorMessage('Please provide a valid date, time, and timezone offset.');
                    const offsetValue = timezoneInputEl ? timezoneInputEl.value.trim() : '';
                    if (!datetimeInputEl?.value) {
                        datetimeInputEl?.focus();
                    } else if (timezoneInputEl && !OFFSET_PATTERN.test(offsetValue)) {
                        timezoneInputEl.setCustomValidity('Offset must match ±HH:MM (maximum ±14:00).');
                        timezoneInputEl.reportValidity();
                    }
                    return;
                }
                timezoneInputEl?.setCustomValidity('');
                formData.append('value[en]', isoValue);
                formData.append('value[ar]', isoValue);
            } else {
                formData.append('value[en]', valueEnField?.value ?? '');
                formData.append('value[ar]', valueArField?.value ?? '');
            }
        } else if (currentContentType === 'image' || currentContentType === 'video') {
            const fileInput = document.getElementById('imageFile');
            if (fileInput.files.length > 0) {
                formData.append('image', fileInput.files[0]);
            }
            const externalUrlEl = document.getElementById('externalVideoUrl');
            const rawUrl = externalUrlEl ? externalUrlEl.value.trim() : '';
            if (rawUrl) {
                formData.append('external_url', rawUrl);
            }
        }
        
        const response = await fetch(`/admin/contents/${currentContentKey}/ajax`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            showSuccessMessage(result.message);

            const updatedType = result.contentType || currentContentType;
            const updatedMediaUrl = result.mediaUrl || result.imageUrl || null;
            
            // Update the content in the skeleton view
            updateSkeletonContent(currentContentKey, result.content, updatedMediaUrl, updatedType);
            currentContentType = updatedType;
            const contentTypeBadge = document.getElementById('contentType');
            if (contentTypeBadge) {
                contentTypeBadge.textContent = updatedType;
            }
            
            // Close modal after short delay
            setTimeout(() => {
                closeModal();
            }, 1500);
        } else {
            showErrorMessage(result.message || 'An error occurred while saving');
        }
        
    } catch (error) {
        console.error('Error saving content:', error);
        showErrorMessage('Network error occurred. Please try again.');
    } finally {
        // Reset button state
        saveButton.disabled = false;
        saveButtonText.textContent = 'Save Changes';
        saveButtonSpinner.classList.add('hidden');
    }
}

// Update content in skeleton view
function updateSkeletonContent(key, content, imageUrl = null, specifiedType = null) {
    const contentElements = document.querySelectorAll(`[data-content-key="${key}"]`);
    
    const updateType = specifiedType || currentContentType;

    contentElements.forEach(element => {
        if (updateType) {
            element.setAttribute('data-content-type', updateType);
            element.dataset.contentType = updateType;
        }

        if (updateType === 'text') {
            const translations = normalizeTranslations(content);
            const currentLocale = document.documentElement.lang || 'en';
            const textValue = translations[currentLocale] ?? translations.en ?? translations.default ?? '';
            element.textContent = textValue;
            const serialised = JSON.stringify(translations);
            element.setAttribute('data-content-value', serialised);
            element.dataset.contentValue = serialised;
        } else if (updateType === 'image' || updateType === 'video') {
            const payload = normalizeImagePayload(content);
            const effectiveUrl = imageUrl || payload.url || payload.path || null;
            const serialised = JSON.stringify(payload);
            element.setAttribute('data-content-value', serialised);
            element.dataset.contentValue = serialised;
            if (effectiveUrl) {
                element.setAttribute('data-image-url', effectiveUrl);
                element.dataset.imageUrl = effectiveUrl;
            } else {
                element.removeAttribute('data-image-url');
                if (element.dataset) {
                    delete element.dataset.imageUrl;
                }
            }

            if (updateType === 'video') {
                if (element.tagName === 'VIDEO') {
                    element.src = effectiveUrl || element.src;
                    try {
                        element.load();
                    } catch (error) {
                        console.warn('Unable to reload video element', error);
                    }
                } else {
                    const video = element.querySelector('video');
                    if (video) {
                        video.src = effectiveUrl || video.src;
                        try {
                            video.load();
                        } catch (error) {
                            console.warn('Unable to reload nested video element', error);
                        }
                    }
                    if (!effectiveUrl) {
                        const img = element.tagName === 'IMG' ? element : element.querySelector('img');
                        if (img) {
                            img.removeAttribute('src');
                        }
                    }
                }
            } else if (effectiveUrl) {
                if (element.tagName === 'IMG') {
                    element.src = effectiveUrl;
                } else {
                    const img = element.querySelector('img');
                    if (img) {
                        img.src = effectiveUrl;
                    }
                }
            }
        }
        
        // Add visual feedback that content was updated
        element.classList.add('content-updated');
        setTimeout(() => {
            element.classList.remove('content-updated');
        }, 2000);
    });

    if (key === COUNTDOWN_TARGET_KEY && currentContentKey === COUNTDOWN_TARGET_KEY && updateType === 'text') {
        const translations = normalizeTranslations(content);
        const isoValue = translations.en ?? translations.default ?? translations.ar ?? '';
        activateCountdownFields(isoValue, translations);
    } else if ((updateType === 'image' || updateType === 'video') && key === currentContentKey) {
        const payload = normalizeImagePayload(content);
        const previewUrl = imageUrl || payload.url || payload.path || null;
        showMediaPreview(updateType, previewUrl);
    }
}

// Show error message
function showErrorMessage(message) {
    hideMessage();
    document.getElementById('errorMessage').textContent = message;
    document.getElementById('errorDisplay').classList.remove('hidden');
}

// Show success message
function showSuccessMessage(message) {
    hideMessage();
    document.getElementById('successMessage').textContent = message;
    document.getElementById('successDisplay').classList.remove('hidden');
}

// Hide all messages
function hideMessage() {
    document.getElementById('errorDisplay').classList.add('hidden');
    document.getElementById('successDisplay').classList.add('hidden');
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape' && !document.getElementById('contentModal').classList.contains('hidden')) {
        closeModal();
    }
});

// Close modal when clicking outside
document.getElementById('contentModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeModal();
    }
});

// Handle content node clicks
document.addEventListener('click', async function(event) {
    const contentNode = event.target.closest('[data-content-key]');
    if (!contentNode || contentNode.closest('#contentModal')) {
        return;
    }

    const key = contentNode.dataset.contentKey || contentNode.getAttribute('data-content-key');
    if (!key) {
        return;
    }

    event.preventDefault();

    const rawType = contentNode.dataset.contentType || contentNode.getAttribute('data-content-type') || 'text';
    const rawValue = contentNode.dataset.contentValue ?? contentNode.getAttribute('data-content-value');
    const rawImageUrl = contentNode.dataset.imageUrl ?? contentNode.getAttribute('data-image-url');

    let resolvedType = rawType;
    let resolvedValue = parseContentValue(rawValue, resolvedType, contentNode);
    let resolvedImageUrl = rawImageUrl || null;
    let resolvedMimeType = null;

    try {
        const response = await fetch(`/admin/contents/${encodeURIComponent(key)}/data`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            cache: 'no-store'
        });

        if (response.ok) {
            const data = await response.json();
            if (data && data.success) {
                resolvedType = data.type || resolvedType;

                if (data.content !== undefined) {
                    resolvedValue = data.content;
                }

                if (data.mediaUrl || data.imageUrl) {
                    resolvedImageUrl = data.mediaUrl || data.imageUrl || resolvedImageUrl;
                }

                if (data.mimeType) {
                    resolvedMimeType = data.mimeType;
                }
            } else {
                console.warn('Unexpected content response payload', data);
            }
        } else {
            console.warn(`Failed to fetch content data for ${key}: ${response.status}`);
        }
    } catch (error) {
        console.warn('Failed to fetch content data for', key, error);
    }

    if (resolvedType === 'image' || resolvedType === 'video') {
        const normalizedMedia = normalizeImagePayload(resolvedValue);
        if (resolvedMimeType) {
            normalizedMedia.mime = resolvedMimeType;
        }
        resolvedValue = normalizedMedia;
        if (!resolvedImageUrl) {
            resolvedImageUrl = normalizedMedia.url || normalizedMedia.path || resolvedImageUrl || null;
        }
    }

    openModal(key, resolvedType, resolvedValue, resolvedImageUrl);
});
</script>
