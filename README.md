# Presentation

Symfony is a framework that represents a set of standalone PHP components (also referred to as libraries) that can be used in private or open-source web projects.

## Installation
After git clone, go in the project with this command :
```bash
cd "name of the directory"
```
When you are in the directory, run this command :
```bash
composer install
```
You have to create ad file named ".env" in the root of the project.

This file will etablish the connection with the database.

Put this in your file and put your username, your password and the name of the database :
```
# In all environments, the following files are loaded if they exist,
# the latter taking precedence over the former:
#
#  * .env                contains default values for the environment variables needed by the app
#  * .env.local          uncommitted file with local overrides
#  * .env.$APP_ENV       committed environment-specific defaults
#  * .env.$APP_ENV.local uncommitted environment-specific overrides
#
# Real environment variables win over .env files.
#
# DO NOT DEFINE PRODUCTION SECRETS IN THIS FILE NOR IN ANY OTHER COMMITTED FILES.
# https://symfony.com/doc/current/configuration/secrets.html
#
# Run "composer dump-env prod" to compile .env files for production use (requires symfony/flex >=1.2).
# https://symfony.com/doc/current/best_practices.html#use-environment-variables-for-infrastructure-configuration

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=d0c7ace948078877f7522f40bd2057f5
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
# DATABASE_URL="mysql://username:password@127.0.0.1:3306/databaseName?serverVersion=8.0.32&charset=utf8mb4"
# DATABASE_URL="mysql://username:password@127.0.0.1:3306/databaseName?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
# DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=15&charset=utf8"
###< doctrine/doctrine-bundle ###

###> symfony/messenger ###
# Choose one of the transports below
# MESSENGER_TRANSPORT_DSN=amqp://guest:guest@localhost:5672/%2f/messages
# MESSENGER_TRANSPORT_DSN=redis://localhost:6379/messages
MESSENGER_TRANSPORT_DSN=doctrine://default?auto_setup=0
###< symfony/messenger ###

###> symfony/mailer ###
# MAILER_DSN=null://null
###< symfony/mailer ###

###> nelmio/cors-bundle ###
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
###< nelmio/cors-bundle ###
```

After that, you have to run some commands to set up the database : 
```
php bin/console doctrine:database:create

php bin/console doctrine:migration:migrate
# Answer yes

php bin/console doctrine:fixtures:load -n
```
After that, you can test the website
## Usage

To test the website, you have to run this command :
```
symfony server:start
```
Click on the link and let's test the website
### User
Firstly, you are on the home page, you can see all the advertisements.

You can click on the green button and more details will be displayed with another button to postulate on this offer.

When you click on this button, a form is display and you have to fill the fields to postulate to this advertisement

At the left of the home page, you have a research bar. With this bar, you can make a research by the title of the advertisements. If you want to reset the result, you must make a research with nothing in the field.

On the top-right of the page, you can log in or sign up.

Sign up and try to log in with your identifiers.

When you are logged in, the form to postulate ask you only the request message, also, you can see you profile and modify your personnal informations.

### HR (RH or Human ressources)
Now, try to log out and make a connection with an user with the HR role.

For that, try to log in with the email : "qinhao.wu@gmail.com" and the password : "123456"

When you are logged in with an HR role, you can post a advertisement when clicking on the red button on the top-right of the page.

When clicked, you must fill the fields and when you submit, go back on the home page and the advertisement should be displayed on the first place.

### Admin
Log out again ant make a connection with the admin role.

For that, try to log in with the email : "admin@admin.com" and the password : "123456"

When you are logged in with the admin role, click on the red button on top-right of the page and you will be on a dashboard page and you can do some actions about the tables of the database like the crud (Create Read Update Delete) actions.
