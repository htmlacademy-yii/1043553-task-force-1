CREATE DATABASE taskForce
DEFAULT CHARACTER SET = utf8
DEFAULT COLLATE = utf8_general_ci;

USE taskForce;

CREATE TABLE `taskForce`.`users` (
`id` INT NOT NULL AUTO_INCREMENT ,
`created_at` INT(11) NOT NULL ,
`last_active` INT(11) NULL ,
`email` VARCHAR(50) NOT NULL ,
`name` VARCHAR(50) NOT NULL ,
`city_id`INT(11)   NOT NULL ,
`address` VARCHAR(50) NULL ,
`address_lat` VARCHAR(50) NULL ,
`address_lon` VARCHAR(50) NULL ,
`birthday` DATE NULL ,
`description` VARCHAR(255) NULL ,
`password_hash` VARCHAR(32) NOT NULL ,
`phone` VARCHAR(16)  NULL ,
`skype` VARCHAR(40)  NULL ,
`other_app` VARCHAR(40)  NULL ,
`msg_notification` BOOLEAN NOT NULL DEFAULT 0 ,
`action_notification` BOOLEAN NOT NULL DEFAULT 0 ,
`review_notification` BOOLEAN NOT NULL DEFAULT 0 ,
`show_contacts_all` BOOLEAN NOT NULL DEFAULT 0 ,
`hide_profile` BOOLEAN NOT NULL DEFAULT 0 ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`tasks` (
`id` INT NOT NULL AUTO_INCREMENT ,
`user_customer_id` INT(11) NOT NULL ,
`user_employee_id` INT(11) NOT NULL ,
`created_at` INT(11) NOT NULL ,
`title` VARCHAR(50) NOT NULL ,
`description` TEXT NOT NULL ,
`category_id` INT(11)   NOT NULL ,
`city_id` INT(11)   NOT NULL ,
`lat` VARCHAR(50) NULL ,
`lon` VARCHAR(50) NULL ,
`address` VARCHAR(50) NULL ,
`budget` INT(11) NOT NULL ,
`deadline` DATE  NULL ,
`current_status` SMALLINT(3)  NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`tasks_files` (
`id` INT NOT NULL AUTO_INCREMENT ,
`task_id` INT(11)   NOT NULL ,
`file` VARCHAR(255) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`responses` (
`id` INT NOT NULL AUTO_INCREMENT ,
`created_at` INT(11) NOT NULL ,
`your_price` INT(11)  NULL ,
`task_id` INT(11)   NOT NULL ,
`user_employee_id` INT(11) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`cities` (
`id` iNT(11) NOT NULL AUTO_INCREMENT,
`name` VARCHAR(50) NOT NULL ,
`lat` VARCHAR(50) NULL ,
`lon` VARCHAR(50) NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`categories` (
`id` iNT(11) NOT NULL AUTO_INCREMENT,
`name` VARCHAR(50) NOT NULL ,
`image` VARCHAR(50) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`user_photos` (
`id` INT NOT NULL AUTO_INCREMENT ,
`user_id` INT(11)   NOT NULL ,
`photo` VARCHAR(255) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`users_review` (
`id` INT NOT NULL AUTO_INCREMENT ,
`created_at` INT(11) NOT NULL ,
`user_customer_id` INT(11) NOT NULL ,
`user_employee_id` INT(11) NOT NULL ,
`vote` SMALLINT(1) NOT NULL ,
`review` TEXT NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`notifications` (
`id` INT NOT NULL AUTO_INCREMENT ,
`user_id` INT(11)   NOT NULL ,
`message` VARCHAR(255) NOT NULL ,
`viewed` BOOLEAN NOT NULL DEFAULT 0 ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`users_categories` (
`user_id` INT(11)   NOT NULL ,
`category_id` INT(11)   NOT NULL ,
PRIMARY KEY (`user_id`, `category_id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `taskForce`.`correspondence` (
`id` iNT(11) NOT NULL AUTO_INCREMENT,
`task_id` INT(11)   NOT NULL ,
`user_id` INT(11)   NOT NULL ,
`created_at` INT(11) NOT NULL ,
`message` VARCHAR(255) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE UNIQUE INDEX index_email on users(email);

ALTER TABLE `users` ADD INDEX (`city_id`);
ALTER TABLE `users` ADD FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `tasks` ADD INDEX( `category_id`);
ALTER TABLE `tasks` ADD FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tasks` ADD INDEX( `user_customer_id`);
ALTER TABLE `tasks` ADD FOREIGN KEY (`user_customer_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tasks` ADD INDEX( `user_employee_id`);
ALTER TABLE `tasks` ADD FOREIGN KEY (`user_employee_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tasks` ADD INDEX( `city_id`);
ALTER TABLE `tasks` ADD FOREIGN KEY (`city_id`) REFERENCES `cities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `tasks_files` ADD INDEX( `task_id`);
ALTER TABLE `tasks_files` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `responses` ADD INDEX( `task_id`);
ALTER TABLE `responses` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `responses` ADD INDEX( `user_employee_id`);
ALTER TABLE `responses` ADD FOREIGN KEY (`user_employee_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `user_photos` ADD INDEX( `user_id`);
ALTER TABLE `user_photos` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `users_review` ADD INDEX( `user_customer_id`);
ALTER TABLE `users_review` ADD FOREIGN KEY (`user_customer_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `users_review` ADD INDEX( `user_employee_id`);
ALTER TABLE `users_review` ADD FOREIGN KEY (`user_employee_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `notifications` ADD INDEX( `user_id`);
ALTER TABLE `notifications` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `users_categories` ADD INDEX( `user_id`);
ALTER TABLE `users_categories` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `users_categories` ADD INDEX( `category_id`);
ALTER TABLE `users_categories` ADD FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `correspondence` ADD INDEX( `task_id`);
ALTER TABLE `correspondence` ADD FOREIGN KEY (`task_id`) REFERENCES `tasks`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `correspondence` ADD INDEX( `user_id`);
ALTER TABLE `correspondence` ADD FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;



