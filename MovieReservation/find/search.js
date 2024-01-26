loginid = document.getElementById('loginid');
loginpw = document.getElementById('loginpw');
loginbutton = document.getElementById('loginbutton');
logoutbutton = document.getElementById('logoutbutton');
submitbutton = document.getElementById('submitbutton');
signinbutton = document.getElementById('signinbutton');
session_id = document.getElementById('session_id');
find_theater_submit = document.getElementById('find_theater_submit');
find_theater_submit = document.getElementById('find_theater_submit');
movie_final_check = document.getElementsByName('movie_final_check');
reservation_submit = document.getElementById('reservation_submit');
reservation_close =  document.getElementById('reservation_close');

const pop = () =>{
  document.getElementById("pop-wrap").style.display ='inline';
}

const signinValidate = () =>{ //회원가입 버튼을 눌렀을 때 validation 만족시 홈화면으로 넘어감
  let RegId = /^([A-Za-z0-9]){6,15}$/;
  let RegPw = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;

  if (!RegId.test(loginid.value)||!RegPw.test(loginpw.value)) {
    alert('아이디 또는 패스워드의 입력양식을 체크해주세요');
    return false;
  }
  else{
    alert("회원가입이 완료되었습니다!");
    return true;
  }
}

const submitValidate = () =>{ //회원가입 버튼을 눌렀을 때 validation 만족시 홈화면으로 넘어감
  let RegId = /^([A-Za-z0-9]){6,15}$/;
  let RegPw = /^.*(?=^.{8,15}$)(?=.*\d)(?=.*[a-zA-Z])(?=.*[!@#$%^&+=]).*$/;

  if (!RegId.test(loginid.value)||!RegPw.test(loginpw.value)) {
    alert('아이디 또는 패스워드의 입력양식을 체크해주세요');
    document.getElementById('pop-wrap').style.display = "none";
    document.getElementById('loginid').value = "";
    document.getElementById('loginpw').value = "";
    return false;
  }
  submitbutton.type="submit";
}

const findTheater = () =>{
  let form = $("#movie_find_form").serialize();
  $.ajax({
    url: 'find_theater.php',
    type: 'POST',
    data: form,
    success:function(data) {
      document.getElementById("date_pop_content_inner").innerHTML = data;
    },
    error:function(e) {
      alert(e.reponseText);
    }
  });
  document.getElementById("movie_date_wrap").style.display = "inline";
}

const reservationValidate = () =>{
  if(session_id==null){
    alert('로그인 후 영화 예약이 가능합니다.');
  }
}

reservation_close.addEventListener("click" ,function(){
  document.getElementById("movie_date_wrap").style.display = "none";
});

if(signinbutton){
signinbutton.addEventListener("click", signinValidate);
}
if(submitbutton){
submitbutton.addEventListener("click", submitValidate);
}
if(reservation_submit!=null){
reservation_submit.addEventListener("click", reservationValidate);
}
if(loginbutton){
loginbutton.addEventListener("click", pop);
}
if(find_theater_submit!=null){
  find_theater_submit.addEventListener("click", findTheater);
}
if(document.getElementById('reserve_go')){
  document.getElementById('reserve_go').addEventListener("click" ,function(){
    if(session_id==null){
      alert('로그인 후 예약정보 보기가 가능합니다.');
    }
    else{
      document.getElementById('reserve_go').target = "_blank";
      document.getElementById('reserve_go').href = "reserve_info.php";
    }

  });
}
