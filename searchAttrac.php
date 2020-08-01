<?php 
try{
    require_once("connectMemberTable.php");
    
    // $sql = "select a.Attrac_Long,a.Attrac_Latit,a.Attrac_Addre,a.Class1,a.Website,a.Attrac_Open,a.Attrac_Desc,a.Attrac_Name,a.Attrac_Region,a.Attrac_PicURL,a.Attrac_Tel,a.Attrac_NO,k.Mem_NO from attraction a left join keep_attrac k on a.Attrac_NO=k.Attrac_NO where Attrac_Name like :searchedName and Attrac_PicURL like 'http%' and Attrac_PicURL not like 'http://210%'";
    
    $sql = "select * from attraction where Attrac_Name like :searchedName and Attrac_PicURL like 'http%' and Attrac_PicURL not like 'http://210%'";

    $attraction = $pdo->prepare($sql); 
    $attraction->bindValue(":searchedName", '%'.$_GET["searchedName"].'%');
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
