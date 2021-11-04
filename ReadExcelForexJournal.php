<?php
    //require 'dbconnection.php';
    require 'vendor/autoload.php';

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load('Records.xlsx');   // Loading the Excel file that contains the sheet that I will
    $sheet = $spreadsheet->getSheetByName("Test");  //getting the specific sheet I want to read data from
    
    // Store data from the read sheet to the variable in the form of Array
    $data = array(1,$sheet->toArray(null,true,true,true)); 
    
    // Display the sheet content 
    var_dump($data);
?>