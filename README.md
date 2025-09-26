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
