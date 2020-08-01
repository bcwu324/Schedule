<?php 
// insert savedScheduel to sche:
try{
    require_once("connectMemberTable.php");
    $sql = "insert into sche (Mem_NO,Sche_Name,Sche_Img,Sche_Day,Sche_Views,Sche_Status) values (:MemNO,:scheName,:scheImg,:scheDay,:scheViews,:scheStatus)";
	$schedule = $pdo->prepare($sql);
	
	$schedule->bindValue(":MemNO", $_POST["MemNO"]);
    $schedule->bindValue(":scheName", $_POST["scheName"]);
    $schedule->bindValue(":scheImg", $_POST["selectedAttractions"][0]["Attrac_PicURL"]);
    $schedule->bindValue(":scheDay", 1);
    $schedule->bindValue(":scheViews", rand(1000,3000));
    $schedule->bindValue(":scheStatus", $_POST["scheStatus"]);
	$schedule->execute();
    
    // 取得db最後一筆資料的pk:
    $scheNO=$pdo->lastInsertId();
    
    echo '成功儲存MemNO,scheName,scheStatus';

  }catch(PDOException $e){
    echo $e->getMessage();
  };

//   inser savedSchedule to attrac_sche:
  try{
    require_once("connectMemberTable.php");

for($i=0;$i<count($_POST["selectedAttractions"]);$i++){
    $sql = "insert into attrac_sche (Sche_NO,Attrac_NO,Nth_Day,Attrac_Start_Time,Attrac_Leave_Time) values (:ScheNO,:AttracNO,:nthDay,:attracStartTime,:attracLeaveTime)";
	$schedule = $pdo->prepare($sql);
	
	$schedule->bindValue(":ScheNO",$scheNO);
    $schedule->bindValue(":AttracNO", $_POST["selectedAttractions"][$i]["Attrac_NO"]);
    $schedule->bindValue(":nthDay", 1);
    $schedule->bindValue(":attracStartTime", $_POST["selectedAttractions"][$i]["attracStartTime"]);
    $schedule->bindValue(":attracLeaveTime", $_POST["selectedAttractions"][$i]["attracLeaveTime"]);
    // $schedule->bindValue(":attracStartTime", $_POST["attracStartTime"][$i]);
	$schedule->execute();
};
    echo '成功儲存ScheNO,AttracNO,attracStartTime,attracLeaveTime';

  }catch(PDOException $e){
    echo $e->getMessage();
  };
?>