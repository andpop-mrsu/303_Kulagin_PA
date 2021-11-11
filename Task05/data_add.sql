Insert into 'users' ('name', 'surname', 'email', 'gender', 'register_date', 'occupation') values ('Pavel', 'Kulagin', 'p_kulaghin@mail.ru', 'male', date('now'), 'student');
Insert into 'users' ('name', 'surname', 'email', 'gender', 'register_date', 'occupation') values ('Stepan', 'Maksimov', 's_maksimov@mail.ru', 'male', date('now'), 'student');
Insert into 'users' ('name', 'surname', 'email', 'gender', 'register_date', 'occupation') values ('Ilya', 'Nikulov', 'i_nikulov@mail.ru', 'male', date('now'), 'student');
Insert into 'users' ('name', 'surname', 'email', 'gender', 'register_date', 'occupation') values ('Anastasiya', 'Inshakova', 'a_inshakova@mail.ru', 'male', date('now'), 'student');
Insert into 'users' ('name', 'surname', 'email', 'gender', 'register_date', 'occupation') values ('Yulia', 'Zavaryuchina', 'y_zavaryuchina@mail.ru', 'male', date('now'), 'student');

Insert into 'movies' ('title', 'year') values ('Wrath of Man', '2021');
Insert into 'movies_genres' ('movie_id', 'genre_id') select movies.id, genres.id from movies, genres where movies.title = "Wrath of Man" and movies.year = "2021" and genres.title = "Action";
Insert into 'movies_genres' ('movie_id', 'genre_id') select movies.id, genres.id from movies, genres where movies.title = "Wrath of Man" and movies.year = "2021" and genres.title = "Thriller";

Insert into 'movies' ('title', 'year') values ('Raya and the Last Dragon', '2021');
Insert into 'movies_genres' ('movie_id', 'genre_id') select movies.id, genres.id from movies, genres where movies.title = "Raya and the Last Dragon" and movies.year = "2021" and genres.title = "Animation";

Insert into 'movies' ('title', 'year') values ('Dune: Part One', '2021');
Insert into 'movies_genres' ('movie_id', 'genre_id') select movies.id, genres.id from movies, genres where movies.title = "Dune: Part One" and movies.year = "2021" and genres.title = "Fantasy";
Insert into 'movies_genres' ('movie_id', 'genre_id') select movies.id, genres.id from movies, genres where movies.title = "Dune: Part One" and movies.year = "2021" and genres.title = "Action";

Insert into 'ratings' ('user_id', 'movie_id', 'rating') select users.id, movies.id, "4.0" from users, movies where users.email = "p_kulaghin@mail.ru" and movies.title = "Wrath of Man" and movies.year = "2021";
Insert into 'tags' ('user_id', 'movie_id', 'tag') select users.id, movies.id, "It could be better" from users, movies where users.email = "p_kulaghin@mail.ru" and movies.title = "Wrath of Man" and movies.year = "2021";

Insert into 'ratings' ('user_id', 'movie_id', 'rating') select users.id, movies.id, "4.5" from users, movies where users.email = "p_kulaghin@mail.ru" and movies.title = "Raya and the Last Dragon" and movies.year = "2021";
Insert into 'tags' ('user_id', 'movie_id', 'tag') select users.id, movies.id, "It's nice animation" from users, movies where users.email = "p_kulaghin@mail.ru" and movies.title = "Raya and the Last Dragon" and year = "2021";

Insert into 'ratings' ('user_id', 'movie_id', 'rating') select users.id, movies.id, "5.0" from users, movies where users.email = "p_kulaghin@mail.ru" and movies.title = "Dune: Part One" and movies.year = "2021";
Insert into 'tags' ('user_id', 'movie_id', 'tag') select users.id, movies.id, "This is a great adaptation of the book" from users, movies where users.email = "p_kulaghin@mail.ru" and movies.title = "Dune: Part One" and year = "2021";
