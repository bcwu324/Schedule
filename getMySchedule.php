<?php 
try{
    require_once("connectMemberTable.php");
    
    $sql = "select * from sche join attrac_sche on sche.Sche_NO=attrac_sche.Sche_NO   join attraction on attrac_sche.Attrac_NO=attraction.Attrac_NO where Mem_NO=:memNO";

    $attraction = $pdo->prepare($sql); 
    $attraction->bindValue(":memNO",$_GET["memNO"]);
    $attraction->execute();
  
    if( $attraction->rowCount()==0){ //查無此景點
        echo 0;
    }else{ //成功取得景點
      //自資料庫中取回景點資料
        $searchedAttractionRows = $attraction->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($searchedAttractionRows);
        // print_r($searchedAttractionRows);
    }
  }catch(PDOException $e){
    echo $e->getMessage();
  }
?>
