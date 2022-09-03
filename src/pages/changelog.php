<?php

/**
 * power.php
 *
 * @author Jay Trees <github.jay@grandel.anonaddy.me>
 */

namespace wishthis;

$page = new Page(__FILE__, __('Changelog'));
$page->header();
$page->bodyStart();
$page->navigation();
?>

<main>
    <div class="ui container">
        <h1 class="ui header"><?= $page->title ?></h1>

        <div class="ui stackable grid">

            <div class="four wide column">
                <div class="ui vertical pointing fluid menu profile">
                    <a class="item" data-tab="unreleased"><?= __('0.7.0') ?></a>
                    <a class="item" data-tab="0-6-0"><?= __('0.6.0') ?></a>
                </div>
            </div>

            <div class="twelve wide stretched column">
                <div class="ui tab" data-tab="unreleased">
                    <div class="ui segments">

                        <div class="ui segment">
                            <h2 class="ui header"><?= __('0.7.0') ?></h2>
                        </div>

                        <div class="ui segment">
                            <h3 class="ui header"><?= __('Added') ?></h3>
                            <ul>
                                <li><?= __('Blog') ?></li>
                                <li><?= __('Dark theme') ?></li>
                                <li><?= __('Wish products') ?></li>
                                <li><?= __('Jump to last edited wishlist from home') ?></li>
                                <li><?= __('Quick add wish from home') ?></li>
                                <li><?= __('Button to request more wishes from a users wishlist') ?></li>
                            </ul>

                            <h3 class="ui header"><?= __('Improved') ?></h3>
                            <ul>
                                <li><?= __('Localisation (many new translations added)') ?></li>
                                <li><?= __('Additional logins are no longer required when switching between wishthis channels') ?></li>
                                <li><?= __('Remembered wishlists design') ?></li>
                            </ul>

                            <h3 class="ui header"><?= __('Changed') ?></h3>
                            <ul>
                                <li><?= __('Changelog is now a page instead of a downloadable markdown file') ?></li>
                                <li><?= __('Wishes can be edited from the wishlist now, without loading another page') ?></li>
                                <li><?= __('"Saved wishlists" has been renamed to "Remember lists"') ?></li>
                            </ul>

                            <h3 class="ui header"><?= __('Fixed') ?></h3>
                            <ul>
                                <li><?= __('Various minor things (typos, menu order, etc)') ?></li>
                                <li><?= __('Wish information being updated with 404 content from URL') ?></li>
                                <li><?= __('Wish image not showing') ?></li>
                                <li><?= __('An error when saving a wish with a really long URL') ?></li>
                                <li><?= __('Redirect errors on Nginx') ?></li>
                                <li><?= __('An error when fetching title from an URL containing quotes') ?></li>
                            </ul>
                        </div>

                    </div>
                </div>

                <div class="ui tab" data-tab="0-6-0">
                    <div class="ui segments">

                        <div class="ui segment">
                            <h2 class="ui header"><?= __('0.6.0') ?></h2>
                        </div>

                        <div class="ui segment">
                            <h3 class="ui header"><?= __('Added') ?></h3>
                            <ul>
                                <li><?= __('This changelog') ?></li>
                                <li><?= __('Wish properties') ?></li>
                                <li><?= __('Button to mark wish as fulfilled') ?></li>
                            </ul>

                            <h3 class="ui header"><?= __('Improved') ?></h3>
                            <ul>
                                <li><?= __('Card design') ?></li>
                            </ul>

                            <h3 class="ui header"><?= __('Fixed') ?></h3>
                            <ul>
                                <li><?= __('Various small bugs') ?></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
</main>

<?php
$page->bodyEnd();
?>
