CREATE DATABASE preesync;

USE preesync;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('student', 'tutor') NOT NULL
);

INSERT INTO
    users (name, email, password, role)
VALUES (
        'Ahmed',
        'ahmed@enaa.ma',
        '123456',
        'student'
    ),
    (
        'Sara',
        'sara@enaa.ma',
        '123456',
        'tutor'
    ),
    (
        'Yassine',
        'yassine@enaa.ma',
        '123456',
        'student'
    ),
    (
        'Imane',
        'imane@enaa.ma',
        '123456',
        'tutor'
    );

CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL
);

INSERT INTO
    skills (name)
VALUES ('PHP'),
    ('SQL'),
    ('JavaScript'),
    ('POO'),
    ('HTML'),
    ('CSS');

INSERT INTO
    skills (name)
VALUES ('react.js'),
    ('Java'),
    ('Laravel'),
    ('Spring Boot');

CREATE TABLE user_skills (
    user_id INT,
    skill_id INT,
    PRIMARY KEY (user_id, skill_id),
    FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skills (id) ON DELETE CASCADE
);

INSERT INTO
    user_skills (user_id, skill_id)
VALUES (1, 4),
    (1, 2),
    (2, 1),
    (2, 2),
    (3, 3),
    (4, 4);

CREATE TABLE help_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    status ENUM(
        'PENDING',
        'ASSIGNED',
        'RESOLVED'
    ) DEFAULT 'PENDING',
    student_id INT NOT NULL,
    tutor_id INT NULL,
    skill_id INT NOT NULL,
    FOREIGN KEY (student_id) REFERENCES users (id) ON DELETE CASCADE,
    FOREIGN KEY (tutor_id) REFERENCES users (id) ON DELETE SET NULL,
    FOREIGN KEY (skill_id) REFERENCES skills (id) ON DELETE CASCADE
);

INSERT INTO
    help_requests (
        title,
        description,
        status,
        student_id,
        tutor_id,
        skill_id
    )
VALUES (
        'Problème héritage POO',
        'Je bloque sur l’héritage en programmation orientée objet',
        'PENDING',
        1,
        NULL,
        4
    ),
    (
        'Erreur requête SQL',
        'Je ne comprends pas les jointures SQL',
        'ASSIGNED',
        3,
        2,
        2
    ),
    (
        'Besoin aide JavaScript',
        'Problème avec les événements JS',
        'RESOLVED',
        1,
        4,
        3
    );

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    help_request_id INT UNIQUE NOT NULL,
    rating INT NOT NULL,
    comment TEXT,
    CHECK (
        rating >= 1
        AND rating <= 5
    ),
    FOREIGN KEY (help_request_id) REFERENCES help_requests (id) ON DELETE CASCADE
);

INSERT INTO
    reviews (
        help_request_id,
        rating,
        comment
    )
VALUES (
        3,
        5,
        'Merci beaucoup pour l’aide, explication claire.'
    );