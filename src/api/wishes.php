<?php

/**
 * wishes.php
 *
 * @author Jay Trees <github.jay@grandel.anonaddy.me>
 */

namespace wishthis;

$api      = true;
$response = array();

ob_start();

require '../../index.php';

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        if (isset($_GET['wish_id'])) {
            $columns = $database
            ->query(
                'SELECT *
                   FROM `wishes`
                  WHERE `id` = ' . $_GET['wish_id'] . ';'
            )
            ->fetch();

            $wish = new Wish($columns, true);

            $response['info'] = $wish;

            if (isset($_GET['wishlist_user'])) {
                $response['html'] = $wish->getCard($_GET['wishlist_user']);
            }
        } elseif (isset($_GET['wish_url'])) {
            $cache = new Cache\Embed($_GET['wish_url']);
            $info  = $cache->get(true);

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
            $wish_url            = trim($_POST['wish_url']);
            $wish_priority       = isset($_POST['wish_priority']) && $_POST['wish_priority'] ? $_POST['wish_priority'] : 'NULL';
            $wish_is_purchasable = isset($_POST['wish_is_purchasable']) ? 'true' : 'false';

            if (isset($_POST['wish_id'], $_POST['wishlist_id'])) {
                /** Update wish */
                $wish_id     = $_POST['wish_id'];
                $wishlist_id = $_POST['wishlist_id'];

                /** Update wish information */
                if (!empty($wish_url)) {
                    $cache = new Cache\Embed($wish_url);
                    $info  = $cache->get(true);

                    if (empty($wish_title)) {
                        $wish_title = $info->title;
                    }

                    if (empty($wish_description)) {
                        $wish_description = $info->description;
                    }

                    $wish_image = is_null($info->image) ? 'NULL' : "' . $info->image . '";

                    $response = array(
                        'info' => $info,
                    );
                }

                $database
                ->query(
                    'REPLACE INTO `wishes`
                    (
                        `id`,
                        `wishlist`,
                        `title`,
                        `description`,
                        `image`,
                        `url`,
                        `priority`,
                        `is_purchasable`
                    ) VALUES (
                         ' . $wish_id      . ',
                         ' . $wishlist_id         . ',
                        "' . $wish_title          . '",
                        "' . $wish_description    . '",
                         ' . $wish_image          . ',
                        "' . $wish_url            . '",
                         ' . $wish_priority       . ',
                         ' . $wish_is_purchasable . '
                    );'
                );
            } elseif (isset($_POST['wishlist_id'])) {
                /** Insert wish */
                $wishlist_id = $_POST['wishlist_id'];

                $database
                ->query(
                    'INSERT INTO `wishes`
                    (
                        `wishlist`,
                        `title`,
                        `description`,
                        `url`,
                        `priority`,
                        `is_purchasable`
                    ) VALUES (
                         ' . $wishlist_id         . ',
                        "' . $wish_title          . '",
                        "' . $wish_description    . '",
                        "' . $wish_url            . '",
                         ' . $wish_priority       . ',
                         ' . $wish_is_purchasable . '
                    );'
                );
            }

            $response['data'] = array(
                'lastInsertId' => $database->lastInsertId(),
            );
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

            $database->query('UPDATE `wishes`
                                 SET `status` = "' . $status . '"
                               WHERE `id`     = ' . $_PUT['wish_id'] . '
            ;');

            $response['success'] = true;
        } elseif (isset($_PUT['wish_url_current'], $_PUT['wish_url_proposed'])) {
            /**
             * Update Wish URL
             */
            $database->query('UPDATE `wishes`
                                 SET `url` = "' . $_PUT['wish_url_proposed'] . '"
                               WHERE `url` = "' . $_PUT['wish_url_current'] . '"
            ;');

            $response['success'] = true;
        }
        break;

    case 'DELETE':
        parse_str(file_get_contents("php://input"), $_DELETE);

        if (isset($_DELETE['wish_id'])) {
            $database->query('DELETE FROM `wishes`
                                    WHERE `id` = ' . $_DELETE['wish_id'] . '
            ;');
        }

        $response['success'] = true;
        break;
}

$response['warning'] = ob_get_clean();

header('Content-type: application/json; charset=utf-8');
echo json_encode($response);
die();
