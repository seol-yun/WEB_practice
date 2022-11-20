const addButton = document.getElementById("addButton");
const pop_schedule = document.getElementById("pop_schedule");
const pop_cancelform = document.getElementById("pop_cancelform");
const changebutton = document.getElementById("changebutton");
const changefinishbutton = document.getElementById("changefinishbutton");
const deletebutton = document.getElementById("deletebutton");
const submitbutton = document.getElementById("submitbutton");
const submitcancel = document.getElementById("submitcancel");
const startweek = document.getElementById("startweek");
const endweek = document.getElementById("endweek");
const starttime = document.getElementById("starttime");
const endtime = document.getElementById("endtime");
const pop_important = document.getElementById("pop_important");
const sun = document.getElementById("sun");
const mon = document.getElementById("mon");
const tue = document.getElementById("tue");
const wen = document.getElementById("wen");
const tur = document.getElementById("tur");
const fri = document.getElementById("fri");
const sat = document.getElementById("sat");
const sun_content = document.getElementById("sun_content");
const mon_content = document.getElementById("mon_content");
const tue_content = document.getElementById("tue_content");
const wen_content = document.getElementById("wen_content");
const tur_content = document.getElementById("tur_content");
const fri_content = document.getElementById("fri_content");
const sat_content = document.getElementById("sat_content");
const sort_important = document.getElementById("sort_important");
const sort_name = document.getElementById("sort_name");
const sort_time = document.getElementById("sort_time");

const array = ["일", "월", "화", "수", "목", "금", "토"];
const array2 = [sun_content, mon_content, tue_content, wen_content, tur_content, fri_content, sat_content];
const array3 = [arraysun = [], arraymon = [], arraytue = [], arraywen = [], arraytur = [], arrayfri = [], arraysat = []];
let listnum=0;
let changeId = -1;

const allDelete = () =>{
  for (var i = 0; i < array2.length; i++) {
    while(array2[i].firstChild){
      array2[i].removeChild(array2[i].firstChild);
    }
  }
}

function Pop(i, j){
  document.getElementById("pop-wrap").style.display ='inline';
  pop_important.value=array3[i][j].important;
  pop_schedule.value=array3[i][j].li;
  startweek.value=array3[i][j].startweek;
  endweek.value=array3[i][j].endweek;
  starttime.value=array3[i][j].starttime;
  endtime.value = array3[i][j].endtime;
  deletebutton.style.display="inline";
  changebutton.style.display="inline";
  submitbutton.style.display="none";
  changefinishbutton.style.display="none";
  pop_schedule.disabled = true;
  pop_important.disabled = true;
  startweek.disabled = true;
  endweek.disabled = true;
  starttime.disabled = true;
  endtime.disabled = true;
}


const newAddForm = () =>{
  for (let i = 0; i < array3.length; i++) {
    for (let j = 0; j < array3[i].length; j++) {
      var tr = document.createElement("tr");
      var ul = document.createElement("ul");
      var li = document.createElement("li");
      var text = document.createElement("text");
      var textin = document.createTextNode(array3[i][j].li);
      text.appendChild(textin);
      li.appendChild(text);
      var li2 = document.createElement("li");
      var text2 = document.createElement("text");
      var textin2 = document.createTextNode("시간: " + array3[i][j].starttime + "~" + array3[i][j].endtime);
      text2.appendChild(textin2);
      li2.appendChild(text2);
      ul.appendChild(li);
      ul.appendChild(li2);
      var td = document.createElement("td");
      if(array3[i][j].important==="상"){
        td.style.background = "red";
      }
      if(array3[i][j].important==="중"){
        td.style.background = "yellow";
      }
      if(array3[i][j].important==="하"){
        td.style.background = "green";
      }
      td.appendChild(ul);
      tr.appendChild(td);
      array2[i].appendChild(tr);

        td.addEventListener("click", ()=>{
          changeId = array3[i][j].id;
          event.cancelBubble = true;
          Pop(i, j)});
    }
  }

}

const addForm = () => {
  document.getElementById("pop-wrap").style.display ='inline';
  pop_important.value="상";
  pop_schedule.value="";
  startweek.value="일";
  endweek.value="일";
  starttime.value="";
  endtime.value="";
  changefinishbutton.style.display="none";
  deletebutton.style.display="none";
  changebutton.style.display="none";
  submitbutton.style.display="inline";
  pop_schedule.disabled = false;
  pop_important.disabled = false;
  startweek.disabled = false;
  endweek.disabled = false;
  starttime.disabled = false;
  endtime.disabled = false;
}

const changeForm = () =>{
    document.getElementById("pop-wrap").style.display ='inline';
    deletebutton.style.display="inline";
    changebutton.style.display="inline";
    submitbutton.style.display="none";
    changebutton.style.display="none";
    changefinishbutton.style.display="inline";
    pop_schedule.disabled = false;
    pop_important.disabled = false;
    startweek.disabled = false;
    endweek.disabled = false;
    starttime.disabled = false;
    endtime.disabled = false;
}

const changeFinishForm = (event) =>{
  //validation
  if(pop_schedule.value===""){
    alert("일정을 입력해 주세요.");
    cancelForm();
    return;
  }
  for(var i=0; i<array.length; i++){
    if(startweek.value===array[i]){
      for (var j = 0; j < i; j++) {
        if(endweek.value===array[j]){
          alert("요일 범위를 올바르게 입력해주세요.");
          cancelForm();
          return;
        }
      }
    }
  }
  if(starttime.value>endtime.value){
    alert("시간 범위를 올바르게 입력해 주세요.")
    cancelForm();
    return;
  }
  
  let s, e;
  for (let i = 0; i < array.length; i++) {
    if(array[i]===startweek.value){
      s=i;
      for (let j = i; j < array.length; j++) {
        if(array[j]===endweek.value){
          e=j;
          break;
        }
      }
    }
  }
  for (let k = 0; k < s; k++) {
    for (let l = 0; l < array3[k].length; l++) {
      if(array3[k][l].id==changeId){
        array3[k].splice(l, 1);
      }
    }
  }
  for (let k = e+1; k < 7; k++) {
    for (let l = 0; l < array3[k].length; l++) {
      if(array3[k][l].id==changeId){
        array3[k].splice(l, 1);
      }
    }
  }
  for(let k=s; k<=e; k++){
    let flag=0;
    for (let l = 0; l < array3[k].length; l++) {
      if(array3[k][l].id==changeId){
        let b = {
          id: changeId,
          li: pop_schedule.value,
          important: pop_important.value,
          startweek: startweek.value,
          endweek: endweek.value,
          starttime: starttime.value,
          endtime: endtime.value,
        };
        array3[k].splice(l, 1, b);
        flag=1;
        break;
      }
    }
    if(flag==0){
      let b = {
        id: changeId,
        li: pop_schedule.value,
        important: pop_important.value,
        startweek: startweek.value,
        endweek: endweek.value,
        starttime: starttime.value,
        endtime: endtime.value,
      };
      array3[k].push(b);
    }
  }
    allDelete();
    newAddForm();
    cancelForm();
}

const deleteForm = () => {
  for (let i = 0; i < array3.length; i++) {
    for (let j = 0; j < array3[i].length; j++) {
      if(array3[i][j].id==changeId){
        array3[i].splice(j, 1);
      }
    }
  }
  allDelete();
  newAddForm();
  cancelForm();
}

const cancelForm = () =>{
  document.getElementById("pop-wrap").style.display = "none";
}

const submit = () =>{
  //validation
  if(pop_schedule.value===""){
    alert("일정을 입력해 주세요.");
    cancelForm();
    return;
  }

  for(var i=0; i<array.length; i++){
    if(startweek.value===array[i]){
      for (var j = 0; j < i; j++) {
        if(endweek.value===array[j]){
          alert("요일 범위를 올바르게 입력해주세요.");
          cancelForm();
          return;
        }
      }
    }
  }

  if(starttime.value>endtime.value){
    alert("시간 범위를 올바르게 입력해 주세요.")
    cancelForm();
    return;
  }
  //
  for (var i = 0; i < array.length; i++) {
    if(array[i]===startweek.value){
      for (var j = i; j < array.length; j++) {
        if(array[j]===endweek.value){
          for(var k=i; k<=j; k++){
            let b = {
              id: listnum,
              li: pop_schedule.value,
              important: pop_important.value,
              startweek: startweek.value,
              endweek: endweek.value,
              starttime: starttime.value,
              endtime: endtime.value,
            };
            array3[k].push(b);
          }
          break;
        }
      }
    }
  }
  allDelete();
  newAddForm();

  listnum++;
  cancelForm();
  return;
}

addButton.addEventListener("click", addForm);
pop_cancelform.addEventListener("click", cancelForm);
submitcancel.addEventListener("click", cancelForm);
submitbutton.addEventListener("click", submit);
changebutton.addEventListener("click", changeForm);
changefinishbutton.addEventListener("click", changeFinishForm);
deletebutton.addEventListener("click", deleteForm);

document.querySelector('#sort').addEventListener("click", function() {
  if (this.value == "우선순위") {
    for (let i = 0; i < array3.length; i++) {
      array3[i].sort((x, y)=>{
        if(x.important==="상"){
          if(y.important==="중"){
            return -1;
          }
          if(y.important==="하"){
            return -1;
          }
        }
        if(x.important==="중"){
          if(y.important==="상"){
            return 1;
          }
          if(y.important==="하"){
            return -1;
          }
        }
        if(x.important==="하"){
          if(y.important==="중"){
            return 1;
          }
          if(y.important==="상"){
            return 1;
          }
        }
      })
    }
    allDelete();
    newAddForm();
    cancelForm();
  }else if(this.value == "이름순"){
    for (let i = 0; i < array3.length; i++) {
      array3[i].sort((x, y)=>{
        if(x.li<y.li){
          return -1;
        }
        else{
          return 1;
        }
      })
      allDelete();
      newAddForm();
      cancelForm();
    }

  }else if(this.value == "시간순"){
    for (let i = 0; i < array3.length; i++) {
      array3[i].sort((x, y)=>{
        if(x.starttime<y.starttime){
          return -1;
        }
        else{
          return 1;
        }

      })
      allDelete();
      newAddForm();
      cancelForm();
    }
  }
});
