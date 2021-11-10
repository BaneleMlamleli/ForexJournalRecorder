<?php
    use function PHPSTORM_META\type;
    require ("dbconnection.php");
    require ("vendor/autoload.php");

    $filePath = 'G:\My Drive\Trading\My Records\Records - copy.xlsx';
    // checking if the specified path and/or file exist and the file is readable
    if(is_readable($filePath)){
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);   // Loading the Excel file that contains the sheet that I will read
        $sheet = $spreadsheet->getSheetByName("Journal (2)");  //getting the specific sheet I want to read
        
        // Store data from the read sheet to the variable in the form of Array
        $data = array(1,$sheet->toArray(null,true,true,true));
        
        $incrementalValue = 1;
        foreach($data[1] as $key){
            // reading only the first column which contains the date cell. I'm incrementing the cell value by 1 to get  A1, A2, A3...
            $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($sheet->getCell('A'.$incrementalValue)->getOldCalculatedValue());
            $dateAndTime = $dt->format('r'); // formatting the above read date into this format e.g., Fri, 04 Jun 2021 00:08:41 +000
            $insertRecordStmt = "INSERT INTO `journalrecord` (`DateAndTime`, `Timeframe`, `Symbol`, `BuyOrSell`, `LotSize`, `EntryPrice`, `Stoploss`, `TakeProfit`, `StopLossPips`, `TakeProfitPips`, `ReasonForEntry`, `EntryType`, `Grade`, `TradeStatus`, `RiskReward`, `MonetaryValue`, `BeforeScreenshot`, `AfterScreenshot`, `Comments`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if(mysqli_stmt_prepare($stmt, $insertRecordStmt)){
                mysqli_stmt_bind_param($stmt, "ssssddddddsssssdsss", $dateAndTime, $key['B'], $key['C'], $key['D'], $key['E'], $key['F'], $key['G'], $key['H'], $key['I'], $key['J'], $key['K'],$key['L'], $key['M'], $key['N'], $key['O'], $key['P'], $key['Q'], $key['R'], $key['S']);
                mysqli_stmt_execute($stmt);
            }
            $incrementalValue +=1;
        }
        echo $incrementalValue-1 . " rows were successfully read and recorded into the database";
    }else{
        echo "The specified path or file (". $filePath .") either does not exist or cannot be read!";
    }
?>