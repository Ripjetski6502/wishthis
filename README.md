![wishthis logo](/src/assets/img/logo-readme.svg?v=2 "wishthis logo")

# Make a wish

wishthis is a simple, intuitive and modern wishlist platform to create, manage and view your wishes for any kind of occasion ([demo](https://wishthis.online)). Currently, wishthis is available in **99** different locales!

## :desktop_computer: Screenshots

| Home                                                 | Wishlists                                                           |
| ---------------------------------------------------- | ------------------------------------------------------------------- |
| ![Home](/src/assets/img/screenshots/home.png "Home") | ![Wishlists](/src/assets/img/screenshots/wishlists.png "Wishlists") |

## :family_man_man_boy: Join the conversation

[![Discord](https://img.shields.io/discord/935867122729496616?color=6435c9&label=Discord&logo=discord&logoColor=%23fff&style=for-the-badge)](https://discord.gg/WrUXnpNyza)
[![Matrix](https://img.shields.io/matrix/wishthis:matrix.org?color=6435c9&label=Matrix&logo=matrix&logoColor=%23fff&style=for-the-badge)](https://matrix.to/#/#wishthis:matrix.org)

## :heavy_check_mark: Requirements

-   Apache or Nginx
-   PHP 8.1
    -   [intl](https://www.php.net/manual/en/book.intl.php)
-   [MJML](https://mjml.io/api) api keys

## :hammer: Installation

### Git (recommended)

```
git clone -b stable https://github.com/grandeljay/wishthis.git .
```

Note: after pulling updates for a new version you might be prompted to update the database schema in the wishthis user interface (if necessary). Make sure you are logged in.

### Manual

Download the code using the [stable branch](https://github.com/grandeljay/wishthis/tree/stable) and upload it to your server.

Note: You will have to manually update wishthis by replacing all files with the changes from the `stable` branch.

## :trophy: Contributing

### As a tester

In the wishthis plattform, navigate to:

1. Account -> Profile
1. Preferences

And set your channel to "Release candidate". Make sure to give feedback!

### As a translator

Localisation is currently done via Transifex.

https://www.transifex.com/wishthis/wishthis/

### As a sponsor

Time spent on wishthis is time not doing for-profit work. Of course there is no expectation but if you would still like to show your appreciation, you can here. It is very appreciated!

[![GitHub Sponsors](https://img.shields.io/github/sponsors/grandeljay?color=6435c9&logo=githubsponsors&logoColor=fff&style=for-the-badge)](https://github.com/sponsors/grandeljay)

### As a developer

Install dependencies

#### Composer

Use one of the following commands.

| Command                     | Description                         |
| --------------------------- | ----------------------------------- |
| `composer install`          | Install all dependencies.           |
| `composer install --no-dev` | Install only required dependencies. |

#### Yarn

Use one of the following commands.

| Command        | Description               |
| -------------- | ------------------------- |
| `yarn install` | Install all dependencies. |

#### Updating fomantic-ui

To update fomantic-ui run the following commands

```
yarn upgrade
cd node_modules/fomantic-ui
npx gulp install
npx gulp build
```

or as a one-liner

```
yarn upgrade fomantic-ui && cd node_modules/fomantic-ui && npx gulp install && npx gulp build && cd ../..
```

#### Theme changes

```
cd semantic
```

And then one of the following commands:

-   `gulp build`
-   `gulp watch`

For more information see: https://fomantic-ui.com/introduction/build-tools.html

#### Code style

| Language | Style                       |
| -------- | --------------------------- |
| PHP      | Custom (PSR-12 + WordPress) |

## :construction: Roadmap

| Item                                                | Status              |
| --------------------------------------------------- | ------------------- |
| Add "or similar" option to wishes                   | Planned             |
| Combined/separate (and/or) wishes                   | Planned             |
| Group wishes by store                               | Planned             |
| Option to show/notify when a wish was fulfilled     | Planned             |
| Redirect to original target after login             | Planned             |
| Activity feed and friends                           | Under consideration |
| Browser extension to quickly create wishes from url | Under consideration |
| Bulk add wishes via link list                       | Under consideration |
| Folders / Subcategories for wishlists               | Under consideration |
| Synchronise Steam wishlist                          | Under consideration |
