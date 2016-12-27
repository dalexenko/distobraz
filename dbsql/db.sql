/* 
SQLyog v3.7
Host - localhost : Database - distobraz
**************************************************************
Server version 4.0.15-max-debug
*/

create database if not exists `distobraz`;

use `distobraz`;

/*
Table structure for course_control
*/

drop table if exists `course_control`;
CREATE TABLE `course_control` (
  `control_id` bigint(10) NOT NULL auto_increment,
  `control_name` varchar(250) default NULL,
  PRIMARY KEY  (`control_id`)
) TYPE=MyISAM;

/*
Table data for distobraz.course_control
*/

INSERT INTO `course_control` VALUES 
(1,'промежуточный'),
(3,'итоговый');

/*
Table structure for course_questions
*/

drop table if exists `course_questions`;
CREATE TABLE `course_questions` (
  `question_id` bigint(10) NOT NULL auto_increment,
  `theme_id` bigint(10) default NULL,
  `course_id` bigint(10) default NULL,
  `question` text,
  `answer1_id` bigint(10) default NULL,
  `answer2_id` bigint(10) default NULL,
  `answer3_id` bigint(10) default NULL,
  `answer4_id` bigint(10) default NULL,
  `answer5_id` bigint(10) default NULL,
  `answer1` text,
  `answer2` text,
  `answer3` text,
  `answer4` text,
  `answer5` text,
  `answer1_count` bigint(3) default NULL,
  `answer2_count` bigint(3) default NULL,
  `answer3_count` bigint(3) default NULL,
  `answer4_count` bigint(3) default NULL,
  `answer5_count` bigint(3) default NULL,
  PRIMARY KEY  (`question_id`)
) TYPE=MyISAM;

/*
Table data for distobraz.course_questions
*/

INSERT INTO `course_questions` VALUES 
(1,5,5,'Яблоко это - ',1,2,3,4,5,'фрукт','птица','овощ','животное','рыба',10,0,0,0,0),
(5,5,5,'Карп это -',1,2,3,4,5,'рыба','строение','река','море','дом',15,0,0,0,0),
(6,5,5,'Круг это -',1,2,3,4,5,'сферическая конструкция','средство передвижения','инструмент','фигура','слово',0,0,0,10,0),
(7,5,5,'Мечь - ',1,2,3,4,5,'оружие','рыба','животное','растение','водоем',10,5,0,0,0),
(8,5,5,'2*2=',1,2,3,4,5,'3','7','8','5','4',0,0,0,0,10),
(9,10,5,'радуга это - ',1,2,3,4,5,'аттракцион','явление природы','болезнь','вид облаков','коромысло',0,10,0,0,0);

/*
Table structure for course_subscribes
*/

drop table if exists `course_subscribes`;
CREATE TABLE `course_subscribes` (
  `user_id` bigint(10) default NULL,
  `course_id` bigint(10) default NULL
) TYPE=MyISAM;

/*
Table data for distobraz.course_subscribes
*/

INSERT INTO `course_subscribes` VALUES 
(1,1),
(1,2),
(1,5),
(4,5),
(4,1);

/*
Table structure for course_testing
*/

drop table if exists `course_testing`;
CREATE TABLE `course_testing` (
  `user_id` bigint(10) default NULL,
  `course_id` bigint(10) default NULL,
  `theme_id` bigint(10) default NULL,
  `question_id` bigint(10) default NULL,
  `answer_id` bigint(10) default NULL,
  `answer_count` bigint(3) default NULL
) TYPE=MyISAM;

/*
Table data for distobraz.course_testing
*/

INSERT INTO `course_testing` VALUES 
(4,5,5,7,1,10),
(4,5,5,6,1,0),
(4,5,5,5,3,0),
(4,5,5,8,4,0);

/*
Table structure for course_testing_results
*/

drop table if exists `course_testing_results`;
CREATE TABLE `course_testing_results` (
  `user_id` bigint(10) default NULL,
  `cource_id` bigint(10) default NULL,
  `result_count` bigint(10) default NULL,
  `date` bigint(10) default NULL
) TYPE=MyISAM;

/*
Table structure for course_themes
*/

drop table if exists `course_themes`;
CREATE TABLE `course_themes` (
  `theme_id` bigint(10) NOT NULL auto_increment,
  `course_id` bigint(10) default NULL,
  `theme_name` varchar(250) default NULL,
  `theme_query` bigint(10) default NULL,
  `success_count` bigint(3) default NULL,
  PRIMARY KEY  (`theme_id`)
) TYPE=MyISAM;

/*
Table data for distobraz.course_themes
*/

INSERT INTO `course_themes` VALUES 
(7,1,'theme1_1',1,10),
(8,5,'theme5_2',2,10),
(9,5,'theme5_3',3,10),
(5,5,'theme5_1',1,20),
(10,5,'theme5_4',4,15),
(11,5,'theme5_5',5,10),
(12,2,'theme2_1',1,15),
(13,2,'theme2_2',2,10),
(14,2,'theme2_3',3,10);

/*
Table structure for courses
*/

drop table if exists `courses`;
CREATE TABLE `courses` (
  `course_id` bigint(10) NOT NULL auto_increment,
  `course_name` varchar(250) default NULL,
  `user_id` bigint(10) default NULL,
  `control_id` bigint(10) default NULL,
  `success_count` bigint(3) default NULL,
  PRIMARY KEY  (`course_id`)
) TYPE=MyISAM ROW_FORMAT=DYNAMIC;

/*
Table data for distobraz.courses
*/

INSERT INTO `courses` VALUES 
(1,'curs1',2,1,100),
(2,'curs2',5,1,75),
(3,'curs3',2,1,150),
(4,'curs4',2,1,150),
(5,'curs5',5,1,100),
(6,'course6',2,1,250);

/*
Table structure for theme_testing_results
*/

drop table if exists `theme_testing_results`;
CREATE TABLE `theme_testing_results` (
  `user_id` bigint(10) default NULL,
  `cource_id` bigint(10) default NULL,
  `theme_id` bigint(10) default NULL,
  `result_count` bigint(10) default NULL,
  `date` bigint(10) default NULL
) TYPE=MyISAM;

/*
Table structure for user_categories
*/

drop table if exists `user_categories`;
CREATE TABLE `user_categories` (
  `usercat_id` bigint(10) NOT NULL auto_increment,
  `usercat_name` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`usercat_id`,`usercat_name`)
) TYPE=MyISAM;

/*
Table data for distobraz.user_categories
*/

INSERT INTO `user_categories` VALUES 
(1,'администраторы'),
(2,'студенты'),
(3,'преподаватели');

/*
Table structure for users
*/

drop table if exists `users`;
CREATE TABLE `users` (
  `user_id` bigint(10) NOT NULL auto_increment,
  `usercat_id` bigint(10) NOT NULL default '0',
  `username` varchar(250) NOT NULL default '',
  `usermediumname` varchar(250) NOT NULL default '',
  `userlastname` varchar(250) NOT NULL default '',
  `user_email` varchar(250) default NULL,
  `passwd` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`user_id`)
) TYPE=MyISAM ROW_FORMAT=DYNAMIC;

/*
Table data for distobraz.users
*/

INSERT INTO `users` VALUES 
(1,2,'Иван','Иванович','Иван','ivan@ua.fm','passivan'),
(2,3,'Василий','Петрович','Пупкин','vasia@ua.fm','qwert'),
(4,2,'Петр','Петрович','Петров','petr@mail.ru','123qwe'),
(5,3,'Александр','Сергеевич','Лоркин','Lorkin@yandex.ru','qaswed'),
(6,1,'админ','test','test','test','test'),
(8,3,'stest','dfg','dfgfd','eee@srer','456466');

