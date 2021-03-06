-- MySQL dump 9.11
--
-- Host: localhost    Database: conversion
-- ------------------------------------------------------
-- Server version	4.0.22-log

--
-- Table structure for table `group`
--
CREATE TABLE `group` (
	`group_id` int(11) NOT NULL auto_increment,
	`group_name` varchar(50) NOT NULL,
	PRIMARY KEY (`group_id`)
) TYPE=MyISAM;

--
-- Table structure for table `allocs`
--
CREATE TABLE `%PREFIX%_allocs` (
  `itemid` int(11) NOT NULL default '0',
  `userid` int(11) NOT NULL default '0',
  `bought` tinyint(1) NOT NULL default '0',
  `quantity` int(11) NOT NULL default '0',
  PRIMARY KEY  (`itemid`,`userid`,`bought`)
) TYPE=MyISAM;

--
-- Table structure for table `categories`
--

CREATE TABLE `%PREFIX%_categories` (
  `categoryid` int(11) NOT NULL auto_increment,
  `category` varchar(50) default NULL,
  PRIMARY KEY  (`categoryid`)
) TYPE=MyISAM;

--
-- Dumping data for table `categories`
--

INSERT INTO `%PREFIX%_categories` VALUES (1,'Books');
INSERT INTO `%PREFIX%_categories` VALUES (2,'Music');
INSERT INTO `%PREFIX%_categories` VALUES (3,'Video Games');
INSERT INTO `%PREFIX%_categories` VALUES (4,'Clothing');
INSERT INTO `%PREFIX%_categories` VALUES (5,'Movies/DVD');
INSERT INTO `%PREFIX%_categories` VALUES (6,'Gift Certificates');
INSERT INTO `%PREFIX%_categories` VALUES (7,'Hobbies');
INSERT INTO `%PREFIX%_categories` VALUES (8,'Household');
INSERT INTO `%PREFIX%_categories` VALUES (9,'Electronics');
INSERT INTO `%PREFIX%_categories` VALUES (10,'Ornaments/Figurines');
INSERT INTO `%PREFIX%_categories` VALUES (11,'Automotive');
INSERT INTO `%PREFIX%_categories` VALUES (12,'Toys');
INSERT INTO `%PREFIX%_categories` VALUES (13,'Jewellery');
INSERT INTO `%PREFIX%_categories` VALUES (14,'Computer');
INSERT INTO `%PREFIX%_categories` VALUES (15,'Games');
INSERT INTO `%PREFIX%_categories` VALUES (16,'Tools');

--
-- Table structure for table `events`
--

CREATE TABLE `%PREFIX%_events` (
  `eventid` int(11) NOT NULL auto_increment,
  `userid` int(11) default NULL,
  `description` varchar(100) NOT NULL default '',
  `eventdate` date NOT NULL default '0000-00-00',
  `recurring` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`eventid`)
) TYPE=MyISAM;

--
-- Dumping data for table `events`
--

INSERT INTO `%PREFIX%_events` VALUES (1,NULL,'Christmas','2000-12-25',1);

--
-- Table structure for table `items`
--

CREATE TABLE `%PREFIX%_items` (
  `itemid` int(11) NOT NULL auto_increment,
  `userid` int(11) NOT NULL default '0',
  `description` varchar(255) NOT NULL default '',
  `price` decimal(7,2) default NULL,
  `source` varchar(255) NOT NULL default '',
  `ranking` int(11) NOT NULL default '0',
  `url` varchar(255) default NULL,
  `category` int(11) default NULL,
  `comment` text,
  `quantity` int(11) NOT NULL default '0',
  `image_filename` varchar(255) default NULL,
  PRIMARY KEY  (`itemid`)
) TYPE=MyISAM;

--
-- Table structure for table `messages`
--

CREATE TABLE `%PREFIX%_messages` (
  `messageid` int(11) NOT NULL auto_increment,
  `sender` int(11) NOT NULL default '0',
  `recipient` int(11) NOT NULL default '0',
  `message` varchar(255) NOT NULL default '',
  `isread` tinyint(1) NOT NULL default '0',
  `created` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`messageid`)
) TYPE=MyISAM;

--
-- Table structure for table `ranks`
--

CREATE TABLE `%PREFIX%_ranks` (
  `ranking` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `rendered` varchar(255) NOT NULL default '',
  `rankorder` int(11) NOT NULL default '0',
  PRIMARY KEY  (`ranking`)
) TYPE=MyISAM;

--
-- Dumping data for table `ranks`
--

INSERT INTO `%PREFIX%_ranks` VALUES (1,'1 - Wouldn\'t mind it','<img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_off.gif\" alt=\"\"><img src=\"images/star_off.gif\" alt=\"\"><img src=\"images/star_off.gif\" alt=\"\"><img src=\"images/star_off.gif\" alt=\"\">',1);
INSERT INTO `%PREFIX%_ranks` VALUES (2,'2 - Would be nice to have','<img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_off.gif\" alt=\"\"><img src=\"images/star_off.gif\" alt=\"\"><img src=\"images/star_off.gif\" alt=\"\">',2);
INSERT INTO `%PREFIX%_ranks` VALUES (3,'3 - Would make me happy','<img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_off.gif\" alt=\"\"><img src=\"images/star_off.gif\" alt=\"\">',3);
INSERT INTO `%PREFIX%_ranks` VALUES (4,'4 - I would really, really like this','<img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_off.gif\" alt=\"\">',4);
INSERT INTO `%PREFIX%_ranks` VALUES (5,'5 - I\'d love to get this','<img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\"><img src=\"images/star_on.gif\" alt=\"*\">',5);

--
-- Table structure for table `shoppers`
--

CREATE TABLE `%PREFIX%_shoppers` (
  `shopper` int(11) NOT NULL default '0',
  `mayshopfor` int(11) NOT NULL default '0',
  `pending` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`shopper`,`mayshopfor`)
) TYPE=MyISAM;

--
-- Table structure for table `families`
--

CREATE TABLE `%PREFIX%_families` (
  familyid int(11) NOT NULL auto_increment,
  familyname varchar(255) NOT NULL default '',
  PRIMARY KEY  (familyid)
) TYPE=MyISAM;

--
-- Table structure for table `users`
--

CREATE TABLE `%PREFIX%_users` (
  `userid` int(11) NOT NULL auto_increment,
  `username` varchar(20) NOT NULL default '',
  `password` varchar(50) NOT NULL default '',
  `fullname` varchar(50) NOT NULL default '',
  `email` varchar(255) default NULL,
  `approved` tinyint(1) NOT NULL default '0',
  `admin` tinyint(1) NOT NULL default '0',
  `comment` text,
  `email_msgs` tinyint(1) NOT NULL default '0',
  `list_stamp` datetime default NULL,
  `initialfamilyid` int NULL,
  PRIMARY KEY  (`userid`)
) TYPE=MyISAM;

--
-- Table structure for table `memberships`
--

CREATE TABLE `%PREFIX%_memberships` (
  userid int(11) NOT NULL default '0',
  familyid int(11) NOT NULL default '0',
  PRIMARY KEY  (userid,familyid)
) TYPE=MyISAM;
