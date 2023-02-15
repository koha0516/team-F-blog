<?php
  require_once "get_connect.php";

  //ユーザ情報をINSERTするメソッド
  function user_register($name, $birth, $mail, $salt, $password) {
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

  function get_salt($name) {
    try {
      // sql文の構築
      $sql = "SELECT salt FROM users WHERE user_name = :name";
      $stm = get_connect()->prepare($sql);
      // プレースホルダに値をバインドする
      $stm->bindValue(":name", $name, PDO::PARAM_STR);
      // sql文の実行
      $stm->execute();

      $res = $stm->fetch(PDO::FETCH_ASSOC);
      return $res["salt"];

    } catch (PDOException $e) {
      // エラー発生
      echo $e->getMessage();
    } finally {
      // DB接続を閉じる
      $pdo = null;
    }
  }

  // nameとpasswordを元にユーザ情報を取ってくる関数
  function login($name, $password) {
    try {
      // sql文の構築
      $sql = "SELECT user_id, user_name, user_birth, user_mail FROM users WHERE user_name = :name AND password = :password AND delete_frag > 0";
      $stm = get_connect()->prepare($sql);
      // プレースホルダに値をバインドする
      $stm->bindValue(":name", $name, PDO::PARAM_STR);
      $stm->bindValue(":password", $password, PDO::PARAM_STR);
      // sql文の実行
      $stm->execute();

      return $stm->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
      // エラー発生
      echo $e->getMessage();
    } finally {
      // DB接続を閉じる
      $pdo = null;
    }
  }