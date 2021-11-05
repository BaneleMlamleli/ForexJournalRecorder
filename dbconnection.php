<?php
    $serverName = "";
    $username = "";
    $password = "";
    $dbName = "";

    switch($_SERVER["SERVER_NAME"]){
        case "localhost":
            $serverName = "localhost";
            $username = "root";
            $password = "";
            $dbName = "forexjournalrecorder";
            break;
    }

    // Create connection
    $conn = new mysqli($serverName, $username, $password, $dbName);

    // Check connection
    if ($conn->connect_error) {
        echo "<script type=text/javascript>alert('Database Connection failed')</script>";
        die($conn->connect_error);
    }

    //dropping the table
    if ($conn->query("DROP TABLE `journalrecord`")) {
        echo "<script type=text/javascript>alert('Table \'journalrecord\' has been deleted/dropped successfully.)</script>";
     }elseif ($conn->errno) {
        echo "<script type=text/javascript>alert('Table \'journalrecord\' was not deleted/dropped.)</script>";
     }

     //creating the table again
    $sqlCreateTable = "CREATE TABLE `forexjournalrecorder`.`journalrecord` ( `Pk` INT NOT NULL AUTO_INCREMENT , `DateAndTime` VARCHAR(30) NOT NULL , `Timeframe` VARCHAR(10) NOT NULL , `Symbol` VARCHAR(6) NOT NULL , `BuyOrSell` VARCHAR(5) NOT NULL , `LotSize` DOUBLE NOT NULL , `EntryPrice` DOUBLE NOT NULL , `Stoploss` DOUBLE NOT NULL , `TakeProfit` DOUBLE NOT NULL , `StopLossPips` DOUBLE NOT NULL , `TakeProfitPips` DOUBLE NOT NULL , `ReasonForEntry` VARCHAR(55) NOT NULL , `EntryType` VARCHAR(55) NOT NULL , `Grade` VARCHAR(20) NOT NULL , `TradeStatus` VARCHAR(20) NOT NULL , `RiskReward` VARCHAR(5) NOT NULL , `MonetaryValue` DOUBLE NOT NULL , `BeforeScreenshot` VARCHAR(200) NOT NULL , `AfterScreenshot` VARCHAR(200) NOT NULL , `Comments` VARCHAR(500) NOT NULL , PRIMARY KEY (`Pk`)) ENGINE = InnoDB;";

    if ($conn->query($sqlCreateTable) === TRUE) {
        echo "<script type=text/javascript>alert('Table \'journalrecord\' was created successfully.)</script>";
    } else {
        echo "<script type=text/javascript>alert('Table \'journalrecord\' was not created.)</script>";
    }
?>