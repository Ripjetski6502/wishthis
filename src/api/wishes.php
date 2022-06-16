<?php

/**
 * Wishes
 *
 * @category API
 */

namespace wishthis;

$api      = true;
$response = array(
    'success' => false,
);

ob_start();

require '../../index.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['wish_id'])) {
            $wish = new Wish($_GET['wish_id'], true);

            $response['info'] = $wish;

            if (isset($_GET['wishlist_user'])) {
                $response['html'] = $wish->getCard($_GET['wishlist_user']);
            }
        } elseif (isset($_GET['wish_url'])) {
            $url   = trim($_GET['wish_url']);
            $cache = new Cache\Embed($url);
            $info  = $cache->get(true);

            if (isset($info->url) && $info->url) {
                $code = URL::getResponseCode($info->url);

                if ($code < 200 || $code >= 400) {
                    $info->url = $url;
                }
            }

            $response = array(
                'info' => $info,
            );
        }
        break;

    case 'POST':
        if (isset($_POST['wishlist_id']) || isset($_POST['wish_id'])) {
            /**
             * Save wish
             */
            if (
                   empty($_POST['wish_title'])
                && empty($_POST['wish_description'])
                && empty($_POST['wish_url'])
            ) {
                break;
            }

            $wish_title          = trim($_POST['wish_title']);
            $wish_description    = trim($_POST['wish_description']);
            $wish_image          = 'NULL';
            $wish_url            = trim($_POST['wish_url']);
            $wish_priority       = isset($_POST['wish_priority']) && $_POST['wish_priority'] ? $_POST['wish_priority'] : 'NULL';
            $wish_is_purchasable = isset($_POST['wish_is_purchasable']) ? 'true' : 'false';

            if (isset($_POST['wish_id'], $_POST['wishlist_id'])) {
                /** Update wish */
                $wish = new Wish($_POST['wish_id']);

                /** Update wish information */
                if (!empty($wish_url)) {
                    $cache = new Cache\Embed($wish_url);
                    $info  = $cache->get(true);

                    if (empty($wish_title) && empty($wish->title)) {
                        $wish_title = $info->title;
                    }

                    if (empty($wish_description) && empty($wish->description)) {
                        $wish_description = $info->description;
                    }

                    /** Image */
                    if (!empty($info->image)) {
                        $codeImage = URL::getResponseCode($info->image);

                        if ($codeImage >= 200 && $codeImage < 400) {
                            $wish_image = '"' . $info->image . '"';
                        }
                    }

                    $response = array(
                        'info' => $info,
                    );
                }

                /** Update */
                $wish_title       = empty($wish_title)       ? 'NULL' : '"' . substr($wish_title, 0, 128) . '"';
                $wish_description = empty($wish_description) ? 'NULL' : '"' . $wish_description            . '"';
                $wish_url         = empty($wish_url)         ? 'NULL' : '"' . $wish_url                    . '"';

                $database
                ->query(
                    'UPDATE `wishes`
                        SET `wishlist`       = ' . $wish->wishlist      . ',
                            `title`          = ' . $wish_title          . ',
                            `description`    = ' . $wish_description    . ',
                            `image`          = ' . $wish_image          . ',
                            `url`            = ' . $wish_url            . ',
                            `priority`       = ' . $wish_priority       . ',
                            `is_purchasable` = ' . $wish_is_purchasable . '
                      WHERE `id`             = ' . $wish->id            . ';'
                );

                /**
                 * Product
                 */
                $wish_price = empty($_POST['wish_price']) || 'false' === $wish_is_purchasable
                            ? 'NULL'
                            : $_POST['wish_price'];

                $database
                ->query(
                    'REPLACE INTO `products`
                    (
                        `wish`,
                        `price`
                    ) VALUES (
                        ' . $wish->id   . ',
                        ' . $wish_price . '
                    );'
                );

                $response['lastInsertId'] = $wish->id;
            } elseif (isset($_POST['wishlist_id'])) {
                /** Insert wish */
                $wishlist_id = $_POST['wishlist_id'];

                /** Update wish information */
                if (!empty($wish_url)) {
                    $cache = new Cache\Embed($wish_url);
                    $info  = $cache->get(true);

                    if (empty($wish_title) && isset($info->title)) {
                        $wish_title = $info->title;
                    }

                    if (empty($wish_description) && isset($info->description)) {
                        $wish_description = $info->description;
                    }

                    /** Image */
                    if (!empty($info->image)) {
                        $codeImage = URL::getResponseCode($info->image);

                        if ($codeImage >= 200 && $codeImage < 400) {
                            $wish_image = '"' . $info->image . '"';
                        }
                    }

                    $response = array(
                        'info' => $info,
                    );
                }

                /** Update */
                $wish_title       = empty($wish_title)       ? 'NULL' : '"' . substr($wish_title, 0, 128) . '"';
                $wish_description = empty($wish_description) ? 'NULL' : '"' . $wish_description            . '"';
                $wish_url         = empty($wish_url)         ? 'NULL' : '"' . $wish_url                    . '"';

                $database
                ->query(
                    'INSERT INTO `wishes`
                    (
                        `wishlist`,
                        `title`,
                        `description`,
                        `image`,
                        `url`,
                        `priority`,
                        `is_purchasable`
                    ) VALUES (
                         ' . $wishlist_id         . ',
                         ' . $wish_title          . ',
                         ' . $wish_description    . ',
                         ' . $wish_image          . ',
                         ' . $wish_url            . ',
                         ' . $wish_priority       . ',
                         ' . $wish_is_purchasable . '
                    );'
                );

                /**
                 * Product
                 */
                $wish_id    = $database->lastInsertId();
                $wish_price = floatval($_POST['wish_price']);

                if ($wish_price > 0) {
                    $database
                    ->query(
                        'INSERT INTO `products`
                        (
                            `wish`,
                            `price`
                        ) VALUES (
                            ' . $wish_id    . ',
                            ' . $wish_price . '
                        );'
                    );
                }

                $response['lastInsertId'] = $wish_id;
            }
        }
        break;

    case 'PUT':
        parse_str(file_get_contents("php://input"), $_PUT);

        if (isset($_PUT['wish_id'], $_PUT['wish_status'])) {
            /**
             * Update Wish Status
             */
            $status = $_PUT['wish_status'];

            if (Wish::STATUS_TEMPORARY === $status) {
                $status = time();
            }

            $database->query(
                'UPDATE `wishes`
                    SET `status` = "' . $status . '"
                  WHERE `id`     = ' . $_PUT['wish_id'] . ';'
            );

            $response['success'] = true;
        } elseif (isset($_PUT['wish_url_current'], $_PUT['wish_url_proposed'])) {
            /**
             * Update Wish URL
             */
            $database->query(
                'UPDATE `wishes`
                    SET `url` = "' . $_PUT['wish_url_proposed'] . '"
                  WHERE `url` = "' . $_PUT['wish_url_current'] . '";'
            );

            $response['success'] = true;
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);

        if (isset($_DELETE['wish_id'])) {
            $database->query(
                'DELETE FROM `wishes`
                       WHERE `id` = ' . $_DELETE['wish_id'] . ';'
            );
        }

        $response['success'] = true;
        break;
}

$response['warning'] = ob_get_clean();

header('Content-type: application/json; charset=utf-8');
echo json_encode($response);
die();
