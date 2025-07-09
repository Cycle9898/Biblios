# Biblios

Biblios is a Symfony application that is used to manage a fictional media library.

Visitors can view the books list, read their details, see if they are available and post comments on them.

This website handle users authentication with different roles.

There is an admin panel to manage books, authors, editors, comments and users.

All data are stored in a PostgreSQL database.

Tailwind CSS is used for styling.

The main goal was to learn how the Symfony framework works.

## Getting Started

### Prerequisites

This project uses the following tech stack:

-   [PHP](https://www.php.net/downloads)

-   [Composer](https://getcomposer.org/)

-   [Symfony](https://symfony.com/) with its CLI

-   [PostgreSQL](https://www.postgresql.org/) for local PostgreSQL database but you can use a cloud hosted one

### Instructions

1. Create the database locally or online
2. Clone the repo onto your computer
3. Open a terminal in the project folder
4. Install dependencies with composer: `composer install`
5. Create .env.local file and set the "DATABASE_URL" env variable with a database url.
6. Start the project with this command:

```bash
# Start local dev server
symfony server:start
```

Open [http://localhost:8000](http://localhost:8000) in a browser to test the web app.
