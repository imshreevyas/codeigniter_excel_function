public function create_excel($table, $where, $fields){

        $styleArray = array(
            'borders' => array(
                'outline' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => array('argb' => '000000'),
                ),
            ),
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'FF4F81BD')
            ),
            'font'  => array(
                'bold'  => true,
                'color' => array('rgb' => 'ffffff'),
                'size'  => 10,
                'name'  => 'Verdana'
            )
        );

        $rows = 2;
        $builder = $this->db->table($table);
        $checkIfRowExist = $builder->where($where)->get()->getResultArray();
        $fileName = $table.'.xlsx';  
        $spreadsheet = new Spreadsheet();
    
        $sheet = $spreadsheet->getActiveSheet();
        $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $newAlp = []; // 25
        
        for ($i=0; $i < count($alphabet); $i++) { 
            if(count($newAlp) == 25 && count($fields) > 25){
                for ($j=0; $j < 2; $j++) {
                    for ($k=0; $k < count($alphabet); $k++) { 
                        $newAlp[] = $alphabet[$j].$alphabet[$k];
                    }
                }
            }
            else
                $newAlp[] = $alphabet[$i];
        }

        $cell = 'A1:'.$newAlp[count($fields)-1].'1';
        $sheet->getStyle($cell)->applyFromArray($styleArray);
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
