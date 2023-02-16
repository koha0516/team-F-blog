<?php
require_once "get_connect.php";

//投稿内容をINSERTするメソッド
function article_register($title, $contents, $tag, $userid, $published) {
  try {
    $sql = "INSERT INTO articles (title, article_content, tag_id, user_id, published) VALUES (:title, :contents, :tag, :user, :published)";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':title', $title, PDO::PARAM_STR);
    $stm->bindValue(':contents', $contents, PDO::PARAM_STR);
    $stm->bindValue(':tag', $tag, PDO::PARAM_INT);
    $stm->bindValue(':user', $userid, PDO::PARAM_INT);
    $stm->bindValue(':published', $published, PDO::PARAM_STR);

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

class user_function
{
  static function length_validation($str, $max, $min)
  {
    //    文字数カウント
    $str = mb_strlen($str, "UTF-8");
    return $str <= $max && $str >= $min;
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
//投稿内容をUPDATEするメソッド
function article_update($title, $contents, $tag, $userid, $published, $articleid) {
  try {
    $sql = "UPDATE articles SET title=:title, article_content=:contents, tag_id=:tag, user_id=:user, published=:published WHERE article_id=:articleid";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':title', $title, PDO::PARAM_STR);
    $stm->bindValue(':contents', $contents, PDO::PARAM_STR);
    $stm->bindValue(':tag', $tag, PDO::PARAM_INT);
    $stm->bindValue(':user', $userid, PDO::PARAM_INT);
    $stm->bindValue(':published', $published, PDO::PARAM_STR);
    $stm->bindValue(':articleid', $articleid, PDO::PARAM_INT);

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
//articleidをもとに一覧取得
function get_article($articleid) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM articles WHERE article_id=:articleid";
    $stm = get_connect()->prepare($sql);

    $stm->bindValue(':articleid', $articleid, PDO::PARAM_INT);
    $stm->execute();
    // 検索結果を配列として全件取得する
    return $article=$stm->fetch(PDO::FETCH_ASSOC);
  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}