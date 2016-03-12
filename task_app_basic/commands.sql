create database camp_task_app;

grant all on camp_task_app.* to testuser@localhost identified by '9999';

use camp_task_app

create table tasks (
    id int auto_increment primary key,
    title text,
    status varchar(10) default 'notyet',
    created_at datetime,
    modified_at datetime
);

insert into tasks (title, created_at, modified_at) values
('報告書を作成する', now(), now()),
('コピー用紙を購入する', now(), now()),
('年賀状を書く', now(), now());

