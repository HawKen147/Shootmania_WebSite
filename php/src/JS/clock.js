const clock = document.getElementById('clock');
const addzero = x => x < 10 ? '0' +x : x;

function showTime(){
    const date = new Date();
    const hour =  addzero(date.getHours());
    const minute = addzero(date.getMinutes());
    const second = addzero(date.getSeconds());
    clock.innerText = `${hour}:${minute}:${second}`;
}

setInterval(showTime, 1000);