USE tcc;
CREATE TABLE campus_address (
  id INT PRIMARY KEY AUTO_INCREMENT,
  street VARCHAR(100),
  address_number VARCHAR(10),
  city VARCHAR(50),
  state CHAR(2),
  zip_code VARCHAR(20)
);
CREATE TABLE course (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  link VARCHAR(255) NOT NULL
);
CREATE TABLE campus (
  id INT PRIMARY KEY AUTO_INCREMENT,
  address_id INT NOT NULL,
  name VARCHAR(255) NOT NULL,
  phone VARCHAR(30),
  email VARCHAR(255),
  FOREIGN KEY (address_id) REFERENCES campus_address(id)
);


CREATE TABLE user (
  id INT PRIMARY KEY AUTO_INCREMENT,
  profile_photo_path VARCHAR(255) DEFAULT NULL,
  name VARCHAR(70) NOT NULL,
  phone varchar(50),
  email VARCHAR(100) UNIQUE NOT NULL,
  address VARCHAR(200) NULL,
  registration VARCHAR(50) NOT NULL,
  birthday DATE NOT NULL,
  role ENUM('student', 'teacher') NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  password_hash VARCHAR(255) NOT NULL
  
);
CREATE TABLE user_course(
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id int,
  course_id int,
  Foreign Key (course_id) REFERENCES course(id),
  FOREIGN KEY (user_id) REFERENCES user(id)
)
CREATE TABLE user_campus(
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id int,
  campus_id int,
  Foreign Key (campus_id) REFERENCES campus(id),
  FOREIGN KEY (user_id) REFERENCES user(id)
)
CREATE TABLE refresh_tokens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  token VARCHAR(255) NOT NULL UNIQUE,
  expires_at DATETIME NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES user(id)
);
CREATE TABLE server (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(70) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE campus_course (
  id INT PRIMARY KEY AUTO_INCREMENT,
  campus_id INT NOT NULL,
  course_id INT NOT NULL,
  FOREIGN KEY (campus_id) REFERENCES campus(id),
  FOREIGN KEY (course_id) REFERENCES course(id)
);
CREATE TABLE post (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_author INT,
  server_id INT,
  content TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_author) REFERENCES user(id) on delete
  set null,
    FOREIGN KEY (server_id) REFERENCES server(id) on delete CASCADE
);
CREATE TABLE likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  content_type VARCHAR(50) NOT NULL,
  content_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_like (user_id, content_type, content_id)
);
CREATE TABLE comment (
  id INT PRIMARY KEY AUTO_INCREMENT,
  id_post INT,
  id_author INT,
  id_parent_comment INT DEFAULT NULL,
  content TEXT,
  likes INT DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (id_post) REFERENCES post(id) on delete CASCADE,
  FOREIGN KEY (id_author) REFERENCES user(id) on delete
  set null,
    FOREIGN KEY (id_parent_comment) REFERENCES comment(id) on delete CASCADE
);
CREATE TABLE message (
  id INT AUTO_INCREMENT PRIMARY KEY,
  sender_id INT NOT NULL,
  receiver_id INT NOT NULL,
  content TEXT NULL,
  media_url VARCHAR(255) NULL,
  media_type VARCHAR(50) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_read BOOLEAN DEFAULT FALSE,
  FOREIGN KEY (sender_id) REFERENCES user(id),
  FOREIGN KEY (receiver_id) REFERENCES user(id),
  CHECK (
    content IS NOT NULL
    OR media_url IS NOT NULL
  )
);
CREATE TABLE follower (
  id INT PRIMARY KEY AUTO_INCREMENT,
  follower_id INT NOT NULL,
  followed_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  FOREIGN KEY (follower_id) REFERENCES user(id),
  FOREIGN KEY (followed_id) REFERENCES user(id)
);
