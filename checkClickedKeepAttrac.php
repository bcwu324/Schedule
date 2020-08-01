<?php 
try{
    require_once("connectMemberTable.php");
    $sql2 = "select * from `keep_attrac` where Mem_NO=:KeepMemNO and Attrac_NO=:KeepAttracNO";
    $keepAttraction = $pdo->prepare($sql2); 
    $keepAttraction->bindValue(":KeepMemNO",$_GET["KeepMemNO"]);
    $keepAttraction->bindValue(":KeepAttracNO",$_GET["KeepAttracNO"]);
    $keepAttraction->execute();
  
    if( $keepAttraction->rowCount()==0){ 
        echo 0;
    }else{ //成功取得收藏景點
      //自資料庫中取回景點資料
        $keepAttractionRow = $keepAttraction->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($keepAttractionRow);
    }
  }catch(PDOException $e){
    echo $e->getMessage();
  }
?>