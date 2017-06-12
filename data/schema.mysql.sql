-- To create a new database, run MySQL client:
--   mysql -u root -p <password>
-- Then in MySQL client command line, type the following (replace <password> with password string):
--   create database blog;
--   grant all privileges on NoFrameworkBlog.* to root@localhost identified by '<password>';
--   quit
-- Then, in shell command line, type:
--   mysql -u root -p <password> < schema.mysql.sql

-- CREATE SCHEMA `noframeworkblog` ;

set names 'utf8';

-- Post
CREATE TABLE `post` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID
  `title` text NOT NULL UNIQUE,     -- Title  
  `content` text NOT NULL,          -- Text 
  `status` int(11) NOT NULL,        -- Status  
  `id_user` int(11) NOT NULL,       -- User's ID of Author
  `date_created` DATETIME DEFAULT   CURRENT_TIMESTAMP -- Creation date    
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Comment
CREATE TABLE `comment` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID  
  `post_id` int(11) NOT NULL,     -- Post ID this comment belongs to  
  `content` text NOT NULL,        -- Text
  `author` varchar(128) NOT NULL, -- Author's name who created the comment  
  `date_created` DATETIME DEFAULT   CURRENT_TIMESTAMP -- Creation date          
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Tag
CREATE TABLE `tag` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID.  
  `name` VARCHAR(128) NOT NULL,            -- Tag name.  
  UNIQUE KEY `name_key` (`name`)          -- Tag names must be unique.      
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

-- Post-Tag
CREATE TABLE `post_tag` (     
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID  
  `post_id` int(11),                       -- Post id
  `tag_id` int(11),                        -- Tag id
   UNIQUE KEY `unique_key` (`post_id`, `tag_id`), -- Tag names must be unique.
   KEY `post_id_key` (`post_id`),
   KEY `tag_id_key` (`tag_id`)      
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';

INSERT INTO tag(`name`) VALUES('ZF3');
INSERT INTO tag(`name`) VALUES('book');
INSERT INTO tag(`name`) VALUES('magento');
INSERT INTO tag(`name`) VALUES('bootstrap');

INSERT INTO post(`title`, `content`, `status`, `date_created`, id_user) VALUES
(
   'A Free Book about Zend Framework',
   'I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.', 
   2, '2017-07-06 10:50',1),
(
   'Getting Started with Magento Extension Development - Book Review',
   'Recently, I needed some good resource to start learning Magento e-Commerce system for one of my current web projects. For this project, I was required to write an extension module that would implement a customer-specific payment method.', 
   2, '2017-06-06 10:50',1),
(
   'Twitter Bootstrap - Making a Professionaly Looking Site',
   'Twitter Bootstrap (shortly, Bootstrap) is a popular CSS framework allowing to make your web site professionally looking and visually appealing, even if you don''t have advanced designer skills.', 
   2, '2017-05-06 10:50',1);

INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(1, 1);
INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(1, 2);
INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(2, 2);
INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(2, 3);
INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(3, 4);

INSERT INTO comment(`post_id`, `content`, `author`, `date_created`) VALUES(
    1, 'Excellent post!', 'Eugene Kaurov', '2017-06-12 10:50');


CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `email`    varchar(100) NOT NULL UNIQUE,
  `name`        varchar(250) DEFAULT NULL,
  `password`    varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
INSERT INTO `user` (`id`, `email`, `name`, `password`) VALUES
(1, 'eugene.kaurov@gmail.com', 'Eugen Kaurov', '202cb962ac59075b964b07152d234b70');