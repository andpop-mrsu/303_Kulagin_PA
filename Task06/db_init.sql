ATTACH DATABASE 'salon.db' as 'db';
DROP TABLE IF EXISTS schedule;
DROP TABLE IF EXISTS emploee;
DROP TABLE IF EXISTS work;
DROP TABLE IF EXISTS appointment;
DROP TABLE IF EXISTS services;

PRAGMA foreign_keys=on;

CREATE TABLE schedule(
emploee_id INTEGER NOT NULL, 
date TEXT NOT NULL CHECK (date==strftime('%Y-%m-%d', date)), 
begin_time TEXT NOT NULL CHECK (begin_time==strftime('%H:%M:%S', begin_time)), 
end_time TEXT NOT NULL CHECK ((end_time==strftime('%H:%M:%S', end_time)) and (begin_time < end_time)), 
PRIMARY KEY (emploee_id, date) FOREIGN KEY (emploee_id) REFERENCES emploee(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE emploee(
id INTEGER PRIMARY KEY AUTOINCREMENT, 
name TEXT NOT NULL, surname TEXT NOT NULL, 
specialization TEXT NOT NULL CHECK (specialization in ('male', 'female', 'universal')), 
percent REAL NOT NULL CHECK ((percent >= 0) and (percent <= 100)), 
status TEXT NOT NULL CHECK (status in ('works', 'fired')) DEFAULT ('works')
);

CREATE TABLE work(
id INTEGER PRIMARY KEY AUTOINCREMENT, 
emploee_id TEXT NOT NULL, 
date TEXT NOT NULL CHECK (date==strftime('%Y-%m-%d', date)), 
time TEXT NOT NULL CHECK (time==strftime('%H:%M:%S', time)), 
done TEXT NOT NULL CHECK (done in ('yes', 'no')) DEFAULT ('no'), 
FOREIGN KEY (emploee_id) REFERENCES emploee(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE appointment(
work_id INTEGER NOT NULL, 
service_id INTEGER NOT NULL, 
PRIMARY KEY (work_id, service_id) FOREIGN KEY (work_id) REFERENCES work(id) ON DELETE RESTRICT ON UPDATE CASCADE FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE services(
id INTEGER PRIMARY KEY AUTOINCREMENT, 
service_name TEXT NOT NULL, 
gender TEXT NOT NULL CHECK (gender in ('male', 'female', 'universal')), 
duration INTEGER NOT NULL, 
price INTEGER NOT NULL CHECK (price >= 0)
);


INSERT INTO 'emploee' ('name', 'surname', 'specialization', 'percent' ) VALUES 
('name1', 'surname1', 'male', '15'), 
('name2', 'surname2', 'female', '20'), 
('name3', 'surname3', 'universal', '25');

INSERT INTO 'services' ('service_name', 'gender', 'duration', 'price') VALUES
('service1', 'male', strftime('%s', '1970-01-01 00:15:00'), '200'),
('service2', 'male', strftime('%s', '1970-01-01 00:30:00'), '300'),
('service3', 'male', strftime('%s', '1970-01-01 00:40:00'), '400'),
('service4', 'female', strftime('%s', '1970-01-01 00:50:00'), '500'),
('service5', 'female', strftime('%s', '1970-01-01 01:00:00'), '750'),
('service6', 'female', strftime('%s', '1970-01-01 01:30:00'), '1000'),
('service7', 'universal', strftime('%s', '1970-01-01 00:20:00'), '300'),
('service8', 'universal', strftime('%s', '1970-01-01 00:30:00'), '500'),
('service9', 'universal', strftime('%s', '1970-01-01 00:45:00'), '750');

INSERT INTO 'schedule' ('emploee_id', 'date', 'begin_time', 'end_time') VALUES 
('1', date('2021-11-13'), time('10:00:00'), time('18:00:00')),
('2', date('2021-11-13'), time('09:00:00'), time('17:00:00')),
('3', date('2021-11-13'), time('10:00:00'), time('19:00:00'));

INSERT INTO 'work' ('emploee_id', 'date', 'time') VALUES
('1', '2021-11-13', time('14:30:00')),
('2', '2021-11-13', time('12:00:00')),
('3', '2021-11-13', time('15:10:00')),
('1', '2021-11-13', time('11:00:00')),
('2', '2021-11-13', time('13:50:00')),
('3', '2021-11-13', time('10:00:00'));

INSERT INTO 'appointment' ('work_id', 'service_id') VALUES 
('1', '1'),
('1', '2'),
('2', '5'),
('2', '6'),
('3', '7'),
('4', '1'),
('4', '2'),
('4', '3'),
('5', '8'),
('5', '9'),
('6', '4');

