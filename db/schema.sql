CREATE TABLE IF NOT EXISTS users (
  id BIGSERIAL PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  age SMALLINT NOT NULL CHECK (age >= 18 AND age <= 100),
  city VARCHAR(100) NOT NULL,
  bio VARCHAR(500) NOT NULL DEFAULT '',
  photo_url VARCHAR(500) NOT NULL DEFAULT '',
  created_at TIMESTAMPTZ NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS questions (
  id BIGSERIAL PRIMARY KEY,
  question TEXT NOT NULL,
  category VARCHAR(30) NOT NULL CHECK (category IN ('values','communication','lifestyle','affection','social','future'))
);

CREATE TABLE IF NOT EXISTS answers (
  user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  question_id BIGINT NOT NULL REFERENCES questions(id) ON DELETE CASCADE,
  answer SMALLINT NOT NULL CHECK (answer BETWEEN 1 AND 5),
  PRIMARY KEY (user_id, question_id)
);

CREATE TABLE IF NOT EXISTS likes (
  user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  liked_user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
  PRIMARY KEY (user_id, liked_user_id),
  CHECK (user_id <> liked_user_id)
);

CREATE TABLE IF NOT EXISTS matches (
  id BIGSERIAL PRIMARY KEY,
  user1_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  user2_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
  created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
  UNIQUE (user1_id, user2_id),
  CHECK (user1_id < user2_id)
);

INSERT INTO questions (question, category) VALUES
('¿Qué buscas principalmente en una relación?', 'values'),
('¿Qué tan importante es la honestidad para ti?', 'values'),
('¿Qué tan importante es la confianza?', 'values'),
('¿Qué tan importante es respetar los límites de la otra persona?', 'values'),
('¿Qué tan importante es poder ser tú mismo/a dentro de la relación?', 'values'),
('¿Qué tan importante es hablar los problemas antes de dejarlos crecer?', 'communication'),
('¿Cómo prefieres resolver un desacuerdo?', 'communication'),
('¿Qué tan importante es sentir que tu pareja te escucha?', 'communication'),
('¿Prefieres mensajes durante todo el día o hablar en momentos concretos?', 'communication'),
('¿Qué tan importante es tener conversaciones profundas?', 'communication'),
('¿Qué tan importante es tener tiempo a solas?', 'lifestyle'),
('¿Prefieres salir o quedarte en casa?', 'lifestyle'),
('¿Qué tan espontáneos te gustan los planes?', 'lifestyle'),
('¿Qué tan importante es compartir hobbies?', 'lifestyle'),
('¿Te gustaría viajar con tu pareja?', 'lifestyle'),
('¿Qué tan importante es tener rutinas parecidas?', 'lifestyle'),
('¿Cómo prefieres recibir cariño?', 'affection'),
('¿Cómo sueles demostrar cariño?', 'affection'),
('¿Qué tan importantes son los pequeños detalles?', 'affection'),
('¿Qué tan cómodo/a te sientes con las muestras públicas de cariño?', 'affection'),
('¿Qué tan importante es el contacto físico?', 'affection'),
('¿Qué tan romántico/a te consideras?', 'affection'),
('¿Te gusta conocer a los amigos de tu pareja?', 'social'),
('¿Qué tan importante es tener una vida social parecida?', 'social'),
('¿Cómo te sientes en reuniones grandes?', 'social'),
('¿Qué tan importante es que tu pareja se lleve bien con tus amigos?', 'social'),
('¿Qué tan importante es mantener amistades independientes?', 'social'),
('¿Qué esperas de una relación a largo plazo?', 'future'),
('¿Qué tan importante es hablar sobre planes de futuro?', 'future'),
('¿Qué tan importante es crecer juntos como personas?', 'future')
ON CONFLICT DO NOTHING;
