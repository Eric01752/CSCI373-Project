CREATE DATABASE IF NOT EXISTS hockeyapp;
    USE hockeyapp;
    CREATE TABLE Teams (
        teamID INT(11) UNSIGNED AUTO_INCREMENT UNIQUE NOT NULL,
        teamname VARCHAR(40) NOT NULL,
        PRIMARY KEY (teamID)
    );
    CREATE TABLE Players (
        playerID INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
        fk_teamID INT(11) UNSIGNED NOT NULL,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        age INT(3) NOT NULL,
        position SET("Center","Left Wing","Right Wing","Defense","Goalie") NOT NULL,
        PRIMARY KEY (playerID),
        FOREIGN KEY (fk_teamID) REFERENCES Teams(teamID)
    );
    CREATE TABLE Stats (
        fk_playerID INT(11) UNSIGNED UNIQUE NOT NULL,
        gamesplayed INT(3) DEFAULT 0,
        goals INT(3) DEFAULT 0,
        assists INT(3) DEFAULT 0,
        points INT(3) DEFAULT 0,
        plusminus INT(3) DEFAULT 0,
        faceoffswon INT(4) DEFAULT 0,
        faceoffslost INT(4) DEFAULT 0,
        faceoffpercentage DECIMAL(2,1) DEFAULT 0.0
    );
    ALTER TABLE Stats
    ADD CONSTRAINT FK_player_stats FOREIGN KEY (fk_playerID)
        REFERENCES Players(playerID);
    /*Test Data*/
    INSERT INTO teams(teamname)
    VALUES("Boston Bruins");
    INSERT INTO players(fk_teamID,firstname,lastname,age,position)
    VALUES(1,"Bob","Smith",30,"Center");
    INSERT INTO stats(fk_playerID)
    VALUES(1);
    INSERT INTO players(fk_teamID,firstname,lastname,age,position)
    VALUES(1,"Phil","Duke",25,"Left Wing");
    INSERT INTO stats(fk_playerID)
    VALUES(2);
    INSERT INTO players(fk_teamID,firstname,lastname,age,position)
    VALUES(1,"Steve","Dome",28,"Goalie");
    INSERT INTO stats(fk_playerID)
    VALUES(3);
    INSERT INTO players(fk_teamID,firstname,lastname,age,position)
    VALUES(1,"Jake","Tucker",19,"Right Wing");
    INSERT INTO stats(fk_playerID)
    VALUES(4);
    INSERT INTO players(fk_teamID,firstname,lastname,age,position)
    VALUES(1,"Mark","White",31,"Defense");
    INSERT INTO stats(fk_playerID)
    VALUES(5);

    /*Test Queries*/
    /*SELECT * FROM teams;
    SELECT * FROM players;
    SELECT * FROM stats;

    SELECT lastname,firstname
    FROM players
    WHERE lastname="Smith";*/
    