<?php
	// DB接続設定
    //DB名
    $dsn = 'DB名';
    //ユーザー名
    $user = 'ユーザ名';
    //パスワード
    $password = 'パスワード';
    //MySQLへの接続
    //ATTR_ERRMODE => PDO::ERRMODE_WARNINGはエラー文を出す
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
  $sql = "CREATE TABLE IF NOT EXISTS Mission5"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "pass TEXT,"
    . "date TEXT"
    .");";
    $stmt = $pdo->query($sql);
	// 編集用データ格納変数
	$editNumber = '';
	$editName = '';
	$editComment = '';
	
	//削除モード
	if(!empty($_POST["delete"]) && !empty($_POST["delpass"])){
	    $id = $_POST["delete"]; //変更する投稿番号
         $delpass = $pdo->prepare("SELECT * FROM Mission5 WHERE id = '$id'");
         $delpass->execute();
         $delpass = $delpass->fetchAll(PDO::FETCH_ASSOC);
         $delPass =  $delpass[0]['pass'];
         if($delPass == $_POST["delpass"]){
	$id = $_POST["delete"];
    //deleteでtbtestのid指定しているところを削除
    $sql = 'delete from Mission5 where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //変数が変わるところに代入して変数を開けてくれる
    $stmt->execute();
     $sql = 'SELECT * FROM Mission5';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
	}
	}
	//書き込み
	if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["pass"]) && isset($_POST["normal"])){
	 $sql = $pdo -> prepare("INSERT INTO Mission5 (name, comment, pass, date) VALUES (:name, :comment, :pass, :date)");
    //指定された変数名に変数を代入する
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $name = $_POST["name"];
    $comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
    $pass = $_POST["pass"];
    $date = date("Y年m月d日H時i分s秒");
    $sql -> execute();
    }
    //編集番号のフォームに入力
    if(isset($_POST["edit"])) {
         $id = $_POST["number"]; //変更する投稿番号
         $edit_select = $pdo->prepare("SELECT * FROM Mission5 WHERE id = '$id'");
         $edit_select->execute();
         $edit_select = $edit_select->fetchAll(PDO::FETCH_ASSOC);
         $editpass = $edit_select[0]['pass'];
         if($editpass == $_POST["henpass"]){
         $editNumber =  $edit_select[0]['id'];
         $editName =  $edit_select[0]['name'];
         $editComment =  $edit_select[0]['comment'];
    }
    }
    //編集
    if(!empty($_POST["edit_post"]) && isset($_POST["hennshu"])){
    $id = $_POST["edit_post"];
    $name = $_POST["name"];
    $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
    $pass = $_POST["pass"];
    $editpass = $pdo->prepare("SELECT * FROM Mission5 WHERE pass = '$pass'");//$editpass = $pdo->prepare("SELECT * FROM Mission5 WHERE pass = '$pass'");
    $editpass->execute();//$editpass->execute();
    $editpass = $editpass->fetchAll(PDO::FETCH_ASSOC);//$editpass = $editpass->fetchAll(PDO::FETCH_ASSOC);
    $pass1 =  $editpass[0]['pass'];//$pass1 =  $editpass[0]['pass'];
    if($pass1 == $pass){ 
    $sql = 'UPDATE Mission5 SET name=:name,comment=:comment,pass=:pass WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    }
    }
?>
<!doctype html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>3-5</title>
</head>
<body>
<form action="" method="POST">
    【投稿フォーム】
<br>
<input type="hidden" name="edit_post" value="<?php if(!empty($editNumber)){ echo $editNumber; }?>">
名前:<input type="text" name="name" value="<?php if(!empty($editName)){ echo $editName;}?>">
<br />
コメント:<input name="comment"value="<?php if(!empty($editComment)){ echo $editComment;} ?>">
パスワード:<input type="text" name="pass">
<input type="submit" name="normal" value="送信">
<input type="submit" name="hennshu" value="編集">
<br>
【削除フォーム】
<br>
n行目:<input type="number" name="delete">
パスワード:<input type="text" name="delpass">
<input type="submit" name="submit">
<br>
【編集フォーム】
<br>
編集したい番号を入力<input type="text" name="number" value="">
パスワード:<input type="text" name="henpass">
<input type="submit" name="edit" value="送信">
</form>
</body>
<?php
echo "----------"."<br>";
            //$nameと$comentに何も入っていないときに動作する
            //投稿機能
            if(empty($name)){
            echo "Error:name is empty";
                }elseif(empty($comment)){
            echo "Error:comment is empty";
                }
                echo "<br>"."----------"."<br>";
                // DB接続設定
                //DB名
                $dsn = 'DB名';
                //ユーザー名
                $user = 'ユーザ名';
                //パスワード
                $password = 'パスワード';
                //MySQLへの接続
                //ATTR_ERRMODE => PDO::ERRMODE_WARNINGはエラー文を出す
                $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
               $sql = 'SELECT * FROM Mission5';
                $stmt = $pdo->query($sql);
                $results = $stmt->fetchAll();
                foreach ($results as $row){
                    //$rowの中にはテーブルのカラム名が入る
                    echo $row['id'].',';
                    echo $row['name'].',';
                    echo $row['comment'].',';
                     echo $row['date'].'<br>';
                echo "<hr>";
                }
                ?>
</html>