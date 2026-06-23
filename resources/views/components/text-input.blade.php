@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-slate-500 focus:ring-slate-500 rounded-md shadow-sm dark:bg-zinc-950 dark:border-zinc-800 dark:text-zinc-250 dark:focus:border-slate-500 dark:focus:ring-slate-500/50']) }}>
