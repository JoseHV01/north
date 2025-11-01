function showHiden(idInput) {
    const input = document.getElementById(`${idInput}`);

    if(input.type == "text"){
        input.type = "password";
    }else{
        input.type = "text";
    }
}