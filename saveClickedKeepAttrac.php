<?php 
try{
    require_once("connectMemberTable.php");
    $sql = "insert into keep_attrac (Mem_NO,Attrac_NO) values (:saveKeepMemNO,:saveKeepAttracNO)";
    $keepAttraction = $pdo->prepare($sql); 
    $keepAttraction->bindValue(":saveKeepMemNO",$_POST["saveKeepMemNO"]);
    $keepAttraction->bindValue(":saveKeepAttracNO",$_POST["saveKeepAttracNO"]);
    $keepAttraction->execute();
    echo "成功收藏此景點";
  }catch(PDOException $e){
    echo $e->getMessage();
  }
?>