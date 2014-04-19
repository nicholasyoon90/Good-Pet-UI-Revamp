DROP TABLE IF EXISTS tempF;
DROP TABLE IF EXISTS tempU;
DROP TRIGGER IF EXISTS account_done;
CREATE TABLE tempU ( email varchar(32) NOT NULL default '',
					 hashed_password varchar(255) NOT NULL default '',
					 fname varchar(32) NOT NULL default'',
					 done TINYINT NOT NULL default 0
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					
CREATE TABLE tempF ( fID int NOT NULL,
					 petName varchar(32) NOT NULL default ''
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					  
DELIMITER $$

CREATE TRIGGER account_done
	AFTER UPDATE ON tempU
	FOR EACH ROW
	BEGIN
		IF (NEW.done = 1)
		THEN INSERT INTO Users (email, hashed_password, fname) VALUES (NEW.email, NEW.hashed_password, NEW.fname);
		END IF;
	END$$
DELIMITER ;

					
					