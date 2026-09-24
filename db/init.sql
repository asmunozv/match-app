CREATE DATABASE IF NOT EXISTS matchapp;
USE matchapp;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  age TINYINT UNSIGNED NOT NULL,
  city VARCHAR(100) NOT NULL,
  bio VARCHAR(500) DEFAULT '',
  photo_url VARCHAR(500) DEFAULT '',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  question TEXT NOT NULL,
  category ENUM('values','communication','lifestyle','affection','social','future') NOT NULL
);

CREATE TABLE answers (
  user_id INT NOT NULL,
  question_id INT NOT NULL,
  answer TINYINT UNSIGNED NOT NULL,
  PRIMARY KEY (user_id, question_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (question_id) REFERENCES questions(id) ON DELETE CASCADE
);

CREATE TABLE likes (
  user_id INT NOT NULL,
  liked_user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (user_id, liked_user_id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (liked_user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE matches (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user1_id INT NOT NULL,
  user2_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_match (user1_id, user2_id),
  FOREIGN KEY (user1_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (user2_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO questions (question, category) VALUES
('¿Qué buscas principalmente en una relación?', 'values'),
('¿Qué tan importante es la honestidad para ti?', 'values'),
('¿Qué tan importante es la confianza?', 'values'),
('¿Qué opinas de hablar los problemas inmediatamente?', 'communication'),
('¿Cómo prefieres resolver un desacuerdo?', 'communication'),
('¿Qué tan importante es sentir que tu pareja te escucha?', 'communication'),
('¿Prefieres mensajes durante todo el día o hablar en momentos concretos?', 'communication'),
('¿Qué tan importante es tener conversaciones profundas?', 'communication'),
('¿Qué tan importante es tener tiempo a solas?', 'lifestyle'),
('¿Prefieres salir o quedarte en casa?', 'lifestyle'),
('¿Qué tan espontáneo te gusta que sea un plan?', 'lifestyle'),
('¿Qué tan importante es compartir hobbies?', 'lifestyle'),
('¿Te gusta viajar con tu pareja?', 'lifestyle'),
('¿Qué tan importante es que tengan rutinas parecidas?', 'lifestyle'),
('¿Cómo prefieres recibir cariño?', 'affection'),
('¿Cómo sueles demostrar cariño?', 'affection'),
('¿Qué tan importante son los detalles pequeños?', 'affection'),
('¿Qué tan cómodo/a te sientes con las muestras públicas de cariño?', 'affection'),
('¿Qué tan importante es el contacto físico?', 'affection'),
('¿Qué tan romántico/a te consideras?', 'affection'),
('¿Te gusta conocer y convivir con los amigos de tu pareja?', 'social'),
('¿Qué tan importante es tener una vida social parecida?', 'social'),
('¿Cómo te sientes en reuniones grandes?', 'social'),
('¿Qué tan importante es que tu pareja se lleve bien con tus amigos?', 'social'),
('¿Qué tan importante es mantener amistades independientes?', 'social'),
('¿Qué esperas de una relación a largo plazo?', 'future'),
('¿Qué tan importante es hablar sobre planes de futuro?', 'future'),
('¿Qué tan importante es la estabilidad económica?', 'future'),
('¿Te gustaría formar una familia algún día?', 'future'),
('¿Qué tan importante es crecer juntos como personas?', 'future');
