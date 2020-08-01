<?php
try {
    require_once("connectMemberTable.php");
    session_start();
    $mem_NO = $_SESSION["Mem_NO"];
    if(isset($_POST['submitButton'])){
        if($_SESSION["Mem_NO"]){
            $PicGroupContent = 'images/groupphoto/'.$_FILES["fileupload"]["name"];
            if(isset($_FILES["fileupload"])){
                switch($_FILES["fileupload"]["error"]){
                    case 0:
                        $dir = "images/groupphoto"; //指定一個資料夾路徑存放檔案
                        if(file_exists($dir) === false){ //檢察資料夾是否已存在，若否，則建立一個
                            mkdir($dir);
                        }
                        $from = $_FILES["fileupload"]["tmp_name"]; //暫存區的路徑
                        $to = "$dir/{$_FILES["fileupload"]["name"]}"; //用原始檔名稱當做資料儲存的來源會有名稱重複的問題，當相同檔案名稱被重複上傳，後者會覆蓋前者
                        copy($from, $to); //將暫存區檔案抓到資料夾
                        break;
                    case 1:
                        echo "上傳失敗, 上傳的檔案太大, 不得超過" , ini_get("upload_max_filesize"), "<br>";
                        break;
                    case 2:
                        echo "上傳失敗, 上傳的檔案太大, 不得超過", $_POST["MAX_FILE_SIZE"], "<br>";
                        break;
                    case 3:
                        echo "上傳失敗, 上傳的檔案不完整<br>";
                        break;
                    case 4:
                        echo "檔案未選<br>";
                        break;
                    default:
                        echo "system upload error : ", $_FILES["upFile"]["error"], "<br>";
                }
            }else{
                echo "<script>console.log('不存在');</script>";
            }
            $sql_group = 
                "Insert into grouptable 
                (Mem_NO, Sche_NO, Group_title, Group_StartDate, 
                Group_EndDate, Group_Deadline,Group_Ppl, Group_Sex, 
                Group_Age, Group_Fee, Group_Place, Group_Pic, 
                Group_Status, Group_Com)
                VALUES 
                (:group_1,  :group_2, :group_3, 
                :group_4,  :group_5,  :group_6, 
                :group_7,  :group_8,  :group_9, 
                :group_10, :group_11, :group_12, 
                :group_13, :group_14)";
            $setupGroup = $pdo->prepare($sql_group);
            $setupGroup->bindValue(":group_1", $mem_NO);
            $setupGroup->bindValue(":group_2", $_POST["shedulename"]);
            $setupGroup->bindValue(":group_3", $_POST["Group_title"]);
            $setupGroup->bindValue(":group_4", $_POST["Group_StartDate"]);
            $setupGroup->bindValue(":group_5", $_POST["Group_EndDate"]);
            $setupGroup->bindValue(":group_6", $_POST["Group_Deadline"]);
            $setupGroup->bindValue(":group_7", $_POST["Group_Ppl"]);
            $setupGroup->bindValue(":group_8", $_POST["Group_Sex"]);
            $setupGroup->bindValue(":group_9", $_POST["Group_Age"]);
            $setupGroup->bindValue(":group_10", $_POST["Group_Fee"]);
            $setupGroup->bindValue(":group_11", $_POST["Group_Place"]);
            $setupGroup->bindValue(":group_12", $PicGroupContent);
            $setupGroup->bindValue(":group_13", 1);
            $setupGroup->bindValue(":group_14", $_POST["Group_Com"]);
            $setupGroup->execute();

            $sql_getgroupno = 
            "Select Group_NO from grouptable g
            where Mem_NO=:Mem_NO
            order by group_no desc limit 1";
            $setupGroupNO = $pdo->prepare($sql_getgroupno);
            $setupGroupNO->bindValue(":Mem_NO", $mem_NO);
            $setupGroupNO->execute();
            $setupGroupNORow=$setupGroupNO->fetch(PDO::FETCH_ASSOC);
           

            $sql_groupHost = 
                "Insert into Mem_Par 
                (Mem_NO, Group_NO, Mem_Par_Status)
                VALUES (:groupHost1, :groupHost2, :groupHost3);";
            $setupGroupHost = $pdo->prepare($sql_groupHost);
            $setupGroupHost->bindValue(":groupHost1", $mem_NO);
            $setupGroupHost->bindValue(":groupHost2", $setupGroupNORow["Group_NO"]);
            $setupGroupHost->bindValue(":groupHost3", 1);
            $setupGroupHost->execute();

            echo "<script>alert('開團成功！');location.href='groupView.html'</script>";
    
        }else{
            echo "<script>alert('請先登入再開團！');location.href='groupView.html'</script>";
        }       
     }

} catch (PDOException $e) {
	// echo "系統暫時無法提供服務, 請通知系統維護人員<br>";
	echo "錯誤行號 : ", $e->getLine(), "<br>";
	echo "錯誤原因 : ", $e->getMessage(), "<br>";
}


?>