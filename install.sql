
create table if not exists naju_visitor_stat (
	id int(100) unsigned not null auto_increment,
	timestamp timestamp not null,
	page varchar(75) not null,
	referer varchar(75) default null,
	primary key(id)
);

create index idx_stat_timestamp on naju_visitor_stat(timestamp);
create index idx_stat_page on naju_visitor_stat(page);

create table if not exists naju_stat_credential (
	token varchar(128) not null,
	alias varchar(75) default null
);
