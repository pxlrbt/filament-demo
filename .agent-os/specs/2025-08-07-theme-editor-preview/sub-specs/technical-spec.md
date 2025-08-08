# Technical Specification

This is the technical specification for the spec detailed in @.agent-os/specs/2025-08-07-theme-editor-preview/spec.md

> Created: 2025-08-07
> Version: 1.0.0

## Technical Requirements

### Frontend Architecture (Vue.js 3 Components)

#### Theme Editor Component Structure
- **ThemeEditor.vue**: Main container component with split-pane layout
- **BaseValuePanel.vue**: Left panel with organized tabs and accordions for controls
- **PreviewPane.vue**: Right panel with iframe preview and controls
- **TabContainer.vue**: Tab navigation component for organizing control groups
- **AccordionSection.vue**: Collapsible sections within each tab
- **ColorPicker.vue**: Custom color selection with hex/rgb inputs
- **BaseValueSlider.vue**: Unified slider component for rounding, font-size, line-height, spacing
- **ScaleGenerator.vue**: Service component that generates design token scales from base values
- **ScalePreview.vue**: Component showing generated scale values in real-time

#### Interface Organization Structure

**Tab-Based Navigation:**
```
┌─ Colors Tab ──────────────────────────────────┐
│  ┌─ Brand Colors (Accordion) ─────────────────┐ │
│  │  • Primary Color Picker                   │ │
│  │  • Secondary Color Picker                 │ │
│  │  • Accent Color Picker                    │ │
│  └───────────────────────────────────────────┘ │
│  ┌─ Surface Colors (Accordion) ───────────────┐ │
│  │  • Base Background Color                  │ │
│  │  • Card Background Color                  │ │
│  └───────────────────────────────────────────┘ │
└───────────────────────────────────────────────┘

┌─ Typography Tab ──────────────────────────────┐
│  ┌─ Base Values (Accordion) ──────────────────┐ │
│  │  • Font Size Base Slider (12px - 20px)    │ │
│  │  • Line Height Base Slider (1.2 - 2.0)   │ │
│  └───────────────────────────────────────────┘ │
│  ┌─ Generated Scale Preview (Accordion) ──────┐ │
│  │  • Text-xs: calc(base * 0.75)             │ │
│  │  • Text-sm: calc(base * 0.875)            │ │
│  │  • Text-base: base value                  │ │
│  │  • Text-lg: calc(base * 1.125)            │ │
│  └───────────────────────────────────────────┘ │
└───────────────────────────────────────────────┘

┌─ Layout Tab ──────────────────────────────────┐
│  ┌─ Spacing (Accordion) ───────────────────────┐ │
│  │  • Spacing Base Slider (0.125rem - 1rem)   │ │
│  │  • Generated: 1x, 2x, 4x, 8x preview      │ │
│  └───────────────────────────────────────────┘ │
│  ┌─ Rounding (Accordion) ──────────────────────┐ │
│  │  • Rounding Base Slider (0rem - 1rem)      │ │
│  │  • Generated: sm, md, lg, xl preview       │ │
│  └───────────────────────────────────────────┘ │
└───────────────────────────────────────────────┘
```

#### State Management
- **Pinia store** for global theme state management
- **Tab state** for tracking active tab and accordion states
- Reactive design tokens object with nested categories
- History stack for undo/redo functionality (max 50 actions)  
- Auto-save debounced state persistence every 2 seconds
- Real-time CSS variable generation from token values

#### Base Values & Generated Scales Structure
```javascript
baseValues: {
  // User-controlled base values
  colors: {
    primary: '#3b82f6',
    secondary: '#64748b', 
    accent: '#10b981',
    base: '#ffffff',
    card: '#f8fafc'
  },
  fontSizeBase: '16px',      // Generates: text-xs, text-sm, text-base, text-lg, etc.
  lineHeightBase: 1.5,       // Generates: leading-tight, leading-normal, leading-loose
  spacingBase: '0.25rem',    // Generates: space-1, space-2, space-4, space-8, etc.
  roundingBase: '0.25rem'    // Generates: rounded-sm, rounded, rounded-md, rounded-lg
},

// Auto-generated scales (read-only)
generatedTokens: {
  fontSize: {
    xs: 'calc(var(--font-size-base) * 0.75)',    // 12px if base is 16px
    sm: 'calc(var(--font-size-base) * 0.875)',   // 14px
    base: 'var(--font-size-base)',               // 16px
    lg: 'calc(var(--font-size-base) * 1.125)',   // 18px
    xl: 'calc(var(--font-size-base) * 1.25)'     // 20px
  },
  spacing: {
    1: 'var(--spacing-base)',                     // 0.25rem
    2: 'calc(var(--spacing-base) * 2)',          // 0.5rem
    4: 'calc(var(--spacing-base) * 4)',          // 1rem
    8: 'calc(var(--spacing-base) * 8)'           // 2rem
  }
}
```

### Backend Laravel Integration

#### Routes and Controllers
- **Route**: `POST /admin/theme-editor/save` - Save theme configuration
- **Route**: `GET /admin/theme-editor/load` - Load current theme
- **Route**: `POST /admin/theme-editor/reset` - Reset to default theme
- **Controller**: `ThemeEditorController` with methods for CRUD operations

#### Theme Storage System
- **Model**: `Theme` with fields: `id`, `name`, `tokens` (JSON), `is_active`, `created_at`, `updated_at`
- **Service**: `ThemeService` for CSS generation and file management
- **Middleware**: Theme injection for admin panel routes

#### CSS Generation Pipeline
1. Convert design tokens to CSS custom properties
2. Generate comprehensive CSS file with all Filament overrides
3. Write to `resources/css/filament/admin/theme-editor.css`
4. Automatically include in Vite build process

### Database Schema Requirements

#### Themes Table
```sql
CREATE TABLE themes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(255) NOT NULL,
    tokens TEXT NOT NULL, -- JSON column for design tokens
    is_active BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

#### Theme History Table (for undo/redo)
```sql
CREATE TABLE theme_history (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    theme_id INTEGER NOT NULL,
    tokens TEXT NOT NULL,
    action_type VARCHAR(50) NOT NULL, -- 'update', 'create', 'reset'
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (theme_id) REFERENCES themes(id) ON DELETE CASCADE
);
```

### CSS Generation and Injection

#### Dynamic CSS Variables
- Generate CSS custom properties from design tokens
- Namespace all variables with `--theme-editor-`
- Override Filament's default CSS variables
- Support for color opacity modifiers and HSL conversions

#### CSS Output Structure
```css
:root {
  /* Colors */
  --theme-editor-primary-50: hsl(var(--theme-editor-primary-hsl) / 0.05);
  --theme-editor-primary-500: var(--theme-editor-primary);

  /* Typography */
  --theme-editor-font-family-sans: var(--theme-editor-font-body);
  --theme-editor-text-sm: var(--theme-editor-font-size-sm);

  /* Spacing */
  --theme-editor-spacing-1: 0.25rem;
  --theme-editor-spacing-2: 0.5rem;
}

/* Filament Component Overrides */
.fi-btn--primary {
  background-color: hsl(var(--theme-editor-primary-hsl) / var(--tw-bg-opacity));
}
```

#### Hot CSS Injection
- Use JavaScript to inject `<style>` tag into iframe
- Update CSS variables in real-time without page refresh
- Maintain CSS specificity for proper overrides

### Iframe Communication

#### PostMessage API Implementation
- **Parent → Iframe**: Send theme updates via `postMessage`
- **Iframe → Parent**: Send ready state and error notifications
- **Message Types**: `THEME_UPDATE`, `IFRAME_READY`, `THEME_ERROR`

#### Security Considerations
- Validate origin of all postMessage communications
- Sanitize all CSS values before injection
- Implement CSP headers for iframe content

#### Communication Protocol
```javascript
// Parent to iframe
iframe.contentWindow.postMessage({
  type: 'THEME_UPDATE',
  tokens: designTokens,
  timestamp: Date.now()
}, window.location.origin);

// Iframe to parent
window.parent.postMessage({
  type: 'IFRAME_READY',
  status: 'loaded'
}, window.location.origin);
```

### Auto-save Implementation

#### Debounced Persistence
- Use Lodash debounce with 2-second delay
- Save to localStorage for immediate persistence
- Background API call to save to database
- Visual indicator for save status (saving/saved/error)

#### Conflict Resolution
- Timestamp-based conflict detection
- User prompt for overwrite or merge on conflicts
- Automatic backup before overwriting

### Undo/Redo System

#### History Stack Management
- Immutable state snapshots for each action
- Maximum 50 history entries (FIFO when exceeded)
- Action types: `COLOR_CHANGE`, `TYPOGRAPHY_UPDATE`, `SPACING_MODIFY`, `RESET_ALL`

#### Implementation Details
```javascript
const historyStore = {
  past: [],
  present: currentTokens,
  future: [],

  undo() {
    if (this.past.length === 0) return;
    const previous = this.past.pop();
    this.future.unshift(this.present);
    this.present = previous;
  },

  redo() {
    if (this.future.length === 0) return;
    const next = this.future.shift();
    this.past.push(this.present);
    this.present = next;
  }
};
```

#### Keyboard Shortcuts
- `Ctrl/Cmd + Z`: Undo last action
- `Ctrl/Cmd + Shift + Z`: Redo last undone action
- `Ctrl/Cmd + S`: Manual save (in addition to auto-save)

## External Dependencies

No additional external dependencies are required beyond the current tech stack. All functionality will be implemented using:
- Laravel 12 (existing)
- Filament v4 (existing)
- Vue.js 3 (existing)
- TailwindCSS v4 (existing)
- Vite (existing)
- SQLite (existing)

The implementation leverages existing Shadcn Vue components and native browser APIs for iframe communication and CSS injection.
