# CMS Conventions

## Overview

This is a Laravel bilingual content management system using Blade templates with session-based locale switching between English and Arabic. Content is stored in a central `contents` table, with images stored in a public folder for direct web server access. The system provides `content()` and `content_media()` helper functions for reading localized text and shared images, with a caching layer that includes explicit cache busting on content updates.

## Key Naming Convention

**Format:** `page.section.item`

**Examples:**
- `home.hero.title`
- `home.hero.subtitle` 
- `about.header.title`
- `about.team.description`
- `partners.banner.image`

**Rules:**
- Always lowercase
- Use dots as separators between segments
- Keys must remain stable even when copy/content changes
- Keys should be descriptive and follow logical page hierarchy

## Content Types

**Text Content:**
- Stored as JSON: `{"en": "English text", "ar": "Arabic text"}`
- English (EN) is required for all text keys
- Arabic (AR) is optional
- English serves as fallback when Arabic is missing
- Read operations fall back: current locale → EN → default parameter

**Image Content:**
- Stored as JSON: `{"path": "key.extension"}`
- Filename format: `<key>.<ext>` (e.g., `home.hero.png`)
- Images are shared across locales (language-agnostic)
- Allowed extensions: `png`, `jpg`, `jpeg`, `webp`
- Recommended dimensions for common types:
  - Hero images: 1600×900px
  - Banner images: 1200×400px
  - Card images: 400×300px
  - Profile images: 300×300px

## Storage Strategy

**CHOSEN FOR THIS PROJECT: Option A (Simple/Public)**

Files stored in: `public/content-images/`
- Direct web server access (no PHP processing required)
- URLs: `/content-images/filename.ext`
- Served by asset() helper: `asset('content-images/filename.ext')`

*Alternative (not chosen):*
- Option B: `storage/app/public/content-images/` with `php artisan storage:link`

**All documentation, UI, and code must consistently use `public/content-images/` path.**

## Locale & Layout

**Locale Management:**
- Session-based locale switching via routes `/lang/en` and `/lang/ar`
- Default locale: `en`
- Session key: `locale`

**Blade Layout Requirements:**
- `<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">`
- English → `ltr` (left-to-right)
- Arabic → `rtl` (right-to-left)

**Content Reading:**
- `content($key)` picks current session locale
- Fallback chain: current locale → EN → default parameter
- Seamless fallback ensures pages never break due to missing translations

## Editors (Admin UI)

**Text Editing:**
- Use plain HTML `<textarea>` elements (no WYSIWYG editors)
- English field: required
- Arabic field: optional
- Per-key maximum length enforced from content registry
- Input sanitization and trimming on save

**Image Editing:**
- File upload with validation
- Auto-rename uploaded file to `<key>.<ext>` format
- Store only filename in database JSON `path` field
- Overwrite existing file when same key is updated
- Validate file type and size constraints

## Caching

**Cache Strategy:**
- Cache all reads in helpers/repository layer
- Use `rememberForever()` with explicit cache busting (preferred approach)

**Cache Keys:**
- Text content: `cms:content:{key}:{locale}`
- Image content: `cms:content-media:{key}`

**Environment Controls (not implemented yet):**
- `CMS_CACHE_ENABLED=true`
- `CMS_CACHE_TTL=3600` (seconds, if TTL-based caching chosen instead)

## Cache Invalidation (on Update)

**Text Updates:**
After saving any text content for key `K`:
- `Cache::forget("cms:content:{K}:en")`
- `Cache::forget("cms:content:{K}:ar")`

**Image Updates:**
After saving any image content for key `K`:
- `Cache::forget("cms:content-media:{K}")`

**Effect:** Next read operation will repopulate cache with fresh data.

## Security (Preview of Phase 8)

**Access Control:**
- All `/admin/*` routes protected by `auth` middleware
- Content management requires `can:manage-content` ability
- CSRF protection enabled on all admin forms
- Rate limiting on admin actions (light throttling for UX)

**Data Validation:**
- Server-side validation on all inputs
- File upload security (type, size, content validation)
- XSS protection through proper output escaping

## Constraints & Validation

**Text Content:**
- `value.en` field: required, trimmed, sanitized
- `value.ar` field: optional, trimmed, sanitized
- Length limits defined per-key in content registry
- HTML content filtered/stripped as needed

**Image Content:**
- Allowed types: `png|jpg|jpeg|webp`
- Maximum size: 5MB (unless overridden in registry)
- Auto-rename to `<key>.<ext>` format
- Store only filename in database JSON `path` field
- Validate image dimensions and content

**Fallback Behavior:**
- Missing Arabic content falls back to English seamlessly
- Missing English content falls back to helper default parameter
- Missing images fall back to placeholder or provided default

## Content Registry Contract

**Location:** `docs/content-registry.json` (to be created in Phase 1)

**Schema per key:**
```json
{
  "key": "page.section.item",
  "group": "page-name",
  "type": "text|image",
  "label": "Human-readable label",
  "help": "Editor guidance text",
  
  // For text keys:
  "max": 120,
  "requiredEN": true,
  "requiredAR": false,
  
  // For image keys:
  "preferredWidth": 1600,
  "preferredHeight": 900,
  "allowedExtensions": ["png", "jpg", "webp"],
  "maxBytes": 5242880
}
```

**Usage:** Admin interface uses registry to render proper labels, help text, and enforce validation constraints.

## Examples (Non-binding)

These examples show the expected key structure—final authoritative list will be maintained in `docs/content-registry.json`:

**Home Page:**
- `home.hero.title` (text) - "Main hero headline"
- `home.hero.subtitle` (text) - "Hero section subtitle"
- `home.hero.image` (image) - "Hero background image"
- `home.services.title` (text) - "Services section heading"

**About Page:**
- `about.header.title` (text) - "Page header title"
- `about.team.description` (text) - "Team section description"
- `about.mission.image` (image) - "Mission statement background"

**Partners Page:**
- `partners.header.title` (text) - "Partners page title"
- `partners.banner.image` (image) - "Partners banner image"

## Operational Notes

**Consistency Requirements:**
- Always use `public/content-images/` storage path across all code
- Key names must remain stable across content updates
- Update registry only when page structure changes, not content

**Maintenance:**
- Database: daily backups recommended
- Images: optional backup of `public/content-images/` directory
- Cache: can be safely cleared anytime (auto-repopulates)

**Performance:**
- Cache layer handles read performance
- Direct file serving optimizes image delivery
- Explicit cache invalidation ensures data consistency

## Acceptance Checklist (for this Phase)

- [ ] Documentation file created at `docs/cms-conventions.md`
- [ ] All required headings present in specified order
- [ ] Storage strategy clearly marked as chosen (Option A)
- [ ] Cache key formats documented
- [ ] Content registry contract specified
- [ ] Example keys provided across multiple pages
- [ ] Validation rules and constraints defined
- [ ] Operational guidance included