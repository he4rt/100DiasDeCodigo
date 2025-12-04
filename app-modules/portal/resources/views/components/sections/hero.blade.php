@php
    use App\Models\User;
@endphp

@props([
    'users',
    'usersCount',
])
@php
    /** @var \Illuminate\Support\Collection<int, User> $usersImages */
    $usersImages = $users
        ->map(fn (User $user) => $user->getFilamentAvatarUrl())
        ->filter()
        ->values()
        ->toArray();
@endphp

<section class="hp-section relative" id="community">
    <div class="absolute -z-1 flex h-[150%] w-[150%] sm:h-full sm:w-full sm:p-16">
        <img src="{{ asset('images/landingLogo.svg') }}" alt="Logo" class="h-full w-full" />
    </div>
    <div class="hp-container">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 lg:gap-12">
            <div class="flex flex-col gap-4">
                <x-he4rt::headline size="2xl" :keywords="['carreira', 'em', 'tecnologia']">
                    <x-slot:badge>
                        <x-he4rt::badge>
                            <x-filament::icon icon="heroicon-o-book-open" class="h-5 w-5" />
                            #100DiasDeCodigo
                        </x-he4rt::badge>
                    </x-slot>

                    <x-slot:title>
                        Construa o hábito que vai mudar sua carreira em tecnologia
                    </x-slot>

                    <x-slot:description>
                        Um desafio simples, consistente e transformador. Dedique 1 hora por dia durante 100 dias e mude
                        sua carreira na programação.
                    </x-slot>
                    <x-slot:actions>
                        <x-he4rt::button href="/app" icon="heroicon-s-chevron-right">Começar agora</x-he4rt::button>

                        <x-he4rt::button icon="heroicon-s-chevron-right" variant="outline">
                            Ver Timeline
                        </x-he4rt::button>
                    </x-slot>
                </x-he4rt::headline>
                <x-he4rt::avatar-stack :images="$usersImages" limit="5">
                    Mais de {{ $usersCount }} desenvolvedores já fazem parte
                </x-he4rt::avatar-stack>
            </div>
            <div class="flex flex-col items-center justify-center">
                <div class="w-full max-w-md p-5 md:max-w-xl">
                    <iframe
                        class="mb-4 aspect-video h-full w-full"
                        src="https://www.youtube.com/embed/rSYBWXQWNJs"
                        title="YouTube video player"
                        frameborder="0"
                        allow="
                            accelerometer;
                            autoplay;
                            clipboard-write;
                            encrypted-media;
                            gyroscope;
                            picture-in-picture;
                            web-share;
                        "
                        allowfullscreen
                    ></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
