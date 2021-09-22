public function create_excel($table, $where, $fields){

        $rows = 2;
        $builder = $this->db->table($table);
        $checkIfRowExist = $builder->where($where)->get()->getResultArray();
        $fileName = $table.'.xlsx';  
        $spreadsheet = new Spreadsheet();
    
        $sheet = $spreadsheet->getActiveSheet();
        $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $newAlp = []; // 25

        for ($i=0; $i <= count($alphabet); $i++) { 
            if($newAlp[25] == 'Z'){
                for ($j=0; $j < 2; $j++) {
                    for ($k=0; $k < count($alphabet); $k++) { 
                        $newAlp[] = $alphabet[$j].$alphabet[$k];
                    }
                }
            }
            else
                $newAlp[] = $alphabet[$i]; 
        }

        
        foreach ($fields as $key=>$field) {
            $sheet->setCellValue($alphabet[$key].'1', $field);
        }

        foreach ($checkIfRowExist as $key=>$val){
            foreach ($fields as $key=>$field) {
                $sheet->setCellValue($alphabet[$key] . $rows, $val[$fields[$key]]);
            }
            $rows++;
        } 
        $writer = new Xlsx($spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$fileName);
        $writer->save("php://output");
    }
