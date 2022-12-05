const inputImg = document.querySelector('#side1 .input-img input');
const inputImg2 = document.querySelector('#pic2');
const imageDisplay = document.querySelector('#side1 .user-logo');

inputImg.addEventListener('change',(e)=>{
    if (e.target.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
           imageDisplay.src = e.target.result;
        }
        reader.readAsDataURL(e.target.files[0]);

        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(e.target.files[0]);
        inputImg2.files = dataTransfer.files;
    }
});

//oninput="pic.src=window.URL.createObjectURL(this.files[0]);"