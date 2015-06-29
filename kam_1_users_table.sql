CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL auto_increment primary key,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `street` varchar(45) NOT NULL,
  `city` varchar(45) NOT NULL,
  `zip_code` varchar(6) NOT NULL,
  `house_nr` int(10) unsigned NOT NULL,
  `apartment_nr` int(10) unsigned NOT NULL,
  `password` char(32) NOT NULL
);