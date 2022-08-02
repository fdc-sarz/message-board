CREATE TABLE `messages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `sender` BIGINT UNSIGNED NOT NULL,
  `recipient` BIGINT UNSIGNED NOT NULL,
  `created` DATETIME NOT NULL,
  `created_ip` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `messages` ADD CONSTRAINT `fk_messages_1` FOREIGN KEY (`sender`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE `messages` ADD CONSTRAINT `fk_messages_2` FOREIGN KEY (`recipient`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/* DROP ACTION */

ALTER TABLE `messages` DROP FOREIGN KEY fk_messages_2;
ALTER TABLE `messages` DROP FOREIGN KEY fk_messages_1;
DROP TABLE IF EXISTS `messages`;