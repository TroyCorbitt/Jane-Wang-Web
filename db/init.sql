-- database: ../test.sqlite
-- Note: Do not delete the line above! It is helpful for testing your init.sql file.
--
CREATE TABLE songs (
  id INTEGER NOT NULL UNIQUE,
  ranking INTEGER NOT NULL,
  song_name TEXT NOT NULL,
  artist INTEGER NOT NULL,
  album INTEGER,
  release_date TEXT,
  genre TEXT,
  languages TEXT,
  file_path TEXT,
  file_type TEXT,
  PRIMARY KEY(id AUTOINCREMENT)
);



CREATE TABLE tags (
  id INTEGER NOT NULL UNIQUE,
  name TEXT NOT NULL UNIQUE,
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE song_tags (
  id INTEGER NOT NULL UNIQUE,
  song_id INTEGER NOT NULL,
  tag_id INTEGER NOT NULL,
  FOREIGN KEY(song_id) REFERENCES songs(id),
  FOREIGN KEY(tag_id) REFERENCES tags(id),
  -- PRIMARY KEY(song_id, tag_id),
  PRIMARY KEY(id AUTOINCREMENT)
);

CREATE TABLE users (
  id INTEGER NOT NULL UNIQUE,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL
);

CREATE TABLE sessions (
  id INTEGER NOT NULL UNIQUE,
  user_id INTEGER NOT NULL,
  session TEXT NOT NULL UNIQUE,
  last_login TEXT NOT NULL,
  PRIMARY KEY(id AUTOINCREMENT) FOREIGN KEY(user_id) REFERENCES users(id)
);



INSERT INTO
  songs (
    ranking,
    song_name,
    artist,
    album,
    release_date,
    genre,
    languages,
    file_path,
    file_type
  )
VALUES
  (
    1,
    'Journey Through the Stars',
    1,
    50,
    '2023-01-01',
    'Electronic',
    'English',
    -- Source: https://en.wikipedia.org/wiki/Man_on_the_Moon:_The_End_of_Day
    'ManonTheMoonTheEndofDay.jpeg',
    'jpeg'
  ),
  (
    2,
    'Summer Vibes',
    2,
    52,
    '2023-06-15',
    'Pop',
    'English',
    -- Source: https://www.pinterest.com/pin/343681015331643595/
    '86a1d48435fc4ae0846ddb4749fff2dc.jpeg',
    'jpeg'
  ),
  (
    3,
    'Echoes of the Past',
    3,
    53,
    '2022-11-05',
    'Rock',
    'English',
    -- Source: https://www.pinterest.com/pin/159455643055471120/
    'a8025aaf5bb90f17ee23eb08ce069acc.jpeg',
    'jpeg'
  ),
  (
    4,
    'Dancing Shadows',
    4,
    54,
    '2023-03-12',
    'Dance',
    'English',
    -- Source: https://www.pinterest.com/pin/212443307417114627/
    '7f7b07a0ca84d84abfb79f3b5452c8b5.jpeg',
    'jpeg'
  ),
  (
    5,
    'Silent Thoughts',
    5,
    55,
    '2022-09-20',
    'Instrumental',
    'Instrumental',
    -- Source: https://www.pinterest.com/pin/24277285477543634/
    '020b183bf9878de3503c24840191ba8a.jpeg',
    'jpeg'
  ),
  (
    6,
    'Lost in Dreams',
    1,
    56,
    '2023-02-02',
    'Electronic',
    'English',
    -- Source: https://www.pinterest.com/pin/724657396298328804/
    '2590b6436441ca13dfdafbfd19dc4710.jpeg',
    'jpeg'
  ),
  (
    7,
    'Heartbeat',
    2,
    57,
    '2023-08-24',
    'Pop',
    'English',
    -- Source: https://www.pinterest.com/pin/1068760555301289966/
    '20ea1ba7aa031f847162ac04018f8c85.jpeg',
    'jpeg'
  ),
  (
    8,
    'The Long Road Home',
    3,
    58,
    '2022-12-17',
    'Rock',
    'English',
    -- Source: https://www.pinterest.com/pin/17099673579203661/
    'e97e586c0a33cc9f13e024ab08ca32ea.jpeg',
    'jpeg'
  ),
  (
    9,
    'Neon Nights',
    4,
    59,
    '2023-04-21',
    'Dance',
    'English',
    -- Source: https://www.pinterest.com/pin/165225880069434472/
    'da214a4468d619191a2b6dcc79f9c853.jpeg',
    'jpeg'
  ),
  (
    10,
    'Reflections',
    5,
    60,
    '2022-10-30',
    'Instrumental',
    'Instrumental',
    -- Source: https://www.pinterest.com/pin/667729082278957693/
    'a1639a90ef52e136972ffc1711f0122e.jpeg',
    'jpeg'
  ),
  (
    11,
    'Moonlight Serenade',
    6,
    61,
    '2023-07-01',
    'Classical',
    'Instrumental',
     -- Source: https://www.amazon.com/FestiKit-Drake-Poster-Canvas-Unframed/dp/B0CR5YJCCS/ref=sr_1_32?crid=35X8DDOXRHS2S&dib=eyJ2IjoiMSJ9.mGz5iLvg3fetgRzArkKVHtlSmu7tF15vRS_PgHFxRcemf6gQ_6r2da4_Dcd05JRBSfyq0oLi_9dLAtPJH0D08VtF1aYffcq6XjS_QM0qgzfHxsFMsMEY3m9luFiKHkCVF8vij7DYqxk3PDHtkuSJUOtH7r98UUZ3r7l_3httSuPDITcWrDdcj77NJCqP5c24-daKPs4OSXLUwMoSya-_XDxoJSpz56ckDC-hdTx6NiFklZaP_2A28KRs8jmXhNLcUdhg7o3i59R2YvPmS1X5jCe3IC8lWax8zSz_aZxcisE.eKM5QsayCiEfZWYnTU3AI6aM-amgCWUNiNYXPsrhG9o&dib_tag=se&keywords=2023%2Balbum%2Bcover%2Bposters&qid=1713462439&sprefix=2023%2Balbum%2Bcov%2Caps%2C144&sr=8-32&th=1
    'rsz_album1',
    'jpeg'
  ),
  (
    12,
    'Urban Jungle',
    7,
    62,
    '2023-03-21',
    'Hip-Hop',
    'English',
     -- Source: https://www.amazon.com/FestiKit-Drake-Poster-Canvas-Unframed/dp/B0CR5YJCCS/ref=sr_1_32?crid=35X8DDOXRHS2S&dib=eyJ2IjoiMSJ9.mGz5iLvg3fetgRzArkKVHtlSmu7tF15vRS_PgHFxRcemf6gQ_6r2da4_Dcd05JRBSfyq0oLi_9dLAtPJH0D08VtF1aYffcq6XjS_QM0qgzfHxsFMsMEY3m9luFiKHkCVF8vij7DYqxk3PDHtkuSJUOtH7r98UUZ3r7l_3httSuPDITcWrDdcj77NJCqP5c24-daKPs4OSXLUwMoSya-_XDxoJSpz56ckDC-hdTx6NiFklZaP_2A28KRs8jmXhNLcUdhg7o3i59R2YvPmS1X5jCe3IC8lWax8zSz_aZxcisE.eKM5QsayCiEfZWYnTU3AI6aM-amgCWUNiNYXPsrhG9o&dib_tag=se&keywords=2023%2Balbum%2Bcover%2Bposters&qid=1713462439&sprefix=2023%2Balbum%2Bcov%2Caps%2C144&sr=8-32&th=1
    'rsz_album2',
   'jpeg'
  ),
  (
    13,
    'Beyond the Horizon',
    8,
    63,
    '2023-05-15',
    'Ambient',
    'Instrumental',
    -- Source: https://www.amazon.com/s?k=2023+album+cover+posters&crid=35X8DDOXRHS2S&sprefix=2023+album+cov%2Caps%2C144&ref=nb_sb_ss_ts-doa-p_1_14
    'rsz_album3',
   'jpeg'
  ),
  (
    14,
    'Waves',
    9,
    64,
    '2022-12-25',
    'Indie',
    'English',
    -- Source: https://www.amazon.com/TUIM-Decorative-Painting-Aesthetic-12x18inch/dp/B0CD474S72/ref=sr_1_16?crid=35X8DDOXRHS2S&dib=eyJ2IjoiMSJ9.mGz5iLvg3fetgRzArkKVHtlSmu7tF15vRS_PgHFxRcemf6gQ_6r2da4_Dcd05JRBSfyq0oLi_9dLAtPJH0D08VtF1aYffcq6XjS_QM0qgzfHxsFMsMEY3m9luFiKHkCVF8vij7DYqxk3PDHtkuSJUOtH7r98UUZ3r7l_3httSuPDITcWrDdcj77NJCqP5c24-daKPs4OSXLUwMoSya-_XDxoJSpz56ckDC-hdTx6NiFklZaP_2A28KRs8jmXhNLcUdhg7o3i59R2YvPmS1X5jCe3IC8lWax8zSz_aZxcisE.eKM5QsayCiEfZWYnTU3AI6aM-amgCWUNiNYXPsrhG9o&dib_tag=se&keywords=2023%2Balbum%2Bcover%2Bposters&qid=1713462439&sprefix=2023%2Balbum%2Bcov%2Caps%2C144&sr=8-16&th=1
    'rsz_album4',
   'jpeg'
  ),
  (
    15,
    'Retrograde',
    10,
    65,
    '2023-02-14',
    'Retro',
    'English',
    -- Source:https://www.amazon.com/BAONG-Graduation-Posters-Aesthetic-12x18inch/dp/B0CJQZNMKJ/ref=sr_1_9?crid=35X8DDOXRHS2S&dib=eyJ2IjoiMSJ9.mGz5iLvg3fetgRzArkKVHtlSmu7tF15vRS_PgHFxRcemf6gQ_6r2da4_Dcd05JRBSfyq0oLi_9dLAtPJH0D08VtF1aYffcq6XjS_QM0qgzfHxsFMsMEY3m9luFiKHkCVF8vij7DYqxk3PDHtkuSJUOtH7r98UUZ3r7l_3httSuPDITcWrDdcj77NJCqP5c24-daKPs4OSXLUwMoSya-_XDxoJSpz56ckDC-hdTx6NiFklZaP_2A28KRs8jmXhNLcUdhg7o3i59R2YvPmS1X5jCe3IC8lWax8zSz_aZxcisE.eKM5QsayCiEfZWYnTU3AI6aM-amgCWUNiNYXPsrhG9o&dib_tag=se&keywords=2023+album+cover+posters&qid=1713462439&sprefix=2023+album+cov%2Caps%2C144&sr=8-9
    'rsz_album5',
   'jpeg'
  ),
  (
    16,
    'Celestial',
    6,
    66,
    '2023-08-30',
    'Classical',
    -- Source: https://www.amazon.com/Poster-Blonde-Aesthetic-Decor12x18inch-30x45cm/dp/B0CLLWM7S8/ref=sr_1_5?crid=35X8DDOXRHS2S&dib=eyJ2IjoiMSJ9.mGz5iLvg3fetgRzArkKVHtlSmu7tF15vRS_PgHFxRcemf6gQ_6r2da4_Dcd05JRBSfyq0oLi_9dLAtPJH0D08VtF1aYffcq6XjS_QM0qgzfHxsFMsMEY3m9luFiKHkCVF8vij7DYqxk3PDHtkuSJUOtH7r98UUZ3r7l_3httSuPDITcWrDdcj77NJCqP5c24-daKPs4OSXLUwMoSya-_XDxoJSpz56ckDC-hdTx6NiFklZaP_2A28KRs8jmXhNLcUdhg7o3i59R2YvPmS1X5jCe3IC8lWax8zSz_aZxcisE.eKM5QsayCiEfZWYnTU3AI6aM-amgCWUNiNYXPsrhG9o&dib_tag=se&keywords=2023+album+cover+posters&qid=1713462439&sprefix=2023+album+cov%2Caps%2C144&sr=8-5
    'Instrumental',
    'rsz_album6',
   'jpeg'
  ),
  (
    17,
    'City Lights',
    7,
    67,
    '2023-04-18',
    'Hip-Hop',
    'English',
    -- Source: https://www.amazon.com/s?k=2023+album+cover+posters&crid=35X8DDOXRHS2S&sprefix=2023+album+cov%2Caps%2C144&ref=nb_sb_ss_ts-doa-p_1_14
    'rsz_album7',
   'jpeg'
  ),
  (
    18,
    'Eternal Echo',
    8,
    68,
    '2023-09-07',
    'Ambient',
    'Instrumental',
    -- Source: https://www.amazon.com/s?k=2023+album+cover+posters&crid=35X8DDOXRHS2S&sprefix=2023+album+cov%2Caps%2C144&ref=nb_sb_ss_ts-doa-p_1_14
    'rsz_album8',
   'jpeg'
  ),
  (
    19,
    'Island Breeze',
    9,
    69,
    '2023-01-20',
    'Indie',
    'English',
    -- Source: https://www.amazon.com/s?k=2023+album+cover+posters&crid=35X8DDOXRHS2S&sprefix=2023+album+cov%2Caps%2C144&ref=nb_sb_ss_ts-doa-p_1_14
  'rsz_album9',
   'jpeg'
  ),
  (
    20,
    'Flashback',
    10,
    70,
    '2023-06-10',
    'Retro',
    'English',
    -- https://www.amazon.com/FestiKit-Drake-Poster-Canvas-Unframed/dp/B0CR5YJCCS/ref=sr_1_32?crid=35X8DDOXRHS2S&dib=eyJ2IjoiMSJ9.mGz5iLvg3fetgRzArkKVHtlSmu7tF15vRS_PgHFxRcemf6gQ_6r2da4_Dcd05JRBSfyq0oLi_9dLAtPJH0D08VtF1aYffcq6XjS_QM0qgzfHxsFMsMEY3m9luFiKHkCVF8vij7DYqxk3PDHtkuSJUOtH7r98UUZ3r7l_3httSuPDITcWrDdcj77NJCqP5c24-daKPs4OSXLUwMoSya-_XDxoJSpz56ckDC-hdTx6NiFklZaP_2A28KRs8jmXhNLcUdhg7o3i59R2YvPmS1X5jCe3IC8lWax8zSz_aZxcisE.eKM5QsayCiEfZWYnTU3AI6aM-amgCWUNiNYXPsrhG9o&dib_tag=se&keywords=2023%2Balbum%2Bcover%2Bposters&qid=1713462439&sprefix=2023%2Balbum%2Bcov%2Caps%2C144&sr=8-32&th=1
    'rsz_album10',
   'jpeg'
  );

INSERT INTO
  tags (name)
VALUES
  ('Energetic'),
  ('Relaxing'),
  ('Electronic'),
  ('Rock'),
  ('Pop'),
  ('Inspirational'),
  ('Acoustic'),
  ('Live'),
  ('Upbeat'),
  ('Chill'),
  ('Melancholic'),
  ('Epic'),
  ('Jazz'),
  ('Soul'),
  ('Funk'),
  ('Classical'),
  ('Hip-Hop'),
  ('Ambient'),
  ('Indie'),
  ('Retro');

INSERT INTO
  song_tags (song_id, tag_id)
VALUES
  (1, 6),
  (1, 9),
  (2, 1),
  (2, 9),
  (3, 2),
  (3, 7),
  (4, 5),
  (4, 9),
  (5, 7),
  (5, 10),
  (6, 1),
  (6, 6),
  (7, 9),
  (7, 10),
  (8, 6),
  (8, 7),
  (9, 3),
  (9, 9),
  (10, 7),
  (10, 10),
  (11, 16),
  (11, 11),
  (12, 17),
  (12, 12),
  (13, 18),
  (13, 13),
  (14, 19),
  (14, 14),
  (15, 20),
  (15, 15),
  (16, 16),
  (16, 11),
  (17, 17),
  (17, 12),
  (18, 18),
  (18, 13),
  (19, 19),
  (19, 14),
  (20, 4),
  (20, 8);

INSERT INTO
  users (id, username, password)
VALUES
  (
    1,
    'Troy',
    '$2y$10$QtCybkpkzh7x5VN11APHned4J8fu78.eFXlyAMmahuAaNcbwZ7FH.'
  );
