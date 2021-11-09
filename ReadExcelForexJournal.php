<?php

use function PHPSTORM_META\type;

require ("dbconnection.php");
    require ("vendor/autoload.php");

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('Records.xlsx');   // Loading the Excel file that contains the sheet that I will
    $sheet = $spreadsheet->getSheetByName("Journal (2)");  //getting the specific sheet I want to read data from
    
    // Store data from the read sheet to the variable in the form of Array
    $data = array(1,$sheet->toArray(null,true,true,true));
    
    $incrementalValue = 1;
    foreach($data[1] as $key){
        $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($sheet->getCell('A'.$incrementalValue)->getOldCalculatedValue());
        $dateAndTime = $dt->format('r');
        $insertRecordStmt = "INSERT INTO `journalrecord` (`DateAndTime`, `Timeframe`, `Symbol`, `BuyOrSell`, `LotSize`, `EntryPrice`, `Stoploss`, `TakeProfit`, `StopLossPips`, `TakeProfitPips`, `ReasonForEntry`, `EntryType`, `Grade`, `TradeStatus`, `RiskReward`, `MonetaryValue`, `BeforeScreenshot`, `AfterScreenshot`, `Comments`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($conn);
        if(mysqli_stmt_prepare($stmt, $insertRecordStmt)){
            mysqli_stmt_bind_param($stmt, "ssssddddddsssssdsss", $dateAndTime, $key['B'], $key['C'], $key['D'], $key['E'], $key['F'], $key['G'], $key['H'], $key['I'], $key['J'], $key['K'],$key['L'], $key['M'], $key['N'], $key['O'], $key['P'], $key['Q'], $key['R'], $key['S']);
            mysqli_stmt_execute($stmt);
            echo '<script type=text/javascript>alert(\"Journal details successfully inserted\")</script>';
        }else{
            echo '<script type=text/javascript>alert(\"Error! Journal details were not inserted\")</script>';
        }
        $incrementalValue +=1;
    }
?>