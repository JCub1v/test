<?php
  if(session_id()){
    session_start();
  }
//include database connection
  require_once"connection.php";

  $redirectURL = "index.html";

  if(isset($_POST['dvSubmit'])){
    //get form field value
    $MemberID = $_POST['MemberID'];
    $manv = trim(strip_tags($_POST['maNV']));
    $tennv = trim(strip_tags($_POST['tenNV']));
    $bophan = trim(strip_tags($_POST['bophan']));
    $nhamay = trim(strip_tags($_POST['nhamay']));
    $loainv = trim(strip_tags($_POST['loaiNV']));
    $loaitb = trim(strip_tags($_POST['loaiTB']));
    $model = trim(strip_tags($_POST['model']));
    $cauhinh = trim(strip_tags($_POST['cauhinh']));
    $modelmh = trim(strip_tags($_POST['modelmh']));
    $kichthuoc = trim(strip_tags($_POST['kichthuoc']));
    $ngaycap = trim(strip_tags($_POST['ngaycap']));
    $ngaybaotri = trim(strip_tags($_POST['ngaybaotri']));
    $note = trim(strip_tags($_POST['note']));

    $id_str ='';
    if(!empty($id)){
        $id_str = '?id=' .$MemberID;
    }

    $errorMsg = '';
    if(empty($manv)){
        $errorMsg .= '<p>Hãy điền mã nhân viên</p>';
    }
    if(empty($tennv)){
        $errorMsg .= '<p>Hãy điền tên nhân viên</p>';
    }
    if(empty($bophan)){
        $errorMsg .= '<p>Hãy điền tên bộ phận</p>';
    }
    if(empty($nhamay)){
        $errorMsg .= '<p>Hãy điền tên nhà máy</p>';
    }
    if(empty($loainv)){
        $errorMsg .= '<p>Hãy điền loại nhân viên</p>';
    }
    if(empty($loaitb)){
        $errorMsg .= '<p>Hãy điền loại thiết bị</p>';
    }
    if(empty($model)){
        $errorMsg .= '<p>Hãy điền model thiết bị</p>';
    }
    if(empty($cauhinh)){
        $errorMsg .= '<p>Hãy điền cấu hình</p>';
    }
    if(empty($modelmh)){
        $errorMsg .= '<p>Hãy điền model màn hình</p>';
    }
    if(empty($kichthuoc)){
        $errorMsg .= '<p>Hãy điền kích thước</p>';
    }
    if(empty($ngaycap)){
        $errorMsg .= '<p>Hãy điền ngày cấp</p>';
    }
    if(empty($ngaybaotri)){
        $errorMsg .= '<p>Hãy điền ngày bảo trì</p>';
    }
    $userData = array(
        'maNV' => $manv,
        'tenNV' => $tennv,
        'bophan' => $bophan,
        'nhamay' => $nhamay,
        'loaiNV' => $loainv,
        'loaiTB' => $loaitb,
        'model' => $model,
        'cauhinh' => $cauhinh,
        'modelmh' => $modelmh,
        'kichthuoc' => $kichthuoc,
        'ngaycap' => $ngaycap,
        'ngaybaotri' => $ngaybaotri,
        'note' => $note
    );
    $sessData['userData'] = $userData;

    //Process the form from data
    if(empty($errorMsg)){
        if(!empty($MemberID)){
            $sql = "UPDATE devices SET maNV = ?, tenNV =? , bophan = ?, nhamay = ?, loaiNV= ?,
         loaiTB = ?, model= ?, cauhinh= ?, modelmh = ?, kichthuoc = ?, ngaycap = ?, ngaybaotri = ?,
          note = ? WHERE MemberID =?";
         $query = $conn -> prepare($sql);
         $update = $query -> execute(array($manv,$tennv,$bophan,$nhamay,$loainv, 
         $loaitb,$model,$cauhinh,$modelmh,$kichthuoc,$ngaycap,$ngaybaotri, $note, $MemberID));
         if($update){
            $sessData['status']['type'] = 'success';
            $sessData['status']['msg'] = 'Device data has been updated sucessfully.';

            // Remove submitted field values from session
            unset($sessData['userData']);
         }else{
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Some problem occured, please try again.';

            //Set redirect url
            $redirectURL = 'addEdit.html'.$id_str;
         }
         }else{
            //Insert data in SQL server
            $sql="INSERT INTO devices (maNV, tenNV, bophan, nhamay, loaiNV, loaiTB, model, cauhinh, modelmh, kichthuoc, ngaycap, ngaybaotri, note)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $params = array(
                &$manv,
                &$tennv,
                &$bophan,
                &$nhamay,
                &$loainv,
                &$loaitb,
                &$model,
                &$cauhinh,
                &$modelmh,
                &$kichthuoc,
                &$ngaycap,
                &$ngaybaotri,
                &$note
            );
         $query = $conn -> prepare($sql);
         $insert =$query->execute($params);

         if($insert){
            $sessData["status"]["type"] = "success";
            $sessData["status"]["msg"] = "Device data has been added successfully.";

            //Remove submitted field values from session

            unset($sessData['userData']);
         }else{
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Some problem occured, please try again.';

            //Set  redirect url
            $redirectURL = 'addEdit.html'.$id_str;
         }
        }
}else{
    $sessData['status']['type'] = 'error';
    $sessData['status']['msg'] = '<p>Please fill all the madatory fields.</p>'.$errorMsg;
    
    //set redirect url
    $redirectURL = 'addEdit.html'.$id_str;
}
    $_SESSION['sessData'] = $sessData;
}elseif($_REQUEST['action_type']== 'delete' && !empty($_GET['id'])){
    $MemberID = $_GET['id'];

    //Delete data from SQL server
    $sql = "DELETE FROM devices WHERE MemberID =?";
    $query = $conn -> prepare($sql);
    $delete = $query -> execute(array($MemberID));

    if($delete){
        $sessData['status']['type'] = 'success';
        $sessData['status']['msg'] = 'Device data has been deleted successfully.';
    }else{
        $sessData['status']['type'] = 'error';
        $sessData['status']['msg'] = 'Some problem occurred, please try again.';
    }
    $_SESSION['sessData']= $sessData;
}
    //Redirect to the respective page
    header("Location:".$redirectURL);
    exit();
