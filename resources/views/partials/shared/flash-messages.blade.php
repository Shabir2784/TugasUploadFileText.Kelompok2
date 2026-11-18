@php
    $flashes = collect([
        ['type' => 'success', 'text' => session('success')],
        ['type' => 'error',   'text' => session('error')],
        ['type' => 'info',    'text' => session('status')],
    ])->filter(fn ($f) => filled($f['text']));

    $styles = [
        'success' => 'border-emerald-200 bg-emerald-50 text-emerald-900',
        'error'   => 'border-rose-200 bg-rose-50 text-rose-900',
        'info'    => 'border-blue-200 bg-blue-50 text-blue-900',
    ];
@endphp

@if ($flashes->isNotEmpty() || $errors->any())
    <div class="mb-6 space-y-3">
        @foreach ($flashes as $flash)
            <div x-data="{ show: true }" x-show="show"
                 x-transition:leave="transition duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 role="{{ $flash['type'] === 'error' ? 'alert' : 'status' }}"
                 class="flex items-start justify-between gap-4 rounded-lg border px-4 py-3 text-sm {{ $styles[$flash['type']] }}">
                <p>{{ $flash['text'] }}</p>
                <button type="button" @click="show = false" class="-m-1 rounded p-1 opacity-60 transition duration-150 hover:opacity-100" aria-label="Tutup notifikasi">
                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M18 6L6 18"/>
                    </svg>
                </button>
            </div>
        @endforeach

        @if ($errors->any())
            <div role="alert" class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-900">
                <p class="font-semibold">Data belum bisa disimpan. Periksa kembali isian berikut:</p>
                <ul class="mt-1 list-disc space-y-0.5 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif