CREATE TABLE IF NOT EXISTS `password_reset_request` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `date_requested` datetime NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
   names varchar(255), 
  email varchar(255),
  password int(50),
  isAdmin boolean,
  CreationDate timestamp  DEFAULT CURRENT_TIMESTAMP,
  UpdationDate timestamp  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    Tittle varchar(255),
description text,
image varchar(255),
UserId int ,
Category int, 
CreationDate timestamp  DEFAULT CURRENT_TIMESTAMP,
UpdationDate timestamp  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      title decimal,
AdminId int ,
CreationDate timestamp  DEFAULT CURRENT_TIMESTAMP,
UpdationDate timestamp  DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

Table user {
id int [pk]

}
Table blogs{
id int [pk]

}
Table Categories{
id int [pk]

}