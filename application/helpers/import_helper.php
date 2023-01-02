<?php
defined('BASEPATH') or exit('No direct script access allowed');


  function importExcelFile($FILE,$FileName,$path){
    $ci = get_instance();
    $data = [];
    require_once APPPATH . "/third_party/PHPExcel.php";
    if (!empty($FILE[$FileName]['name']) != '') {
        $extension = end(explode(".", $FILE[$FileName]["name"]));
        $allowed_extension = array("xls", "xlsx", "csv");
        if(in_array($extension, $allowed_extension)){     
            $newName = strtotime('now').'.'.$extension;
            $path    = "{$path}/{$newName}";
            if (move_uploaded_file($FILE[$FileName]['tmp_name'],$path)) {
                $inputFileName = APPPATH.'../'.$path;
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                    $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $data = ['error' => '','data' => $allDataInSheet];
                }catch(Exception $e) {
                    $data = ['error' => 'Error loading file "' . pathinfo($tempFile, PATHINFO_BASENAME) . '": ' . $e->getMessage(),'data' => '' ];
                }
            } else {
                   $data = ['error' => 'File not uploded','data' => ''];
            }
        }else{
            $data = ['error' => 'Invalid File','data' => ''];
        }
    }
    return $data;
  }

  function pr($data,$die = ""){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
    if( !empty($die) ){
        die($die);
    }
  }
