<?php

/**
 * The home page.
 *
 * @author Jay Trees <github.jay@grandel.anonaddy.me>
 */

namespace wishthis;

$page = new Page(__FILE__, __('Home'));
$page->header();
$page->bodyStart();
$page->navigation();
?>

<main>
    <div class="ui container">
        <h1 class="ui header"><?= $page->title ?></h1>

        <div class="ui doubling stackable grid">
            <div class="twelve wide column">
                <div class="ui segment">
                    <h2 class="ui header"><?= __('Make a wish') ?></h2>

                    <p><?= __('wishthis is a simple, intuitive and modern wishlist platform to create, manage and view your wishes for any kind of occasion.') ?></p>

                    <div class="ui two column doubling stackable centered grid">
                        <?php if ($user->isLoggedIn()) { ?>
                            <div class="column">
                                <a class="ui fluid primary button"
                                href="<?= Page::PAGE_WISHLISTS ?>"
                                title="<?= __('My lists') ?>"
                                >
                                    <?= __('My lists') ?>
                                </a>
                            </div>
                        <?php } else { ?>
                            <div class="column">
                                <a class="ui fluid primary button"
                                href="<?= Page::PAGE_REGISTER ?>"
                                title="<?= __('Register now') ?>"
                                >
                                    <?= __('Register now') ?>
                                </a>
                            </div>
                            <div class="column">
                                <a class="ui fluid button"
                                href="<?= Page::PAGE_LOGIN ?>"
                                title="<?= __('Login') ?>"
                                >
                                    <?= __('Login') ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="ui segment">
                    <h2 class="ui header"><?= __('Use case') ?></h2>

                    <p><?= __('Your birthday is coming up and you just created a wishlist with all the cool stuff you want. Your friends and family want to make sure you get something you are happy with so you send them your wishlist link and if anybody decides to fulfil one of your wishes, it will disappear for everybody else.') ?></p>
                </div>

                <div class="ui segment">
                    <h2 class="ui header"><?= __('Why wishthis?') ?></h2>

                    <p><?= sprintf(
                        __('wishthis is free and open source software. With free I don\'t just mean, you don\'t have to pay money to use it, but you are also not paying with your personal information and behaviour. Not only can anybody %sview and verify its code%s, I also encourage you to do so.'), '<a href="https://github.com/grandeljay/wishthis" title="wishthis source code" target="_blank">', '</a>'
                    ) ?></p>

                    <p><?= __('As a non-commercial project it remains') ?></p>
                    <ul class="ui list">
                        <li class="item">
                            <i class="green check icon" aria-hidden="true"></i>
                            <div class="content"><?= __('free of advertisements,') ?></div>
                        </li>
                        <li class="item">
                            <i class="green check icon" aria-hidden="true"></i>
                            <div class="content"><?= __('without tracking, and') ?></div>
                        </li>
                        <li class="item">
                            <i class="green check icon" aria-hidden="true"></i>
                            <div class="content"><?= __('open for feedback and suggestions.') ?></div>
                        </li>
                    </ul>
                </div>

                <div class="ui segment">
                    <h2 class="ui header"><?= __('News') ?></h2>

                    <div class="ui relaxed divided list news">

                        <div class="item">
                            <i class="large rss middle aligned icon"></i>
                            <div class="content">
                                <div class="ui placeholder">
                                    <div class="paragraph">
                                        <div class="full line"></div>
                                        <div class="long line"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <i class="large rss middle aligned icon"></i>
                            <div class="content">
                                <div class="ui placeholder">
                                    <div class="paragraph">
                                        <div class="short line"></div>
                                        <div class="very short line"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <i class="large rss middle aligned icon"></i>
                            <div class="content">
                                <div class="ui placeholder">
                                    <div class="paragraph">
                                        <div class="medium line"></div>
                                        <div class="very long line"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="four wide column">

                <div class="ui segment">
                    <h2 class="ui header"><?= __('Statistics') ?></h2>

                    <p><?= __('Join the others and get started now!') ?></p>

                    <div class="ui stackable statistics">

                        <div class="statistic" id="wishes">
                            <div class="value"><?= __('N. A.') ?></div>
                            <div class="label"><?= __('Wishes') ?></div>
                        </div>

                        <div class="statistic" id="wishlists">
                            <div class="value"><?= __('N. A.') ?></div>
                            <div class="label"><?= __('Wishlists') ?></div>
                        </div>

                        <div class="statistic" id="users">
                            <div class="value"><?= __('N. A.') ?></div>
                            <div class="label"><?= __('Registered users') ?></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>

<?php
$page->bodyEnd();
