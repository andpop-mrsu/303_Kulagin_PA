#!/bin/bash
chcp 65001

sqlite3 movies_rating.db < db_init.sql

echo "1. Найти все пары пользователей, оценивших один и тот же фильм. Устранить дубликаты, проверить отсутствие пар с самим собой. Для каждой пары должны быть указаны имена пользователей и название фильма, который они ценили."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select m.title as movie, u1.name as first_user, u2.name as second_user from ratings r1 join ratings r2 on r1.movie_id = r2.movie_id and r1.id > r2.id join movies m on r1.movie_id = m.id join users u1 on r1.user_id = u1.id join users u2 on r2.user_id = u2.id order by m.id"
echo " "

echo "2. Найти 10 самых старых оценок от разных пользователей, вывести названия фильмов, имена пользователей, оценку, дату отзыва в формате ГГГГ-ММ-ДД."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select movies.title, users.name, rating, DATE(timestamp, 'unixepoch') as date from ratings join movies on movies.id == ratings.movie_id join users on ratings.user_id == users.id group by users.name HAVING MIN(timestamp) order by timestamp LIMIT 10;"
echo " "

echo "3. Вывести в одном списке все фильмы с максимальным средним рейтингом и все фильмы с минимальным средним рейтингом. Общий список отсортировать по году выпуска и названию фильма. В зависимости от рейтинга в колонке 'Рекомендуем' для фильмов должно быть написано 'Да' или 'Нет'."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select title, year, avg_rating, CasE average.avg_rating WHEN max_or_min.max_avg_rating then 'Yes' ELSE 'No' END as Recommend from (select movies.title as title, movies.year as year, AVG(rating) as avg_rating from ratings join movies on movies.id = movie_id group by movie_id) as average join (select MAX(avg_rating) as max_avg_rating, MIN(avg_rating) as min_avg_rating from (select avg(rating) as avg_rating from ratings join movies on movies.id = movie_id group by movie_id)) as max_or_min on average.avg_rating = max_or_min.max_avg_rating OR average.avg_rating = max_or_min.min_avg_rating order by average.year, average.title;"
echo " "

echo "4. Вычислить количество оценок и среднюю оценку, которую дали фильмам пользователи-мужчины в период с 2011 по 2014 год."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select count(*) as ratings_count, round(avg(r.rating), 2) as ratings_average from ratings r join users u on r.user_id = u.id where u.gender = 'male' and datetime(r.timestamp, 'unixepoch') between '2011-01-01' and '2014-01-01';"
echo " "

echo "5. Составить список фильмов с указанием средней оценки и количества пользователей, которые их оценили. Полученный список отсортировать по году выпуска и названиям фильмов. В списке оставить первые 20 записей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select title, year, AVG(ratings.rating) as avg_rating, COUNT(DisTINCT ratings.user_id) as number_of_ratings from movies join ratings on movies.id == ratings.movie_id group by movies.id order by year, title LIMIT 20"
echo " "

echo "6. Определить самый распространенный жанр фильма и количество фильмов в этом жанре. Отдельную таблицу для жанров не использовать, жанры нужно извлекать из таблицы movies."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select genre, max(movies_number) as movies_number from (with divided_genres(genre, combined_genres) as (select NULL, genres from movies UNIon ALL select CASE WHEN INSTR(combined_genres, '|') == 0 THEN combined_genres ELSE SUBSTR(combined_genres, 1, INSTR(combined_genres, '|') - 1) END, CASE WHEN INSTR(combined_genres, '|') == 0 THEN NULL ELSE SUBSTR(combined_genres, INSTR(combined_genres, '|') + 1) END from divided_genres where combined_genres is not NULL) select genre, COUNT(*) as movies_number from divided_genres where genre is not NULL group by genre);"
echo " "

echo "7. Вывести список из 10 последних зарегистрированных пользователей в формате \"Фамилия Имя Дата регистрации\" (сначала фамилия, потом имя)."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select substr(name, instr(name, ' ') + 1) || ' ' || substr(name, 1, instr(name, ' ')  - 1) as name, register_date from users order by register_date desc limit 10;"
echo " "

echo "8. С помощью рекурсивного CTE определить, на какие дни недели приходился ваш день рождения в каждом году."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "with RECURSIVE birthday(date, day) as (select '2001-03-16', STRFTIME('%%w', '2001-03-16') UNIon ALL select DATE(date, '+1 year'), STRFTIME('%%w', DATE(date, '+1 year')) from birthday where date < '2022-01-01') select date, CasE day WHEN '0' THEN 'Sunday' WHEN '1' THEN 'Monday' WHEN '2' THEN 'Tuesday' WHEN '3' THEN 'Wednesday' WHEN '4' THEN 'Thursday' WHEN '5' THEN 'Friday' ELSE 'Saturday' END 'day_of_week' from birthday;"
