function makeCode (elText) {      
    //var elText = document.getElementById("text");    
    if (!elText.value) {
        alert("Input a text");
        elText.focus();
        return;
    }
    
    qrcode.makeCode(elText.value);
}