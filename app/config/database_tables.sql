CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    name VARCHAR(255),
    username VARCHAR(255),
    email VARCHAR(255),
    password VARCHAR(255),
    profile_img VARCHAR(255) DEFAULT 'img/default-profile.png',
    email_notification INT(11) DEFAULT '1',
    activation TINYINT(1) DEFAULT NULL,
    validation_hash VARCHAR(255),
    forget_pass_hash VARCHAR(255) DEFAULT 'empty'
);

CREATE TABLE IF NOT EXISTS images (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT(11),
    image_url VARCHAR(255),
    creation_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS comments (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    image_id INT(11),
    user_id INT(11),
    comment TEXT,
    comment_date DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS likes (
    id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id INT(11),
    image_id INT(11),
    liked INT(11) DEFAULT NULL
);