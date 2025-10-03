<p class="filament-hidden" align="center">
    <img src="https://filafly.com/images/filafly-identity-column.jpg" alt="Banner" style="width: 100%; max-width: 800px;" />
</p>
A reusable identity column for Filament Tables and Infolists.

## Basic Usage

```php
use Filafly\IdentityColumn\Tables\Columns\IdentityColumn;
use Filafly\IdentityColumn\Infolists\Components\IdentityEntry;

// Table column
IdentityColumn::make('name')
    ->avatar('avatar_url')
    ->primary('name')
    ->primaryUrl(fn ($record) => route('users.show', $record))
    ->secondary('email')
    ->secondaryUrl('profile_url', openInNewTab: true)
    ->size('md');

// Infolist entry
IdentityEntry::make('name')
    ->avatar('avatar_url')
    ->primary('name')
    ->secondary('email')
    ->size('md');
```

## Requirements

- PHP 8.2+
- Filament 4.x
- Laravel (package auto-discovery enabled)

## Installation

```bash
composer require filafly/filament-identity-column
php artisan filament:assets
```

## Avatar

- `avatar(string|Closure $value)`
  - Absolute URL, root-relative path, attribute path, or Closure.
- `avatarShape('square'|'rounded'|'circular'|Closure)`
- `squareAvatar()` / `roundedAvatar()` / `circularAvatar()`
- `avatarSize(string|Closure $cssSize)`
  - CSS size (e.g., `28px`, `2rem`).

## Primary

- `primary(string|Closure $value)`
  - Falls back to the column/entry state when not set.
- `primaryUrl(string|Closure|null $url, bool|Closure $openInNewTab = false)`
  - Suppressed if a wrapper `->url()` is set on the column/entry.

## Secondary

- `secondary(string|Closure $value)`
- `secondaryUrl(string|Closure|null $url, bool|Closure $openInNewTab = false)`
  - Suppressed if a wrapper `->url()` is set on the column/entry.

## Sizing

- `size('sm'|'md'|'lg'|TextSize|Closure|null)` (inherited from Filament)
- Defaults: text `md`; avatar size derives from visual size when `avatarSize()` is not set.
- Text scale by size: `sm` (0.875/0.75rem), `md` (1/0.75rem), `lg` (1.125/0.875rem).

## Notes

- Strings passed to methods are resolved from the record via `data_get()` when they look like attribute paths.

## License

MIT
