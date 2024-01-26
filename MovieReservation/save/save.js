performer_wrap = document.getElementById('performer_wrap');
addperformer_button = document.getElementById('addperformer_button');
subperformer_button = document.getElementById('subperformer_button');
addtheater_button =  document.getElementById('addtheater_button');
addtheater_wrap =  document.getElementById('addtheater_wrap');
findtheater_button = document.getElementById('findtheater_button');
radio_one = document.getElementById('radio_one');
radio_two = document.getElementById('radio_two');
radio_three = document.getElementById('radio_three');
movie_date = document.getElementById('movie_date');
performer = document.getElementsByClassName('performer');
movie_date_array = [];

//출연자 추가
const addPerformer = () =>{
  if(performer.length<3){
    input = document.createElement('input');
    input.setAttribute("name", "performer[]");
    input.setAttribute("class", "performer");
    performer_wrap.appendChild(input);
  }
}

//출연자 삭제
const subPerformer =() =>{
  if(performer.length>1){
    performer_wrap.lastChild.remove();
  }
}

const findTheater =()=>{
  addtheater_button.disabled=false;
  radio_one.disabled=false;
  radio_two.disabled=false;
  radio_three.disabled=false;
}

const addTheater =() =>{
  input = document.createElement('input');
  input.setAttribute("type", "text");
  for(x of movie_date_array){
    if(x===movie_date.value){
      alert('같은 날짜에 이미 추가되었습니다.');
      return;
    }
  }
  movie_date_array.push(movie_date.value);
  if(radio_one.checked){
    input.value=movie_date.value+",상영관1";
  }
  if(radio_two.checked){
    input.value=movie_date.value+",상영관2";
  }
  if(radio_three.checked){
    input.value=movie_date.value+",상영관3";
  }
  input.setAttribute("name", "theater_date[]");
  br = document.createElement("br");
  addtheater_wrap.appendChild(input);
  addtheater_wrap.appendChild(br);

  addtheater_button.disabled=true;
}

addperformer_button.addEventListener("click", addPerformer);
subperformer_button.addEventListener("click", subPerformer);
addtheater_button.addEventListener("click", addTheater);
findtheater_button.addEventListener("click", findTheater);
