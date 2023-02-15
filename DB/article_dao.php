<?php
require_once "get_connect.php";

//ユーザ情報をINSERTするメソッド
function article_register($name, $birth, $mail, $salt, $password) {
  try {
    $sql = "INSERT INTO users (user_name, user_birth, user_mail, salt, password, delete_frag) VALUES (:name, :birth, :mail, :salt, :password, 1)";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':name', $name, PDO::PARAM_STR);
    $stm->bindValue(':birth', $birth, PDO::PARAM_STR);
    $stm->bindValue(':mail', $mail, PDO::PARAM_STR);
    $stm->bindValue(':salt', $salt, PDO::PARAM_STR);
    $stm->bindValue(':password', $password, PDO::PARAM_STR);

    // SQL文を実行する
    $stm->execute();

    return true;
  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}
function get_articles() {
  try {
    // sql文の構築
    $sql = "SELECT * FROM articles WHERE delete_frag < 1";
    $stm = get_connect()->prepare($sql);
    $stm->execute();
    // 検索結果を配列として全件取得する
    return $stm->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}
