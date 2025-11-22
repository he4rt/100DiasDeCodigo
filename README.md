# 100 Dias de Código 🚀

Welcome to the **100 Dias de Código** platform! This project is designed to support the #100DaysOfCode challenge, providing a dedicated space for developers to track their progress, log daily submissions, and maintain their coding streaks.

## 🛠️ Tech Stack

This project is built with the latest and greatest in the Laravel ecosystem:

- **Framework**: [Laravel 12](https://laravel.com)
- **Admin Panel**: [Filament v4](https://filamentphp.com)
- **Frontend**: [Livewire v3](https://livewire.laravel.com) & [Tailwind CSS v4](https://tailwindcss.com)
- **Database**: SQLite (Default) / PostgreSQL Ready
- **Testing**: [Pest v4](https://pestphp.com)
- **Architecture**: Modular (using `internachi/modular`)

## 📦 Modules

The application is structured into domain-driven modules located in `app-modules/`:

- **User**: Manages user profiles, authentication, and dashboard stats.
- **Submission**: Handles daily coding logs, streak calculations, and tweet integrations.
- **Portal**: Core portal functionality.
- **Core**: Shared utilities and base configurations.

## ✨ Features

- **Dashboard**: Real-time tracking of your #100DaysOfCode journey.
    - **Progress Bar**: Visual representation of days completed (e.g., 32/100).
    - **Streak Counter**: Tracks consecutive days of coding. Invalidates if you miss 5+ days.
- **Daily Submissions**:
    - Log your daily progress with a description and tweet URL.
    - Smart validation to prevent duplicate daily submissions.
    - "Vendor Killer" integration for managing project cleanup.
- **Community Timeline**: See what others are building and learning.

## 🚀 Getting Started

### Prerequisites

- PHP 8.4+
- Composer
- Node.js & NPM

### Installation

1.  **Clone the repository**

    ```bash
    git clone https://github.com/he4rt/100daysofcode-l.git
    cd 100daysofcode-l
    ```

2.  **Setup the project**

    We have a handy setup script that installs dependencies, generates keys, and links storage:

    ```bash
    composer run setup
    ```

3.  **Start the development server**

    This command runs the Laravel server, queue worker, logs, and Vite dev server concurrently:

    ```bash
    composer run dev
    ```

    Access the application at `http://localhost:8000`.

## 🧪 Testing & Code Quality

We use a suite of tools to ensure code quality. You can run them all with a single command:

```bash
composer run check
```

This runs:

- **Rector**: For automated refactoring.
- **Pint**: For code style formatting.
- **PHPStan**: For static analysis.

To run the test suite (Pest):

```bash
composer run test
```

## 🤝 Contributing

Contributions are welcome! Please check out the `app-modules/` directory to understand the modular structure before making changes.

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
