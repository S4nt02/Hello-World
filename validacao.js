const form   = document.getElementById('form');
const campos = document.querySelectorAll('.require');
const spans  = document.querySelectorAll('.span-required');

function setError(index){
    campos[index].style.border = '3px solid red';
    spans[index].style.display = 'block';
}

function removeError(index){
    campos[index].style.border = '';
    spans[index].style.display = 'none';
}

function validarnome(){
    if(campos[0].value.length < 15)
    {
        setError(0);
    }
    else
    {
        removeError(0)
    }
}

function validarmaterno(){
    if(campos[1].value.length < 15)
    {
        setError(1);
    }
    else
    {
        removeError(1)
    }
}

function validarcpf(){
    if(campos[2].value.length < 11)
    {
        setError(2);
    }
    else
    {
        removeError(2)
    }
}

function validaremail(){
    if(campos[3].value.length < 5)
    {
        setError(3)
    }
    else
    {
        removeError(3)
    }
}

function validarcel(){
    if(campos[4].value.length < 11)
    {
        setError(4);
    }
    else
    {
        removeError(4)
    }
}

function validartelfixo(){
    if(campos[5].value.length < 10)
    {
        setError(5);
    }
    else
    {
        removeError(5)
    }
}


function validarUser(){
    if(campos[6].value.length < 8)
    {
        setError(6)
    }
    else
    {
        removeError(6)
    }
}

function validarsenha(){
    if(campos[7].value.length < 8)
    {
        setError(7);
    }
    else
    {
        removeError(7);
        confirmsenha();
    }
}

function confirmsenha(){
    if(campos[7].value == campos[8].value && campos[8].value.length >= 8)
    {
        removeError(8);
    }
    else
    {
        setError(8);
    }
}