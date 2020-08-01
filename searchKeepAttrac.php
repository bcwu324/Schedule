<?php 
try{
    require_once("connectMemberTable.php");
    $sql = "select * from keep_attrac k left join attraction a on k.Attrac_NO=a.Attrac_NO where Mem_NO=:MemNO and Attrac_PicURL like 'http%' and Attrac_PicURL not like 'http://210%'";
    $attraction = $pdo->prepare($sql); 
    $attraction->bindValue(":MemNO",$_GET["MemNO"]);
    $attraction->execute();
  
    if( $attraction->rowCount()==0){ //尚無收藏任何景點
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
// echo $_GET["MemNO"];
?>