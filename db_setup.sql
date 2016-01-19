CREATE DATABASE `blog` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_time` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `text` text NOT NULL,
  `author_ID` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author_ID` (`author_ID`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_ID`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(200) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `f_name` varchar(30) DEFAULT NULL,
  `l_name` varchar(30) DEFAULT NULL,
  `image_name` varchar(80) NOT NULL,
  `admin` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
