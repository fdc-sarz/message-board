CREATE TABLE `messages` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `sender` BIGINT NOT NULL,
  `recipient` BIGINT NOT NULL,
  `created` DATETIME NOT NULL,
  `created_ip` VARCHAR(50) NOT NULL,
  `modified` DATETIME NULL,
  `modified_ip` VARCHAR(50) NOT NULL
);