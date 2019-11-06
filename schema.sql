CREATE DATABASE TaskForce
DEFAULT CHARACTER SET = utf8
DEFAULT COLLATE = utf8_general_ci;

USE TaskForce;

CREATE TABLE `TaskForce`.`Users` (
`id` INT NOT NULL AUTO_INCREMENT ,
`created_at` INT(11) NOT NULL ,
`last_active` INT(11) NOT NULL ,
`email` VARCHAR(50) NOT NULL ,
`name` VARCHAR(50) NOT NULL ,
`city_id` INT(11) NOT NULL ,
`address` VARCHAR(50) NULL ,
`address_lat` VARCHAR(50) NULL ,
`address_lon` VARCHAR(50) NULL ,
`birthday` DATE NULL ,
`description` VARCHAR(255) NULL ,
`password_hash` VARCHAR(32) NOT NULL ,
`phone` VARCHAR(16)  NULL ,
`skype` VARCHAR(40)  NULL ,
`other_app` VARCHAR(40)  NULL ,
`msg_notification` SMALLINT(1)  NULL ,
`action_notification` SMALLINT(1)  NULL ,
`review_notification` SMALLINT(1)  NULL ,
`show_contacts_all` SMALLINT(1)  NULL ,
`hide_profile` SMALLINT(1)  NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Tasks` (
`id` INT NOT NULL AUTO_INCREMENT ,
`user_customer_id` INT(11) NOT NULL ,
`user_employee_id` INT(11) NOT NULL ,
`created_at` INT(11) NOT NULL ,
`title` VARCHAR(50) NOT NULL ,
`description` VARCHAR(255) NOT NULL ,
`category_id` INT(11) NOT NULL ,
`city_id` INT(11) NOT NULL ,
`address` VARCHAR(50) NULL ,
`budget` INT(11) NOT NULL ,
`deadline` DATE  NULL ,
`current_status` SMALLINT(3)  NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Tasks_Files` (
`id` INT NOT NULL AUTO_INCREMENT ,
`task_id` INT(11) NOT NULL ,
`file` VARCHAR(255) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Responses` (
`id` INT NOT NULL AUTO_INCREMENT ,
`created_at` INT(11) NOT NULL ,
`your_price` INT(11)  NULL ,
`task_id` INT(11) NOT NULL ,
`user_employee_id` INT(11) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Cities` (
`id` iNT(11) NOT NULL AUTO_INCREMENT,
`name` VARCHAR(50) NOT NULL ,
`lat` VARCHAR(50) NULL ,
`lon` VARCHAR(50) NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Categories` (
`id` iNT(11) NOT NULL AUTO_INCREMENT,
`name` VARCHAR(50) NOT NULL ,
`image` VARCHAR(50) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Users_Photo` (
`id` INT NOT NULL AUTO_INCREMENT ,
`user_id` INT(11) NOT NULL ,
`photo` VARCHAR(255) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Users_Review` (
`id` INT NOT NULL AUTO_INCREMENT ,
`created_at` INT(11) NOT NULL ,
`user_customer_id` INT(11) NOT NULL ,
`user_employee_id` INT(11) NOT NULL ,
`vote` SMALLINT(1) NOT NULL ,
`review` VARCHAR(255) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Notifications` (
`id` INT NOT NULL AUTO_INCREMENT ,
`user_id` INT(11) NOT NULL ,
`message` VARCHAR(255) NOT NULL ,
`viewed` SMALLINT(1) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Users_Categories` (
`user_id` INT(11) NOT NULL ,
`category_id` INT(11) NOT NULL ,
PRIMARY KEY (`user_id`, `category_id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Correspondence` (
`id` iNT(11) NOT NULL AUTO_INCREMENT,
`task_id` INT(11) NOT NULL ,
`user_id` INT(11) NOT NULL ,
`created_at` INT(11) NOT NULL ,
`message` VARCHAR(255) NOT NULL ,
PRIMARY KEY (`id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE UNIQUE INDEX index_email on Users(email);

ALTER TABLE `Users` ADD INDEX (`city_id`);
ALTER TABLE `Users` ADD FOREIGN KEY (`city_id`) REFERENCES `Cities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Tasks` ADD INDEX( `category_id`);
ALTER TABLE `Tasks` ADD FOREIGN KEY (`category_id`) REFERENCES `Categories`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Tasks` ADD INDEX( `user_customer_id`);
ALTER TABLE `Tasks` ADD FOREIGN KEY (`user_customer_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Tasks` ADD INDEX( `user_employee_id`);
ALTER TABLE `Tasks` ADD FOREIGN KEY (`user_employee_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Tasks` ADD INDEX( `city_id`);
ALTER TABLE `Tasks` ADD FOREIGN KEY (`city_id`) REFERENCES `Cities`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Tasks_Files` ADD INDEX( `task_id`);
ALTER TABLE `Tasks_Files` ADD FOREIGN KEY (`task_id`) REFERENCES `Tasks`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Responses` ADD INDEX( `task_id`);
ALTER TABLE `Responses` ADD FOREIGN KEY (`task_id`) REFERENCES `Tasks`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Responses` ADD INDEX( `user_employee_id`);
ALTER TABLE `Responses` ADD FOREIGN KEY (`user_employee_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Users_Photo` ADD INDEX( `user_id`);
ALTER TABLE `Users_Photo` ADD FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Users_Review` ADD INDEX( `user_customer_id`);
ALTER TABLE `Users_Review` ADD FOREIGN KEY (`user_customer_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Users_Review` ADD INDEX( `user_employee_id`);
ALTER TABLE `Users_Review` ADD FOREIGN KEY (`user_employee_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Notifications` ADD INDEX( `user_id`);
ALTER TABLE `Notifications` ADD FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Users_Categories` ADD INDEX( `user_id`);
ALTER TABLE `Users_Categories` ADD FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Users_Categories` ADD INDEX( `category_id`);
ALTER TABLE `Users_Categories` ADD FOREIGN KEY (`category_id`) REFERENCES `Categories`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Correspondence` ADD INDEX( `task_id`);
ALTER TABLE `Correspondence` ADD FOREIGN KEY (`task_id`) REFERENCES `Tasks`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Correspondence` ADD INDEX( `user_id`);
ALTER TABLE `Correspondence` ADD FOREIGN KEY (`user_id`) REFERENCES `Users`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
