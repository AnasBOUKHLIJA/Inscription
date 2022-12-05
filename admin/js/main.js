const tableItem = document.querySelectorAll('.table-item');
const tableNomItem = document.querySelectorAll('.table-item .nom');
const tablePrenomItem = document.querySelectorAll('.table-item .prenom');
const input = document.querySelector('#recherche');
// console.log(input);
input.addEventListener('change',() => {
    for (let index = 0; index < tableItem.length; index++) {
        if(input.value.length > 0){
            let nomByLengthInput = tableNomItem[index].textContent.substring(input.value.length,0);
            let prenomByLengthInput = tablePrenomItem[index].textContent.substring(input.value.length,0);
            if( nomByLengthInput.toLowerCase() != input.value.toLowerCase() && prenomByLengthInput.toLowerCase() != input.value.toLowerCase()){
                tableItem[index].style.display = "none";
            }       
        }else{
            tableItem[index].style.display = "";
        }
    }
});
