<div
    class="rounded-2xl border border-gray-200 bg-white/50 p-6 backdrop-blur-sm dark:border-gray-800 dark:bg-gray-900/50"
>
    <div class="mb-4 flex items-center justify-between">
        <h3 class="flex items-center gap-2 font-semibold text-gray-900 dark:text-white">
            <x-filament::icon icon="heroicon-o-trophy" class="h-4 w-4 text-yellow-500" />
            Destaques da Comunidade
        </h3>
        <a
            href="#"
            class="hover:text-primary-500 dark:hover:text-primary-400 text-xs text-gray-500 transition-colors dark:text-gray-400"
        >
            Ver todos
        </a>
    </div>

    <div class="space-y-3">
        @foreach ($highlights as $user)
            <a
                href="#"
                class="group -mx-2 flex items-center gap-3 rounded-lg p-2 transition-colors hover:bg-gray-100/50 dark:hover:bg-gray-800/50"
            >
                <span
                    class="relative flex h-9 w-9 shrink-0 overflow-hidden rounded-full border-2 border-gray-200/50 dark:border-gray-700/50"
                >
                    <img
                        class="aspect-square h-full w-full object-cover"
                        alt="{{ $user['name'] }}"
                        src="{{ $user['avatar'] }}"
                    />
                </span>

                <div class="min-w-0 flex-1">
                    <p
                        class="group-hover:text-primary-500 dark:group-hover:text-primary-400 truncate text-sm font-medium text-gray-900 transition-colors dark:text-white"
                    >
                        {{ $user['name'] }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ '@' . $user['username'] }}</p>
                </div>

                <div class="flex items-center gap-2">
                    <span @class (['rounded-full px-2 py-0.5 text-xs font-medium'])> {{ $user['badge'] }} </span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">Dia {{ $user['day'] }}</span>
                    <x-filament::icon
                        icon="heroicon-m-chevron-right"
                        class="h-4 w-4 text-gray-400 opacity-0 transition-opacity group-hover:opacity-100"
                    />
                </div>
            </a>
        @endforeach
    </div>
</div>
