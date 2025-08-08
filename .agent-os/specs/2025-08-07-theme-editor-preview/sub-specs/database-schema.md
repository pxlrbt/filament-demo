# Database Schema

This is the database schema implementation for the spec detailed in @.agent-os/specs/2025-08-07-theme-editor-preview/spec.md

> Created: 2025-08-07
> Version: 1.0.0

## Schema Changes

### 1. Themes Table

Stores theme configurations with design tokens and metadata.

```php
Schema::create('themes', function (Blueprint $table) {
    $table->id();
    $table->string('name', 100)->index();
    $table->string('slug', 100)->unique();
    $table->text('description')->nullable();
    $table->json('design_tokens'); // Stores all design token values
    $table->boolean('is_default')->default(false)->index();
    $table->boolean('is_preset')->default(false)->index();
    $table->string('created_by')->nullable(); // User identifier
    $table->timestamps();

    // Indexes for performance
    $table->index(['is_default', 'is_preset']);
    $table->index(['created_by', 'created_at']);
});
```

**Design Tokens JSON Structure:**
```json
{
  "colors": {
    "base": "#ffffff",
    "primary": "#3b82f6",
    "card": "#f8fafc",
    "accent": "#10b981",
    "secondary": "#6b7280"
  },
  "typography": {
    "fontFamily": "Inter, sans-serif",
    "fontSize": "16px",
    "lineHeight": 1.5
  },
  "spacing": "0.25rem",
  "rounding": "0.25rem"
  "borders": {
    "width": "1px",
    "style": "solid",
    "color": "#e5e7eb"
  },
  "shadows": {
    "sm": "0 1px 2px 0 rgb(0 0 0 / 0.05)",
    "md": "0 4px 6px -1px rgb(0 0 0 / 0.1)",
    "lg": "0 10px 15px -3px rgb(0 0 0 / 0.1)"
  }
}
```

### 2. Theme Histories Table

Stores version history for undo/redo functionality with auto-save support.

```php
Schema::create('theme_histories', function (Blueprint $table) {
    $table->id();
    $table->foreignId('theme_id')->constrained()->onDelete('cascade');
    $table->json('design_tokens_snapshot'); // Complete design tokens at this point
    $table->json('changes')->nullable(); // Delta changes for efficient storage
    $table->string('change_type', 50)->default('manual'); // manual, auto_save, preset_applied
    $table->text('change_description')->nullable();
    $table->string('created_by')->nullable();
    $table->timestamp('created_at');

    // Indexes for performance
    $table->index(['theme_id', 'created_at']);
    $table->index(['theme_id', 'change_type']);
});
```

### 3. Preset Themes Table

Stores default preset themes that users can apply as starting points.

```php
Schema::create('preset_themes', function (Blueprint $table) {
    $table->id();
    $table->string('name', 100);
    $table->string('slug', 100)->unique();
    $table->text('description')->nullable();
    $table->string('category', 50)->default('general'); // light, dark, colorful, minimal, etc.
    $table->json('design_tokens');
    $table->string('preview_image_url')->nullable();
    $table->integer('sort_order')->default(0);
    $table->boolean('is_active')->default(true);
    $table->timestamps();

    // Indexes for performance
    $table->index(['category', 'sort_order']);
    $table->index(['is_active', 'sort_order']);
});
```

## Migrations

### Create Themes Migration

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->index();
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->json('design_tokens');
            $table->boolean('is_default')->default(false)->index();
            $table->boolean('is_preset')->default(false)->index();
            $table->string('created_by')->nullable();
            $table->timestamps();

            $table->index(['is_default', 'is_preset']);
            $table->index(['created_by', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('themes');
    }
};
```

### Create Theme Histories Migration

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('theme_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('theme_id')->constrained()->onDelete('cascade');
            $table->json('design_tokens_snapshot');
            $table->json('changes')->nullable();
            $table->string('change_type', 50)->default('manual');
            $table->text('change_description')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamp('created_at');

            $table->index(['theme_id', 'created_at']);
            $table->index(['theme_id', 'change_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('theme_histories');
    }
};
```

### Create Preset Themes Migration

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('preset_themes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();
            $table->text('description')->nullable();
            $table->string('category', 50)->default('general');
            $table->json('design_tokens');
            $table->string('preview_image_url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['category', 'sort_order']);
            $table->index(['is_active', 'sort_order']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('preset_themes');
    }
};
```

### Seed Default Preset Themes

```php
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresetThemesSeeder extends Seeder
{
    public function run()
    {
        $presets = [
            [
                'name' => 'Default Light',
                'slug' => 'default-light',
                'description' => 'Clean and minimal light theme',
                'category' => 'light',
                'design_tokens' => [
                    'colors' => [
                        'base' => '#ffffff',
                        'primary' => '#3b82f6',
                        'card' => '#f8fafc',
                        'accent' => '#10b981',
                        'secondary' => '#6b7280'
                    ],
                    'typography' => [
                        'fontFamily' => 'Inter, sans-serif',
                        'fontSize' => '16px',
                    ],
                    'spacing' => '0.25rem',
                    'rounding' => '0.25rem',
                    'borders' => ['width' => '1px', 'style' => 'solid', 'color' => '#e5e7eb'],
                    'shadows' => [
                        'sm' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                        'md' => '0 4px 6px -1px rgb(0 0 0 / 0.1)',
                        'lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1)'
                    ]
                ],
                'sort_order' => 1
            ],
            [
                'name' => 'Dark Theme',
                'slug' => 'dark-theme',
                'description' => 'Professional dark theme',
                'category' => 'dark',
                'design_tokens' => [
                    'colors' => [
                        'base' => '#1f2937',
                        'primary' => '#60a5fa',
                        'card' => '#374151',
                        'accent' => '#34d399',
                        'secondary' => '#9ca3af'
                    ],
                    'typography' => [
                        'fontFamily' => 'Inter, sans-serif',
                        'fontSize' => '16px',
                    ],
                    'spacing' => '0.25rem"',
                    'rounding' => '0.25rem',
                    'borders' => ['width' => '1px', 'style' => 'solid', 'color' => '#4b5563'],
                    'shadows' => [
                        'sm' => '0 1px 2px 0 rgb(0 0 0 / 0.3)',
                        'md' => '0 4px 6px -1px rgb(0 0 0 / 0.4)',
                        'lg' => '0 10px 15px -3px rgb(0 0 0 / 0.4)'
                    ]
                ],
                'sort_order' => 2
            ]
        ];

        foreach ($presets as $preset) {
            DB::table('preset_themes')->insert(array_merge($preset, [
                'design_tokens' => json_encode($preset['design_tokens']),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now()
            ]));
        }
    }
}
```

## Performance Considerations

### Auto-Save Optimization

1. **Debounced Writes**: Client-side debouncing (500ms) to prevent excessive database writes
2. **Delta Changes**: Store only changed values in the `changes` column to reduce storage
3. **History Cleanup**: Periodic cleanup of old auto-save entries (keep last 50 per theme)
4. **Batch Inserts**: Group multiple auto-save operations when possible

### Database Optimization

1. **Indexes**: Strategic indexes on frequently queried columns
2. **JSON Queries**: SQLite JSON functions for efficient design token queries
3. **Cascading Deletes**: Automatic cleanup of related records
4. **Connection Pooling**: Reuse database connections for better performance

### Storage Considerations

1. **JSON Compression**: Consider compressing large design token payloads
2. **Archive Old Histories**: Move old history records to archive tables
3. **Preset Caching**: Cache preset themes in application memory
4. **Theme Validation**: Validate design token structure before storage
