<?php

  class user_function {
    // ハッシュ化する関数
    public function hash256($pw, $salt) {
      return hash('sha256', $pw . $salt);
    }

    //    空白置換をする関数
    public function space_replacement($str) {
      $target = array(' ', '　');
      //      全角半角スペースを削除する
      str_replace($target, '', $str);
      return $str;
    }

    //    文字数チェックをする関数
    public function length_validation($str, $max, $min) {
      //    文字数カウント
      $str = mb_strlen($str, "UTF-8");

      return $str <= $max && $str >= $min;
    }

    //    メールのバリデーションチェックをする関数
    public function mail_validation($mail) {
      //      空白を削除
      $mail = $this->space_replacement($mail);
      //      5文字以上、64文字以内であるか
      if ($this->length_validation($mail, 64, 5)) {
        //        行頭が英数字の1文字以上でかつ「＠」マークの後、英字「.」英字の形式であるか 例1※a@a.a 例2※01.Sample_Mail-DaNyo@Abc.deF
        if (preg_match("/^([a-zA-Z\d])+([a-zA-Z\d._-])*@([a-zA-Z])+((\.)+([a-zA-Z]+))+$/", $mail)) {
          return true;
        } else {
          return false;
        }
      }
    }

    //    パスワードのバリデーションチェックをする関数
    public function pw_validation($pw) {
      //      空白を削除
      $pw = $this->space_replacement($pw);
      //     8文字以上、50文字以内であるか
      if ($this->length_validation($pw, 50, 8)) {
        //        半角英小文字大文字数字をそれぞれ1種類以上含んでいるか
        if (preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*[\d])[a-zA-Z0-9.?\/-@]{8,50}$/", $pw)) {
          return true;
        } else {
          return false;
        }
      }
    }

    // パスワードの再入力が正しいか
    public function repeat_pw_check($pw, $re_pw): bool {
      return $pw === $re_pw;
    }

    //    名前のバリデーションチェックをする関数
    public function name_validation($name) {
      //     1文字以上、64文字以内であるか
      if ($this->length_validation($name, 64, 1)) {
        return true;
      } else {
        return false;
      }
    }

    //    電話番号のバリデーションチェックをする関数
    public function tel_validation($tel) {
      //      空白を削除
      $tel = $this->space_replacement($tel);
      //     7文字以上、14文字以内であるか
      if ($this->length_validation($tel, 14, 7)) {
        //        数字(2~4文字) - 数字(2~4文字以上) - 数字(3~4文字以上) の形式であるか 例1※00-0000-0000 例2※000-000-0000 例3※0000-00-0000
        if (preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/", $tel)) {
          return true;
        } else {
          return false;
        }
      }
    }
  }
