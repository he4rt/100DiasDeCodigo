<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white">Minha Jornada</h1>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                Acompanhe seu progresso e conecte-se com a comunidade
            </p>
        </div>

        {{-- Stats Row --}}
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            {{-- Card 1: Progress --}}
            <x-filament::section>
                <div class="mb-4 flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Progresso do desafio</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                        <x-filament::icon icon="heroicon-m-chart-bar" class="h-5 w-5 text-gray-400" />
                    </div>
                </div>
                <div class="mb-4 text-3xl font-bold">{{ auth()->user()->total_days }}/100 Dias</div>
                <div class="mb-2 h-2.5 w-full rounded-full bg-gray-200 dark:bg-gray-700">
                    <div
                        class="bg-primary-600 h-2.5 rounded-full"
                        style="width: {{ auth()->user()->total_days }}%"
                    ></div>
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ 100 - auth()->user()->total_days }} dias restantes
                </div>
            </x-filament::section>

            {{-- Card 2: Streak --}}
            <x-filament::section>
                <div class="mb-4 flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Streak atual</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                        <x-filament::icon icon="heroicon-m-fire" class="h-5 w-5 text-gray-400" />
                    </div>
                </div>
                <div class="mb-8 text-3xl font-bold">{{ auth()->user()->current_streak }} dias</div>
                <div
                    class="flex items-center justify-between border-t border-gray-100 pt-4 text-xs text-gray-500 dark:border-gray-800 dark:text-gray-400"
                >
                    <span>Recorde</span>
                    <span class="font-bold text-gray-900 dark:text-white">
                        {{ auth()->user()->longest_streak }} dias
                    </span>
                </div>
            </x-filament::section>

            {{-- Card 3: Projects Started --}}
            <x-filament::section>
                <div class="mb-4 flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Projetos iniciados</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                        <x-filament::icon icon="heroicon-m-rocket-launch" class="h-5 w-5 text-gray-400" />
                    </div>
                </div>
                <div class="mb-8 text-3xl font-bold">1</div>
                <div
                    class="flex items-center justify-between border-t border-gray-100 pt-4 text-xs text-gray-500 dark:border-gray-800 dark:text-gray-400"
                >
                    <span>Recorde</span>
                    <span class="font-bold text-gray-900 dark:text-white">15 dias</span>
                </div>
            </x-filament::section>

            {{-- Card 4: Projects Finished --}}
            <x-filament::section>
                <div class="mb-4 flex items-start justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Projetos finalizados</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800">
                        <x-filament::icon icon="heroicon-m-check-badge" class="h-5 w-5 text-gray-400" />
                    </div>
                </div>
                <div class="mb-8 text-3xl font-bold">1</div>
                <div
                    class="flex items-center justify-between border-t border-gray-100 pt-4 text-xs text-gray-500 dark:border-gray-800 dark:text-gray-400"
                >
                    <span>Recorde</span>
                    <span class="font-bold text-gray-900 dark:text-white">15 dias</span>
                </div>
            </x-filament::section>
        </div>

        @if (! auth()->user()->dailySubmission)
            <x-filament::section :collapsible="true">
                <x-slot name="heading">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <x-filament::icon
                                :size="\Filament\Support\Enums\IconSize::TwoExtraLarge"
                                icon="heroicon-m-calendar-days"
                                class="text-primary-500"
                            />
                            <div>
                                <h2 class="text-xl font-bold">Registrar dia {{ auth()->user()->total_days + 1 }}</h2>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Progresso do desafio</p>
                            </div>
                        </div>
                    </div>
                </x-slot>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
                    <div class="col-span-2 space-y-4">
                        <div>
                            {{ $this->submissionForm }}
                        </div>
                    </div>

                    <div class="col-span-1 flex h-full flex-col justify-between space-y-4">
                        <div class="">
                            <h3 class="mb-5 text-sm font-medium text-gray-900 dark:text-white">Checklist do dia</h3>

                            <div class="space-y-3">
                                <label
                                    class="border-primary-600 bg-primary-50/10 dark:bg-primary-900/10 hover:bg-primary-50/20 flex cursor-pointer items-center gap-3 rounded-lg border p-3 transition-colors"
                                >
                                    <div
                                        class="flex h-5 w-5 items-center justify-center rounded-full bg-green-500 text-white"
                                    >
                                        <x-filament::icon icon="heroicon-m-check" class="h-3 w-3" />
                                    </div>
                                    <span class="text-sm font-medium">Codei por pelo menos 1hr</span>
                                </label>

                                <label
                                    class="hover:border-primary-500 flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800"
                                >
                                    <div
                                        class="h-5 w-5 rounded-full border-2 border-gray-300 dark:border-gray-600"
                                    ></div>
                                    <span class="text-sm text-gray-500">Fiz um commit no Github e atualizei...</span>
                                </label>

                                <label
                                    class="hover:border-primary-500 flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800"
                                >
                                    <div
                                        class="h-5 w-5 rounded-full border-2 border-gray-300 dark:border-gray-600"
                                    ></div>
                                    <span class="text-sm text-gray-500">Estudei sobre front end</span>
                                </label>

                                <label
                                    class="hover:border-primary-500 flex cursor-pointer items-center gap-3 rounded-lg border border-gray-200 p-3 transition-colors hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-800"
                                >
                                    <div
                                        class="h-5 w-5 rounded-full border-2 border-gray-300 dark:border-gray-600"
                                    ></div>
                                    <span class="text-sm text-gray-500">Estudei sobre acessibilidade</span>
                                </label>

                                <label
                                    class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 dark:border-gray-800"
                                >
                                    <div
                                        class="h-5 w-5 rounded-full border-2 border-gray-300 dark:border-gray-600"
                                    ></div>
                                    <span class="text-sm text-gray-500">Estudei sobre estrutura de dados</span>
                                </label>
                            </div>
                        </div>
                        <x-filament::button wire:click="submitSubmission" color="primary" class="w-full">
                            Registrar dia
                        </x-filament::button>
                    </div>
                </div>
            </x-filament::section>
        @else
            <x-filament::section>
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                        <x-filament::icon icon="heroicon-m-check" class="h-6 w-6 text-green-600 dark:text-green-400" />
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                            Você já registrou seu progresso hoje!
                        </h2>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Volte amanhã para continuar sua jornada.</p>
                    </div>
                </div>
            </x-filament::section>
        @endif
        <!-- Timeline Section -->
        <x-filament::section>
            <x-slot name="heading">
                <div class="flex items-center gap-2">
                    <x-filament::icon icon="heroicon-m-chat-bubble-left-right" class="h-6 w-6" />
                    <h2 class="text-xl font-bold">Timeline de Atividades</h2>
                </div>
            </x-slot>

            <div class="space-y-4">
                @foreach ([
                        [
                            'user' => 'João Code',
                            'handle' => '@joaocodes',
                            'time' => '4h atrás',
                            'day' => 'Dia 15/100',
                            'content' =>
                                'Estudando Rust hoje. A curva de aprendizado é íngreme, mas o compilador é como um professor rigoroso que quer te ver brilhar. Amando o borrow checker! 🦀',
                            'hashtags' => ['#RustLang', '#Coding'],
                            'tags' => ['#Rust', '#Backend'],
                            'comments' => 15,
                            'retweets' => 34,
                            'likes' => 128
                        ],
                        [
                            'user' => 'Maria Dev',
                            'handle' => '@mariadev',
                            'time' => '8h atrás',
                            'day' => 'Dia 14/100',
                            'content' =>
                                'Finalmente entendi como funciona o sistema de módulos do Laravel! A organização do código ficou muito melhor. Próximo passo: implementar testes automatizados.',
                            'hashtags' => ['#Laravel', '#PHP'],
                            'tags' => ['#Laravel', '#Testing'],
                            'comments' => 8,
                            'retweets' => 12,
                            'likes' => 45
                        ],
                        [
                            'user' => 'Pedro Frontend',
                            'handle' => '@pedrofe',
                            'time' => '1d atrás',
                            'day' => 'Dia 13/100',
                            'content' =>
                                'Criei meu primeiro componente reutilizável com Livewire! A reatividade é incrível. Agora entendo porque todo mundo ama esse framework.',
                            'hashtags' => ['#Livewire', '#Frontend'],
                            'tags' => ['#Livewire', '#Alpine'],
                            'comments' => 22,
                            'retweets' => 56,
                            'likes' => 189
                        ]
                    ]
                    as $post)
                    <x-filament::section class="!p-0">
                        <div class="">
                            {{-- Header --}}
                            <div class="mb-4 flex items-start justify-between">
                                <div class="flex items-start gap-2">
                                    <x-filament::avatar
                                        src="https://ui-avatars.com/api/?name={{ urlencode($post['user']) }}&color=f59e0b&background=fef3c7"
                                        alt="{{ $post['user'] }}"
                                        size="lg"
                                    />
                                    <div>
                                        <div class="flex flex-col">
                                            <div class="flex items-center gap-2">
                                                <span class="font-bold text-gray-900 dark:text-white">
                                                    {{ $post['user'] }}
                                                </span>
                                                <span class="text-gray-500">•</span>
                                                <span class="text-sm text-gray-500">{{ $post['time'] }}</span>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $post['handle'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-filament::badge color="primary" size="md">
                                        {{ $post['day'] }}
                                    </x-filament::badge>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="mb-4">
                                <p class="leading-relaxed text-gray-900 dark:text-white">
                                    {{ $post['content'] }}
                                </p>
                            </div>

                            {{-- Hashtags --}}
                            <div class="mb-4 flex flex-wrap gap-2">
                                @foreach ($post['hashtags'] as $hashtag)
                                    <span class="text-primary-600 dark:text-primary-400 font-medium">
                                        {{ $hashtag }}
                                    </span>
                                @endforeach
                            </div>

                            {{-- Tags --}}
                            <div class="mb-4 flex flex-wrap gap-2">
                                @foreach ($post['tags'] as $tag)
                                    <x-filament::badge color="gray" size="sm">
                                        {{ $tag }}
                                    </x-filament::badge>
                                @endforeach
                            </div>

                            {{-- Interaction Stats --}}
                            <div class="flex items-center gap-6 border-t border-gray-200 pt-4 dark:border-gray-700">
                                <button
                                    class="hover:text-primary-600 flex items-center gap-2 text-gray-500 transition-colors"
                                >
                                    <x-filament::icon icon="heroicon-m-chat-bubble-oval-left" class="h-5 w-5" />
                                    <span class="text-sm">{{ $post['comments'] }}</span>
                                </button>

                                <button
                                    class="flex items-center gap-2 text-gray-500 transition-colors hover:text-green-600"
                                >
                                    <x-filament::icon icon="heroicon-m-arrow-path-rounded-square" class="h-5 w-5" />
                                    <span class="text-sm">{{ $post['retweets'] }}</span>
                                </button>

                                <button
                                    class="flex items-center gap-2 text-gray-500 transition-colors hover:text-red-600"
                                >
                                    <x-filament::icon icon="heroicon-m-heart" class="h-5 w-5" />
                                    <span class="text-sm">{{ $post['likes'] }}</span>
                                </button>

                                <button
                                    class="hover:text-primary-600 ml-auto flex items-center gap-2 text-gray-500 transition-colors"
                                >
                                    <x-filament::icon icon="heroicon-m-bookmark" class="h-5 w-5" />
                                </button>

                                <button
                                    class="hover:text-primary-600 flex items-center gap-2 text-gray-500 transition-colors"
                                >
                                    <x-filament::icon icon="heroicon-m-share" class="h-5 w-5" />
                                </button>
                            </div>
                        </div>
                    </x-filament::section>
                @endforeach
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
