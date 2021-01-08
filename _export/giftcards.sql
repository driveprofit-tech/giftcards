# Host: localhost  (Version 5.7.24)
# Date: 2021-01-08 10:27:12
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account"
#

INSERT INTO `account` VALUES (1,'roxana','','','active'),(2,'gateway','','','active');

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
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

#
# Data for table "account_giftcard"
#

INSERT INTO `account_giftcard` VALUES (24,1,9,'Christmas 1','Get 50% off your first trip with us!','Christmas-1.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:33:53'),(25,1,10,'Christmas 2','Get 50% off your first trip with us!','Christmas-2.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:33:56'),(26,1,11,'Christmas 3','Get 50% off your first trip with us!','Christmas-3.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:33:58'),(27,1,12,'Hanukkah 1','Get 50% off your first trip with us!','Hanukkah-1.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:00'),(28,1,13,'Hanukkah 2','Get 50% off your first trip with us!','Hanukkah-2.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:02'),(29,1,14,'Hanukkah 3','Get 50% off your first trip with us!','Hanukkah-3.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:05'),(30,1,15,'New Year\'s Eve 1','Get 50% off your first trip with us!','NYE-1.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:07'),(31,1,16,'New Year\'s Eve 2','Get 50% off your first trip with us!','NYE-2.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:09'),(32,1,17,'New Year\'s Eve 3','Get 50% off your first trip with us!','NYE-3.png',25.00,'active',1,1,'2020-12-08 12:31:52','2020-12-08 12:34:11'),(33,2,10,'Merry Christmas','Send your loved ones your wishes for Christmas and a $50 giftcard that can be used for any Gateway Limousines services.','Christmas-2.png',50.00,'active',2,2,'2020-12-11 09:23:13','2020-12-11 09:28:22'),(34,2,13,'Happy Hanukkah','Send your loved ones your wishes for Hanukkah and a $50 giftcard that can be used for any Gateway Limousines services.','Hanukkah-2.png',50.00,'active',2,2,'2020-12-11 09:23:13','2020-12-11 09:29:01'),(35,2,16,'Happy New Year','Help your loved ones travel easier for New Year with a $50 giftcard that can be used for any Gateway Limousines services.','NYE-2.png',50.00,'active',2,2,'2020-12-11 09:23:13','2020-12-11 09:31:04'),(36,2,13,'Hanukkah 2','','Hanukkah-21.png',0.00,'active',2,2,'2020-12-11 15:17:12','2020-12-11 15:17:12');

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
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account_globals"
#

INSERT INTO `account_globals` VALUES (1,1,'site_name','Roxana\'s Cars','2020-12-05 17:51:33','2021-01-07 18:30:10'),(2,1,'site_link','https://roxanacars.ro','2020-12-05 17:51:33','2021-01-07 18:30:10'),(3,1,'custom_domain','','2020-12-07 14:21:13','2020-12-07 14:21:13'),(4,1,'site_logo','happy-car-logo-design-template-450w-4669123491.jpg','2020-12-07 14:21:13','2020-12-11 08:42:06'),(5,1,'font_family','Arial, sans-serif','2020-12-07 14:22:26','2020-12-07 18:16:56'),(6,1,'font_size','15','2020-12-07 14:22:26','2020-12-07 18:16:56'),(7,1,'font_unit_size','px','2020-12-07 14:22:26','2020-12-07 18:16:56'),(8,1,'main_color','#cf7aca','2020-12-07 14:22:26','2020-12-07 18:16:56'),(9,1,'background_color','#e4cfe4','2020-12-07 14:22:26','2020-12-07 18:16:56'),(10,1,'overlayer_color','#dacdcd','2020-12-07 14:22:26','2020-12-07 14:29:43'),(11,1,'text_color','#6a1250','2020-12-07 14:22:26','2020-12-07 18:16:56'),(12,1,'custom_css','','2020-12-07 14:22:26','2020-12-07 18:16:56'),(13,1,'header_image','8785204fa9d0ff3690bd8a645bc74eadec0ebd4d2.jpg','2020-12-07 14:29:02','2020-12-07 14:29:02'),(14,1,'background_image','','2020-12-07 14:29:43','2020-12-07 14:29:43'),(15,1,'contact_link','https://roxanacars.ro/contact','2020-12-07 16:21:36','2021-01-07 18:30:10'),(16,1,'intro_text','<p>\r\n\r\n</p><p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p><p>Bawds jog, flick quartz, vex nymphs. Waltz, bad nymph, for quick jigs vex! Fox nymphs grab quick-jived waltz. Brick quiz whangs jumpy veldt fox.</p>\r\n\r\n<br><p></p>','2020-12-07 17:28:24','2020-12-07 17:28:24'),(17,1,'_wysihtml5_mode','1','2020-12-07 17:28:24','2020-12-07 17:28:24'),(18,1,'disclaimer_text','<p>\r\n\r\nBright vixens jump; dozy fowl quack. Quick wafting zephyrs vex bold Jim. Quick zephyrs blow, vexing daft Jim. Sex-charged fop blew my junk TV quiz.\r\n\r\n<br></p>','2020-12-07 17:28:24','2020-12-07 17:28:24'),(19,1,'terms_of_use_link','https://roxanacars.ro/terms','2020-12-11 09:14:09','2021-01-07 18:30:10'),(20,1,'privacy_policy_link','https://roxanacars.ro/privacy','2020-12-11 09:14:09','2021-01-07 18:30:10'),(21,2,'site_name','Gateway Limousines','2020-12-11 09:22:16','2021-01-08 08:24:20'),(22,2,'site_link','https://gatewaylimos.com/','2020-12-11 09:22:16','2021-01-08 08:24:20'),(23,2,'contact_link','https://gatewaylimos.com/index.php?page=contact','2020-12-11 09:34:23','2021-01-08 08:24:20'),(24,2,'terms_of_use_link','https://gatewaylimos.com/index.php?page=duty-of-care','2020-12-11 09:34:23','2021-01-08 08:24:20'),(25,2,'privacy_policy_link','https://gatewaylimos.com/index.php?page=privacy-policy','2020-12-11 09:34:23','2021-01-08 08:24:20'),(26,2,'site_favicon','favicon[1].ico','2020-12-11 09:34:23','2020-12-11 09:34:23'),(27,2,'site_logo','gateway-limousine[1].png','2020-12-11 09:34:23','2020-12-11 09:34:23'),(28,2,'font_family','Georgia, serif','2020-12-11 09:38:12','2020-12-11 09:40:52'),(29,2,'font_size','14','2020-12-11 09:38:12','2020-12-11 09:40:52'),(30,2,'font_unit_size','px','2020-12-11 09:38:12','2020-12-11 09:40:52'),(31,2,'main_color','#8d0032','2020-12-11 09:38:12','2020-12-11 09:40:52'),(32,2,'background_color','','2020-12-11 09:38:12','2020-12-11 09:40:52'),(33,2,'text_color','#333333','2020-12-11 09:38:12','2020-12-11 09:40:52'),(34,2,'custom_css','body {background-image:linear-gradient(rgba(141,0,50,.8),rgba(141,0,50,.8)) !important; background-color: transparent;}','2020-12-11 09:38:12','2020-12-11 09:40:52'),(35,2,'intro_text','<p>Get your loved ones closer these Holydays by sending them a giftcard along with your best wishes. They can\'t get to you for Holidays? No problem! They can use it to make their travel easier and safer.&nbsp;</p>','2020-12-11 09:51:00','2020-12-11 09:52:44'),(36,2,'_wysihtml5_mode','1','2020-12-11 09:51:00','2020-12-11 09:52:44'),(37,2,'disclaimer_text','<p>\r\n\r\nSafety and security are hot topics in the transportation industry. We take the safety, the privacy and the well-being of our clients very seriously. If you are looking for safe and reliable Connecticut car service, you can count on Gateway Limousine.\r\n\r\n<br></p>','2020-12-11 09:51:00','2020-12-11 09:52:44'),(38,1,'payment_gateway','paypal','2021-01-07 15:22:16','2021-01-07 18:30:10'),(39,1,'time_zone','','2021-01-07 15:22:16','2021-01-07 18:30:10'),(40,1,'authorize_sandbox','on','2021-01-07 15:22:22','2021-01-07 15:22:22'),(41,1,'paypal_sandbox','on','2021-01-07 18:30:17','2021-01-07 18:30:17'),(42,1,'paypal_username','','2021-01-07 18:30:17','2021-01-07 18:30:17'),(43,2,'payment_gateway','paypal','2021-01-08 08:23:03','2021-01-08 08:24:20'),(44,2,'time_zone','','2021-01-08 08:23:03','2021-01-08 08:24:20'),(45,2,'authorize_sandbox','on','2021-01-08 08:23:09','2021-01-08 08:23:09'),(46,2,'paypal_sandbox','on','2021-01-08 08:24:25','2021-01-08 08:24:25'),(47,2,'paypal_username','','2021-01-08 08:24:25','2021-01-08 08:24:25');

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
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

#
# Data for table "account_purchase"
#

INSERT INTO `account_purchase` VALUES (4,1,24,'Get 50% off your first trip with us!','5FCF73CB40458','','Roxana Driveprofit','Roxana Gmail','roxana@driveprofit.com','roxanalupu1981@gmail.com','Hi!','2020-12-08 23:00:00',25.00,'','not_paid','','2020-12-08 12:38:35','2020-12-08 12:38:35','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','on','off','off',''),(5,1,24,'Get 50% off your first trip with us!','5FCF79AC9DA43','','Roxana Driveprofit','Roxana Gmail','roxana@driveprofit.com','roxanalupu1981@gmail.com','Hi!','0000-00-00 00:00:00',25.00,'','not_paid','','2020-12-08 13:03:40','2020-12-08 13:03:40','error','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','on','off','off',''),(6,1,30,'Get 50% off your first trip with us!','5FCF7BC67F5A2','','Roxana Driveprofit','Roxana Gmail','roxana@driveprofit.com','roxanalupu1981@gmail.com','Hi!','2020-12-08 23:00:00',25.00,'','paid','a:0:{}','2020-12-08 13:12:38','2020-12-11 08:49:12','sent','2020-12-11 08:49:07','not_opened','0000-00-00 00:00:00','on','off','off',''),(7,1,26,'Get 50% off your first trip with us!','EDKBZK','','Roxana Driveprofit','Roxana Gmail','roxana@driveprofit.com','roxanalupu1981@gmail.com','Hi!','2020-12-08 16:53:08',25.00,'','paid','a:0:{}','2020-12-08 16:53:08','2020-12-08 18:42:55','sent','2020-12-08 18:42:55','not_opened','0000-00-00 00:00:00','on','off','off',''),(8,1,24,'Get 50% off your first trip with us!','CHUT7S','','Roxana','Roxi','roxanalupu1981@gmail.com','roxanalupu1981+000@gmail.com','Hi roxi!','2020-12-08 17:20:28',25.00,'','paid','a:0:{}','2020-12-08 17:20:28','2020-12-08 18:43:00','sent','2020-12-08 18:42:57','not_opened','0000-00-00 00:00:00','on','off','off',''),(9,1,26,'Get 50% off your first trip with us!','CYPY8VKG','','sfsdf','sdfsdfdsf','roxanalupu1981@gmail.com','roxana@driveprofit.com','sddasdasd','2020-12-08 17:24:06',25.00,'','paid','a:0:{}','2020-12-08 17:24:06','2020-12-08 18:43:04','sent','2020-12-08 18:43:02','not_opened','0000-00-00 00:00:00','on','off','off',''),(10,1,29,'Get 50% off your first trip with us!','RQQGCUJL','5GHNMNL7','Roxana Sender','Roxana Receiver','roxanalupu1981+000@gmail.com','roxanalupu1981+111@gmail.com','Hi, how are you!','2020-12-08 19:26:02',25.00,'','paid','a:0:{}','2020-12-08 19:26:02','2020-12-08 19:27:37','sent','2020-12-08 19:26:45','not_opened','0000-00-00 00:00:00','on','on','off',''),(11,1,29,'Get 50% off your first trip with us!','SAHIFZGL','ABXMCMZB','Roxana Sender','Roxana Receiver','roxanalupu1981+000@gmail.com','roxanalupu1981+111@gmail.com','My best wishes for you!','2020-12-11 08:43:29',25.00,'','paid','a:0:{}','2020-12-11 08:43:29','2020-12-11 08:49:58','sent','2020-12-11 08:49:13','not_opened','0000-00-00 00:00:00','on','on','off',''),(12,2,33,'Send your loved ones your wishes for Christmas and a $50 giftcard that can be used for any Gateway Limousines services.','BLIRDGNQ','7RRPQTEG','Roxana','Pat','roxana@tech360group.com','pat@tech360group.com','Hi Pat,\r\n\r\nThis is a test giftcard from a test account set up on the new \"giftcards product\"\r\n\r\nRoxana','2020-12-11 12:20:42',50.00,'','paid','a:0:{}','2020-12-11 12:20:42','2020-12-11 15:15:15','sent','2020-12-11 12:21:17','not_opened','0000-00-00 00:00:00','on','on','off',''),(13,2,33,'Send your loved ones your wishes for Christmas and a $50 giftcard that can be used for any Gateway Limousines services.','QBPGUPFC','KO3LA23A','Roxana','Simon','roxana@tech360group.com','simon.gare@tech360group.com','Hi Simon,\r\n\r\nThis is a test giftcard from a test account set up on the new \"giftcards product\"\r\n\r\nRoxana','2020-12-11 12:22:54',50.00,'','paid','a:0:{}','2020-12-11 12:22:54','2020-12-11 15:14:58','sent','2020-12-11 12:23:06','not_opened','0000-00-00 00:00:00','on','on','off',''),(14,2,34,'Send your loved ones your wishes for Hanukkah and a $50 giftcard that can be used for any Gateway Limousines services.','INVV09MZ','MFDI8PHL','ccxxc','xcxzc','roxana@driveprofit.com','roxana@driveprofit.com','Hi!','2020-12-11 15:21:48',50.00,'','paid','a:0:{}','2020-12-11 15:21:48','2020-12-11 15:22:12','sent','2020-12-11 15:22:07','not_opened','0000-00-00 00:00:00','off','off','off',''),(15,1,24,'Get 50% off your first trip with us!','PIZXXH9U','TBODBTLT','ddfsdf','sfsdfsdf','roxana@tech360group.com','roxana@tech360group.com','fdfgdfg','2021-01-07 15:23:50',25.00,'authorize','not_paid','','2021-01-07 15:23:50','2021-01-07 15:23:50','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','on','off','off',''),(16,1,24,'Get 50% off your first trip with us!','X2CNMRGY','EHZ3N3E1','fsdf','sdfsf','roxana@incorom.ro','roxana@incorom.ro','sfsf','2021-01-07 15:25:57',25.00,'authorize','not_paid','','2021-01-07 15:25:57','2021-01-07 15:25:57','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','off','off','off',''),(17,1,24,'Get 50% off your first trip with us!','IILECKT4','OITPVGP7','sdfsf','sdfsf','roxana@incorom.ro','roxana@incorom.ro','dfdg','2021-01-07 15:29:19',25.00,'authorize','not_paid','','2021-01-07 15:29:19','2021-01-07 15:29:19','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','off','off','off',''),(18,1,26,'Get 50% off your first trip with us!','Z5QPEOUA','UWSLIKYZ','dfsf','sdfsdf','roxana@incorom.ro','roxana@incorom.ro','sdfsdf','2021-01-07 15:34:14',25.00,'authorize','not_paid','','2021-01-07 15:34:14','2021-01-07 15:34:14','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','off','off','off',''),(19,1,24,'Get 50% off your first trip with us!','WDX24CB7','AZIMS2JV','sfsdf','sdfsdf','roxana@tech360group.com','roxana@tech360group.com','ertert','2021-01-07 15:36:55',25.00,'authorize','not_paid','','2021-01-07 15:36:55','2021-01-07 15:36:55','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','off','off','off',''),(20,1,24,'Get 50% off your first trip with us!','UJHYEJAY','HCTI3JQP','sfsdf','sfsdf','roxana@tech360group.com','roxana@tech360group.com','tert','2021-01-07 15:44:08',25.00,'authorize','not_paid','','2021-01-07 15:44:08','2021-01-07 15:44:08','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','off','off','off',''),(21,1,24,'Get 50% off your first trip with us!','CVDWVI0L','FBL4N4QU','sdfsdf','sfsdf','roxana@tech360group.com','roxana@tech360group.com','sdfsf','2021-01-07 15:50:37',25.00,'authorize','paid','a:44:{s:15:\"x_response_code\";s:1:\"1\";s:22:\"x_response_reason_code\";s:1:\"1\";s:22:\"x_response_reason_text\";s:46:\"(TESTMODE) This transaction has been approved.\";s:10:\"x_avs_code\";s:1:\"P\";s:11:\"x_auth_code\";s:6:\"000000\";s:10:\"x_trans_id\";s:1:\"0\";s:8:\"x_method\";s:2:\"CC\";s:11:\"x_card_type\";s:4:\"Visa\";s:16:\"x_account_number\";s:8:\"XXXX1111\";s:12:\"x_first_name\";s:0:\"\";s:11:\"x_last_name\";s:0:\"\";s:9:\"x_company\";s:0:\"\";s:9:\"x_address\";s:0:\"\";s:6:\"x_city\";s:0:\"\";s:7:\"x_state\";s:0:\"\";s:5:\"x_zip\";s:0:\"\";s:9:\"x_country\";s:0:\"\";s:7:\"x_phone\";s:0:\"\";s:5:\"x_fax\";s:0:\"\";s:7:\"x_email\";s:23:\"roxana@tech360group.com\";s:13:\"x_invoice_num\";s:8:\"CVDWVI0L\";s:13:\"x_description\";s:8:\"Giftcard\";s:6:\"x_type\";s:12:\"auth_capture\";s:9:\"x_cust_id\";s:2:\"21\";s:20:\"x_ship_to_first_name\";s:0:\"\";s:19:\"x_ship_to_last_name\";s:0:\"\";s:17:\"x_ship_to_company\";s:0:\"\";s:17:\"x_ship_to_address\";s:0:\"\";s:14:\"x_ship_to_city\";s:0:\"\";s:15:\"x_ship_to_state\";s:0:\"\";s:13:\"x_ship_to_zip\";s:0:\"\";s:17:\"x_ship_to_country\";s:0:\"\";s:8:\"x_amount\";s:5:\"25.00\";s:5:\"x_tax\";s:4:\"0.00\";s:6:\"x_duty\";s:4:\"0.00\";s:9:\"x_freight\";s:4:\"0.00\";s:12:\"x_tax_exempt\";s:5:\"FALSE\";s:8:\"x_po_num\";s:0:\"\";s:10:\"x_MD5_Hash\";s:0:\"\";s:11:\"x_SHA2_Hash\";s:128:\"4876175D62C167FBEFC281F3075E65F371E336E43963AA19E68B40052F3A30E82DD683A8EDA65D2F5ED60DF2CEFB61B2052C5D977F3CFD9257EE8C1C424D1B5A\";s:16:\"x_cvv2_resp_code\";s:0:\"\";s:15:\"x_cavv_response\";s:0:\"\";s:14:\"x_test_request\";s:4:\"true\";s:18:\"x_method_available\";s:4:\"true\";}','2021-01-07 15:50:37','2021-01-07 15:58:02','sent','2021-01-07 15:58:01','not_opened','0000-00-00 00:00:00','off','off','off',''),(22,1,24,'Get 50% off your first trip with us!','S62NXXGJ','DQ6MFFDU','dfgdfg','fgdfg','roxana@tech360group.com','roxana@tech360group.com','test','2021-01-07 15:59:55',25.00,'authorize','paid','a:44:{s:15:\"x_response_code\";s:1:\"1\";s:22:\"x_response_reason_code\";s:1:\"1\";s:22:\"x_response_reason_text\";s:46:\"(TESTMODE) This transaction has been approved.\";s:10:\"x_avs_code\";s:1:\"P\";s:11:\"x_auth_code\";s:6:\"000000\";s:10:\"x_trans_id\";s:1:\"0\";s:8:\"x_method\";s:2:\"CC\";s:11:\"x_card_type\";s:4:\"Visa\";s:16:\"x_account_number\";s:8:\"XXXX1111\";s:12:\"x_first_name\";s:0:\"\";s:11:\"x_last_name\";s:0:\"\";s:9:\"x_company\";s:0:\"\";s:9:\"x_address\";s:0:\"\";s:6:\"x_city\";s:0:\"\";s:7:\"x_state\";s:0:\"\";s:5:\"x_zip\";s:0:\"\";s:9:\"x_country\";s:0:\"\";s:7:\"x_phone\";s:0:\"\";s:5:\"x_fax\";s:0:\"\";s:7:\"x_email\";s:23:\"roxana@tech360group.com\";s:13:\"x_invoice_num\";s:8:\"S62NXXGJ\";s:13:\"x_description\";s:8:\"Giftcard\";s:6:\"x_type\";s:12:\"auth_capture\";s:9:\"x_cust_id\";s:2:\"22\";s:20:\"x_ship_to_first_name\";s:0:\"\";s:19:\"x_ship_to_last_name\";s:0:\"\";s:17:\"x_ship_to_company\";s:0:\"\";s:17:\"x_ship_to_address\";s:0:\"\";s:14:\"x_ship_to_city\";s:0:\"\";s:15:\"x_ship_to_state\";s:0:\"\";s:13:\"x_ship_to_zip\";s:0:\"\";s:17:\"x_ship_to_country\";s:0:\"\";s:8:\"x_amount\";s:5:\"25.00\";s:5:\"x_tax\";s:4:\"0.00\";s:6:\"x_duty\";s:4:\"0.00\";s:9:\"x_freight\";s:4:\"0.00\";s:12:\"x_tax_exempt\";s:5:\"FALSE\";s:8:\"x_po_num\";s:0:\"\";s:10:\"x_MD5_Hash\";s:0:\"\";s:11:\"x_SHA2_Hash\";s:128:\"BF55BCCC42EEFB88353C4F55A4B1328FDCFF1D6E48C761D47B039705CB9425152BE516A0ACB4F3AE483D67E0693E22C1CFD4F22B937CD97D117AC6F6A7CC1D34\";s:16:\"x_cvv2_resp_code\";s:0:\"\";s:15:\"x_cavv_response\";s:0:\"\";s:14:\"x_test_request\";s:4:\"true\";s:18:\"x_method_available\";s:4:\"true\";}','2021-01-07 15:59:55','2021-01-07 16:00:03','sent','2021-01-07 16:00:02','not_opened','0000-00-00 00:00:00','off','off','off',''),(23,1,24,'Get 50% off your first trip with us!','RFYQEDDS','1WLPHOWG','Sender','Receiver','roxana@driveprofit.com','roxana@tech360group.com','Hi!','2021-01-07 16:38:29',25.00,'authorize','paid','a:44:{s:15:\"x_response_code\";s:1:\"1\";s:22:\"x_response_reason_code\";s:1:\"1\";s:22:\"x_response_reason_text\";s:46:\"(TESTMODE) This transaction has been approved.\";s:10:\"x_avs_code\";s:1:\"P\";s:11:\"x_auth_code\";s:6:\"000000\";s:10:\"x_trans_id\";s:1:\"0\";s:8:\"x_method\";s:2:\"CC\";s:11:\"x_card_type\";s:4:\"Visa\";s:16:\"x_account_number\";s:8:\"XXXX1111\";s:12:\"x_first_name\";s:0:\"\";s:11:\"x_last_name\";s:0:\"\";s:9:\"x_company\";s:0:\"\";s:9:\"x_address\";s:0:\"\";s:6:\"x_city\";s:0:\"\";s:7:\"x_state\";s:0:\"\";s:5:\"x_zip\";s:0:\"\";s:9:\"x_country\";s:0:\"\";s:7:\"x_phone\";s:0:\"\";s:5:\"x_fax\";s:0:\"\";s:7:\"x_email\";s:22:\"roxana@driveprofit.com\";s:13:\"x_invoice_num\";s:8:\"RFYQEDDS\";s:13:\"x_description\";s:8:\"Giftcard\";s:6:\"x_type\";s:12:\"auth_capture\";s:9:\"x_cust_id\";s:2:\"23\";s:20:\"x_ship_to_first_name\";s:0:\"\";s:19:\"x_ship_to_last_name\";s:0:\"\";s:17:\"x_ship_to_company\";s:0:\"\";s:17:\"x_ship_to_address\";s:0:\"\";s:14:\"x_ship_to_city\";s:0:\"\";s:15:\"x_ship_to_state\";s:0:\"\";s:13:\"x_ship_to_zip\";s:0:\"\";s:17:\"x_ship_to_country\";s:0:\"\";s:8:\"x_amount\";s:5:\"25.00\";s:5:\"x_tax\";s:4:\"0.00\";s:6:\"x_duty\";s:4:\"0.00\";s:9:\"x_freight\";s:4:\"0.00\";s:12:\"x_tax_exempt\";s:5:\"FALSE\";s:8:\"x_po_num\";s:0:\"\";s:10:\"x_MD5_Hash\";s:0:\"\";s:11:\"x_SHA2_Hash\";s:128:\"E5A07075B0046528804BD4E7B2F7551389A91C4CCF3C99BC7AA9EE3AB266012D2EDD18048A96C7FCD4E2406D9CB010EED21D9EEF18309587098BDC7FE43150C1\";s:16:\"x_cvv2_resp_code\";s:0:\"\";s:15:\"x_cavv_response\";s:0:\"\";s:14:\"x_test_request\";s:4:\"true\";s:18:\"x_method_available\";s:4:\"true\";}','2021-01-07 16:38:29','2021-01-07 16:39:02','sent','2021-01-07 16:39:02','not_opened','0000-00-00 00:00:00','on','off','off',''),(24,1,24,'Get 50% off your first trip with us!','R4ZNNOKY','LE3485PW','sfsd','sfsdf','roxana@incorom.ro','roxana@incorom.ro','tert','2021-01-07 16:42:47',25.00,'authorize','paid','a:44:{s:15:\"x_response_code\";s:1:\"1\";s:22:\"x_response_reason_code\";s:1:\"1\";s:22:\"x_response_reason_text\";s:46:\"(TESTMODE) This transaction has been approved.\";s:10:\"x_avs_code\";s:1:\"P\";s:11:\"x_auth_code\";s:6:\"000000\";s:10:\"x_trans_id\";s:1:\"0\";s:8:\"x_method\";s:2:\"CC\";s:11:\"x_card_type\";s:4:\"Visa\";s:16:\"x_account_number\";s:8:\"XXXX1111\";s:12:\"x_first_name\";s:0:\"\";s:11:\"x_last_name\";s:0:\"\";s:9:\"x_company\";s:0:\"\";s:9:\"x_address\";s:0:\"\";s:6:\"x_city\";s:0:\"\";s:7:\"x_state\";s:0:\"\";s:5:\"x_zip\";s:0:\"\";s:9:\"x_country\";s:0:\"\";s:7:\"x_phone\";s:0:\"\";s:5:\"x_fax\";s:0:\"\";s:7:\"x_email\";s:17:\"roxana@incorom.ro\";s:13:\"x_invoice_num\";s:8:\"R4ZNNOKY\";s:13:\"x_description\";s:8:\"Giftcard\";s:6:\"x_type\";s:12:\"auth_capture\";s:9:\"x_cust_id\";s:2:\"24\";s:20:\"x_ship_to_first_name\";s:0:\"\";s:19:\"x_ship_to_last_name\";s:0:\"\";s:17:\"x_ship_to_company\";s:0:\"\";s:17:\"x_ship_to_address\";s:0:\"\";s:14:\"x_ship_to_city\";s:0:\"\";s:15:\"x_ship_to_state\";s:0:\"\";s:13:\"x_ship_to_zip\";s:0:\"\";s:17:\"x_ship_to_country\";s:0:\"\";s:8:\"x_amount\";s:5:\"25.00\";s:5:\"x_tax\";s:4:\"0.00\";s:6:\"x_duty\";s:4:\"0.00\";s:9:\"x_freight\";s:4:\"0.00\";s:12:\"x_tax_exempt\";s:5:\"FALSE\";s:8:\"x_po_num\";s:0:\"\";s:10:\"x_MD5_Hash\";s:0:\"\";s:11:\"x_SHA2_Hash\";s:128:\"67296F47A441540C3E4270630754241C1EA5C3D4EFCB8E96900D6221688314B1E201168DBA71A69E1266867B56FF13928EFC8180DD121C7802ADDF79ECCD2103\";s:16:\"x_cvv2_resp_code\";s:0:\"\";s:15:\"x_cavv_response\";s:0:\"\";s:14:\"x_test_request\";s:4:\"true\";s:18:\"x_method_available\";s:4:\"true\";}','2021-01-07 16:42:47','2021-01-07 16:43:02','sent','2021-01-07 16:43:02','not_opened','0000-00-00 00:00:00','off','off','off',''),(25,1,24,'Get 50% off your first trip with us!','GBDOMWYR','4BWJKIYU','sdfsdf','sdfsdf','roxana@incorom.ro','roxana@incorom.ro','dgdfg','2021-01-07 18:30:44',25.00,'paypal','not_paid','','2021-01-07 18:30:44','2021-01-07 18:30:44','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','off','off','off',''),(26,2,35,'Help your loved ones travel easier for New Year with a $50 giftcard that can be used for any Gateway Limousines services.','EFWB69K7','VQDQL0KJ','test','test','roxana@tech360group.com','roxana@tech360group.com','test','2021-01-08 08:23:51',50.00,'authorize','not_paid','','2021-01-08 08:23:51','2021-01-08 08:23:51','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','off','off','off',''),(27,2,35,'Help your loved ones travel easier for New Year with a $50 giftcard that can be used for any Gateway Limousines services.','MIXGVFMI','HH5QNA9P','Test','Test','roxana@tech360group.com','roxana@tech360group.com','test','2021-01-08 08:25:05',50.00,'paypal','paid','a:36:{s:9:\"TIMESTAMP\";s:20:\"2021-01-08T08:25:47Z\";s:13:\"CORRELATIONID\";s:13:\"64fcd756344b7\";s:3:\"ACK\";s:7:\"Success\";s:7:\"VERSION\";s:4:\"57.0\";s:5:\"BUILD\";s:8:\"55025969\";s:3:\"AMT\";s:5:\"50.00\";s:12:\"CURRENCYCODE\";s:3:\"USD\";s:7:\"AVSCODE\";s:1:\"A\";s:9:\"CVV2MATCH\";s:1:\"M\";s:13:\"TRANSACTIONID\";s:17:\"8SE36646AL860334M\";s:15:\"x_response_code\";i:1;s:10:\"x_trans_id\";s:17:\"8SE36646AL860334M\";s:8:\"x_amount\";s:5:\"50.00\";s:11:\"x_SHA2_Hash\";s:13:\"64fcd756344b7\";s:9:\"x_cust_id\";s:2:\"27\";s:13:\"x_description\";s:8:\"Giftcard\";s:22:\"x_response_reason_text\";s:0:\"\";s:9:\"x_address\";s:5:\"dsfsd\";s:6:\"x_city\";s:3:\"sdf\";s:7:\"x_state\";s:2:\"AL\";s:5:\"x_zip\";s:3:\"123\";s:11:\"x_card_type\";s:6:\"Paypal\";s:12:\"x_first_name\";s:4:\"Test\";s:11:\"x_last_name\";s:0:\"\";s:9:\"x_country\";s:2:\"US\";s:7:\"x_email\";s:23:\"roxana@tech360group.com\";s:7:\"x_phone\";s:0:\"\";s:20:\"x_ship_to_first_name\";s:4:\"Test\";s:19:\"x_ship_to_last_name\";s:0:\"\";s:17:\"x_ship_to_address\";s:5:\"dsfsd\";s:14:\"x_ship_to_city\";s:3:\"sdf\";s:13:\"x_ship_to_zip\";s:3:\"123\";s:17:\"x_ship_to_country\";s:2:\"US\";s:11:\"x_auth_code\";s:13:\"64fcd756344b7\";s:16:\"x_account_number\";s:23:\"roxana@tech360group.com\";s:13:\"x_invoice_num\";s:8:\"MIXGVFMI\";}','2021-01-08 08:25:05','2021-01-08 08:25:47','queued','0000-00-00 00:00:00','not_opened','0000-00-00 00:00:00','off','off','off','');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

#
# Data for table "account_user"
#

INSERT INTO `account_user` VALUES (1,1,'roxana@driveprofit.com','roxana','0000-00-00','on','Roxana Lupu','','active','','2020-12-05 17:51:33','2020-12-06 12:43:38'),(2,2,'andrei@tech360group.com','demo','0000-00-00','on','Main Admin','','active','','2020-12-11 09:22:16','2020-12-11 09:22:16');

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
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "account_user_logs"
#

INSERT INTO `account_user_logs` VALUES (1,1,1,1,'::1','2020-12-06 12:12:02'),(2,1,1,1,'::1','2020-12-06 12:43:28'),(3,1,1,1,'::1','2020-12-06 16:16:34'),(4,1,1,1,'::1','2020-12-07 12:29:24'),(5,1,1,1,'::1','2020-12-07 21:57:50'),(6,1,1,1,'::1','2020-12-08 06:49:00'),(7,1,1,1,'::1','2020-12-08 12:30:52'),(8,1,1,1,'86.122.83.248','2020-12-11 08:41:12'),(9,1,1,1,'86.122.83.248','2020-12-11 09:13:53'),(10,2,2,1,'86.122.83.248','2020-12-11 09:22:25'),(11,2,2,1,'86.122.83.248','2020-12-11 12:16:22'),(12,2,2,1,'86.122.83.248','2020-12-11 15:15:59'),(13,1,1,1,'86.126.173.96','2021-01-07 15:19:22'),(14,1,1,1,'86.126.173.96','2021-01-07 16:32:22'),(15,1,1,1,'86.126.173.96','2021-01-07 18:29:41'),(16,2,2,1,'::1','2021-01-08 08:22:56');

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
