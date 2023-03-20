<?php
require_once "get_connect.php";

//投稿内容をINSERTするメソッド
function register_article($title, $contents, $tag, $userid, $published) {
  try {
    $sql = "INSERT INTO articles (title, article_content, tag_id, user_id, published) VALUES (:title, :contents, :tag, :user, :published)";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':title', $title, PDO::PARAM_STR);
    $stm->bindValue(':contents', $contents, PDO::PARAM_STR);
    $stm->bindValue(':tag', $tag, PDO::PARAM_INT);
    $stm->bindValue(':user', $userid, PDO::PARAM_INT);
    $stm->bindValue(':published', $published, PDO::PARAM_INT);

    // SQL文を実行する
    $stm->execute();

    return true;
  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
    return false;
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}


function get_articles() {
  try {
    // sql文の構築
    $sql = "SELECT * FROM articles WHERE delete_frag < 1 AND published > 0";
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

//userごとに記事を取り出す
function get_user_articles($user_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM articles WHERE user_id=:user_id AND delete_frag < 1 AND published > 0";
    $stm = get_connect()->prepare($sql);

    $stm->bindValue(':user_id', $user_id, PDO::PARAM_INT);

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

//キーワード検索して記事を取り出す
function get_keyword_articles($keyword) {
  try {
    // sql文の構築
    $keyword = "%".$keyword."%";
    $sql = "SELECT * FROM articles WHERE title LIKE :keyword AND delete_frag < 1 AND published > 0";
    $stm = get_connect()->prepare($sql);

    $stm->bindValue(':keyword', $keyword, PDO::PARAM_STR);

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

function get_own_articles($user_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM articles WHERE user_id=:user_id AND delete_frag < 1";
    $stm = get_connect()->prepare($sql);

    $stm->bindValue(':user_id', $user_id, PDO::PARAM_INT);

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
function update_article($title, $contents, $tag, $userid, $published, $articleid) {
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

function get_tags() {
  try {
    // sql文の構築
    $sql = "SELECT * FROM tags";
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

//タグIDからタグの名前を取ってくるメソッド
function get_tag_name($tag_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM tags WHERE tag_id = :tag_id";
    $stm = get_connect()->prepare($sql);
    $stm->bindValue(':tag_id', $tag_id, PDO::PARAM_INT);
    $stm->execute();
    // 検索結果を配列として全件取得する
    $res = $stm->fetch(PDO::FETCH_ASSOC);
    return $res['tag_name'];
  } catch (PDOException $e) {
    // エラー発生
    echo $e->getMessage();
  } finally {
    // DB接続を閉じる
    $pdo = null;
  }
}

//article_idをもとに記事を一件取得
function get_article($article_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM articles WHERE article_id=:articleid";
    $stm = get_connect()->prepare($sql);

    $stm->bindValue(':articleid', $article_id, PDO::PARAM_INT);
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

//タグごとにDBから記事を持ってくる
function get_tag_articles($tag_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM articles WHERE tag_id = :tag_id AND delete_frag < 1 AND published > 0";
    $stm = get_connect()->prepare($sql);
    // プレースホルダに値をバインドする
    $stm->bindValue(':tag_id', $tag_id, PDO::PARAM_INT);
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


//  いいねする関数
function create_like($article_id, $like_user_id) {
  try {
    $sql = "INSERT INTO likes (article_id, like_user_id) VALUES (:article_id, :like_user_id)";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':article_id', $article_id, PDO::PARAM_INT);
    $stm->bindValue(':like_user_id', $like_user_id, PDO::PARAM_INT);

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

//article_idとlike_user_idからいいね情報を確認
function check_like($article_id, $like_user_id) {
  try {
    // sql文の構築
    $sql = "SELECT * FROM likes WHERE article_id=:article_id AND like_user_id=:like_user_id";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':article_id', $article_id, PDO::PARAM_INT);
    $stm->bindValue(':like_user_id', $like_user_id, PDO::PARAM_INT);

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

// いいね情報を削除する関数
function delete_like($article_id, $like_user_id) {
  try {
    // sql文の構築
    $sql = "DELETE FROM likes WHERE article_id=:article_id AND like_user_id=:like_user_id";
    $stm = get_connect()->prepare($sql);

    // プレースホルダに値をバインドする
    $stm->bindValue(':article_id', $article_id, PDO::PARAM_INT);
    $stm->bindValue(':like_user_id', $like_user_id, PDO::PARAM_INT);

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



