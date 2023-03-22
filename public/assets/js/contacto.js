const order_submit = document.querySelector(".order-submit")

const name = document.querySelector("#name")
const email = document.querySelector("#email")
const phone = document.querySelector("#phone")
const asunto = document.querySelector("#asunto")
const msg = document.querySelector("#text-contac")

const email_regex = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i

order_submit.addEventListener("click", (e) =>{
    e.preventDefault()
   

    if(name.value == "" || email.value == "" || phone.value == "" || asunto.value == "" || msg.value == ""){
        alert("debe llenar los datos")
    }else if(!email_regex.test(email.value)){
        alert("email no valido")
    }else{
        const parameters = {
            "name" : name.value,
            "email" : email.value,
            "phone" : phone.value,
            "asunto" : asunto.value,
            "msg" : msg.value
        }
        new Promise((resolve, reject) =>{
            $.ajax({
                data: parameters,
                url:  _Url+"api/send_contact",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend:function(){
                    Swal.fire({
                        html:'<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
                        title: 'Agregando..',
                        showCloseButton: false,
                        showCancelButton: false,
                        focusConfirm: false,
                        showConfirmButton:false,
                    })
                    $(".swal2-modal").css('background-color', 'rgba(0, 0, 0, 0.0)'); 
                    $(".swal2-title").css("color","white"); 
    
                },
                success:function(response){
                    resolve(response);
                }
            })
        }).then(res =>{
            swal.close()
            alert(res)
        })
    }

})