CREATE DATABASE IF NOT EXISTS hockeyapp;
    USE hockeyapp;
    CREATE TABLE Teams (
        id INT(11) UNSIGNED AUTO_INCREMENT UNIQUE NOT NULL,
        teamname VARCHAR(40) NOT NULL,
        PRIMARY KEY (id)
    );
    CREATE TABLE Players (
        id INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
        teamID INT(11) UNSIGNED NOT NULL,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        age INT(3) NOT NULL,
        position SET("Center","Left Wing","Right Wing","Defense","Goalie") NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (teamID) REFERENCES Teams(id)
    );
    CREATE TABLE Stats (
        playerID INT(11) UNSIGNED UNIQUE NOT NULL,
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
    ADD CONSTRAINT FK_player_stats FOREIGN KEY (playerID)
        REFERENCES Players(id);
    /*Test Data*/
    INSERT INTO teams(teamname)
    VALUES("Boston Bruins");
    INSERT INTO players(teamID,firstname,lastname,age,position)
    VALUES(1,"Bob","Smith",30,"Center");
    INSERT INTO stats(playerID)
    VALUES(1);
    INSERT INTO players(teamID,firstname,lastname,age,position)
    VALUES(1,"Phil","Duke",25,"Left Wing");
    INSERT INTO stats(playerID)
    VALUES(2);
    INSERT INTO players(teamID,firstname,lastname,age,position)
    VALUES(1,"Steve","Dome",28,"Goalie");
    INSERT INTO stats(playerID)
    VALUES(3);
    INSERT INTO players(teamID,firstname,lastname,age,position)
    VALUES(1,"Jake","Tucker",19,"Right Wing");
    INSERT INTO stats(playerID)
    VALUES(4);
    INSERT INTO players(teamID,firstname,lastname,age,position)
    VALUES(1,"Mark","White",31,"Defense");
    INSERT INTO stats(playerID)
    VALUES(5);

    /*Test Queries*/
    /*SELECT * FROM teams;
    SELECT * FROM players;
    SELECT * FROM stats;

    SELECT lastname,firstname
    FROM players
    WHERE lastname="Smith";*/
    