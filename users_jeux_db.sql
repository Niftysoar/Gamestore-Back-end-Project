CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users VALUES (1, 'Niftysoar', 'berthomath@hotmail.com', '$2y$10$zbUe6EB3GpvODEUeMSHGjO8Hja9GjqxKvZuAaPocusrr4yr4bmZLi', '2024-11-07 10:00:00');