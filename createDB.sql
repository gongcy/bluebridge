/**
 * Created by PhpStorm.
 * User: gongcy
 * Date: 16-10-31
 * Time: 下午8:17
 */
-- create database jol;
use jol;
set names utf8;
create table blueSySSubmit(
	submit_id int(11) primary key auto_increment, -- BlueSystem提交序号
# 	problem_id int(11) not null DEFAULT '0',
	user_id char(48) not null,
	contest_code varchar(40) not null,  -- 比赛代码
	pid int not null,
	ans varchar(100) null,
	solution_id int null, -- hustoj提交序号
	score int null,
	is_correct int DEFAULT '0',
	foreign key(user_id) references users(user_id)
  # 	language int UNSIGNED not null DEFAULT '0',
  -- 	problem_id int(11)
  # 	submit_time datetime not null,
)default charset=utf8;