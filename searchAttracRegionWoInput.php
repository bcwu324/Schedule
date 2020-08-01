<?php 
try{
    require_once("connectMemberTable.php");
    $sql = "select * from attraction where Attrac_Region=:Region and Attrac_PicURL like 'http%' and Attrac_PicURL not like 'http://210%'";
    $attraction = $pdo->prepare($sql); 
    $attraction->bindValue(":Region", $_GET["Region"]);
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