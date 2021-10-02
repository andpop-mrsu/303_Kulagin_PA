#!/bin/bash
chcp 65001

sqlite3 movies_rating.db < db_init.sql

echo "1. Составить список фильмов, имеющих хотя бы одну оценку. Список фильмов отсортировать по году выпуска и по названиям. В списке оставить первые 10 фильмов."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select distinct movies.title from movies inner join ratings on ratings.movie_id = movies.id order by movies.title, year asc limit 10;"
echo " "

echo "2. Вывести список всех пользователей, фамилии (не имена!) которых начинаются на букву 'A'. Полученный список отсортировать по дате регистрации. В списке оставить первых 5 пользователей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select users.name from users where instr( name, ' A' ) > 0 order by register_date limit 5;"

echo "3. Написать запрос, возвращающий информацию о рейтингах в более читаемом формате: имя и фамилия эксперта, название фильма, год выпуска, оценка и дата оценки в формате ГГГГ-ММ-ДД. Отсортировать данные по имени эксперта, затем названию фильма и оценке. В списке оставить первые 50 записей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select users.name, movies.title, movies.year, ratings.rating, DATE(ratings.timestamp, 'unixepoch') as evaluation_date from users inner join ratings on users.id = ratings.user_id inner join movies on ratings.movie_id = movies.id order by users.name, movies.title, evaluation_date limit 50;"

echo "4. Вывести список фильмов с указанием тегов, которые были им присвоены пользователями. Сортировать по году выпуска, затем по названию фильма, затем по тегу. В списке оставить первые 40 записей."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select movies.title, tags.tag from movies inner join tags on movies.id = tags.movie_id order by movies.year, movies.title, tags.tag limit 40;"

echo "5. Вывести список самых свежих фильмов. В список должны войти все фильмы последнего года выпуска, имеющиеся в базе данных. Запрос должен быть универсальным, не зависящим от исходных данных (нужный год выпуска должен определяться в запросе, а не жестко задаваться)."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "select * from movies where year == (select max(year) from movies where printf('%%d', year) = year);"

echo "6. Найти все комедии, выпущенные после 2000 года, которые понравились мужчинам (оценка не ниже 4.5). Для каждого фильма в этом списке вывести название, год выпуска и количество таких оценок. Результат отсортировать по году выпуска и названию фильма."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "create temp view movies_that_men_liked as select ratings.movie_id, count(*) as num_of_excellent_grades from ratings inner join users on ratings.user_id = users.id where ratings.rating >= 4.5 and users.gender = 'male' group by ratings.movie_id;select movies.title, movies.year, movies_that_men_liked.num_of_excellent_grades from movies inner join movies_that_men_liked on movies_that_men_liked.movie_id = movies.id where printf('%%d', movies.year) = movies.year and movies.year > 2000 order by movies.year, movies.title;drop view movies_that_men_liked;"

echo "7. Провести анализ занятий (профессий) пользователей - вывести количество пользователей для каждого рода занятий. Найти самую распространенную и самую редкую профессию посетитетей сайта."
echo --------------------------------------------------
sqlite3 movies_rating.db -box -echo "create temp view professions as select users.occupation, count(*) as amount from users group by occupation;select * from professions;select occupation as occupation_with_min_amount, amount from professions where amount = (select min(amount) from professions);select occupation as occupation_with_max_amount, amount from professions where amount = (select max(amount) from professions);drop view professions;"
pause