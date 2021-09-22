public function create_excel(){

  <!-- example code to create excel with some where -->
  $name = $this->request->getPost('employee');      <!-- employee names -->
  $from = $this->request->getPost('fromdate');      <!-- start date -->
  $to = $this->request->getPost('todate');          <!-- to date -->
  $table = 'daily_attendance';                      <!-- table name -->
  $where['emp_id'] = 'XXXX1234';                    <!-- where emp_id = 'XXXX1234' -->

  
  <!-- check date if greater than To Date   -->
  if($from > $to){
      echo 'To Date cannot be greater than From date';
      exit;
  }

  <!-- If from not null add where date >= '2020-05-09' -->
  if($from != '')
      $where['date >='] = $from;   

  <!-- If To not null add where date <= '2020-05-09' -->
  if($to != '')
      $where['date <= '] = $to;


  <!-- Feilds is the array of all column names you want, column name should be same as daqtabse or it won't work -->
  $fields = array('id','emp_id','checkin','checkout','type','remark','ip');
  
  <!-- Call Common Model with table name, where clause array and feilds array you want  -->
  $this->common_model->create_excel($table, $where, $fields);
}
