<section
    x-ref="section"
    class="container mx-auto max-w-7xl px-4 py-8"
    x-init="
        $watch('search', (newValue, oldValue) => {
            if (newValue !== oldValue) {
                currentPage = 1
            }
        })
        $watch('[selectedSort]', () => {
            currentPage = 1
        })
    "
    x-data="{
        search: '',
        selectedSort: 'Progress',
        participants: @js($participants),

        _currentPage: $queryString(1).usePush().as('page'),
        get currentPage() {
            return +this._currentPage
        },

        set currentPage(value) {
            this._currentPage = value
            this.$nextTick(() => {
                this.$refs.section.scrollIntoView({ behavior: 'smooth' })
            })
        },

        _viewMode: $queryString('grid').usePush().as('viewMode'),
        get viewMode() {
            return this._viewMode
        },

        set viewMode(value) {
            this._viewMode = value
            this.$nextTick(() => {
                this.$refs.section.scrollIntoView({ behavior: 'smooth' })
            })
        },

        perPage: 24,
        totalItems: 0,
        get totalPages() {
            return Math.ceil(this.totalItems / this.perPage)
        },

        get filteredParticipants() {
            let filteredParticipants = this.participants

            const sortMap = {
                'Progress': (p) => p.total_days,
                'Streak': (p) => p.current_streak,
                'Likes': (p) => p.twitter_metrics.likes_raw,
                'Views': (p) => p.twitter_metrics.views_raw,
            }

            filteredParticipants = filteredParticipants
                .slice()
                .sort(
                    (a, b) =>
                        sortMap[this.selectedSort](b) -
                        sortMap[this.selectedSort](a),
                )

            if (this.search) {
                const term = this.search.toLowerCase()

                filteredParticipants = filteredParticipants.filter(
                    (i) =>
                        i.username?.toLowerCase().includes(term) ||
                        i.name?.toLowerCase().includes(term),
                )
            }

            this.totalItems = filteredParticipants.length
            filteredParticipants = filteredParticipants.slice(
                (this.currentPage - 1) * this.perPage,
                this.currentPage * this.perPage,
            )

            return filteredParticipants
        },
    }"
>
    <div class="flex flex-col gap-8 lg:flex-row">
        <main class="min-w-0 flex-1">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row">
                <div class="relative flex-1">
                    <x-filament::icon
                        icon="heroicon-o-magnifying-glass"
                        class="lucide lucide-search text-muted-foreground text-primary absolute top-1/2 left-3 me-2 h-4 w-4 -translate-y-1/2"
                        x-on::click=""
                    />
                    <input
                        x-model="search"
                        data-slot="input"
                        class="bg-primary/1 text-foreground placeholder:text-muted-foreground focus:ring-primary/40 focus:border-ring dark:bg-input/30 h-9 w-full rounded-md border border-gray-200 px-3 pl-10 text-sm focus:ring-2 focus:outline-none disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700"
                        placeholder="Busque por nome ou username..."
                        value=""
                    />
                </div>
                <div class="flex items-center gap-2">
                    <div
                        class="flex flex-row items-center justify-center gap-1 rounded-md border border-gray-200 bg-white px-3 py-2 text-sm dark:border-gray-700 dark:bg-gray-800"
                    >
                        <x-filament::icon icon="heroicon-o-arrows-up-down" class="me-2 h-4 w-4" x-on::click="" />
                        <select class="border-0 bg-white text-sm outline-0 dark:bg-gray-800" x-model="selectedSort">
                            <option>Progress</option>
                            <option>Streak</option>
                            <option>Likes</option>
                            <option>Views</option>
                        </select>
                    </div>

                    <div
                        class="hidden items-center rounded-lg border border-gray-200 bg-white p-1 sm:flex dark:border-gray-700 dark:bg-gray-800"
                    >
                        <button
                            x-on:click="
                                viewMode = 'grid';
                            "
                            class="rounded px-2 py-1"
                            :class="{
                                'text-white bg-primary': viewMode === 'grid'
                            }"
                        >
                            <x-filament::icon icon="heroicon-s-table-cells" class="h-4 w-4 text-white" />
                        </button>
                        <button
                            x-on:click="
                                viewMode = 'list';
                            "
                            class="rounded px-2 py-1"
                            :class="{
                                'text-white bg-primary': viewMode === 'list'
                            }"
                        >
                            <x-filament::icon icon="heroicon-o-list-bullet" class="h-4 w-4 text-white" />
                        </button>
                    </div>
                </div>
            </div>

            <div class="mb-4 flex items-center justify-between">
                <div x-show="filteredParticipants.length" class="text- mr-auto text-sm">
                    Mostrando
                    <span class="font-extrabold" x-text="(currentPage - 1) * perPage + 1"></span>
                    até
                    <span class="font-extrabold" x-text="Math.min(currentPage * perPage, totalItems)"></span>
                    de
                    <span class="font-extrabold" x-text="totalItems"></span>
                    resultados
                </div>
            </div>

            <div
                x-ref="participantCardsWrapper"
                x-init="autoAnimate($refs.participantCardsWrapper)"
                :class="{
                    'grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4': viewMode === 'grid',
                    'flex flex-col gap-2': viewMode === 'list'
                }"
            >
                <template x-for="participant in filteredParticipants" :key="participant.username">
                    <x-portal::participants.participant-card x-bind:data-view-mode="viewMode" />
                </template>
            </div>
            <div class="flex items-center justify-end px-1 pt-7">
                <x-he4rt::pagination />
            </div>
        </main>
    </div>
</section>
