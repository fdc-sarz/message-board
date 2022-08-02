CREATE TABLE `user_details` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uid` BIGINT UNSIGNED NOT NULL UNIQUE,
  `birth_date` DATE NULL,
  `hubby` TEXT NULL,
  `profile_picture` VARCHAR(50),
  `gender` ENUM('Male', 'Female') NULL DEFAULT 'Male',
  PRIMARY KEY (id)
);
ALTER TABLE `user_details` ADD CONSTRAINT `fk_user_details_1` FOREIGN KEY (`uid`) REFERENCES `users`(`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

/* DROP ACTION */
ALTER TABLE `user_details` DROP FOREIGN KEY fk_messages_1;
DROP TABLE IF EXISTS `user_details`;