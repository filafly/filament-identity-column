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
    'getUrl' => null,
    'shouldOpenUrlInNewTab' => null,
])

<div class="fi-identity">
    @if ($getAvatar && filled($getAvatar()))
        @php($shape = $getAvatarShape())
        @php($size = $getAvatarSize())
        <img src="{{ $getAvatar() }}" alt="" class="fi-identity__avatar fi-identity__avatar--{{ $shape }}"
            style="min-width: {{ $size }}; min-height: {{ $size }}; width: {{ $size }}; height: {{ $size }};"
            loading="lazy" />
    @endif

    <div class="fi-identity__text">
        @php($primaryText = $getPrimary ? $getPrimary() ?? $getState() : $getState())
        @php($wrapperUrl = $getUrl ? $getUrl() : null)

        @if (!$wrapperUrl && filled($getPrimaryUrl()))
            <a href="{{ $getPrimaryUrl() }}" class="fi-identity__primary fi-identity__primary--link"
                @if ($shouldOpenPrimaryUrlInNewTab && $shouldOpenPrimaryUrlInNewTab()) target="_blank" rel="noopener noreferrer" @endif>
                {{ $primaryText }}
            </a>
        @else
            <span class="fi-identity__primary">{{ $primaryText }}</span>
        @endif

        @if ($getSecondary && filled($getSecondary()))
            @php($secondaryText = $getSecondary())
            @if (!$wrapperUrl && filled($getSecondaryUrl()))
                <a href="{{ $getSecondaryUrl() }}" class="fi-identity__secondary fi-identity__secondary--link"
                    @if ($shouldOpenSecondaryUrlInNewTab && $shouldOpenSecondaryUrlInNewTab()) target="_blank" rel="noopener noreferrer" @endif>
                    {{ $secondaryText }}
                </a>
            @else
                <span class="fi-identity__secondary">{{ $secondaryText }}</span>
            @endif
        @endif
    </div>
</div>
