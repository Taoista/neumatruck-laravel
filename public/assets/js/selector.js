const selector =  document.querySelectorAll(".section-selector")


selector.forEach(item => {
    item.addEventListener("click", () =>{
        // const id_selectpr = btoa(item.dataset.type)
        const id_selectpr = item.dataset.type
        
        window.location.href = `${_Url}categoria/${id_selectpr}`

    })
});
