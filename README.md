# Filament Identity Column

A reusable identity column for Filament Tables.

## Installation

```bash
composer require filafly/filament-identity-column
```

Laravel will auto-discover the service provider.

## Usage

```php
use Filafly\IdentityColumn\Tables\Columns\IdentityColumn;
use Filafly\IdentityColumn\Infolists\Components\IdentityEntry;

// Inside a Filament Table schema()
IdentityColumn::make('name')
    // Absolute URL, attribute path, or Closure
    ->avatar('avatar_url')
    // ->avatar(fn ($record) => $record->profilePhotoUrl)
    // Primary and secondary can be attribute paths or Closures
    ->primary('name')
    // ->primary(fn ($record) => $record->full_name)
    ->primaryUrl(fn ($record) => route('users.show', $record))
    ->secondary('email')
    ->secondaryUrl('profile_url', openInNewTab: true)
    ->size('md'); // sm | md | lg
    // ->secondary(fn ($record) => $record->company?->name)

// Avatar shape helpers:
// ->circularAvatar()  // fully round (default)
// ->roundedAvatar()   // slightly rounded corners
// ->squareAvatar()    // no rounding
 
// Inside a Filament Infolist schema()
IdentityEntry::make('name')
    ->avatar('avatar_url')
    ->circularAvatar()
    ->size('md')
    ->primary('name')
    ->secondary('email');
```

## API

Both components expose the same fluent API. Strings may be literal values or attribute paths resolved from the record using `data_get($record, 'path')`. Closures receive the record and can return a value dynamically.

- Avatar
  - `avatar(string|Closure $value)`
    - Accepts absolute/protocol-relative URL, root-relative path (e.g. `/img.png`), a record attribute path (e.g. `user.avatar_url`), or a Closure.
  - `avatarShape('square'|'rounded'|'circular'|Closure)`
  - `squareAvatar()` / `roundedAvatar()` / `circularAvatar()`
  - `avatarSize(string|Closure $cssSize)`
    - Overrides the computed avatar size. Examples: `28px`, `2rem`.

- Identity text
  - `primary(string|Closure $value)`
  - `secondary(string|Closure $value)`

- Links
  - `primaryUrl(string|Closure|null $url, bool|Closure $openInNewTab = false)`
  - `secondaryUrl(string|Closure|null $url, bool|Closure $openInNewTab = false)`
  - If the table column/entry has its own wrapper `->url()`, inner links are suppressed to avoid nested anchors.

- Size
  - `size('sm'|'md'|'lg'|TextSize|Closure|null)`
    - Inherited from Filament. This package defaults to Medium when unset.
    - Text scaling mapping used by the components:
      - `sm`: primary `0.875rem`, secondary `0.75rem`
      - `md`: primary `1rem`, secondary `0.75rem`
      - `lg`: primary `1.125rem`, secondary `0.875rem`
    - Avatar size (when `avatarSize()` not set):
      - `sm`: `1.25rem`, `md`: `1.5rem`, `lg`: `2rem`

## Defaults & Behavior

- Defaults (when not set):
  - Shape: `circular`
  - Size: `md` (Medium)
  - Avatar size: derived from size (see mapping above)
- Strings passed to `avatar()`, `primary()`, `secondary()`, `primaryUrl()`, `secondaryUrl()` are resolved from the record via `data_get()` if they match an attribute path.
- Closures are evaluated with Filament’s normal evaluation context (you may type-hint `$record` and/or use `$state`).

## Configuration

No configuration is required. Views are available under the `filafly-identity-column` namespace.

### Styling in Filament (Tailwind v4)

Filament loads plugin assets via its asset manager. This package ships a tiny CSS file that ensures the avatar is rounded and the text is stacked even if your app isn’t compiling Tailwind utilities from this view.

After installing or updating the package, publish assets:

```bash
php artisan filament:assets
```

You don’t need a Tailwind config for this package to render correctly under Tailwind v4.

## License

MIT
