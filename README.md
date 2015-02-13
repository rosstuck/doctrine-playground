# Welcome!

This repository is meant to be a quick, simple way to test out some Doctrine
code samples. It's not meant to be an example of how to use Doctrine production
but if you're just finding your way or testing out some crazy idea, it might be
just what you're looking for.

## Setup
1. Clone this repo: `git clone git@github.com:rosstuck/doctrine-playground.git`
2. Install the dependencies: `composer install`
3. Copy `config/copy.yml.dist` to `config/config.yml` and fill in your database details.
4. Write your test code in run.php and execute it with `php run.php`

You can also add your own sample code in the src directory. Doctrine is setup
to scan all files in the directory for annotations, which isn't ideal for a
production environment but makes it really easy to test here.
