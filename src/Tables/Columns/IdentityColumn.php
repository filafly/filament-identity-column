<?php

namespace Filafly\IdentityColumn\Tables\Columns;

use Closure;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\TextColumn;

class IdentityColumn extends TextColumn
{
    protected string $view = 'filafly-identity-column::columns.identity-column';

    protected string|Closure|null $avatar = null;

    protected string|Closure|null $primary = null;

    protected string|Closure|null $secondary = null;

    protected string|Closure|null $primaryUrl = null;

    protected string|Closure|null $secondaryUrl = null;

    protected bool|Closure $shouldOpenPrimaryUrlInNewTab = false;

    protected bool|Closure $shouldOpenSecondaryUrlInNewTab = false;

    protected string|Closure|null $avatarShape = 'circular';

    protected string|Closure|null $avatarSize = null; // CSS size like '2rem' or '32px'

    public static function make(?string $name = null): static
    {
        return parent::make($name);
    }

    /**
     * Set an avatar image URL to render alongside the value.
     */
    public function avatar(string|Closure $url): static
    {
        $this->avatar = $url;

        return $this;
    }

    /**
     * Set the primary identifier attribute path (e.g., 'name' or 'user.name').
     * Falls back to the column state if not set.
     */
    public function primary(string|Closure $attribute): static
    {
        $this->primary = $attribute;

        return $this;
    }

    /**
     * Set the secondary identifier attribute path (e.g., 'email' or 'user.email').
     */
    public function secondary(string|Closure $attribute): static
    {
        $this->secondary = $attribute;

        return $this;
    }

    /**
     * Add a URL for the primary line. Accepts a URL string, attribute path, or Closure.
     */
    public function primaryUrl(string|Closure|null $url, bool|Closure $openInNewTab = false): static
    {
        $this->primaryUrl = $url;
        $this->shouldOpenPrimaryUrlInNewTab = $openInNewTab;

        return $this;
    }

    /**
     * Add a URL for the secondary line. Accepts a URL string, attribute path, or Closure.
     */
    public function secondaryUrl(string|Closure|null $url, bool|Closure $openInNewTab = false): static
    {
        $this->secondaryUrl = $url;
        $this->shouldOpenSecondaryUrlInNewTab = $openInNewTab;

        return $this;
    }

    /**
     * Set the avatar shape: 'square', 'rounded', or 'circular'.
     */
    public function avatarShape(string|Closure $shape): static
    {
        $this->avatarShape = $shape;

        return $this;
    }

    /** Make the avatar square (no rounding). */
    public function squareAvatar(): static
    {
        return $this->avatarShape('square');
    }

    /** Make the avatar slightly rounded. */
    public function roundedAvatar(): static
    {
        return $this->avatarShape('rounded');
    }

    /** Make the avatar fully circular. */
    public function circularAvatar(): static
    {
        return $this->avatarShape('circular');
    }

    /**
     * Set the avatar size (CSS unit string, e.g. '2rem', '28px').
     */
    public function avatarSize(string|Closure $size): static
    {
        $this->avatarSize = $size;

        return $this;
    }

    /**
     * Exposed to the Blade view as $getAvatar().
     */
    public function getAvatar(): ?string
    {
        $avatar = $this->evaluate($this->avatar);

        if (blank($avatar)) {
            return null;
        }

        // Resolve against record if it's an attribute path; fall back to the literal string.
        $record = $this->getRecord();
        if ($record) {
            $resolved = data_get($record, (string) $avatar);
            if (! blank($resolved)) {
                $avatar = (string) $resolved;
            }
        }

        // Treat as absolute (or protocol-relative) URL if valid; otherwise return as-is.
        if (is_string($avatar) && (filter_var($avatar, FILTER_VALIDATE_URL) || str_starts_with($avatar, '/'))) {
            return $avatar;
        }

        return is_string($avatar) && filled($avatar) ? $avatar : null;
    }

    /**
     * Value to display as primary (top) line.
     */
    public function getPrimary(): ?string
    {
        if (blank($this->primary)) {
            $state = $this->getState();

            return blank($state) ? null : (string) $state;
        }

        $value = $this->evaluate($this->primary);

        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $record = $this->getRecord();
            if ($record) {
                $resolved = data_get($record, $value);
                if ($resolved !== null && $resolved !== '') {
                    return (string) $resolved;
                }
            }

            return $value === '' ? null : (string) $value;
        }

        return (string) $value;
    }

    /**
     * Value to display as secondary (below) line.
     */
    public function getSecondary(): ?string
    {
        if (blank($this->secondary)) {
            return null;
        }

        $value = $this->evaluate($this->secondary);

        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            $record = $this->getRecord();
            if ($record) {
                $resolved = data_get($record, $value);
                if ($resolved !== null && $resolved !== '') {
                    return (string) $resolved;
                }
            }

            return $value === '' ? null : (string) $value;
        }

        return (string) $value;
    }

    /**
     * Resolve the primary URL from string/Closure/attribute path.
     */
    public function getPrimaryUrl(): ?string
    {
        $url = $this->evaluate($this->primaryUrl);

        if (blank($url)) {
            return null;
        }

        $record = $this->getRecord();
        if ($record) {
            $resolved = data_get($record, (string) $url);
            if ($resolved !== null && $resolved !== '') {
                $url = (string) $resolved;
            }
        }

        return is_string($url) ? $url : null;
    }

    public function shouldOpenPrimaryUrlInNewTab(): bool
    {
        return (bool) $this->evaluate($this->shouldOpenPrimaryUrlInNewTab);
    }

    /**
     * Resolve the secondary URL from string/Closure/attribute path.
     */
    public function getSecondaryUrl(): ?string
    {
        $url = $this->evaluate($this->secondaryUrl);

        if (blank($url)) {
            return null;
        }

        $record = $this->getRecord();
        if ($record) {
            $resolved = data_get($record, (string) $url);
            if ($resolved !== null && $resolved !== '') {
                $url = (string) $resolved;
            }
        }

        return is_string($url) ? $url : null;
    }

    public function shouldOpenSecondaryUrlInNewTab(): bool
    {
        return (bool) $this->evaluate($this->shouldOpenSecondaryUrlInNewTab);
    }

    public function getAvatarShape(): string
    {
        $shape = $this->evaluate($this->avatarShape) ?? 'circular';

        return match (strtolower((string) $shape)) {
            'square', 'rounded', 'circular' => strtolower((string) $shape),
            default => 'circular',
        };
    }

    public function getAvatarSize(): string
    {
        $explicit = $this->evaluate($this->avatarSize);

        if (is_string($explicit) && $explicit !== '') {
            return $explicit;
        }

        return match ($this->getVisualSize()) {
            'sm' => '2rem',
            'lg' => '3.25rem',
            default => '2.75rem',
        };
    }

    public function getVisualSize(): string
    {
        $size = $this->getSize($this->getState());

        if ($size instanceof TextSize) {
            return match ($size) {
                TextSize::Small => 'sm',
                TextSize::Large => 'lg',
                default => 'md',
            };
        }

        return match (strtolower((string) $size)) {
            'sm', 'small' => 'sm',
            'lg', 'large' => 'lg',
            default => 'md',
        };
    }

    public function getSize(mixed $state): TextSize | string
    {
        // Mirror parent logic, with a default of Medium instead of Small.
        $size = $this->evaluate($this->size, [
            'state' => $state,
        ]);

        if (blank($size)) {
            return TextSize::Medium;
        }

        if (is_string($size)) {
            $size = TextSize::tryFrom($size) ?? $size;
        }

        if ($size === 'base') {
            return TextSize::Medium;
        }

        return $size;
    }
}
