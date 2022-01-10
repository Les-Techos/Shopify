function testNumerique(e){
    var caractere = carClavier(e);    

    if(carEffacement(e))
        return true;
    else{
        if(caractere < "0" || caractere > "9")
            return false;
        else
            return true;
    }
}

function testString(e){
    var caractere = carClavier(e);    

    if(carEffacement(e))
        return true;
    else{
        if((caractere >= "a" && caractere <= "z") || (caractere >= "A" && caractere <= "Z"))
            return true;
        else
            return false;
    }
}

function carClavier(e){
    return unCaractere = String.fromCharCode(e.which);
}

function carEffacement(e){
    return false;
}