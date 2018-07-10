Pimcore System Migrations Bundle
================================

This bundle allows to run system database migrations independent from the
Pimcore 5 code updates. This is particulary usefull when you do a full update
in a development environment and have to just replay the database migrations on
your other environments like staging and production.

## The problem

Pimcore 5 allows you to update your installation via commandline or via the
admin web interface. *But* these updates are both code and database migrations.
So in the case that you are doing your update in a development environment to
prepare everything for the next update in staging and production these steps
are not reproducable. The code will be updated due to a deploy on your other
environment, but the database migrations will not be there, potentially causing
all sorts of issues and/or unexpected behaviour.

## Installation

``` sh
$ composer require studioemma/system-migrations-bundle:"*"
$ php bin/console pimcore:bundle:enable StudioEmmaSystemMigrationsBundle
$ php bin/console pimcore:bundle:install StudioEmmaSystemMigrationsBundle
```

This will create an extra table `plugin_se_system_migrations` where the build
and updatedate are tracked. Initially after install it will contain 1 record
containing the current Pimcore 5 build number and the date of installation.

## Usage

``` sh
$ php bin/console studioemma:systemmigrations:update
```

Running this will determine based on the `plugin_se_system_migrations` table
and the build number found in `Version.php` what must be done. It will upgrade
the database or downgrade the database - if possible - to the schema version
associated with the current version of your Pimcore 5 code.

When you install this plugin in an existing installation you can also
re-initialize the `plugin_se_system_migrations` table - say you have installed
this plugin in dev, but prod is not yet updated.

``` sh
$ php bin/console studioemma:systemmigrations:init --buildnumber 202
```

This command will reset the `plugin_se_system_migrations` table and insert only
one record with the chosen buildnumber and the current date.

## Versioning

Since the easiest and most comprehensible way of versioning was to take the
major version as the pimcore build number we do not follow semver. If you want
to be able to fully use this bundle you should use the latest version. It is
limited to Pimcore 5. If there is a Pimcore 6 release this bundle could be
updated or become obsolete.

## License

GPLv3. See [License file](LICENSE) for more information
