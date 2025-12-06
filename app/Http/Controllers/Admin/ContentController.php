<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Partner;
use App\Models\Testimonial;
use App\Models\TournamentCard;
use App\Support\ContentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function dashboard()
    {
        // Get statistics
        $stats = [
            'total' => Content::count(),
            'text' => Content::where('type', 'text')->count(),
            'image' => Content::where('type', 'image')->count(),
            'video' => Content::where('type', 'video')->count(),
        ];
        
        // Get recent edits (last 10 updated items)
        $recentEdits = Content::orderBy('updated_at', 'desc')
                             ->limit(10)
                             ->get();
        
        $skeletonPages = collect(File::files(resource_path('views/admin/skeletons')))
            ->filter(fn($file) => Str::endsWith($file->getFilename(), '.blade.php'))
            ->map(function ($file) {
                return Str::before($file->getFilename(), '.blade.php');
            })
            ->sort()
            ->values();
        
        return view('admin.dashboard', compact('stats', 'recentEdits', 'skeletonPages'));
    }
    
    public function page(string $group)
    {
        // Get contents for specific page/group
        $contents = Content::where('group', $group)
                          ->orderBy('key')
                          ->paginate(20);
        
        // Get all available groups and types for filter dropdowns
        $groups = Content::select('group')->distinct()->orderBy('group')->pluck('group');
        $types = Content::select('type')->distinct()->orderBy('type')->pluck('type');
        
        // Set current filter values
        $q = '';
        $currentGroup = $group;
        $type = '';
        $registry = [];
        
        return view('admin.contents.index', [
            'contents' => $contents,
            'groups' => $groups,
            'types' => $types,
            'q' => $q,
            'group' => $currentGroup,
            'type' => $type,
            'registry' => $registry,
            'pageTitle' => ucfirst($group) . ' Content'
        ]);
    }
    
    public function skeleton(string $group)
    {
        // Get all contents for this page/group indexed by key
        $contents = Content::where('group', $group)
                          ->get()
                          ->keyBy('key');
        
        // Check if skeleton view exists for this page
        $skeletonView = "admin.skeletons.{$group}";
        if (!view()->exists($skeletonView)) {
            return redirect()->route('admin.dashboard')
                           ->with('status', __('Skeleton view not available for this page yet.'));
        }
        
        $extra = [];

        if ($group === 'tournaments') {
            $extra['cards'] = TournamentCard::ordered()->get();
        }
        if ($group === 'home') {
            $extra['testimonials'] = Testimonial::ordered()->get();
            $extra['partners'] = Partner::ordered()->get();
        }
        if ($group === 'partners') {
            $extra['partners'] = Partner::ordered()->get();
        }
        
        return view($skeletonView, array_merge([
            'contents' => $contents,
            'pageGroup' => $group,
        ], $extra));
    }
    public function index(Request $request)
    {
        // Get filter parameters from request
        $q = $request->get('q', '');
        $group = $request->get('group', '');
        $type = $request->get('type', '');
        
        // Build the query with filters
        $query = Content::query();
        
        // Apply search filter (search in key and content values)
        if (!empty($q)) {
            $query->where(function($subQuery) use ($q) {
                $subQuery->where('key', 'LIKE', '%' . $q . '%')
                        ->orWhere('value', 'LIKE', '%' . $q . '%');
            });
        }
        
        // Apply group filter
        if (!empty($group)) {
            $query->where('group', $group);
        }
        
        // Apply type filter
        if (!empty($type)) {
            $query->where('type', $type);
        }
        
        // Get filtered contents with pagination
        $contents = $query->orderBy('key')->paginate(20)->withQueryString();
        
        // Get all available groups and types for dropdown options
        $groups = Content::select('group')->distinct()->orderBy('group')->pluck('group');
        $types = Content::select('type')->distinct()->orderBy('type')->pluck('type');
        
        $registry = [];
        
        return view('admin.contents.index', compact('contents','groups','types','q','group','type','registry'));
    }
    public function edit(string $key)
    {
        $content = $this->findOrCreateContent($key);
        $meta = null;
        return view('admin.contents.edit', compact('content','meta'));
    }
    public function update(Request $request, string $key)
    {
        $content = $this->findOrCreateContent($key);
        
        // Handle text content updates
        if ($content->type === 'text') {
            $request->validate([
                'value.en' => 'required|string',
                'value.ar' => 'nullable|string',
            ]);
            
            $value = [];
            $value['en'] = $request->input('value.en');
            if ($request->filled('value.ar')) {
                $value['ar'] = $request->input('value.ar');
            }
            
            $content->value = $value;
            $content->save();
            
            // Clear cache for text content (all locales we have values for)
            $locales = array_keys($content->getTranslations('value') ?? []);
            ContentRepository::forgetText($key, $locales);
        }
        
        // Handle media content updates (form submit)
        if ($request->hasFile('image')) {
            // Validate based on detected mime kind (guard if invalid upload)
            $probeFile = $request->file('image');
            $mime = ($probeFile instanceof UploadedFile && $probeFile->isValid()) ? ($probeFile->getMimeType() ?? '') : '';
            if (is_string($mime) && str_starts_with($mime, 'video/')) {
                $request->validate([
                    'image' => 'required|file|mimetypes:video/mp4,video/quicktime,video/webm,video/x-matroska,video/ogg|max:102400'
                ]);
            } else {
                $request->validate([
                    'image' => 'required|image|mimes:png,jpg,jpeg,webp,gif|max:15360'
                ]);
            }
        }

        if ($this->hasAnyUpload($request)) {
            $this->processMediaUpload($request, $content);
        }
        
        return back()->with('status', __('Content updated successfully!'));
    }
    
    public function updateAjax(Request $request, string $key)
    {
        try {
            // Determine content type from request if creating new content
            $isNewContent = !Content::where('key', $key)->exists();
            $requestType = $this->determineContentTypeFromRequest($request);
            
            $content = $this->findOrCreateContent($key, $requestType);
            
            // Handle text content updates
            if ($content->type === 'text') {
                $request->validate([
                    'value.en' => 'required|string',
                    'value.ar' => 'nullable|string',
                ]);
                
                $value = [];
                $value['en'] = $request->input('value.en');
                if ($request->filled('value.ar')) {
                    $value['ar'] = $request->input('value.ar');
                }
                
                $content->value = $value;
                $content->save();
                
                // Clear cache for text content
                $locales = array_keys($content->getTranslations('value') ?? []);
                ContentRepository::forgetText($key, $locales);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Content updated successfully',
                    'content' => $content->getTranslations('value')
                ]);
            }
            
            // Handle image content updates
            // External URL for media (YouTube/Vimeo/CDN) → save as video, skip upload
            if ($request->filled('external_url')) {
                $url = trim((string) $request->input('external_url'));
                if (!preg_match('~^https?://~i', $url)) {
                    return response()->json([
                        'success' => false,
                        'message' => 'External URL must start with http(s)://'
                    ], 422);
                }

                $content->type = 'video';
                $content->value = [
                    'path' => $url,
                    'mime' => 'video/external',
                    'size' => null,
                ];
                $content->save();
                ContentRepository::forgetMedia($key);

                $normalizedValue = $this->normalizeMediaValue($content->value);

                return response()->json([
                    'success' => true,
                    'message' => 'Video URL saved successfully',
                    'content' => $normalizedValue,
                    'mediaUrl' => ContentRepository::media($key),
                    'contentType' => 'video',
                    'mimeType' => $normalizedValue['mime'] ?? null,
                ]);
            }

            if ($this->hasAnyUpload($request)) {
                $media = $this->processMediaUpload($request, $content);
                $normalizedValue = $this->normalizeMediaValue($content->value);
                
                return response()->json([
                    'success' => true,
                    'message' => ucfirst($media['type']) . ' updated successfully',
                    'content' => $normalizedValue,
                    'mediaUrl' => $media['url'],
                    'contentType' => $media['type'],
                    'mimeType' => $media['mime'],
                ]);
            }
            
            return response()->json([
                'success' => false,
                'message' => 'No valid data provided. Content type: ' . $content->type . ', Has file: ' . ($request->hasFile('image') ? 'yes' : 'no')
            ], 400);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            \Log::error('AJAX Update Error: ' . $e->getMessage(), [
                'key' => $key,
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Return raw content data for skeleton editors.
     */
    public function showData(string $key)
    {
        $content = Content::where('key', $key)->firstOrFail();

        $base = [
            'success' => true,
            'key' => $content->key,
            'type' => $content->type,
            'updated_at' => optional($content->updated_at)->toIso8601String(),
        ];

        if ($content->type === 'text') {
            $translations = $content->getTranslations('value') ?? [];

            return response()->json($base + [
                'content' => $translations,
                'locales' => array_keys($translations),
            ]);
        }

        if (in_array($content->type, ['image', 'video'])) {
            $value = $this->normalizeMediaValue($content->value);
            return response()->json($base + [
                'content' => $value,
                'mediaUrl' => ContentRepository::image($key),
                'mimeType' => $value['mime'] ?? null,
            ]);
        }

        return response()->json($base + [
            'content' => $content->value,
        ]);
    }
    
    /**
     * Determine content type from request data
     */
    private function determineContentTypeFromRequest($request)
    {
        $file = $this->extractUploadedFile($request);
        if ($file instanceof UploadedFile) {
            $mimeType = $file?->getMimeType() ?? '';
            if (is_string($mimeType) && str_starts_with($mimeType, 'video/')) {
                return 'video';
            }
            return 'image';
        }
        if ($request->has('value')) {
            return 'text';
        }
        return null; // Let findOrCreateContent determine from key
    }

    /**
     * Determine if request carries any uploaded file (not just under name 'image').
     */
    private function hasAnyUpload(Request $request): bool
    {
        $file = $request->file('image');
        if ($file instanceof UploadedFile && $file->isValid()) {
            return true;
        }
        foreach ($request->files->all() as $item) {
            if ($item instanceof UploadedFile && $item->isValid()) {
                return true;
            }
            if (is_array($item)) {
                foreach ($item as $sub) {
                    if ($sub instanceof UploadedFile && $sub->isValid()) return true;
                }
            }
        }
        return false;
    }

    /**
     * Get the uploaded file from request, trying common field names and any-first fallback.
     */
    private function extractUploadedFile(Request $request): ?UploadedFile
    {
        $file = $request->file('image');
        if ($file instanceof UploadedFile) {
            return $file->isValid() ? $file : null;
        }
        foreach ($request->files->all() as $item) {
            if ($item instanceof UploadedFile) {
                return $item->isValid() ? $item : null;
            }
            if (is_array($item)) {
                foreach ($item as $sub) {
                    if ($sub instanceof UploadedFile) {
                        return $sub->isValid() ? $sub : null;
                    }
                }
            }
        }
        return null;
    }
    
    /**
     * Find existing content or create new content record with intelligent defaults
     */
    private function findOrCreateContent(string $key, string $forceType = null)
    {
        $content = Content::where('key', $key)->first();
        
        if (!$content) {
            // Parse the key to determine group and type
            $keyParts = explode('.', $key);
            $group = $keyParts[0] ?? 'general';
            
            // Determine content type based on force type or key patterns
            $type = $forceType ?? 'text'; // default
            if (!$forceType) {
                if (str_contains($key, '.video') ||
                    str_ends_with($key, '_video')) {
                    $type = 'video';
                } elseif (str_contains($key, '.image') || 
                    str_contains($key, '.icon') || 
                    str_contains($key, '.avatar') || 
                    str_contains($key, '.badge') || 
                    str_contains($key, '.logo') ||
                    str_ends_with($key, '_image') ||
                    str_ends_with($key, '_icon')) {
                    $type = 'image';
                }
            }
            
            // Create default values
            if ($type === 'text') {
                $defaultValue = [
                    'en' => ucwords(str_replace(['.', '_', '-'], ' ', $key)),
                    'ar' => ''
                ];
            } elseif ($type === 'image') {
                $defaultValue = [
                    'path' => 'placeholder.png',
                    'mime' => 'image/png',
                ];
            } else {
                $defaultValue = [
                    'path' => 'placeholder.mp4',
                    'mime' => 'video/mp4',
                ];
            }
            
            // Create the content record
            $content = Content::create([
                'key' => $key,
                'type' => $type,
                'group' => $group,
                'value' => $defaultValue
            ]);
            
            \Log::info('Auto-created missing content', [
                'key' => $key,
                'type' => $type,
                'group' => $group
            ]);
        }
        
        return $content;
    }
    
    /**
     * Handle AJAX content updates (simplified version for skeleton editors)
     */
    public function updateContentAjax(Request $request)
    {
        try {
            $key = $request->input('key');
            $value = $request->input('value');
            
            if (!$key || !$value) {
                return response()->json([
                    'success' => false,
                    'message' => 'Key and value are required'
                ], 400);
            }
            
            $content = $this->findOrCreateContent($key);
            
            if ($content->type === 'text') {
                // For AJAX updates from skeleton editors, treat as English content
                $currentValue = $content->value ?: [];
                $currentValue['en'] = $value;
                if (!isset($currentValue['ar'])) {
                    $currentValue['ar'] = '';
                }
                
                $content->value = $currentValue;
                $content->save();
                
                // Clear cache
                $locales = array_keys($content->getTranslations('value') ?? []);
                ContentRepository::forgetText($key, $locales);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Content updated successfully'
            ]);
            
        } catch (\Exception $e) {
            \Log::error('AJAX Content Update Error: ' . $e->getMessage(), [
                'key' => $request->input('key'),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Handle batch content updates from skeleton editors
     */
    public function batchUpdate(Request $request)
    {
        try {
            $updates = $request->input('updates', []);
            
            if (empty($updates)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No updates provided'
                ], 400);
            }
            
            $updatedCount = 0;
            
            foreach ($updates as $update) {
                if (!isset($update['key']) || !isset($update['value'])) {
                    continue;
                }
                
                $key = $update['key'];
                $value = $update['value'];
                
                $content = $this->findOrCreateContent($key);
                
                if ($content->type === 'text') {
                    $currentValue = $content->value ?: [];
                    $currentValue['en'] = $value;
                    if (!isset($currentValue['ar'])) {
                        $currentValue['ar'] = '';
                    }
                    
                    $content->value = $currentValue;
                    $content->save();
                    
                    // Clear cache
                    $locales = array_keys($content->getTranslations('value') ?? []);
                    ContentRepository::forgetText($key, $locales);
                    $updatedCount++;
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => "Successfully updated {$updatedCount} content items",
                'updated_count' => $updatedCount
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Batch Update Error: ' . $e->getMessage(), [
                'updates' => $request->input('updates'),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Process an uploaded image or video file for a content record.
     *
     * @return array{filename:string,url:string,type:string,mime:?string,size:int}
     */
    private function processMediaUpload(Request $request, Content $content): array
    {
        $file = $this->extractUploadedFile($request);

        if (! $file) {
            throw new \RuntimeException('No media file provided for upload.');
        }

        if (! $file->isValid()) {
            $error = $file->getError();
            $message = match ($error) {
                \UPLOAD_ERR_INI_SIZE, \UPLOAD_ERR_FORM_SIZE => 'File too large (server or form limit exceeded).',
                \UPLOAD_ERR_PARTIAL => 'The file was only partially uploaded.',
                \UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                \UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder on server.',
                \UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                \UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                default => 'Upload failed due to an unknown error.',
            };
            throw new \RuntimeException($message);
        }

        $mimeType = $file->getMimeType() ?? '';
        $isVideo = is_string($mimeType) && str_starts_with($mimeType, 'video/');

        $validationRules = $isVideo
            ? ['image' => 'required|file|mimetypes:video/mp4,video/quicktime,video/webm,video/x-matroska,video/ogg|max:102400']
            : ['image' => 'required|image|mimes:png,jpg,jpeg,webp,gif|max:15360'];

        $request->validate($validationRules);

        $extension = strtolower($file->getClientOriginalExtension() ?: '');

        if ($isVideo) {
            $extension = $extension ?: match ($mimeType) {
                'video/quicktime' => 'mov',
                'video/webm' => 'webm',
                'video/ogg' => 'ogg',
                'video/x-matroska' => 'mkv',
                default => 'mp4',
            };
        } else {
            $allowedImageExtensions = ['png', 'jpg', 'jpeg', 'webp', 'gif'];
            if (! in_array($extension, $allowedImageExtensions, true)) {
                $extension = 'png';
            }
        }

        $filename = "{$content->key}.{$extension}";
        $uploadsPath = public_path('content-images');

        if (! is_dir($uploadsPath)) {
            mkdir($uploadsPath, 0755, true);
        }

        // Capture size before moving (tmp file may be removed after move)
        $originalSize = $file->getSize();
        $existingValue = $this->normalizeMediaValue($content->value);
        $previousFilename = $existingValue['path'] ?? null;
        $file->move($uploadsPath, $filename);

        if ($previousFilename && $previousFilename !== $filename) {
            $previousPath = $uploadsPath . DIRECTORY_SEPARATOR . $previousFilename;
            if (is_file($previousPath)) {
                @unlink($previousPath);
            }
        }

        $content->type = $isVideo ? 'video' : 'image';
        $movedPath = $uploadsPath . DIRECTORY_SEPARATOR . $filename;
        $calculatedSize = $originalSize;
        if ($calculatedSize === null && is_file($movedPath)) {
            // Fallback to filesize on the moved path if needed
            $calculatedSize = @filesize($movedPath) ?: null;
        }

        $content->value = [
            'path' => $filename,
            'mime' => $mimeType,
            'size' => $calculatedSize,
        ];
        $content->save();

        ContentRepository::forgetMedia($content->key);
        $mediaUrl = ContentRepository::media($content->key);

        return [
            'filename' => $filename,
            'url' => $mediaUrl,
            'type' => $content->type,
            'mime' => $mimeType,
            'size' => $calculatedSize,
        ];
    }

    private function normalizeMediaValue($value): array
    {
        if (is_array($value)) {
            return $value;
        }
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
            if (preg_match('~^https?://~i', $value)) {
                return [
                    'path' => $value,
                    'mime' => 'video/external',
                    'size' => null,
                ];
            }
            return ['path' => $value];
        }
        if ($value instanceof \JsonSerializable) {
            $serialized = $value->jsonSerialize();
            return is_array($serialized) ? $serialized : [];
        }
        return [];
    }
}
