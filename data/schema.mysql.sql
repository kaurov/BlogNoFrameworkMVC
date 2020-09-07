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

-- Blog Posts
DROP TABLE IF EXISTS `post`;

CREATE TABLE `post` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID
  `title` varchar(250) NOT NULL UNIQUE,     -- Title
  `content` text(5000) NOT NULL,          -- Text
  `status` int(11) NOT NULL,        -- Status
  `id_user` int(11) NOT NULL,       -- User's ID of Author
  `date_created` DATETIME          -- Creation date
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';


-- users Comments for posts
DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID
  `post_id` int(11) NOT NULL,     -- Post ID this comment belongs to
  `content` text(5000) NOT NULL,        -- Text
  `author` varchar(128) NOT NULL, -- Author's name who created the comment
  `author_url` varchar(128) DEFAULT NULL, -- Author's URL of homepage
  `author_email` varchar(128) DEFAULT NULL, -- Author's email
  `date_created` DATETIME         -- Creation date
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';


-- List of available Tags (categories)
DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT, -- Unique ID.
  `name` VARCHAR(128) NOT NULL,            -- Tag name.
  UNIQUE KEY `name_key` (`name`)          -- Tag names must be unique.
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='utf8_general_ci';


-- Post-Tag many to many relations
DROP TABLE IF EXISTS `post_tag`;
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

# noinspection SpellCheckingInspection

INSERT INTO post(`title`, `content`, `status`, `date_created`, id_user) VALUES
  (
    'A Free Book about Zend Framework',
    'I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute. I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute. You should not see this text in Short version    <h2>You should not see this text in Short version </h2> I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute. I''m pleased to announce that now you can read my new book "Using Zend Framework 3" absolutely for free! Moreover, the book is an open-source project hosted on GitHub, so you are encouraged to contribute.',
    2, '2020-02-24 10:50',1),
  (
    'Getting Started with Magento Extension Development - Book Review',
    'Recently, I needed some good resource to start learning Magento e-Commerce system for one of my current web projects. For this project, I was required to write an extension module that would implement a customer-specific payment method.',
    2, '2020-06-06 10:50',1),
  (
    'Twitter Bootstrap - Making a Professionally Looking Site',
    'Twitter Bootstrap (shortly, Bootstrap) is a popular CSS framework allowing to make your web site professionally looking and visually appealing, even if you don''t have advanced designer skills.',
    2, '2020-05-06 10:50',1);

INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(1, 1);
INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(1, 2);
INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(2, 2);
INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(2, 3);
INSERT INTO post_tag(`post_id`, `tag_id`) VALUES(3, 4);

INSERT INTO comment(`post_id`, `content`, `author`, `date_created`) VALUES(
  1, 'Excellent post!', 'Eugene Kaurov', '2020-02-24 10:50');

-- CREATE TABLE IF NOT EXISTS `user` (
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email`    varchar(100) NOT NULL UNIQUE,
  `name`        varchar(250) DEFAULT NULL,
  `password`    varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- For the test sake input login eugene.kaurov@gmail.com and password 123
INSERT INTO `user` (`id`, `email`, `name`, `password`)
VALUES
(
    1,
    'eugene.kaurov@gmail.com',
    'Eugen Kaurov',
    '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2'
);