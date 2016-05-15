<?php return [
  1 => [
      'up' => 'CREATE TABLE `posts`(  
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255),
  `active` TINYINT(1),
  `content` TEXT,
  PRIMARY KEY (`id`)
);',
      'down' => 'DROP TABLE posts'
  ]
    
    
];
