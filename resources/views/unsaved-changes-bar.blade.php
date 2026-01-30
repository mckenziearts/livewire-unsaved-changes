<div
    x-data="{
        initialData: @js($form),
        form: @js($form),
        loading: false,
        get isDirty() {
            return JSON.stringify(this.initialData) !== JSON.stringify(this.form)
        },
        discard() {
            this.form = JSON.parse(JSON.stringify(this.initialData))
        },
        async save() {
            this.loading = true

            try {
                await $wire.{{ $saveMethod }}(this.form)
                this.initialData = JSON.parse(JSON.stringify(this.form))
            } finally {
                this.loading = false
            }
        },
        init() {
            @if($preventNavigation)
                window.addEventListener('beforeunload', (e) => {
                    if (this.isDirty) {
                        e.preventDefault()
                    }
                })
            @endif
        }
    }"
>
    {{ $slot }}

    <div
        x-cloak
        x-show="isDirty"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-y-full opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-full opacity-0"
        @class([
            'fixed inset-x-0 z-50 mx-auto max-w-xl rounded-xl bg-zinc-50 ring-1 ring-zinc-950/10 p-1 shadow-lg dark:bg-zinc-950 dark:ring-white/10',
            match ($position) {
                'top' => 'top-6',
                default => 'bottom-6',
            },
        ])
    >
        <div class="flex items-center justify-end gap-2 p-2 ring-1 rounded-lg ring-zinc-200 bg-white dark:bg-zinc-800 dark:ring-white/20">
            <span class="mr-auto pl-2 text-sm font-medium text-zinc-900 dark:text-white">
                {{ $getMessage() }}
            </span>
            <button
                type="button"
                x-on:click="discard"
                x-bind:disabled="loading"
                class="rounded-lg bg-white px-3 py-1.5 text-sm font-medium text-zinc-900 shadow-sm ring-1 ring-zinc-200 hover:bg-zinc-50 disabled:opacity-50 dark:bg-zinc-700 dark:ring-white/10 dark:text-white dark:hover:bg-zinc-600"
            >
                {{ $getDiscardLabel() }}
            </button>
            <button
                type="button"
                x-on:click="save"
                x-bind:disabled="loading"
                @class([
                    'inline-flex relative rounded-lg px-3 py-1.5 text-sm font-medium shadow-sm disabled:opacity-50',
                    match ($color) {
                        'red' => 'bg-red-500 text-white hover:bg-red-600',
                        'orange' => 'bg-orange-500 text-white hover:bg-orange-600',
                        'amber' => 'bg-amber-500 text-white hover:bg-amber-600',
                        'yellow' => 'bg-yellow-500 text-black hover:bg-yellow-600',
                        'lime' => 'bg-lime-500 text-black hover:bg-lime-600',
                        'green' => 'bg-green-500 text-white hover:bg-green-600',
                        'emerald' => 'bg-emerald-500 text-white hover:bg-emerald-600',
                        'teal' => 'bg-teal-500 text-white hover:bg-teal-600',
                        'cyan' => 'bg-cyan-500 text-white hover:bg-cyan-600',
                        'sky' => 'bg-sky-500 text-white hover:bg-sky-600',
                        'indigo' => 'bg-indigo-500 text-white hover:bg-indigo-600',
                        'violet' => 'bg-violet-500 text-white hover:bg-violet-600',
                        'purple' => 'bg-purple-500 text-white hover:bg-purple-600',
                        'fuchsia' => 'bg-fuchsia-500 text-white hover:bg-fuchsia-600',
                        'pink' => 'bg-pink-500 text-white hover:bg-pink-600',
                        'rose' => 'bg-rose-500 text-white hover:bg-rose-600',
                        default => 'bg-blue-500 text-white hover:bg-blue-600',
                    },
                ])
            >
                <span x-bind:class="loading && 'invisible'">{{ $getSaveLabel() }}</span>
                <svg
                    x-show="loading"
                    x-cloak
                    class="absolute inset-0 m-auto size-4 animate-spin text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    />
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    />
                </svg>
            </button>
        </div>
    </div>
</div>
