CREATE TABLE `users` (
  `id` BIGINT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(20) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password` TEXT NOT NULL,
  `created` DATETIME NOT NULL,
  `created_ip` VARCHAR(50) NOT NULL,
  `modified` DATETIME NULL,
  `modified_ip` VARCHAR(50) NULL,
  `last_login` DATETIME NULL,
  PRIMARY KEY (id)
);