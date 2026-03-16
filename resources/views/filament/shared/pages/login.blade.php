<x-filament-panels::page.simple>
    <x-filament::section class="mb-6">
        <div>
            <div class="flex flex-row items-center justify-center gap-2">
                <x-fab-github class="h-8 w-8 text-indigo-500 dark:text-indigo-400" />
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{
                        __(
                            'filament.pages.github_auth.title',
                        )
                    }}
                </h2>
            </div>

            <div class="flex flex-col text-center">
                <p class="mt-2 text-justify text-sm text-gray-600 dark:text-gray-400">
                    {{
                        __(
                            'filament.pages.github_auth.intro',
                        )
                    }}
                </p>
                <p class="mt-2 text-justify text-sm text-gray-600 dark:text-gray-400">
                    {{
                        __(
                            'filament.pages.github_auth.create_account',
                        )
                    }}
                </p>
            </div>
        </div>
    </x-filament::section>

    <x-filament-socialite::buttons :show-divider="false" />
</x-filament-panels::page.simple>
