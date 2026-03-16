<section class="hp-section" id="about">
    <div class="hp-container">
        <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 sm:gap-16">
            <div class="order-2 flex flex-col items-center justify-center sm:order-1">
                <x-he4rt::headline size="md" :keywords="['#100DiasDeCodigo?']">
                    <x-slot:badge>
                        <x-he4rt::badge>
                            <x-filament::icon icon="heroicon-o-cursor-arrow-ripple" class="h-5 w-5" />
                            Resumão do Desafio
                        </x-he4rt::badge>
                    </x-slot:badge>

                    <x-slot:title>
                        O que é #100DiasDeCodigo?
                    </x-slot:title>

                    <x-slot:description>
                        <div>
                            É um desafio global que incentiva programadores a
                            <span class="text-text-high font-bold">dedicarem 1 hora por dia durante 100 dias</span>
                            consecutivos para aprender e melhorar suas habilidades de programação.
                            <br />
                            <br />

                            Não é sobre se tornar um
                            <span class="text-text-high font-bold">especialista em 100</span>
                            dias. É sobre construir consistência, ganhar confiança e transformar seu aprendizado em
                            hábito.
                        </div>

                        <div>
                            <div class="flex gap-2 pt-4">
                                <x-filament::icon icon="heroicon-o-check-circle" class="text-primary h-6 w-6" />
                                <span class="text-gray-200">Gratuito e aberto para todos</span>
                            </div>
                            <div class="flex gap-2 pt-4">
                                <x-filament::icon icon="heroicon-o-check-circle" class="text-primary h-6 w-6" />
                                <span class="text-gray-200">Nenhum conhecimento prévio necessário</span>
                            </div>
                            <div class="flex gap-2 pt-4">
                                <x-filament::icon icon="heroicon-o-check-circle" class="text-primary h-6 w-6" />
                                <span class="text-gray-200">Comunidade global de suporte</span>
                            </div>
                        </div>
                    </x-slot:description>
                    <x-slot:actions>
                        <x-he4rt::button icon="heroicon-s-chevron-right" variant="outline">
                            Começar Desafio
                        </x-he4rt::button>
                    </x-slot:actions>
                </x-he4rt::headline>
            </div>

            <div class="order-2 mx-auto flex w-full max-w-lg flex-col sm:order-2 sm:grid-cols-2">
                <div class="bg-elevation-01dp overflow-hidden rounded-lg shadow-xl">
                    <div class="bg-elevation-surface flex items-center gap-2 p-4">
                        <div class="h-3 w-3 rounded-full bg-red-500"></div>
                        <div class="h-3 w-3 rounded-full bg-yellow-500"></div>
                        <div class="bg-primary h-3 w-3 rounded-full"></div>
                    </div>

                    <div class="flex w-full flex-col gap-2 p-6 font-mono text-sm text-gray-300">
                        <div class="mt-1 flex flex-col">
                            <span class="text-primary mr-2 text-lg font-bold"># Anotações 100DiasDeCodigo</span>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <span class="mr-2 text-gray-500">## Dia 1</span>
                            <span class="text-gray-100">Configurei o ambiente e revisei lógica de programação.</span>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <span class="mr-2 text-gray-500">## Dia 2</span>
                            <span class="text-gray-100">Aprofundei estudo em PHP com funções e arrays.</span>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <span class="mr-2 text-gray-500">## Dia 3</span>
                            <span class="text-gray-100">Pratiquei orientação a objetos criando classes simples.</span>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <span class="mr-2 text-gray-500">## Dia 4</span>
                            <span class="text-gray-100">Comecei um mini-projeto usando Laravel.</span>
                        </div>
                        <div class="mt-1 flex flex-col">
                            <span class="mr-2 text-gray-500">## Dia 5</span>
                            <span class="text-gray-100">Aprendi mais sobre Tailwind e responsabilidades CSS.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
