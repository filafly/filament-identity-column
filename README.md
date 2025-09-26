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

// Inside a Filament Table schema()
IdentityColumn::make('id');
```

## Configuration

No configuration is required. Views are available under the `filafly-identity-column` namespace.

## License

MIT
