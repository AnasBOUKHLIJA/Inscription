document.querySelector("#loader").style.display = "block";
document.querySelector("#loader .lds-roller").style.display = "block";
window.onload = () => {
  document.querySelector("#loader").style.display = "none";
  document.querySelector("#loader .lds-roller").style.display = "none";
}