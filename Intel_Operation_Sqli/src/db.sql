CREATE DATABASE IF NOT EXISTS 17ed80ddc97e283e7e299e4a7d591a46 CHARACTER SET utf8 COLLATE utf8_general_ci;
# 17ed80ddc97e283e7e299e4a7d591a46 = SuperSecretDb

SET GLOBAL query_cache_size = 100000;
GRANT SELECT ON 17ed80ddc97e283e7e299e4a7d591a46.* TO 'HackfestUser'@'%' IDENTIFIED BY 'seCR3T_p@ssw0rD';

USE 17ed80ddc97e283e7e299e4a7d591a46;

CREATE TABLE operations (
	id INT UNSIGNED,
	code VARCHAR (255),
	name VARCHAR (255)
);

CREATE TABLE 64ff585930293b81079991770a3b28de (
	SecretData VARCHAR (255)
);

INSERT INTO operations (id, code, name) VALUES (1, "15999820", "hack the tactical map- satellite");
INSERT INTO operations (id, code, name) VALUES (2, "48225863", "Supply Drops");

INSERT INTO 64ff585930293b81079991770a3b28de (SecretData) VALUES ("HACKFEST{template}");
