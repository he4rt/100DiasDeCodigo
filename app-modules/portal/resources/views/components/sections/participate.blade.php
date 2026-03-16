@php
    $items = [
        [
            'title' => 'Estude Programação',
            'description' => 'Estude no mínimo uma hora todos os dias pelos próximos 100 dias algum tópico de tecnologia.',
        ],
        [
            'title' => 'Faça um Tweet',
            'description' => 'Tweete seu progresso todos os dias com a hashtag #100DaysOfCode.',
        ],
        [
            'title' => 'Interaja com a comunidade',
            'description' =>
                'Todos os dias, entre em contato com pelo menos duas pessoas no Twitter que também estão participando do desafio.',
        ],
    ];
@endphp

<section class="mx-auto max-w-6xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
    <h2 class="mb-12 text-center text-3xl font-bold md:text-4xl">Como participar</h2>
    <div class="grid items-center gap-12 md:grid-cols-2">
        <div class="flex h-full flex-col justify-between space-y-8">
            @foreach ($items as $key => $item)
                <x-he4rt::card class="flex h-fit flex-row justify-start!">
                    <x-slot:icon class="flex-1">
                        <div
                            class="bg-primary/8 border-primary/16 flex items-center justify-center rounded-lg border p-2"
                        >
                            {{ $key }}
                        </div>
                    </x-slot:icon>
                    <x-slot name="content"></x-slot>
                    <x-slot name="title">
                        {{ $item['title'] }}
                    </x-slot>

                    <x-slot name="description">
                        {{ $item['description'] }}
                    </x-slot>
                </x-he4rt::card>
            @endforeach
        </div>
        <div class="space-y-4">
            <style>
                .twitter-tweet iframe {
                    filter: hue-rotate(50deg);
                    border-radius: 0.8rem;
                }
            </style>

            <blockquote class="twitter-tweet" data-theme="dark" data-dnt="true" align="center">
                <p lang="pt" dir="ltr">
                    Eu publicamente me comprometo aos desafios do 100 Dias De Codigo começando hoje!
                    <a href="https://t.co/YciX4dGFlw">https://t.co/YciX4dGFlw</a>
                    <a href="https://twitter.com/hashtag/100DiasDeCodigo?src=hash&amp;ref_src=twsrc%5Etfw">
                        #100DiasDeCodigo
                    </a>
                    via
                    <a href="https://twitter.com/He4rtDevs?ref_src=twsrc%5Etfw">@he4rtdevs</a>
                </p>
                &mdash; danielhe4rt.php (
                @danielhe4rt
                )
                <a href="https://twitter.com/danielhe4rt/status/1990792483677376759?ref_src=twsrc%5Etfw">
                    November 18, 2025
                </a>
            </blockquote>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>

            <div class="space-y-4">
                <p class="text-foreground font-semibold">Comprometa-se publicamente com o desafio:</p>
                <x-he4rt::button icon="heroicon-s-chevron-right" class="w-full">Começar agora</x-he4rt::button>
            </div>
        </div>
    </div>
</section>
<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
