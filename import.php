<?php
session_start();
include("MysqliDb.php");

$db = new MysqliDb ('localhost', 'root', '', 'test'); /// Creating Connection Object

    /////////////////////////////////  Upload  ////////////////////
    if(isset($_POST['submit'])) {
         $loc ="location:".$_SERVER['HTTP_REFERER'];
        if(isset($_FILES['uploadFile']['name']) && $_FILES['uploadFile']['name'] != "") {
    $allowedExtensions = array("xls","xlsx","csv");
    $ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
    if(in_array($ext, $allowedExtensions)) {
        $file_size = $_FILES['uploadFile']['size'] / 1024;
        if($file_size < 50000) {
            
                $file = "uploads/".$_FILES['uploadFile']['name'];
                $isUploaded = copy($_FILES['uploadFile']['tmp_name'], $file);
                if($isUploaded) {
                    include("Classes/PHPExcel/IOFactory.php");
                    try {
                        //Load the excel(.xls/.xlsx) file
                        $objPHPExcel = PHPExcel_IOFactory::load($file);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
                    }
                     
                    $sheet = $objPHPExcel->getSheet(0);
                    $total_rows = $sheet->getHighestRow();
                    $highest_column = $sheet->getHighestColumn();

                    $res ="";
                    for($row =2; $row <= $total_rows; $row++) {
                        
                        $single_row = $sheet->rangeToArray('A' . $row . ':' . $highest_column . $row, NULL, TRUE, FALSE);
      
                            $data["name"] = trim($single_row[0][0]); 
                            $data["email"] = trim($single_row[0][1]); 
                            $res = $db->insert("users", $data);



                          }

                    

                       
                          // echo "<pre>";
                           // pr($data);
                            unset($data);

                           // die;

                          
                     
                    }

      
                    unlink($file);
                     $_SESSION['success'] ="User imported successfully!";
                    header($loc);
                
                   
            } else {
                $_SESSION['error'] ="File not uploaded!";
                header($loc);
              
            }
        } else {
            
           
             $_SESSION['error'] ="Maximum file size should not cross 50 MB on size!";
             header($loc);
            
        }
    } else {
       
        $_SESSION['error'] ="This type of file not allowed!";
        header($loc);
        
    }
}
    
?>