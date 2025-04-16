const keyworks = document.querySelector("#tipo-busqueda")
const btn_search = document.querySelector("#btn-search")

btn_search.addEventListener("click", (e) => {
    e.preventDefault();

    if(keyworks.value == "" || keyworks.value == false || keyworks.value == null ){
        Swal.fire('Error','Debe agregar una medida valida para buscar','error')
    }else{
        window.location.href = `${_Url}busqueda/${btoa(keyworks.value)}`
    }
})
