<?php
  require_once "get_connect.php";

  //ユーザ情報をINSERTする関数
  function register_user($name, $birth, $mail, $salt, $password) {
    try {
      $sql = "INSERT INTO users (user_name, user_birth, user_mail, salt, password) VALUES (:name, :birth, :mail, :salt, :password)";
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

function edit_user($user_id, $name, $mail) {
  try {
    // sql文の構築
    $sql = "UPDATE users SET user_name = :user_name, user_mail = :user_mail WHERE user_id = :user_id";
    $stm = get_connect()->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    $stm->bindValue(":user_name", $name, PDO::PARAM_STR);
    $stm->bindValue(":user_mail", $mail, PDO::PARAM_STR);
    // sql文の実行
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

//  ソルトを生成する関数
  function get_salt($name) {
    try {
      // sql文の構築
      $sql = "SELECT salt FROM users WHERE user_name = :name AND delete_frag < 1";
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
      $sql = "SELECT user_id, user_name, user_birth, user_mail FROM users WHERE user_name = :name AND password = :password  AND delete_frag < 1";
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


function get_user_name($user_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM users WHERE user_id = :user_id";
    $stm = get_connect()->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(":user_id", $user_id, PDO::PARAM_INT);
    // sql文の実行
    $stm->execute();

    $res = $stm->fetch(PDO::FETCH_ASSOC);
    return $res['user_name'];

  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}

//  フォローする関数
function create_follow($follow_user_id, $followed_user_id) {
  try {
    $sql = "INSERT INTO follow (follow_user_id, followed_user_id) VALUES (:follow_user_id, :followed_user_id)";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':follow_user_id', $follow_user_id, PDO::PARAM_INT);
    $stm->bindValue(':followed_user_id', $followed_user_id, PDO::PARAM_INT);

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

//DELETE文ではなくUPDATE文で後で実装
//フォローを解除する関数
function delete_follow($follow_user_id, $followed_user_id) {
  try {
    $sql = "DELETE FROM follow WHERE follow_user_id = :follow_user_id AND followed_user_id = :followed_user_id";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':follow_user_id', $follow_user_id, PDO::PARAM_INT);
    $stm->bindValue(':followed_user_id', $followed_user_id, PDO::PARAM_INT);

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


//  フォロー情報を確認する関数
function check_follow($follow_user_id, $followed_user_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM follow WHERE follow_user_id = :follow_user_id AND followed_user_id = :followed_user_id";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':follow_user_id', $follow_user_id, PDO::PARAM_INT);
    $stm->bindValue(':followed_user_id', $followed_user_id, PDO::PARAM_INT);

    //  SQLを実行
    $stm->execute();
    // 検索結果を配列として全件取得する
    return $stm->fetch(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}

// フォローリスト取得
function get_follows($follow_user_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM follow WHERE follow_user_id = :follow_user_id";
    $stm = get_connect()->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(':follow_user_id', $follow_user_id, PDO::PARAM_INT);
    // sql文の実行
    $stm->execute();

    return $stm->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}

function get_followers($followed_user_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM follow WHERE followed_user_id = :followed_user_id";
    $stm = get_connect()->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(':followed_user_id', $followed_user_id, PDO::PARAM_INT);
    // sql文の実行
    $stm->execute();

    return $stm->fetchAll(PDO::FETCH_ASSOC);

  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}