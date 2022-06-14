/**
 * Wishes
 */
ALTER TABLE `wishes` MODIFY     `image`  TEXT          NULL DEFAULT NULL,
                     ADD COLUMN `edited` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

/**
 * Products
 */
CREATE TABLE `products` (
             `wish`  INT   NOT NULL PRIMARY KEY,
             `price` FLOAT NULL     DEFAULT NULL,
    FOREIGN KEY (`wish`)
        REFERENCES `wishes` (`id`)
        ON DELETE CASCADE
);
