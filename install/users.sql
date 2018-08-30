CREATE TABLE `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_czech_ci',
	`firstname` VARCHAR(50) NOT NULL COLLATE 'utf8mb4_czech_ci',
	`lastname` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_czech_ci',
	`email` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_czech_ci',
	`password` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_czech_ci',
	`remember_token` VARCHAR(100) NULL DEFAULT NULL COLLATE 'utf8mb4_czech_ci',
	`hash` VARCHAR(32) NOT NULL COLLATE 'utf8mb4_czech_ci',
	`avatar` longblob,
	`active` bool not null default 0,
	`lastlogin` datetime not null,
	`created_at` TIMESTAMP NULL DEFAULT NULL,
	`updated_at` TIMESTAMP NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `users_email_unique` (`email`),
	UNIQUE INDEX `users_username_unique` (`username`)
)
COLLATE='utf8mb4_czech_ci'
ENGINE=InnoDB
;