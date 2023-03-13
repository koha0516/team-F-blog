<?php

  class user_function {

    //    文字数チェックをする関数

    static function length_validation($str, $max, $min) {
      //    文字数カウント
      $str = mb_strlen($str, "UTF-8");

      return $str <= $max && $str >= $min;
    }

    //    メールのバリデーションチェックをする関数
    static function mail_validation($mail) {
      //      5文字以上、64文字以内であるか
      if (user_function::length_validation($mail, 64, 5)) {
        //        行頭が英数字の1文字以上でかつ「＠」マークの後、英字「.」英字の形式であるか 例1※a@a.a 例2※01.Sample_Mail-DaNyo@Abc.deF
        if (preg_match("/^([a-zA-Z\d])+([a-zA-Z\d._-])*@([a-zA-Z])+((\.)+([a-zA-Z]+))+$/", $mail)) {
          return true;
        } else {
          return false;
        }
      }
    }

    //    パスワードのバリデーションチェックをする関数
    static function pw_validation($pw) {

      //     8文字以上、32文字以内であるか
      if (user_function::length_validation($pw, 32, 8)) {
        //        半角英小文字大文字数字をそれぞれ1種類以上含んでいるか
        if (preg_match("/^(?=.*[a-z])(?=.*[\d])[a-z0-9.?\/-@]{8,32}$/", $pw)) {
          return true;
        } else {
          return false;
        }
      }
    }

    // パスワードの再入力が正しいか
    static function repeat_pw_check($pw, $re_pw): bool {
      return $pw === $re_pw;
    }

    static function age_validation($birth) {
      $now = date('Ymd');
      $birth = str_replace("-", "", $birth);
      $age = floor(($now - $birth) / 10000);
      if($age <= 12){
        return false;
      }else{
        return true;
      }
    }
  }
