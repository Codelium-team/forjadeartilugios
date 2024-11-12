function cargarDestacados(){
    let destacados = document.getElementById("destacados")
    fetch('http://localhost:8000/controllers/productos.php')
    .then(respuesta => respuesta.json())
    .then(datos => {
        datos.forEach(element => {
            if(element.destacado == 1){
            let imagenPrincipal = element.imagenes.find(imagen => imagen.principal == 1) ?element.imagenes.find(imagen => imagen.principal == 1) : element.imagenes[0]
            destacados.innerHTML += `
            <div class="producto-destacado">
            <img src=${imagenPrincipal.archivo} alt="">
            <h3>${element.nombre_producto}</h3>
            </div>
            `
        }});
    })
}

cargarDestacados()