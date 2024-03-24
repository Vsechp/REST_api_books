CREATE TABLE users (
                       id SERIAL PRIMARY KEY,
                       email VARCHAR(255) NOT NULL UNIQUE,
                       password VARCHAR(255) NOT NULL
);

CREATE TABLE books (
                       id SERIAL PRIMARY KEY,
                       title VARCHAR(255) NOT NULL,
                       author VARCHAR(255) NOT NULL
);

INSERT INTO books (title, author) VALUES
                                      ('To Kill a Mockingbird', 'Harper Lee'),
                                      ('1984', 'George Orwell'),
                                      ('The Great Gatsby', 'F. Scott Fitzgerald'),
                                      ('Pride and Prejudice', 'Jane Austen'),
                                      ('The Catcher in the Rye', 'J.D. Salinger'),
                                      ('The Hobbit', 'J.R.R. Tolkien'),
                                      ('Fahrenheit 451', 'Ray Bradbury'),
                                      ('Jane Eyre', 'Charlotte Bronte'),
                                      ('Animal Farm', 'George Orwell'),
                                      ('Wuthering Heights', 'Emily Bronte'),
                                      ('Lord of the Flies', 'William Golding'),
                                      ('Moby Dick', 'Herman Melville'),
                                      ('War and Peace', 'Leo Tolstoy'),
                                      ('The Odyssey', 'Homer'),
                                      ('Ulysses', 'James Joyce'),
                                      ('Madame Bovary', 'Gustave Flaubert'),
                                      ('The Divine Comedy', 'Dante Alighieri'),
                                      ('The Brothers Karamazov', 'Fyodor Dostoevsky'),
                                      ('Don Quixote', 'Miguel de Cervantes'),
                                      ('The Iliad', 'Homer');
