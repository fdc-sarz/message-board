CREATE TABLE `message_threads` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `mid` BIGINT UNSIGNED NOT NULL,
  `uid` BIGINT UNSIGNED NOT NULL,
  `message` TEXT NOT NULL,
  `created` DATETIME NOT NULL,
  `created_ip` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE `message_threads` ADD CONSTRAINT `fk_message_threads_1` FOREIGN KEY (`mid`) REFERENCES `messages`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;
ALTER TABLE `message_threads` ADD CONSTRAINT `fk_message_threads_2` FOREIGN KEY (`uid`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;




/* DROP ACTION */
ALTER TABLE `message_threads` DROP FOREIGN KEY fk_message_threads_2;
ALTER TABLE `message_threads` DROP FOREIGN KEY fk_message_threads_1;
DROP TABLE IF EXISTS `message_threads`;