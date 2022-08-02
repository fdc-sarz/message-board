ALTER TABLE `messages` ADD `last_response_id` BIGINT UNSIGNED NULL AFTER `recipient`;
ALTER TABLE `messages` ADD CONSTRAINT `fk_messages_3` FOREIGN KEY (`last_response_id`) REFERENCES `message_threads`(`id`) ON DELETE SET NULL ON UPDATE NO ACTION;

/* DROP ACTION */
ALTER TABLE `messages` DROP FOREIGN KEY fk_messages_3;
ALTER TABLE `messages` DROP `last_response_id`;
