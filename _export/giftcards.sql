# Host: localhost  (Version 5.7.24)
# Date: 2020-12-11 09:54:52
# Generator: MySQL-Front 6.1  (Build 1.26)


#
# Structure for table "account"
#

CREATE TABLE `account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `subdomain` varchar(255) NOT NULL DEFAULT '',
  `notes` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account"
#

INSERT INTO `account` VALUES (1,'roxana','','','active');

#
# Structure for table "account_email_template"
#

CREATE TABLE `account_email_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `display_name` varchar(255) NOT NULL DEFAULT '',
  `display_info` varchar(255) NOT NULL DEFAULT '',
  `variables_list` text NOT NULL,
  `subject` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `added_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_email_per_account` (`account_id`,`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account_email_template"
#


#
# Structure for table "account_giftcard"
#

CREATE TABLE `account_giftcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `giftcard_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `added_by` int(11) NOT NULL DEFAULT '0',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

#
# Data for table "account_giftcard"
#

INSERT INTO `account_giftcard` VALUES (24,1,9,'Christmas 1','Get 50% off your first trip with us!','Christmas-1.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:33:53'),(25,1,10,'Christmas 2','Get 50% off your first trip with us!','Christmas-2.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:33:56'),(26,1,11,'Christmas 3','Get 50% off your first trip with us!','Christmas-3.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:33:58'),(27,1,12,'Hanukkah 1','Get 50% off your first trip with us!','Hanukkah-1.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:00'),(28,1,13,'Hanukkah 2','Get 50% off your first trip with us!','Hanukkah-2.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:02'),(29,1,14,'Hanukkah 3','Get 50% off your first trip with us!','Hanukkah-3.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:05'),(30,1,15,'New Year\'s Eve 1','Get 50% off your first trip with us!','NYE-1.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:07'),(31,1,16,'New Year\'s Eve 2','Get 50% off your first trip with us!','NYE-2.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:09'),(32,1,17,'New Year\'s Eve 3','Get 50% off your first trip with us!','NYE-3.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:11');

#
# Structure for table "account_globals"
#

CREATE TABLE `account_globals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` text NOT NULL,
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_setting_per_account` (`name`,`account_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account_globals"
#

INSERT INTO `account_globals` VALUES (1,1,'site_name','Roxana\'s Cars','2020-12-05 17:51:33','2020-12-07 16:57:51'),(2,1,'site_link','https://roxanacars.ro','2020-12-05 17:51:33','2020-12-07 16:57:51'),(3,1,'custom_domain','','2020-12-07 14:21:13','2020-12-07 14:21:13'),(4,1,'site_logo','happy-car-logo-design-template-450w-4669123491.jpg','2020-12-07 14:21:13','2020-12-07 16:57:51'),(5,1,'font_family','Arial, sans-serif','2020-12-07 14:22:26','2020-12-07 18:16:56'),(6,1,'font_size','15','2020-12-07 14:22:26','2020-12-07 18:16:56'),(7,1,'font_unit_size','px','2020-12-07 14:22:26','2020-12-07 18:16:56'),(8,1,'main_color','#cf7aca','2020-12-07 14:22:26','2020-12-07 18:16:56'),(9,1,'background_color','#e4cfe4','2020-12-07 14:22:26','2020-12-07 18:16:56'),(10,1,'overlayer_color','#dacdcd','2020-12-07 14:22:26','2020-12-07 14:29:43'),(11,1,'text_color','#6a1250','2020-12-07 14:22:26','2020-12-07 18:16:56'),(12,1,'custom_css','','2020-12-07 14:22:26','2020-12-07 18:16:56'),(13,1,'header_image','8785204fa9d0ff3690bd8a645bc74eadec0ebd4d2.jpg','2020-12-07 14:29:02','2020-12-07 14:29:02'),(14,1,'background_image','','2020-12-07 14:29:43','2020-12-07 14:29:43'),(15,1,'contact_link','https://roxanacars.ro/contact','2020-12-07 16:21:36','2020-12-07 16:57:51'),(16,1,'intro_text','<p>\r\n\r\n</p><p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p><p>Bawds jog, flick quartz, vex nymphs. Waltz, bad nymph, for quick jigs vex! Fox nymphs grab quick-jived waltz. Brick quiz whangs jumpy veldt fox.</p>\r\n\r\n<br><p></p>','2020-12-07 17:28:24','2020-12-07 17:28:24'),(17,1,'_wysihtml5_mode','1','2020-12-07 17:28:24','2020-12-07 17:28:24'),(18,1,'disclaimer_text','<p>\r\n\r\nBright vixens jump; dozy fowl quack. Quick wafting zephyrs vex bold Jim. Quick zephyrs blow, vexing daft Jim. Sex-charged fop blew my junk TV quiz.\r\n\r\n<br></p>','2020-12-07 17:28:24','2020-12-07 17:28:24');

#
# Structure for table "account_purchase"
#

CREATE TABLE `account_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `account_giftcard_id` int(11) NOT NULL DEFAULT '0',
  `benefits` text NOT NULL,
  `sender_code` varchar(255) NOT NULL DEFAULT '',
  `receiver_code` varchar(255) NOT NULL DEFAULT '',
  `sender_name` varchar(255) NOT NULL DEFAULT '',
  `receiver_name` varchar(255) NOT NULL DEFAULT '',
  `sender_email` varchar(255) NOT NULL DEFAULT '',
  `receiver_email` varchar(255) NOT NULL DEFAULT '',
  `message` text NOT NULL,
  `send_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `price_total` float(10,2) NOT NULL DEFAULT '0.00',
  `payment_gateway` varchar(30) NOT NULL,
  `payment_status` enum('not_paid','paid','rejected') NOT NULL DEFAULT 'not_paid',
  `payment_response` text NOT NULL,
  `added_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  `sent_status` enum('queued','sent','error') NOT NULL DEFAULT 'queued',
  `sent_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `opened_status` enum('not_opened','opened') NOT NULL DEFAULT 'not_opened',
  `opened_on` datetime NOT NULL,
  `received_notification` enum('on','off') NOT NULL DEFAULT 'off',
  `received_notified` enum('on','off') NOT NULL DEFAULT 'off',
  `redeemed` enum('on','off') NOT NULL DEFAULT 'off',
  `redeemed_comments` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

#
# Data for table "account_purchase"
#

INSERT INTO `account_purchase` VALUES (4,1,24,'Get 50% off your first trip with us!','5FCF73CB40458','','Roxana Driveprofit','Roxana Gmail','roxana@driveprofit.com','roxanalupu1981@gmail.com','Hi!','2020-12-08 23:00:00',25.00,'','not_paid','','2020-12-08 12:38:35','2020-12-08 12:38:35','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','on','off','off',''),(5,1,24,'Get 50% off your first trip with us!','5FCF79AC9DA43','','Roxana Driveprofit','Roxana Gmail','roxana@driveprofit.com','roxanalupu1981@gmail.com','Hi!','0000-00-00 00:00:00',25.00,'','not_paid','','2020-12-08 13:03:40','2020-12-08 13:03:40','error','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','on','off','off',''),(6,1,30,'Get 50% off your first trip with us!','5FCF7BC67F5A2','','Roxana Driveprofit','Roxana Gmail','roxana@driveprofit.com','roxanalupu1981@gmail.com','Hi!','2020-12-08 23:00:00',25.00,'','paid','a:0:{}','2020-12-08 13:12:38','2020-12-08 13:12:40','queued','2020-12-08 13:12:38','not_opened','0000-00-00 00:00:00','on','off','off',''),(7,1,26,'Get 50% off your first trip with us!','EDKBZK','','Roxana Driveprofit','Roxana Gmail','roxana@driveprofit.com','roxanalupu1981@gmail.com','Hi!','2020-12-08 16:53:08',25.00,'','paid','a:0:{}','2020-12-08 16:53:08','2020-12-08 18:42:55','sent','2020-12-08 18:42:55','not_opened','0000-00-00 00:00:00','on','off','off',''),(8,1,24,'Get 50% off your first trip with us!','CHUT7S','','Roxana','Roxi','roxanalupu1981@gmail.com','roxanalupu1981+000@gmail.com','Hi roxi!','2020-12-08 17:20:28',25.00,'','paid','a:0:{}','2020-12-08 17:20:28','2020-12-08 18:43:00','sent','2020-12-08 18:42:57','not_opened','0000-00-00 00:00:00','on','off','off',''),(9,1,26,'Get 50% off your first trip with us!','CYPY8VKG','','sfsdf','sdfsdfdsf','roxanalupu1981@gmail.com','roxana@driveprofit.com','sddasdasd','2020-12-08 17:24:06',25.00,'','paid','a:0:{}','2020-12-08 17:24:06','2020-12-08 18:43:04','sent','2020-12-08 18:43:02','not_opened','0000-00-00 00:00:00','on','off','off',''),(10,1,29,'Get 50% off your first trip with us!','RQQGCUJL','5GHNMNL7','Roxana Sender','Roxana Receiver','roxanalupu1981+000@gmail.com','roxanalupu1981+111@gmail.com','Hi, how are you!','2020-12-08 19:26:02',25.00,'','paid','a:0:{}','2020-12-08 19:26:02','2020-12-08 19:27:37','sent','2020-12-08 19:26:45','not_opened','0000-00-00 00:00:00','on','on','off','');

#
# Structure for table "account_user"
#

CREATE TABLE `account_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `email` varchar(200) NOT NULL DEFAULT '',
  `password` varchar(200) NOT NULL,
  `password_set_on` date NOT NULL DEFAULT '0000-00-00',
  `admin` enum('on','off') NOT NULL DEFAULT 'off',
  `name` varchar(200) NOT NULL DEFAULT '',
  `access_ip` varchar(255) NOT NULL DEFAULT '',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `recover_code` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "account_user"
#

INSERT INTO `account_user` VALUES (1,1,'roxana@driveprofit.com','roxana','0000-00-00','on','Roxana Lupu','','active','','2020-12-05 17:51:33','2020-12-06 12:43:38');

#
# Structure for table "account_user_logs"
#

CREATE TABLE `account_user_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `sulogin` int(11) NOT NULL DEFAULT '0',
  `ip` varchar(255) NOT NULL DEFAULT '',
  `moment` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account_user_logs"
#

INSERT INTO `account_user_logs` VALUES (1,1,1,1,'::1','2020-12-06 12:12:02'),(2,1,1,1,'::1','2020-12-06 12:43:28'),(3,1,1,1,'::1','2020-12-06 16:16:34'),(4,1,1,1,'::1','2020-12-07 12:29:24'),(5,1,1,1,'::1','2020-12-07 21:57:50'),(6,1,1,1,'::1','2020-12-08 06:49:00'),(7,1,1,1,'::1','2020-12-08 12:30:52');

#
# Structure for table "account_user_notification"
#

CREATE TABLE `account_user_notification` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `message` text,
  `type` enum('info','warning','danger') NOT NULL DEFAULT 'info',
  `read` enum('yes','no') NOT NULL DEFAULT 'no',
  `added_by` int(11) NOT NULL DEFAULT '0',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account_user_notification"
#


#
# Structure for table "account_widget"
#

CREATE TABLE `account_widget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `settings` text NOT NULL,
  `added_by` int(11) NOT NULL,
  `modified_by` int(11) NOT NULL,
  `added_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account_widget"
#


#
# Structure for table "category"
#

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `added_by` int(11) NOT NULL DEFAULT '0',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "category"
#

INSERT INTO `category` VALUES (1,'Christmas','Christmas giftcards','active',9999,9999,'2020-12-05 18:53:54','2020-12-08 12:25:31'),(2,'Hanukkah','Hanukkah giftcards','active',9999,9999,'2020-12-06 19:42:46','2020-12-08 12:25:51'),(3,'New Year\'s Eve','New Year\'s Eve giftcards','active',9999,9999,'2020-12-08 12:26:41','2020-12-08 12:26:41');

#
# Structure for table "giftcard"
#

CREATE TABLE `giftcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL DEFAULT '',
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `added_by` int(11) NOT NULL DEFAULT '0',
  `modified_by` int(11) NOT NULL DEFAULT '0',
  `added_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

#
# Data for table "giftcard"
#

INSERT INTO `giftcard` VALUES (9,'Christmas 1','',1,'Christmas-1.png','active',0,9999,'2020-12-08 12:28:05','2020-12-08 12:28:05'),(10,'Christmas 2','',1,'Christmas-2.png','active',0,9999,'2020-12-08 12:28:17','2020-12-08 12:28:17'),(11,'Christmas 3','',1,'Christmas-3.png','active',0,9999,'2020-12-08 12:28:30','2020-12-08 12:28:30'),(12,'Hanukkah 1','',2,'Hanukkah-1.png','active',0,9999,'2020-12-08 12:28:52','2020-12-08 12:28:52'),(13,'Hanukkah 2','',2,'Hanukkah-2.png','active',0,9999,'2020-12-08 12:29:06','2020-12-08 12:29:06'),(14,'Hanukkah 3','',2,'Hanukkah-3.png','active',0,9999,'2020-12-08 12:29:23','2020-12-08 12:29:23'),(15,'New Year\'s Eve 1','',3,'NYE-1.png','active',0,9999,'2020-12-08 12:30:04','2020-12-08 12:30:04'),(16,'New Year\'s Eve 2','',3,'NYE-2.png','active',0,9999,'2020-12-08 12:30:18','2020-12-08 12:30:18'),(17,'New Year\'s Eve 3','',3,'NYE-3.png','active',0,9999,'2020-12-08 12:30:31','2020-12-08 12:30:31');

#
# Structure for table "globals"
#

CREATE TABLE `globals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `value` varchar(255) NOT NULL DEFAULT '',
  `added_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "globals"
#

INSERT INTO `globals` VALUES (3,'site_name','Giftcards','0000-00-00 00:00:00','2020-12-05 17:35:59'),(6,'site_logo','dp.png','0000-00-00 00:00:00','2020-12-05 17:35:40'),(8,'site_link','http://localhost/giftcards/','0000-00-00 00:00:00','2020-12-05 17:35:59'),(9,'site_favicon','favicon_dp.ico','0000-00-00 00:00:00','2020-12-05 17:35:30'),(11,'admin_user','giftcards','0000-00-00 00:00:00','2020-12-05 17:35:59'),(12,'admin_password','fe01ce2a7fbac8fafaed7c982a04e229','0000-00-00 00:00:00','2019-09-15 11:24:30');
