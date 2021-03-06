CREATE TABLE icmlm_scores (
	id				INT PRIMARY KEY AUTO_INCREMENT,
	title			VARCHAR(64) NOT NULL, 
	author			VARCHAR(64) NOT NULL,
	email			VARCHAR(128),
	notify			VARCHAR(16),
	instruments		VARCHAR(1024) NOT NULL,
	tonality		VARCHAR(64) NOT NULL,
	dynamics		VARCHAR(64) NOT NULL,
	mood			VARCHAR(64) NOT NULL,
	tempo			VARCHAR(64) NOT NULL,
	length			INT NOT NULL,
	queue_time		DATETIME,
	status			VARCHAR(32) NOT NULL DEFAULT 'pending'
);
CREATE TABLE icmlm_instruments (
	id				INT PRIMARY KEY AUTO_INCREMENT,
	name			VARCHAR(128) NOT NULL UNIQUE, 
	status			VARCHAR(32) NOT NULL DEFAULT 'available'
);