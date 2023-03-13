// 未記入の時、送信ボタンを押せなくする //
window.addEventListener('DOMContentLoaded',function(){
	document.getElementById('submit').disabled = true;
	document.getElementById('article').addEventListener('keyup',function(){
	if (this.value.length < 1) {
	document.getElementById('submit').disabled = true;
	} else {
	document.getElementById('submit').disabled = false;
	}
	},false);
	document.getElementById('article').addEventListener('change',function(){
	if (this.value.length < 1) {
	document.getElementById('submit').disabled = true;
	}
	},false);
	},false);
    function toggleNav() {
  var body = document.body;
  var hamburger = document.getElementById('js-hamburger');
  var blackBg = document.getElementById('js-black-bg');

  hamburger.addEventListener('click', function() {
    body.classList.toggle('nav-open');
  });
  blackBg.addEventListener('click', function() {
    body.classList.remove('nav-open');
  });
}

// 入力した文字カウント //
const textArea = document.querySelector('#textarea'); // テキストエリアの要素
const length = document.querySelector('.length'); // 残り文字数を表示させる要素
const maxLength = 10000 // 最大文字数
textArea.addEventListener('input', () => {
  length.textContent = maxLength - textArea.value.length;
  if(maxLength - textArea.value.length < 0){
    length.style.color = 'red'; // 最大文字数を超過したら赤字で表示する
  }else{
    length.style.color = '#444';
  }
}, false);