CREATE DATABASE IF NOT EXISTS hockeyapp;
    USE hockeyapp;
    CREATE TABLE Teams (
        teamID INT(11) UNSIGNED AUTO_INCREMENT UNIQUE NOT NULL,
        teamcode VARCHAR(3) UNIQUE NOT NULL,
        teamname VARCHAR(40) UNIQUE NOT NULL,
        wins INT(3) DEFAULT 0,
        losses INT(3) DEFAULT 0,
        overtimelosses INT(3) DEFAULT 0,
        winningpercentage DECIMAL(4,3) DEFAULT 0.0,
        PRIMARY KEY (teamID)
    );
    CREATE TABLE Players (
        playerID INT(11) UNSIGNED AUTO_INCREMENT NOT NULL,
        fk_teamID INT(11) UNSIGNED NOT NULL,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        birthyear INT(4) NOT NULL,
        position VARCHAR(10) NOT NULL,
        PRIMARY KEY (playerID),
        FOREIGN KEY (fk_teamID) REFERENCES Teams(teamID) ON DELETE CASCADE
    );
    CREATE TABLE Stats (
        fk_playerID INT(11) UNSIGNED UNIQUE NOT NULL,
        fk_stats_teamID INT(11) UNSIGNED NOT NULL,
        gamesplayed INT(3) DEFAULT 0,
        goals INT(3) DEFAULT 0,
        assists INT(3) DEFAULT 0,
        points INT(3) DEFAULT 0,
        plusminus INT(3) DEFAULT 0,
        faceoffswon INT(4) DEFAULT 0,
        faceoffslost INT(4) DEFAULT 0,
        faceoffpercentage DECIMAL(4,2) DEFAULT 0.0,
        wins INT(3) DEFAULT 0,
        losses INT(3) DEFAULT 0,
        overtimelosses INT(3) DEFAULT 0,
        shotsagainst INT(4) DEFAULT 0,
        goalsagainst INT(4) DEFAULT 0,
        goalsagainstaverage DECIMAL(3,2) DEFAULT 0.0,
        savepercentage DECIMAL(4,3) DEFAULT 0.0,
        shutouts INT(3) DEFAULT 0
    );
    ALTER TABLE Stats
    ADD CONSTRAINT FK_player_stats FOREIGN KEY (fk_playerID)
        REFERENCES Players(playerID)
        ON DELETE CASCADE;

    INSERT INTO teams (teamcode, teamname) VALUES ("FA", "Free Agents");