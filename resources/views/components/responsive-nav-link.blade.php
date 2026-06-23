@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-slate-500 text-start text-base font-medium text-slate-300 bg-slate-900 focus:outline-none focus:text-white focus:bg-slate-800 focus:border-slate-400 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-zinc-400 hover:text-zinc-200 hover:bg-zinc-800 hover:border-zinc-700 focus:outline-none focus:text-zinc-200 focus:bg-zinc-800 focus:border-zinc-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
