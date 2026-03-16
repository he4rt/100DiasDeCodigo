<?php

declare(strict_types=1);

namespace He4rt\Submission\Filament\App\Resources\Submissions\Actions;

use DutchCodingCompany\FilamentSocialite\Models\SocialiteUser;
use Filament\Actions\Action;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;
use He4rt\IntegrationTwitterApi\Endpoints\FindTweet\FindTweetRequest;
use He4rt\IntegrationTwitterApi\Endpoints\FindTweet\FindTweetResponse;
use He4rt\IntegrationTwitterApi\TwitterApiClient;
use He4rt\Submission\Enums\SubmissionStatus;
use He4rt\Submission\Models\Submission;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\HtmlString;

use function Illuminate\Support\minutes;

class NewSubmissionAction extends Action
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->name('new_submission');
        $this->label('Registrar Dia');
        $this->fillForm([]);
        $this->modalHeading(fn () => 'Registrar Dia '.(auth()->user()->total_days + 1));

        $this->schema([
            Wizard::make([
                Step::make('URL')
                    ->afterValidation($this->tweetValidation(...))
                    ->schema([
                        Grid::make()
                            ->schema([
                                Hidden::make('tweet_payload')->nullable(),
                                Fieldset::make('Checklist')
                                    ->columns(1)
                                    ->schema([
                                        TextInput::make('url')
                                            ->label('Link do Tweet')
                                            ->placeholder('https://x.com/seu_usuario/status/...')
                                            ->required()
                                            ->live(debounce: 500)
                                            ->regex('/^https?:\/\/(www\.)?(twitter\.com|x\.com)\/\w+\/status\/[0-9]{19}$/i')
                                            ->validationMessages([
                                                'regex' => 'URL inválida. Por favor, insira um link válido do Twitter/X.',
                                            ])
                                            ->helperText(new HtmlString('
                                                <ul class="list-disc list-inside text-xs text-gray-500 mt-2">
                                                    <li>Link válido do Twitter/X</li>
                                                    <li>Deve conter a hashtag #100DiasDeCodigo</li>
                                                </ul>
                                            ')),
                                        Checkbox::make('contains_hashtag')
                                            ->label('Tem Hashtag #100DiasDeCodigo')
                                            ->helperText('Declaro que adicionei a hashtag #100DiasDeCodigo no tweet')
                                            ->disabled()
                                            ->required(),
                                        Checkbox::make('contains_daily_count')
                                            ->label('Tem alguma contagem de dias')
                                            ->helperText('Algo como [1/100] ou Dia 1')
                                            ->disabled()
                                            ->required(),
                                    ]),
                                ViewField::make('preview')
                                    ->live()
                                    ->viewData(fn (Get $get) => ['submission' => $get('tweet_payload') ?? null])
                                    ->view('filament.components.submission-preview'),
                            ]),
                    ]),
                Step::make('Checklist')
                    ->schema([
                        Fieldset::make('Checklist')
                            ->columns(1)
                            ->schema([
                                Checkbox::make('study')
                                    ->label('Estudei por pelo menos 1 hora')
                                    ->helperText('Dediquei tempo focado ao aprendizado')
                                    ->rules(['required', 'boolean:strict'])
                                    ->accepted()
                                    ->required(),
                                Checkbox::make('practice')
                                    ->label('Pratiquei código')
                                    ->helperText('Escrevi código ou resolvi exercícios')
                                    ->accepted()
                                    ->required(),
                                Checkbox::make('document')
                                    ->label('Documentei meu progresso')
                                    ->helperText('Anotei o que aprendi e fiz')
                                    ->accepted()
                                    ->required(),
                                Checkbox::make('review')
                                    ->label('Revisei o aprendizado')
                                    ->helperText('Refleti sobre os conceitos estudados')
                                    ->accepted()
                                    ->required(),
                                Checkbox::make('interact')
                                    ->label('Interagi com outros membros da comunidade')
                                    ->helperText('Fui na hashtag #100DiasDeCodigo ver o progresso dos outros')
                                    ->accepted()
                                    ->required(),
                                Checkbox::make('publish')
                                    ->label('Publiquei meu resultado')
                                    ->helperText('Compartilhei nas redes sociais')
                                    ->accepted()
                                    ->required(),
                            ]),
                    ]),

            ])
                ->submitAction(new HtmlString('<button type="submit" class="fi-btn fi-btn-size-md fi-btn-color-primary relative grid-flow-col items-center justify-center gap-1.5 rounded-lg border border-transparent bg-primary-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition duration-75 hover:bg-primary-500 focus:ring-2 focus:ring-primary-600 focus:ring-offset-2 dark:bg-primary-500 dark:hover:bg-primary-400 dark:focus:ring-offset-0">Confirmar Submissão</button>')),
        ]);

        $this->modalFooterActions([]);

        $this->action(function (array $data): void {
            $tweet = TweetDTO::fromArray($data['tweet_payload']);
            auth()->user()->submissions()
                ->create([
                    'submitted_at' => Date::parse($tweet->createdAt)->timezone(config('app.timezone')),
                    'content' => $tweet->getFormattedText(),
                    'tweet_id' => $tweet->id,
                    'status' => SubmissionStatus::Pending,
                    'metadata' => $tweet->jsonSerialize(),
                ]);

            Notification::make()
                ->title('Dia Registrado!')
                ->body('Excelente trabalho! Continue assim e você vai completar os 100 dias em breve.')
                ->success()
                ->send();
        });
    }

    public static function getDefaultName(): ?string
    {
        return 'new-submission-action';
    }

    public function tweetValidation(Get $get, Set $set): void
    {

        $tweetId = str($get('url'))->afterLast('/')->beforeLast('/')->toString();

        $alreadySubmitted = Submission::query()->where('tweet_id', $tweetId)->exists();

        if ($alreadySubmitted) {
            Notification::make()
                ->title('Submissão já realizada')
                ->body('Essa submissão já foi realizada. Por favor, tente novamente com outro tweet.')
                ->danger()
                ->send();
            $this->halt();
        }

        $userId = auth()->id();
        $cacheKey = 'tweet_response_'.$tweetId;
        $rateLimitKey = sprintf('submission_rate_limit_%s_', $userId).now()->format('Y-m-d');

        $validations = $get('contains_hashtag') && $get('contains_daily_count');

        if (!$validations) {

            $attempts = (int) cache()->get($rateLimitKey, 0);

            if ($attempts >= 3) {
                Notification::make()
                    ->title('Limite de requisições excedido')
                    ->body('Você atingiu o limite de 3 verificações de tweets por dia. Por favor, tente novamente amanhã.')
                    ->danger()
                    ->send();

                $this->halt();
            }

            // he will get blocked if he tries to validate more than 3 times in a day

            cache()->put($rateLimitKey, $attempts + 1, now()->endOfDay());

            /** @var FindTweetResponse $response */
            $response = cache()->flexible($cacheKey, [minutes(5), minutes(10)], fn () => resolve(TwitterApiClient::class)
                ->findTweets(FindTweetRequest::fromId($tweetId)));

            if ($response->empty()) {
                $this->halt();
            }

            $tweet = $response->getFirstTweet();
            $set('tweet_payload', $tweet->jsonSerialize());

            $tweetOwnership = SocialiteUser::query()
                ->where('user_id', auth()->id())
                ->where('provider_id', $tweet->author->id)
                ->exists();
            if (!$tweetOwnership) {
                Notification::make()
                    ->title('Para com essa porra')
                    ->body('Coloca um tweet q seja da sua conta pelo amor de deus.')
                    ->danger()
                    ->send();
            }

            $tweet->entities->containsHashtag('#100diasdecodigo') ? $set('contains_hashtag', true) : $set('contains_hashtag', false);
            $tweet->getDailyCount() ? $set('contains_daily_count', true) : $set('contains_daily_count', false);

            $this->halt();
        }
    }
}
