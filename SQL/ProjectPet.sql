DROP TABLE IF EXISTS Schedules;
DROP TABLE IF EXISTS Feeders;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Logs;
DROP TABLE IF EXISTS Emails;
DROP TRIGGER IF EXISTS feeder_insert;
DROP TRIGGER IF EXISTS user_insert;
DROP TRIGGER IF EXISTS schedule_insert;
DROP TRIGGER IF EXISTS schedule_edit;
DROP TRIGGER IF EXISTS schedule_delete;
DROP TRIGGER IF EXISTS encounter_error;
CREATE TABLE Users ( email varchar(32) NOT NULL default '',
					 hashed_password varchar(255) NOT NULL default '',
					 fname varchar(32) NOT NULL default'',
					 userID BIGINT UNSIGNED AUTO_INCREMENT,
					 remid varchar(128) NOT NULL,
					 PRIMARY KEY (userID),
					 UNIQUE (email)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					  
					   
CREATE TABLE Feeders ( fID int NOT NULL,
					   petName varchar(32) NOT NULL default '',
					   userID BIGINT NOT NULL,
					   feederIP varchar(15) NOT NULL default '',
					   petType varchar(32) NOT NULL default '',
					   petBreed varchar(32) NOT NULL default '',
					   petGender varchar(10) NOT NULL default '',
					   petAgeYears int NOT NULL default 0,
					   petWeightLbs int NOT NULL default 0,
					   petFoodBrand varchar(32) NOT NULL default '',
					   petHealth varchar(32) NOT NULL default '',
					   timestamp BIGINT NOT NULL default 0,
					   disn TINYINT NOT NULL default 0,
					   schChanged TINYINT NOT NULL default 0,
					   command TINYINT NOT NULL default 0,
					   open TINYINT NOT NULL default 0,
					   SWUpdate TINYINT NOT NULL default 0,
					   SWVersion int NOT NULL,
					   PRIMARY KEY (fID)
					 ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Schedules ( scheduleName varchar(32) NOT NULL default '',
						 Monday BIT NOT NULL default False,
						 Tuesday BIT NOT NULL default False,
						 Wednesday BIT NOT NULL default False,
						 Thursday BIT NOT NULL default False,
						 Friday BIT NOT NULL default False,
						 Saturday BIT NOT NULL default False,
						 Sunday BIT NOT NULL default False,
						 Everyday BIT NOT NULL default False,
						 aTime varchar(10) NOT NULL default '',
						 AMPM BIT NOT NULL default False,
						 fID int NOT NULL,
						 amountFed DECIMAL(4,2) NOT NULL default '0',
						 userID BIGINT NOT NULL,
						 sID BIGINT UNSIGNED AUTO_INCREMENT,
						 PRIMARY KEY(sID)
					   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					   
CREATE TABLE Logs ( userID int NOT NULL default 0,
					email varchar(32) NOT NULL default '',
					fID int NOT NULL default 0,
					sID int NOT NULL default 0,
					eventTime TIMESTAMP NOT NULL,
					eventError BIT NOT NULL default False,
					eventDescription varchar(30) NOT NULL default '',
					logID BIGINT UNSIGNED AUTO_INCREMENT,
					PRIMARY KEY(logID)
				   ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE Emails ( userID int NOT NULL,
					  emailAddress varchar(32) NOT NULL default '',
					  emailBody varchar(255) NOT NULL default '',
					  emailHeaderInfo varchar(32) NOT NULL default '',
					  emailID BIGINT UNSIGNED AUTO_INCREMENT,
					  PRIMARY KEY(emailID)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8;
					  
DELIMITER $$
						
CREATE TRIGGER feeder_insert
	AFTER INSERT ON Feeders
	FOR EACH ROW
	BEGIN
		INSERT INTO Logs (userID, fID, eventError, eventDescription) VALUES (NEW.userID,NEW.fID,0,'Feeder Created');
	END$$

CREATE TRIGGER user_insert
	AFTER INSERT ON Users
	FOR EACH ROW
	BEGIN
		INSERT INTO Logs (userID, email, eventError, eventDescription) VALUES (NEW.userID,NEW.email,0,'User Created');
	END$$

CREATE TRIGGER schedule_insert
	AFTER INSERT ON Schedules
	FOR EACH ROW
	BEGIN
		INSERT INTO Logs (userID, fID, sID, eventError, eventDescription) VALUES (NEW.userID,NEW.fID,NEW.sID,0,'Schedule Created');
		UPDATE Feeders SET schChanged=1 WHERE fID=NEW.fID;
	END$$

CREATE TRIGGER schedule_edit
	AFTER UPDATE ON Schedules
	FOR EACH ROW
	BEGIN
		INSERT INTO Logs (userID, fID, sID, eventError, eventDescription) VALUES (NEW.userID,NEW.fID,NEW.sID,0,'Schedule Edited');
		UPDATE Feeders SET schChanged=1 WHERE fID=NEW.fID;
	END$$

CREATE TRIGGER schedule_delete
	AFTER DELETE ON Schedules
	FOR EACH ROW
	BEGIN
		INSERT INTO Logs (userID, fID, sID, eventError, eventDescription) VALUES (OLD.userID,OLD.fID,OLD.sID,0,'Schedule Deleted');
		UPDATE Feeders SET schChanged=1 WHERE fID=OLD.fID;
	END$$

CREATE TRIGGER encounter_error
	AFTER INSERT ON Logs
	FOR EACH ROW
	BEGIN
		IF (NEW.eventError = 1)
		THEN INSERT INTO Emails (userID, emailAddress, emailBody, emailHeaderInfo) VALUES (NEW.userID,NEW.email,NEW.eventDescription);
		END IF;
	END$$

DELIMITER ;

					
					