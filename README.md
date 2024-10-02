[![Codacy Badge](https://app.codacy.com/project/badge/Grade/59aade04c3474f2abee3b94f237d0a40)](https://app.codacy.com/gh/AurelienLab/daps-p7-bilemo/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

# Bilemo API

Bilemo is a company that sells high quality mobile phones. This project is a webservice that exposes an API which aims
to manage available phones and save data about customer's users.

## Installation

Follow these steps to install and set up the project on your local machine.

### Prerequisites

- PHP 8.3 or higher
- Composer
- Symfony CLI (optional to serve the project)
- Node.js and Yarn

### Clone the Repository

First, clone the repository to your local machine:

```
git clone git@github.com:AurelienLab/daps-p7-bilemo.git bilemo
cd bilemo
```

### Install PHP Dependencies

Use Composer to install the required PHP dependencies:

```
composer install
```

### Set Up Environment Variables

Copy `.env` to `.env.local` file at the root of your project and configure your environment variables, especially
database vars and `JWT_PASSPHRASE`

### Database Migration

Run the following command to create the database schema:

```
php bin/console doctrine:migrations:migrate
```

### Databse seed

You can prepopulate the database with categories, tricks and users:

```
php bin/console doctrine:fixtures:load
```

### Default credentials

| login            | password     | role          |
|------------------|--------------|---------------|
| admin@bilemo.com | BMadmin2k24# | Administrator |
| user@bilemo.com  | BMuser2k24#  | User          |

### Generate JWT key pair

For JWT generation (auth) and verification, you need a pair of public and private keys. Generate them with the following
commande (dont forget to fill the `JWT_PASSPHRASE` env var before)

```
php bin/console lexik:jwt:generate-keypair
```

### Start the Server (optional)

Finally, start the Symfony server:

```
symfony serve
```

Your application should now be running at `http://127.0.0.1:8000`.