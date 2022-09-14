if (/Android|webOS|iPhone|iPad|iPod|BlackBerry|BB|PlayBook|IEMobile|Windows Phone|Kindle|Silk|Opera Mini/i.test(navigator.userAgent)) {
    // document.getElementById("img-photo2").style.display = "block";
}


function delete_photo(){
    document.getElementById("img-photo").value = '';
    document.getElementById("btn-delete").style.display="none";
    // document.getElementById("btn-envio").disabled = false;
}


function update_file(){
    // e.preventDefault();
    var formData = new FormData();
    let name_foto, name_foto2, email;
    name_foto = document.getElementById("img-photo");
    email = document.getElementById("email").value;
    // name_foto = $('input[type=file]')[0].files[0]; 
    // formData.append('image', name_foto);
    var formData = new FormData();
    formData.append('image', $('input[type=file]')[0].files[0]); 
    if(name_foto == ""){
        Swal.fire('Error','Debe seleccionar una fotografia para continuar','error');
    }else if(email == ""){
        Swal.fire('Error','Debe ingresar el email para continuar','error');
        document.getElementById("img-photo").value = '';

    }else{
           $.ajax({
                url: "./funciones/upload-photo.php?email="+email, 
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
            beforeSend: function() {
                Swal.fire({
                    html:'<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
                    title: 'Cargando Imagen..',
                    showCloseButton: false,
                    showCancelButton: false,
                    focusConfirm: false,
                    showConfirmButton:false,
                })
                $(".swal2-modal").css('background-color', 'rgba(0, 0, 0, 0.0)'); 
                $(".swal2-title").css("color","white"); 
            },
            success: function(response) {
                if(response == "Success"){
                    document.getElementById("btn-delete").style.display="inline-block";
                    // document.getElementById("btn-envio").disabled = true;
                }else{

                }
                Swal.close();
            },
        });
    }
}

// $("#form-img").on('submit', (function(e) {
//     e.preventDefault();

//     let name_foto, name_foto2, email;
//     name_foto = document.getElementById("img-photo").value;
//     email = document.getElementById("email").value;

//     if(name_foto == ""){
//         Swal.fire('Error','Debe seleccionar una fotografia para continuar','error');
//     }else if(email == ""){
//         Swal.fire('Error','Debe ingresar el email para continuar','error');
//         document.getElementById("img-photo").value = '';
        
//     }else{
//            $.ajax({
//                 url: "./funciones/upload-photo.php?email="+email, 
//                 type: "POST",
//                 data: new FormData(this),
//                 contentType: false,
//                 cache: false,
//                 processData: false,
//             beforeSend: function() {
//                 Swal.fire({
//                     html:'<div class="lds-roller"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>',
//                     title: 'Cargando Imagen..',
//                     showCloseButton: false,
//                     showCancelButton: false,
//                     focusConfirm: false,
//                     showConfirmButton:false,
//                 })
//                 $(".swal2-modal").css('background-color', 'rgba(0, 0, 0, 0.0)'); 
//                 $(".swal2-title").css("color","white"); 
//             },
//             success: function(response) {
//                 if(response == "Success"){
//                     document.getElementById("btn-delete").style.display="inline-block";
//                     // document.getElementById("btn-envio").disabled = true;
//                 }else{

//                 }
//                 Swal.close();
//             },
//         });
//     }

 
//  }));