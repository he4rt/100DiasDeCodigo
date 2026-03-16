<section class="hp-section" id="projects">
    <div class="hp-container">
        <x-he4rt::headline align="center" size="md" :keywords="['prática']">
            <x-slot:badge>
                <x-he4rt::badge>
                    <x-filament::icon icon="heroicon-o-cube" class="h-5 w-5" />
                    Nossos projetos
                </x-he4rt::badge>
            </x-slot:badge>

            <x-slot:title>
                Aprenda na prática
            </x-slot:title>

            <x-slot:description>
                Contribua com projetos open source e desenvolva habilidades reais enquanto constrói seu portfólio.
            </x-slot:description>
        </x-he4rt::headline>

        <div class="grid w-full grid-cols-1 items-center justify-center gap-8 sm:grid-cols-3 lg:gap-16">
            <x-he4rt::card>
                <x-slot:title>
                    4Noobs
                </x-slot:title>
                <x-slot:description>
                    Repositórios de conteúdos sobre diversas tecnologias.
                </x-slot:description>
                <x-slot:tags>
                    <x-he4rt::tag>Documentação</x-he4rt::tag>
                    <x-he4rt::tag>Documentação</x-he4rt::tag>
                </x-slot:tags>
                <x-slot:actions>
                    <x-he4rt::button block>Ver projeto</x-he4rt::button>
                </x-slot:actions>
            </x-he4rt::card>

            <x-he4rt::card>
                <x-slot:title>
                    He4rtLabs
                </x-slot:title>
                <x-slot:description>
                    Projetos práticos desenvolvidos pela comunidade para aprendizado.
                </x-slot:description>
                <x-slot:tags>
                    <x-he4rt::tag>Documentação</x-he4rt::tag>
                    <x-he4rt::tag>Documentação</x-he4rt::tag>
                </x-slot:tags>
                <x-slot:actions>
                    <x-he4rt::button block>Ver projeto</x-he4rt::button>
                </x-slot:actions>
            </x-he4rt::card>

            <x-he4rt::card>
                <x-slot:title>
                    Desafios de Código
                </x-slot:title>
                <x-slot:description>
                    Desafios semanais para praticar suas habilidades de programação.
                </x-slot:description>
                <x-slot:tags>
                    <x-he4rt::tag>Documentação</x-he4rt::tag>
                    <x-he4rt::tag>Documentação</x-he4rt::tag>
                </x-slot:tags>
                <x-slot:actions>
                    <x-he4rt::button block>Ver projeto</x-he4rt::button>
                </x-slot:actions>
            </x-he4rt::card>
        </div>
    </div>
</section>
