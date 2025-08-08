# API Specification

This is the API specification for the spec detailed in @.agent-os/specs/2025-08-07-theme-editor-preview/spec.md

> Created: 2025-08-07
> Version: 1.0.0

## Endpoints

### Theme Management Endpoints

#### GET /api/themes

**Purpose:** Retrieve all available themes for the current user/tenant
**Parameters:**
- `page` (optional): Page number for pagination
- `per_page` (optional): Items per page (default: 15)
- `search` (optional): Search term for theme names

**Response:**
```json
{
  "data": [
    {
      "id": "uuid",
      "name": "My Theme",
      "is_active": true,
      "is_preset": false,
      "design_tokens": {
        "colors": {
          "primary": "#3b82f6",
          "secondary": "#64748b",
          "success": "#10b981",
          "warning": "#f59e0b",
          "danger": "#ef4444"
        },
        "typography": {
          "font_family": "Inter",
          "font_size_base": "16px",
          "line_height": "1.5"
        },
        "spacing": "0.25rem",
        "border_radius": "0.25rem"
      },
      "created_at": "2025-08-07T12:00:00Z",
      "updated_at": "2025-08-07T12:00:00Z"
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 15,
    "total": 45
  }
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 500: Internal Server Error

#### GET /api/themes/{theme}

**Purpose:** Retrieve a specific theme by ID
**Parameters:**
- `theme` (path): Theme UUID or slug

**Response:**
```json
{
  "data": {
    "id": "uuid",
    "name": "My Theme",
    "is_active": true,
    "is_preset": false,
    "design_tokens": {
      "colors": {
        "primary": "#3b82f6",
        "secondary": "#64748b",
        "success": "#10b981",
        "warning": "#f59e0b",
        "danger": "#ef4444",
        "gray": {
          "50": "#f9fafb",
          "100": "#f3f4f6",
          "900": "#111827"
        }
      },
      "typography": {
        "font_family": "Inter",
        "font_size_base": "16px",
        "line_height": "1.5"
      },
      "spacing": "0.25rem",
      "border_radius": "0.25rem",
      "shadows": {
        "sm": "0 1px 2px 0 rgb(0 0 0 / 0.05)",
        "md": "0 4px 6px -1px rgb(0 0 0 / 0.1)",
        "lg": "0 10px 15px -3px rgb(0 0 0 / 0.1)"
      }
    },
    "created_at": "2025-08-07T12:00:00Z",
    "updated_at": "2025-08-07T12:00:00Z"
  }
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 404: Theme not found
- 500: Internal Server Error

#### POST /api/themes

**Purpose:** Create a new theme
**Parameters:**
Request Body:
```json
{
  "name": "My New Theme",
  "design_tokens": {
    "colors": {
      "primary": "#3b82f6"
    }
  },
  "clone_from": "uuid" // Optional: Clone from existing theme
}
```

**Response:**
```json
{
  "data": {
    "id": "new-uuid",
    "name": "My New Theme",
    "is_active": false,
    "is_preset": false,
    "design_tokens": { /* full design tokens */ },
    "created_at": "2025-08-07T12:00:00Z",
    "updated_at": "2025-08-07T12:00:00Z"
  },
  "message": "Theme created successfully"
}
```

**Errors:**
- 400: Validation errors
- 401: Unauthorized
- 403: Forbidden
- 422: Invalid design tokens
- 500: Internal Server Error

#### PUT /api/themes/{theme}

**Purpose:** Update an existing theme
**Parameters:**
- `theme` (path): Theme UUID
Request Body:
```json
{
  "name": "Updated Theme Name",
  "design_tokens": {
    "colors": {
      "primary": "#ef4444"
    }
  }
}
```

**Response:**
```json
{
  "data": {
    "id": "uuid",
    "name": "Updated Theme Name",
    "design_tokens": { /* updated design tokens */ },
    "updated_at": "2025-08-07T12:30:00Z"
  },
  "message": "Theme updated successfully"
}
```

**Errors:**
- 400: Validation errors
- 401: Unauthorized
- 403: Forbidden
- 404: Theme not found
- 422: Invalid design tokens
- 500: Internal Server Error

#### DELETE /api/themes/{theme}

**Purpose:** Delete a theme (soft delete for non-preset themes)
**Parameters:**
- `theme` (path): Theme UUID

**Response:**
```json
{
  "message": "Theme deleted successfully"
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden (cannot delete preset themes or active theme)
- 404: Theme not found
- 500: Internal Server Error

#### PUT /api/themes/{theme}/activate

**Purpose:** Set a theme as the active theme
**Parameters:**
- `theme` (path): Theme UUID

**Response:**
```json
{
  "data": {
    "id": "uuid",
    "name": "My Theme",
    "is_active": true
  },
  "message": "Theme activated successfully"
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 404: Theme not found
- 500: Internal Server Error

### Auto-Save Endpoints

#### PUT /api/themes/{theme}/auto-save

**Purpose:** Auto-save theme changes with optimized payload
**Parameters:**
- `theme` (path): Theme UUID
Request Body:
```json
{
  "design_tokens": {
    "colors.primary": "#ef4444",
    "typography.font_size_base": "18px"
  },
  "timestamp": "2025-08-07T12:00:00Z"
}
```

**Response:**
```json
{
  "data": {
    "saved_at": "2025-08-07T12:00:00Z",
    "version": 15
  },
  "message": "Auto-saved successfully"
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 404: Theme not found
- 422: Invalid design token path
- 500: Internal Server Error

#### GET /api/themes/{theme}/auto-save-status

**Purpose:** Check if there are unsaved changes
**Parameters:**
- `theme` (path): Theme UUID
- `last_known_version` (query): Last known version number

**Response:**
```json
{
  "data": {
    "has_unsaved_changes": false,
    "current_version": 15,
    "last_saved_at": "2025-08-07T12:00:00Z"
  }
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 404: Theme not found
- 500: Internal Server Error

### History Management Endpoints

#### GET /api/themes/{theme}/history

**Purpose:** Retrieve theme version history for undo/redo
**Parameters:**
- `theme` (path): Theme UUID
- `limit` (query, optional): Number of versions to retrieve (default: 50)

**Response:**
```json
{
  "data": [
    {
      "version": 15,
      "changes": {
        "colors.primary": {
          "old": "#3b82f6",
          "new": "#ef4444"
        }
      },
      "change_summary": "Updated primary color",
      "created_at": "2025-08-07T12:00:00Z"
    },
    {
      "version": 14,
      "changes": {
        "typography.font_size_base": {
          "old": "16px",
          "new": "18px"
        }
      },
      "change_summary": "Increased base font size",
      "created_at": "2025-08-07T11:45:00Z"
    }
  ]
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 404: Theme not found
- 500: Internal Server Error

#### POST /api/themes/{theme}/revert

**Purpose:** Revert theme to a specific version
**Parameters:**
- `theme` (path): Theme UUID
Request Body:
```json
{
  "version": 14
}
```

**Response:**
```json
{
  "data": {
    "reverted_to_version": 14,
    "new_version": 16,
    "design_tokens": { /* reverted design tokens */ }
  },
  "message": "Theme reverted successfully"
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 404: Theme or version not found
- 422: Invalid version number
- 500: Internal Server Error

### Preset Theme Endpoints

#### GET /api/themes/presets

**Purpose:** Retrieve available preset themes
**Parameters:** None

**Response:**
```json
{
  "data": [
    {
      "id": "default",
      "name": "Default Theme",
      "description": "Clean and professional default theme",
      "preview_image": "/images/presets/default.png",
      "design_tokens": { /* preset design tokens */ }
    },
    {
      "id": "dark",
      "name": "Dark Theme",
      "description": "Modern dark theme with blue accents",
      "preview_image": "/images/presets/dark.png",
      "design_tokens": { /* dark theme tokens */ }
    }
  ]
}
```

**Errors:**
- 401: Unauthorized
- 500: Internal Server Error

#### POST /api/themes/presets/{preset}/apply

**Purpose:** Create a new theme based on a preset
**Parameters:**
- `preset` (path): Preset ID
Request Body:
```json
{
  "name": "My Dark Theme",
  "customizations": {
    "colors.primary": "#10b981"
  }
}
```

**Response:**
```json
{
  "data": {
    "id": "new-uuid",
    "name": "My Dark Theme",
    "design_tokens": { /* preset tokens with customizations */ }
  },
  "message": "Theme created from preset successfully"
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 404: Preset not found
- 422: Invalid customizations
- 500: Internal Server Error

### CSS Generation Endpoints

#### POST /api/themes/{theme}/generate-css

**Purpose:** Generate CSS from theme design tokens
**Parameters:**
- `theme` (path): Theme UUID
Request Body:
```json
{
  "format": "css", // or "scss", "json"
  "include_variables": true,
  "minify": false,
  "scope": "filament" // Optional CSS scope
}
```

**Response:**
```json
{
  "data": {
    "css": ":root {\n  --primary: #3b82f6;\n  --secondary: #64748b;\n}\n\n.btn-primary {\n  background-color: var(--primary);\n}",
    "format": "css",
    "generated_at": "2025-08-07T12:00:00Z",
    "hash": "sha256-abc123"
  }
}
```

**Errors:**
- 401: Unauthorized
- 403: Forbidden
- 404: Theme not found
- 422: Invalid format or options
- 500: Internal Server Error

#### GET /api/themes/preview/contexts

**Purpose:** Get available preview contexts
**Parameters:** None

**Response:**
```json
{
  "data": [
    {
      "id": "dashboard",
      "name": "Dashboard",
      "description": "Main dashboard with widgets and navigation",
      "preview_url": "/preview/dashboard"
    },
    {
      "id": "forms",
      "name": "Form Elements",
      "description": "Various form components and inputs",
      "preview_url": "/preview/forms"
    },
    {
      "id": "tables",
      "name": "Data Tables",
      "description": "Table layouts and data display",
      "preview_url": "/preview/tables"
    }
  ]
}
```

**Errors:**
- 401: Unauthorized
- 500: Internal Server Error

## Controllers

### ThemeController
- `index()` - GET /api/themes
- `show($theme)` - GET /api/themes/{theme}
- `store(ThemeCreateRequest $request)` - POST /api/themes
- `update(ThemeUpdateRequest $request, Theme $theme)` - PUT /api/themes/{theme}
- `destroy(Theme $theme)` - DELETE /api/themes/{theme}
- `activate(Theme $theme)` - PUT /api/themes/{theme}/activate

### ThemeAutoSaveController
- `save(ThemeAutoSaveRequest $request, Theme $theme)` - PUT /api/themes/{theme}/auto-save
- `status(Theme $theme, Request $request)` - GET /api/themes/{theme}/auto-save-status

### ThemeHistoryController
- `index(Theme $theme, Request $request)` - GET /api/themes/{theme}/history
- `revert(ThemeRevertRequest $request, Theme $theme)` - POST /api/themes/{theme}/revert

### ThemePresetController
- `index()` - GET /api/themes/presets
- `apply(ThemePresetRequest $request, $preset)` - POST /api/themes/presets/{preset}/apply

### ThemeCssController
- `generate(ThemeCssGenerateRequest $request, Theme $theme)` - POST /api/themes/{theme}/generate-css
- `show(Theme $theme, Request $request)` - GET /api/themes/{theme}/css

### ThemePreviewController
- `update(ThemePreviewRequest $request)` - POST /api/themes/preview/update
- `contexts()` - GET /api/themes/preview/contexts

## Request Validation Rules

### ThemeCreateRequest
```php
[
    'name' => 'required|string|max:255',
    'design_tokens' => 'required|array',
    'design_tokens.colors' => 'sometimes|array',
    'design_tokens.colors.*' => 'sometimes|string|regex:/^#[0-9A-Fa-f]{6}$/',
    'design_tokens.typography' => 'sometimes|array',
    'design_tokens.typography.font_family' => 'sometimes|string|max:100',
    'design_tokens.typography.font_size_base' => 'sometimes|string|regex:/^\d+px$/',
    'design_tokens.spacing' => 'sometimes|array',
    'design_tokens.spacing.base_unit' => 'sometimes|string|regex:/^\d+px$/',
    'design_tokens.border_radius' => 'sometimes|array',
    'clone_from' => 'sometimes|uuid|exists:themes,id'
]
```

### ThemeUpdateRequest
```php
[
    'name' => 'sometimes|string|max:255',
    'design_tokens' => 'sometimes|array',
    // Same design_tokens validation as ThemeCreateRequest
]
```

### ThemeAutoSaveRequest
```php
[
    'design_tokens' => 'required|array',
    'timestamp' => 'required|date_format:Y-m-d\TH:i:s\Z'
]
```

### ThemeRevertRequest
```php
[
    'version' => 'required|integer|min:1'
]
```

### ThemeCssGenerateRequest
```php
[
    'format' => 'sometimes|in:css,scss,json',
    'include_variables' => 'sometimes|boolean',
    'minify' => 'sometimes|boolean',
    'scope' => 'sometimes|string|max:50'
]
```

### ThemePreviewRequest
```php
[
    'design_tokens' => 'required|array',
    'preview_context' => 'sometimes|in:dashboard,forms,tables',
    'temporary' => 'sometimes|boolean'
]
```

## Route Structure

```php
// routes/api.php
Route::middleware(['auth:sanctum'])->prefix('api')->group(function () {
    // Theme CRUD
    Route::apiResource('themes', ThemeController::class);
    Route::put('themes/{theme}/activate', [ThemeController::class, 'activate']);

    // Auto-save
    Route::put('themes/{theme}/auto-save', [ThemeAutoSaveController::class, 'save']);
    Route::get('themes/{theme}/auto-save-status', [ThemeAutoSaveController::class, 'status']);

    // History
    Route::get('themes/{theme}/history', [ThemeHistoryController::class, 'index']);
    Route::post('themes/{theme}/revert', [ThemeHistoryController::class, 'revert']);

    // Presets
    Route::get('themes/presets', [ThemePresetController::class, 'index']);
    Route::post('themes/presets/{preset}/apply', [ThemePresetController::class, 'apply']);

    // CSS Generation
    Route::post('themes/{theme}/generate-css', [ThemeCssController::class, 'generate']);
    Route::get('themes/{theme}/css', [ThemeCssController::class, 'show']);

    // Preview
    Route::post('themes/preview/update', [ThemePreviewController::class, 'update']);
    Route::get('themes/preview/contexts', [ThemePreviewController::class, 'contexts']);
});
```

## Error Handling

All endpoints return consistent error responses:

```json
{
  "message": "Validation failed",
  "errors": {
    "design_tokens.colors.primary": [
      "The primary color must be a valid hex color"
    ]
  }
}
```

Common HTTP status codes:
- 200: Success
- 201: Created
- 400: Bad Request
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Validation Error
- 500: Internal Server Error

## Rate Limiting

- Theme CRUD operations: 60 requests per minute
- Auto-save operations: 120 requests per minute
- Preview updates: 240 requests per minute
- CSS generation: 30 requests per minute
