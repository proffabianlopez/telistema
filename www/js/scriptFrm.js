/* 
 Pertenece al formulario

 Developed |by LAG13_OFC

 Date: 08/2022

*/
/****** ESTE SCRIPT ES PARA MOSTRAR UN MENSAJE DE ENVIO *******/

const form = document.querySelector('#form');

form.addEventListener('submit', function(e){
    e.preventDefault();
    email();
})

function email(){
    const datos = new FormData(form);

    fetch('/php/form.php', {
        method: 'POST',
        body: datos
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'success'){
            Swal.fire({
                title: 'ENVIADO CON ÉXITO',
                icon: 'success',
                background: '#F5F5F5',
                backdrop: `
                  rgba(0,0,333,0.3)
                  left top
                  no-repeat
                ` 
              });
        } else if(res.status === 'error'){
            Swal.fire({
                icon: 'error',
                title: 'Oops',
                text: res.message,
                footer: 'Intenta nuevamente'
            });
        }

    })
}
