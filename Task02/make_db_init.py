import csv
import sqlite3

def read_csv(path, rows_num, rows_names, rows, delimiter, has_rows_names):
    with open(path) as file:
        file_reader = csv.reader(file, delimiter=delimiter)
        count = 0
        for row in file_reader:
            if count == 0 and has_rows_names:
                rows_names.append(row)
            else:
                rows.append(row)
            count += 1
        rows_num.append(count)

def add_semicolon(string):
    string = list(string)
    string[len(string) - 2] = ";"
    string = ''.join(string)
    return string

def shield_quote(table):
    for i in range(len(table)):
        for j in range(len(table[0])):
            table[i][j] = table[i][j].replace("'", "''")

movies_rows_names = []
movies_rows = []
movies_rows_num = []

ratings_rows_names = []
ratings_rows = []
ratings_rows_num = []

tags_rows_names = []
tags_rows = []
tags_rows_num = []

users_rows_names = []
users_rows = []
users_rows_num = []

read_csv("movies.csv", movies_rows_num, movies_rows_names, movies_rows, delimiter=",", has_rows_names=True)
read_csv("ratings.csv", ratings_rows_num, ratings_rows_names, ratings_rows, delimiter=",", has_rows_names=True)
read_csv("tags.csv", tags_rows_num, tags_rows_names, tags_rows, delimiter=",", has_rows_names=True)
read_csv("users.txt", users_rows_num, users_rows_names, users_rows, delimiter="|", has_rows_names=False)
for row in movies_rows:
    row[1] = row[1].split('(')
    title = row[1][0]
    if 1 < len(row[1]):
        year = row[1][1].split(")")
        row.insert(2, year[0])
    else:
        row.insert(2, "year not specified")
    row[1] = title

shield_quote(movies_rows)
shield_quote(ratings_rows)
shield_quote(tags_rows)
shield_quote(users_rows)


connection = sqlite3.connect('movies_rating.db')
connection.close()

insert_movies_command = "Insert into 'movies' ('id', 'title', 'year', 'genres') values "
for row in movies_rows:
    insert_movies_command += "('" + row[0] + "', '" + row[1] + "', '" + row[2] + "', '" + row[3] + "'),\n"
insert_movies_command = add_semicolon(insert_movies_command)

insert_ratings_command = "Insert into 'ratings' ('user_id', 'movie_id', 'rating', 'timestamp') values "
for row in ratings_rows:
    insert_ratings_command += "('" + row[0] + "', '" + row[1] + "', '" + row[2] + "', '" + row[3] + "'),\n"
insert_ratings_command = add_semicolon(insert_ratings_command)

insert_tags_command = "Insert into 'tags' ('user_id', 'movie_id', 'tag', 'timestamp') values "
for row in tags_rows:
    insert_tags_command += "('" + row[0] + "', '" + row[1] + "', '" + row[2] + "', '" + row[3] + "'),\n"
insert_tags_command = add_semicolon(insert_tags_command)

insert_users_command = "Insert into 'users' ('id', 'name', 'email', 'gender', 'register_date', 'occupation') values "
for row in users_rows:
    insert_users_command += "('" + row[0] + "', '" + row[1] + "', '" + row[2] + "', '" + row[3] + "', '" + row[4] + "', '" + row[5] + "'),\n"
insert_users_command = add_semicolon(insert_users_command)


db_init = open("db_init.sql", "w")
db_init.write("ATTACH DATABASE 'movies_rating.db' as 'db';\n")
db_init.write("DROP TABLE IF EXISTS movies;\n")
db_init.write("DROP TABLE IF EXISTS ratings;\n")
db_init.write("DROP TABLE IF EXISTS tags;\n")
db_init.write("DROP TABLE IF EXISTS users;\n")
db_init.write("CREATE TABLE movies (id INTEGER PRIMARY KEY NOT NULL, title TEXT NOT NULL, year TEXT NOT NULL, genres TEXT NOT NULL);\n")
db_init.write("CREATE TABLE ratings (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, movie_id INTEGER NOT NULL, rating REAL NOT NULL, timestamp INTEGER);\n")
db_init.write("CREATE TABLE tags (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, movie_id INTEGER NOT NULL, tag TEXT NOT NULL, timestamp INTEGER NOT NULL);\n")
db_init.write("CREATE TABLE users (id INTEGER PRIMARY KEY NOT NULL, name TEXT NOT NULL, email TEXT NOT NULL, gender TEXT NOT NULL, register_date TEXT NOT NULL, occupation TEXT NOT NULL);\n")
db_init.write(insert_movies_command + "\n")
db_init.write(insert_ratings_command + "\n")
db_init.write(insert_tags_command + "\n")
db_init.write(insert_users_command + "\n")
db_init.close()
