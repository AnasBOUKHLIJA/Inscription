let countDownDate = new Date(document.querySelector('#date_fin').innerHTML).getTime();
// console.log(countDownDate);
// console.log(new Date(document.querySelector('#date_fin').innerHTML));
setInterval(() => {
    const now = new Date().getTime();
    const distance = countDownDate - now;
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("countdown").innerHTML = days + "Jours " + hours + "heures "
  + minutes + "minutes " + seconds + "secondes ";
}, 1000);
