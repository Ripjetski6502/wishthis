<?php

/**
 * home.php
 *
 * @author Jay Trees <github.jay@grandel.anonaddy.me>
 */

namespace wishthis;

$page = new Page(__FILE__, __('Blog'));
$page->header();
$page->bodyStart();
$page->navigation();

$posts = Blog::getPosts();
?>

<main>
    <div class="ui container">
        <h1 class="ui header"><?= $page->title ?></h1>

        <?= $page->messages() ?>

        <div class="ui two column doubling stackable grid">
            <?php foreach ($posts as $post) { ?>
                <?php
                $dateFormatter  = new \IntlDateFormatter(
                    $user->locale,
                    \IntlDateFormatter::MEDIUM,
                    \IntlDateFormatter::NONE
                );
                $mediaHTML      = isset($post->featured_media) ? Blog::getMediaHTML($post->featured_media) : '';
                $categoriesHTML = Blog::getCategoriesHTML($post->categories);
                $postLink       = '/?page=post&slug=' . $post->slug;
                ?>
                <div class="column">
                    <div class="ui fluid card stretch">
                        <div class="image"><a href="<?= $postLink ?>"><?= $mediaHTML ?></a></div>
                        <div class="content">
                            <div class="header"><?= $post->title->rendered ?></div>
                            <div class="meta">
                                <a><?= $categoriesHTML ?></a>
                            </div>
                            <div class="description">
                                <?= $post->excerpt->rendered ?>
                                <p><a href="<?= $postLink ?>"><?= __('Read more') ?></a></p>
                            </div>
                        </div>
                        <div class="extra content">
                            <span class="right floated"><?= $dateFormatter->format(strtotime($post->date)) ?></span>
                            <!--
                            <span>
                                <i class="user icon"></i>
                                75 Friends
                            </span>
                            -->
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>

<?php
$page->footer();
$page->bodyEnd();
?>
