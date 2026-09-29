{{--
    PAGER logo lockup: the "cradling hands" P in a purple app-icon tile, plus the wordmark.
    <x-logo />                       34px tile + PAGER
    <x-logo :size="44" tagline />    adds "Parenting Manager" under the name
    <x-logo mark-only />             just the tile (e.g. tight spaces)
    Assets are generated from public/logo.png: apple-touch-icon.png (tile), logo-mark.png (transparent mark).
--}}
@props(['size' => 34, 'tagline' => false, 'markOnly' => false])

@once
<style>
    .pg-logo { display: inline-flex; align-items: center; gap: 0.6rem; color: var(--ink, #111827); text-decoration: none; line-height: 1; }
    .pg-logo-tile {
        display: block; flex-shrink: 0; border-radius: 26%;
        box-shadow: 0 4px 12px rgba(106,79,179,0.28), inset 0 0 0 1px rgba(255,255,255,0.15);
        transition: transform 0.45s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s;
    }
    a:hover > .pg-logo .pg-logo-tile, a.pg-logo:hover .pg-logo-tile { transform: rotate(-8deg) scale(1.06); box-shadow: 0 8px 20px rgba(106,79,179,0.35); }
    .pg-logo-text { display: flex; flex-direction: column; gap: 0.2em; }
    .pg-logo-name { font-weight: 800; letter-spacing: 0.08em; }
    .pg-logo-tag { font-size: 0.58em; font-weight: 600; letter-spacing: 0.04em; color: var(--sub, #6b7280); white-space: nowrap; }
    @media (prefers-reduced-motion: reduce) { .pg-logo-tile { transition: none; } }
</style>
@endonce

<span {{ $attributes->merge(['class' => 'pg-logo', 'style' => 'font-size:' . round($size * 0.47) . 'px']) }}>
    <img class="pg-logo-tile" src="{{ asset('apple-touch-icon.png') }}" width="{{ $size }}" height="{{ $size }}" alt="{{ $markOnly ? 'PAGER' : '' }}">
    @unless ($markOnly)
        <span class="pg-logo-text">
            <span class="pg-logo-name">PAGER</span>
            @if ($tagline)<span class="pg-logo-tag">Parenting Manager</span>@endif
        </span>
    @endunless
</span>
