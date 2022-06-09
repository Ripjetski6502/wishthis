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
        if (isset($_GET['wish_id'], $_GET['wishlist_user'])) {
            $columns = $database
            ->query('SELECT *
                       FROM `wishes`
                      WHERE `id` = ' . $_GET['wish_id'] . ';')
            ->fetch();

            $wish = new Wish($columns, true);

            $response = array(
                'info' => $wish,
                'html' => $wish->getCard($_GET['wishlist_user'])
            );
        } elseif (isset($_GET['wish_url'])) {
            $cache  = new Cache\Embed($_GET['wish_url']);
            $info   = $cache->get(true);
            $exists = $cache->exists() ? 'true' : 'false';

            $response = array(
                'info' => $info,
            );
        }
        break;

    case 'POST':
        if (isset($_POST['wishlist_id'])) {
            /**
             * Insert New Wish
             */
            if (
                   empty($_POST['wish_title'])
                && empty($_POST['wish_description'])
                && empty($_POST['wish_url'])
            ) {
                break;
            }

            $wishlist_id      = $_POST['wishlist_id'];
            $wish_title       = trim($_POST['wish_title']);
            $wish_description = trim($_POST['wish_description']);
            $wish_url         = trim($_POST['wish_url']);
            $wish_priority    = isset($_POST['wish_priority']) && $_POST['wish_priority'] ? $_POST['wish_priority'] : 'NULL';

            $database
            ->query('INSERT INTO `wishes`
                     (
                        `wishlist`,
                        `title`,
                        `description`,
                        `url`,
                        `priority`
                     ) VALUES (
                        ' . $wishlist_id . ',
                        "' . $wish_title . '",
                        "' . $wish_description . '",
                        "' . $wish_url . '",
                        ' . $wish_priority . '
                     )
            ;');

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
