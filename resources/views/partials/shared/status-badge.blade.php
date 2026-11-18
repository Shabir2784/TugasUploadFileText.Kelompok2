@php
    $status = $status ?? 'Tersedia';
    $badgeStyles = [
        'Tersedia' => 'bg-emerald-100 text-emerald-800',
        'Menipis'  => 'bg-amber-100 text-amber-800',
        'Habis'    => 'bg-rose-100 text-rose-800',
    ];
@endphp
<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $badgeStyles[$status] ?? 'bg-slate-100 text-slate-700' }}">
    {{ $status }}
</span>