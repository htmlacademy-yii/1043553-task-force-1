CREATE DATABASE TaskForce
DEFAULT CHARACTER SET = utf8
DEFAULT COLLATE = utf8_general_ci;

USE TaskForce;

CREATE TABLE `TaskForce`.`Users` (
`user_id` INT NOT NULL AUTO_INCREMENT ,
`email` VARCHAR(50) NOT NULL ,
`name` VARCHAR(50) NOT NULL ,
`city` VARCHAR(150) NOT NULL ,
`birthday` VARCHAR(10) NULL ,
`description` VARCHAR(1000) NULL ,
`specialisation` VARCHAR(1000) NULL ,
`password` VARCHAR(60) NOT NULL ,
`phone` VARCHAR(15)  NULL ,
`skype` VARCHAR(40)  NULL ,
`other_app` VARCHAR(40)  NULL ,
`msg_alert` VARCHAR(40)  NULL ,
`action_alert` VARCHAR(40)  NULL ,
`show_contacts_emp` VARCHAR(40)  NULL ,
`show_contacts_all` VARCHAR(40)  NULL ,
PRIMARY KEY (`user_id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Tasks` (
`task_id` INT NOT NULL AUTO_INCREMENT ,
`employer_id` INT(50) NOT NULL ,
`date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
`title` VARCHAR(50) NOT NULL ,
`description` VARCHAR(1000) NOT NULL ,
`category` VARCHAR(50) NOT NULL ,
`files` VARCHAR(10) NULL ,
`location` VARCHAR(20) NULL ,
`budget` INT(10) NOT NULL ,
`deadline` VARCHAR(15)  NULL ,
`current_status` VARCHAR(15)  NULL ,
PRIMARY KEY (`task_id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Responses` (
`response_id` INT NOT NULL AUTO_INCREMENT ,
`your_price` INT(10) NOT NULL ,
`task_id` INT(10) NOT NULL ,
`worker_id` INT(10 NOT NULL ,
PRIMARY KEY (`response_id`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Cities` (
`city_key` VARCHAR(50) NOT NULL ,
`city` VARCHAR(50) NOT NULL ,
PRIMARY KEY (`city_key`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `TaskForce`.`Categories` (
`category_key` VARCHAR(50) NOT NULL ,
`category` VARCHAR(50) NOT NULL ,
PRIMARY KEY (`category_key`)) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE UNIQUE INDEX index_email on Users(email);

ALTER TABLE `Tasks` ADD INDEX( `category`);
ALTER TABLE `Tasks` ADD FOREIGN KEY (`category`) REFERENCES `Categories`(`category_key`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Tasks` ADD INDEX( `employer_id`);
ALTER TABLE `Tasks` ADD FOREIGN KEY (`employer_id`) REFERENCES `Users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `Users` ADD INDEX( `city`);
ALTER TABLE `Users` ADD FOREIGN KEY (`city`) REFERENCES `Cities`(`city_key`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Users` ADD INDEX( `specialisation`);

ALTER TABLE `Responses` ADD INDEX( `task_id`);
ALTER TABLE `Responses` ADD FOREIGN KEY (`task_id`) REFERENCES `Tasks`(`task_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `Responses` ADD INDEX( `worker_id`);
ALTER TABLE `Responses` ADD FOREIGN KEY (`worker_id`) REFERENCES `Users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;