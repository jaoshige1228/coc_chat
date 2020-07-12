-- create database coc_chat;

-- grant all on coc_chat.* to dbuser@localhost identified by 'blitz7039';

create table userType(
  id int not null auto_increment primary key,
  roomId int,
  userName varchar(255),
  type enum('gest','player','keeper') default 'gest'
);

create table users(
  id int not null auto_increment primary key,
  name varchar(255) unique,
  password varchar(255),
  created datetime,
  modified datetime
);

create table temp_player( 
  roomId int,
  charName varchar(255),
  charId int,
  charHP int,
  charMP int,
  charSAN int,
  userName varchar(255)
);

create table chars(
  id int not null auto_increment primary key,
  plId int,
  name varchar(120),
  sex varchar(10),
  age int,
  job varchar(60),
  str int,
  dex int,
  intel int,
  con int,
  app int,
  pow int,
  siz int,
  san int,
  maxSan int,
  edu int,
  hp int,
  mp int,
  idea int,
  luck int,
  know int,
  db varchar(20),
  profile text,
  subProfile text,
  sum_jobP int,
  sum_hobP int,
  sum_etcP int,
  icon varchar(1000) default 'thumbs/user.png'
);

create table skills(
  id int not null auto_increment primary key,
  charId int unique,
  `回避` int,
  `キック` int default 25,
  `組み付き` int default 25,
  `こぶし` int default 50,
  `頭突き` int default 10,
  `投擲` int default 25,
  `マーシャルアーツ` int default 1,
  `拳銃` int default 20,
  `サブマシンガン` int default 15,
  `ショットガン` int default 30,
  `マシンガン` int default 15,
  `ライフル` int default 25,
  `応急手当` int default 30,
  `鍵開け` int default 1,
  `隠す` int default 15,
  `隠れる` int default 10,
  `聞き耳` int default 25,
  `忍び歩き` int default 10,
  `写真術` int default 10,
  `精神分析` int default 1,
  `追跡` int default 10,
  `登攀` int default 40,
  `図書館` int default 25,
  `目星` int default 25,
  `運転` int default 20,
  `重機械操作` int default 1,
  `機械修理` int default 20,
  `乗馬` int default 5,
  `水泳` int default 25,
  `製作` int default 5,
  `操縦` int default 1,
  `跳躍` int default 25,
  `電気修理` int default 10,
  `ナビゲート` int default 10,
  `変装` int default 1,
  `言いくるめ` int default 5,
  `信用` int default 15,
  `説得` int default 15,
  `値切り` int default 5,
  `母国語` int,
  `他の言語` int default 1,
  `医学` int default 5,
  `オカルト` int default 5,
  `化学` int default 1,
  `クトゥルフ神話` int default 0,
  `芸術` int default 5,
  `経理` int default 10,
  `考古学` int default 1,
  `コンピューター` int default 1,
  `心理学` int default 5,
  `人類学` int default 1,
  `生物学` int default 1,
  `地質学` int default 1,
  `電子工学` int default 1,
  `天文学` int default 1,
  `博物学` int default 10,
  `物理学` int default 1,
  `法律` int default 5,
  `薬学` int default 1,
  `歴史` int default 20
);


create table skills_def(
  id int not null auto_increment primary key,
  charId int unique,
  `回避` int,
  `キック` int default 25,
  `組み付き` int default 25,
  `こぶし` int default 50,
  `頭突き` int default 10,
  `投擲` int default 25,
  `マーシャルアーツ` int default 1,
  `拳銃` int default 20,
  `サブマシンガン` int default 15,
  `ショットガン` int default 30,
  `マシンガン` int default 15,
  `ライフル` int default 25,
  `応急手当` int default 30,
  `鍵開け` int default 1,
  `隠す` int default 15,
  `隠れる` int default 10,
  `聞き耳` int default 25,
  `忍び歩き` int default 10,
  `写真術` int default 10,
  `精神分析` int default 1,
  `追跡` int default 10,
  `登攀` int default 40,
  `図書館` int default 25,
  `目星` int default 25,
  `運転` int default 20,
  `重機械操作` int default 1,
  `機械修理` int default 20,
  `乗馬` int default 5,
  `水泳` int default 25,
  `製作` int default 5,
  `操縦` int default 1,
  `跳躍` int default 25,
  `電気修理` int default 10,
  `ナビゲート` int default 10,
  `変装` int default 1,
  `言いくるめ` int default 5,
  `信用` int default 15,
  `説得` int default 15,
  `値切り` int default 5,
  `母国語` int,
  `他の言語` int default 1,
  `医学` int default 5,
  `オカルト` int default 5,
  `化学` int default 1,
  `クトゥルフ神話` int default 0,
  `芸術` int default 5,
  `経理` int default 10,
  `考古学` int default 1,
  `コンピューター` int default 1,
  `心理学` int default 5,
  `人類学` int default 1,
  `生物学` int default 1,
  `地質学` int default 1,
  `電子工学` int default 1,
  `天文学` int default 1,
  `博物学` int default 10,
  `物理学` int default 1,
  `法律` int default 5,
  `薬学` int default 1,
  `歴史` int default 20
);

create table sum_jobP(
  id int not null auto_increment primary key,
  charId int unique,
  `回避` int,
  `キック` int,
  `組み付き` int,
  `こぶし` int,
  `頭突き` int,
  `投擲` int,
  `マーシャルアーツ` int,
  `拳銃` int,
  `サブマシンガン` int,
  `ショットガン` int,
  `マシンガン` int,
  `ライフル` int,
  `応急手当` int,
  `鍵開け` int,
  `隠す` int,
  `隠れる` int,
  `聞き耳` int,
  `忍び歩き` int,
  `写真術` int,
  `精神分析` int,
  `追跡` int,
  `登攀` int,
  `図書館` int,
  `目星` int,
  `運転` int,
  `重機械操作` int,
  `機械修理` int,
  `乗馬` int,
  `水泳` int,
  `製作` int,
  `操縦` int,
  `跳躍` int,
  `電気修理` int,
  `ナビゲート` int,
  `変装` int,
  `言いくるめ` int,
  `信用` int,
  `説得` int,
  `値切り` int,
  `母国語` int,
  `他の言語` int,
  `医学` int,
  `オカルト` int,
  `化学` int,
  `クトゥルフ神話` int,
  `芸術` int,
  `経理` int,
  `考古学` int,
  `コンピューター` int,
  `心理学` int,
  `人類学` int,
  `生物学` int,
  `地質学` int,
  `電子工学` int,
  `天文学` int,
  `博物学` int,
  `物理学` int,
  `法律` int,
  `薬学` int,
  `歴史` int
);

create table sum_hobP(
  id int not null auto_increment primary key,
  charId int unique,
  `回避` int,
  `キック` int,
  `組み付き` int,
  `こぶし` int,
  `頭突き` int,
  `投擲` int,
  `マーシャルアーツ` int,
  `拳銃` int,
  `サブマシンガン` int,
  `ショットガン` int,
  `マシンガン` int,
  `ライフル` int,
  `応急手当` int,
  `鍵開け` int,
  `隠す` int,
  `隠れる` int,
  `聞き耳` int,
  `忍び歩き` int,
  `写真術` int,
  `精神分析` int,
  `追跡` int,
  `登攀` int,
  `図書館` int,
  `目星` int,
  `運転` int,
  `重機械操作` int,
  `機械修理` int,
  `乗馬` int,
  `水泳` int,
  `製作` int,
  `操縦` int,
  `跳躍` int,
  `電気修理` int,
  `ナビゲート` int,
  `変装` int,
  `言いくるめ` int,
  `信用` int,
  `説得` int,
  `値切り` int,
  `母国語` int,
  `他の言語` int,
  `医学` int,
  `オカルト` int,
  `化学` int,
  `クトゥルフ神話` int,
  `芸術` int,
  `経理` int,
  `考古学` int,
  `コンピューター` int,
  `心理学` int,
  `人類学` int,
  `生物学` int,
  `地質学` int,
  `電子工学` int,
  `天文学` int,
  `博物学` int,
  `物理学` int,
  `法律` int,
  `薬学` int,
  `歴史` int
);

create table sum_etcP(
  id int not null auto_increment primary key,
  charId int unique,
  `回避` int,
  `キック` int,
  `組み付き` int,
  `こぶし` int,
  `頭突き` int,
  `投擲` int,
  `マーシャルアーツ` int,
  `拳銃` int,
  `サブマシンガン` int,
  `ショットガン` int,
  `マシンガン` int,
  `ライフル` int,
  `応急手当` int,
  `鍵開け` int,
  `隠す` int,
  `隠れる` int,
  `聞き耳` int,
  `忍び歩き` int,
  `写真術` int,
  `精神分析` int,
  `追跡` int,
  `登攀` int,
  `図書館` int,
  `目星` int,
  `運転` int,
  `重機械操作` int,
  `機械修理` int,
  `乗馬` int,
  `水泳` int,
  `製作` int,
  `操縦` int,
  `跳躍` int,
  `電気修理` int,
  `ナビゲート` int,
  `変装` int,
  `言いくるめ` int,
  `信用` int,
  `説得` int,
  `値切り` int,
  `母国語` int,
  `他の言語` int,
  `医学` int,
  `オカルト` int,
  `化学` int,
  `クトゥルフ神話` int,
  `芸術` int,
  `経理` int,
  `考古学` int,
  `コンピューター` int,
  `心理学` int,
  `人類学` int,
  `生物学` int,
  `地質学` int,
  `電子工学` int,
  `天文学` int,
  `博物学` int,
  `物理学` int,
  `法律` int,
  `薬学` int,
  `歴史` int
);

create table skill_name(
  id int not null auto_increment primary key,
  charId int unique,
  `運転` varchar(60),
  `製作` varchar(60),
  `操縦` varchar(60),
  `芸術` varchar(60),
  `母国語` varchar(60),
  `他の言語` varchar(60)
);

create table rooms(
  id int not null auto_increment primary key,
  roomName varchar(600),
  userName varchar(600),
  created datetime,
  modified datetime
  );

create table chat1(
  id int(5) zerofill auto_increment primary key,
  name varchar(255),
  text varchar(6000),
  icon varchar(1000),
  modified datetime
);

create table chat11(
  id int(5) zerofill auto_increment primary key,
  name varchar(255),
  text varchar(6000),
  icon varchar(1000),
  modified datetime
);


create table skill_data(
  name varchar(60),
  defaultP int,
  value enum('戦闘','探索','行動','交渉','知識')
);

insert into rooms(
  roomName, userName, created, modified
) values(
  '誰でも書き込める部屋',
  'じゃお',
  '2020-07-10 12:00:00',
  '2020-07-10 12:00:00'
);

insert into rooms(
  roomName, userName, created, modified
) values(
  'サンプル部屋',
  'じゃお',
  '2020-07-10 13:00:00',
  '2020-07-10 13:00:00'
);





insert into skill_data(name,defaultP,value) value('回避',0,'戦闘');
insert into skill_data(name,defaultP,value) value('キック',25,'戦闘');
insert into skill_data(name,defaultP,value) value('組み付き',25,'戦闘');
insert into skill_data(name,defaultP,value) value('こぶし',50,'戦闘');
insert into skill_data(name,defaultP,value) value('頭突き',10,'戦闘');
insert into skill_data(name,defaultP,value) value('投擲',25,'戦闘');
insert into skill_data(name,defaultP,value) value('マーシャルアーツ',1,'戦闘');
insert into skill_data(name,defaultP,value) value('拳銃',20,'戦闘');
insert into skill_data(name,defaultP,value) value('サブマシンガン',15,'戦闘');
insert into skill_data(name,defaultP,value) value('ショットガン',30,'戦闘');
insert into skill_data(name,defaultP,value) value('マシンガン',15,'戦闘');
insert into skill_data(name,defaultP,value) value('ライフル',25,'戦闘');
insert into skill_data(name,defaultP,value) value('応急手当',30,'探索');
insert into skill_data(name,defaultP,value) value('鍵開け',1,'探索');
insert into skill_data(name,defaultP,value) value('隠す',15,'探索');
insert into skill_data(name,defaultP,value) value('隠れる',10,'探索');
insert into skill_data(name,defaultP,value) value('聞き耳',25,'探索');
insert into skill_data(name,defaultP,value) value('忍び歩き',10,'探索');
insert into skill_data(name,defaultP,value) value('写真術',10,'探索');
insert into skill_data(name,defaultP,value) value('精神分析',1,'探索');
insert into skill_data(name,defaultP,value) value('追跡',10,'探索');
insert into skill_data(name,defaultP,value) value('登攀',40,'探索');
insert into skill_data(name,defaultP,value) value('図書館',25,'探索');
insert into skill_data(name,defaultP,value) value('目星',25,'探索');
insert into skill_data(name,defaultP,value) value('運転',20,'行動');
insert into skill_data(name,defaultP,value) value('機械修理',20,'行動');
insert into skill_data(name,defaultP,value) value('重機械操作',1,'行動');
insert into skill_data(name,defaultP,value) value('乗馬',5,'行動');
insert into skill_data(name,defaultP,value) value('水泳',25,'行動');
insert into skill_data(name,defaultP,value) value('製作',5,'行動');
insert into skill_data(name,defaultP,value) value('操縦',1,'行動');
insert into skill_data(name,defaultP,value) value('跳躍',25,'行動');
insert into skill_data(name,defaultP,value) value('電気修理',10,'行動');
insert into skill_data(name,defaultP,value) value('ナビゲート',10,'行動');
insert into skill_data(name,defaultP,value) value('変装',1,'行動');
insert into skill_data(name,defaultP,value) value('言いくるめ',5,'交渉');
insert into skill_data(name,defaultP,value) value('信用',15,'交渉');
insert into skill_data(name,defaultP,value) value('説得',15,'交渉');
insert into skill_data(name,defaultP,value) value('値切り',5,'交渉');
insert into skill_data(name,defaultP,value) value('母国語',30,'交渉');
insert into skill_data(name,defaultP,value) value('他の言語',1,'交渉');
insert into skill_data(name,defaultP,value) value('医学',5,'知識');
insert into skill_data(name,defaultP,value) value('オカルト',5,'知識');
insert into skill_data(name,defaultP,value) value('化学',1,'知識');
insert into skill_data(name,defaultP,value) value('クトゥルフ神話',0,'知識');
insert into skill_data(name,defaultP,value) value('芸術',5,'知識');
insert into skill_data(name,defaultP,value) value('経理',10,'知識');
insert into skill_data(name,defaultP,value) value('考古学',1,'知識');
insert into skill_data(name,defaultP,value) value('コンピューター',1,'知識');
insert into skill_data(name,defaultP,value) value('心理学',5,'知識');
insert into skill_data(name,defaultP,value) value('人類学',1,'知識');
insert into skill_data(name,defaultP,value) value('生物学',1,'知識');
insert into skill_data(name,defaultP,value) value('地質学',1,'知識');
insert into skill_data(name,defaultP,value) value('電子工学',1,'知識');
insert into skill_data(name,defaultP,value) value('天文学',1,'知識');
insert into skill_data(name,defaultP,value) value('博物学',10,'知識');
insert into skill_data(name,defaultP,value) value('物理学',1,'知識');
insert into skill_data(name,defaultP,value) value('法律',5,'知識');
insert into skill_data(name,defaultP,value) value('薬学',1,'知識');
insert into skill_data(name,defaultP,value) value('歴史',20,'知識');
