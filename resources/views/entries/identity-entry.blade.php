@props([
    'getState',
    'getAvatar' => null,
    'getPrimary' => null,
    'getSecondary' => null,
    'getPrimaryUrl' => null,
    'shouldOpenPrimaryUrlInNewTab' => null,
    'getSecondaryUrl' => null,
    'shouldOpenSecondaryUrlInNewTab' => null,
    'getAvatarShape' => null,
    'getAvatarSize' => null,
    'getUrl' => null, // Entry-level wrapper URL
    'getVisualSize' => null,
])

@php($visualSize = $getVisualSize())
@php($sizes = [
    'sm' => ['primary' => '.875rem', 'secondary' => '.75rem'],
    'md' => ['primary' => '1rem', 'secondary' => '.75rem'],
    'lg' => ['primary' => '1.125rem', 'secondary' => '.875rem'],
])
@php($primaryFs = $sizes[$visualSize]['primary'] ?? '1rem')
@php($secondaryFs = $sizes[$visualSize]['secondary'] ?? '.75rem')
@php($sizeClass = 'fi-identity--' . $visualSize)
<div class="fi-identity {{ $sizeClass }}"
    style="--fi-identity-primary-size: {{ $primaryFs }}; --fi-identity-secondary-size: {{ $secondaryFs }};">
    @if ($getAvatar && filled($getAvatar()))
@php($shape = $getAvatarShape())
@php($size = $getAvatarSize())
        <img src="{{ $getAvatar() }}" alt="" class="fi-identity__avatar fi-identity__avatar--{{ $shape }}"
            style="width: {{ $size }}; height: {{ $size }};" loading="lazy" />
    @endif

    <div class="fi-identity__text">
        @php($primaryText = $getPrimary ? $getPrimary() ?? $getState() : $getState())
        @php($wrapperUrl = $getUrl ? $getUrl() : null)

        @if (!$wrapperUrl && filled($getPrimaryUrl()))
            <a href="{{ $getPrimaryUrl() }}" class="fi-identity__primary"
                @if ($shouldOpenPrimaryUrlInNewTab && $shouldOpenPrimaryUrlInNewTab()) target="_blank" rel="noopener noreferrer" @endif>
                {{ $primaryText }}
            </a>
        @else
            <span class="fi-identity__primary">{{ $primaryText }}</span>
        @endif

        @if ($getSecondary && filled($getSecondary()))
            @php($secondaryText = $getSecondary())
            @if (!$wrapperUrl && filled($getSecondaryUrl()))
                <a href="{{ $getSecondaryUrl() }}" class="fi-identity__secondary"
                    @if ($shouldOpenSecondaryUrlInNewTab && $shouldOpenSecondaryUrlInNewTab()) target="_blank" rel="noopener noreferrer" @endif>
                    {{ $secondaryText }}
                </a>
            @else
                <span class="fi-identity__secondary">{{ $secondaryText }}</span>
            @endif
        @endif
    </div>
</div>
