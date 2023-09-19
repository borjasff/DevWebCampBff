(function(){
    //para la consulta de los ponentes hacemos un llamado a un arreglo de ponentes
    const ponentesInput = document.querySelector('#ponentes');

    if(ponentesInput){
        let ponentes = [];
        let ponentesFiltrados = [];

        const listadoPonentes = document.querySelector('#listado-ponentes');
        const ponenteHidden = document.querySelector('[name="ponente_id"]');

        obtenerPonentes();
        ponentesInput.addEventListener('input', buscarPonentes);

        if(ponenteHidden.value){
            (async() =>{
                const ponente = await obtenerPonente(ponenteHidden.value);

                //insertar en el HTML
                const ponenteDOM = document.createElement('LI');
                ponenteDOM.classList.add('listado-ponentes__ponente', 'listado-ponentes__ponente--seleccionado');
                ponenteDOM.textContent = `${ponente.nombre} ${ponente.apellido}`

                listadoPonentes.appendChild(ponenteDOM); //para añadirlo al html
            })()
        }

        async function obtenerPonentes(){
            const url = `/api/ponentes`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();

            formatearPonentes(resultado);
        }

        async function obtenerPonente(id){
            const url = `/api/ponente?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            return resultado;
        }

        function formatearPonentes(arrayPonentes = []) {
            ponentes = arrayPonentes.map( ponente => {
                return {
                    nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                    id: ponente.id
                }
            })
            console.log(ponentes);
        }

        function buscarPonentes(e){
            const busqueda = e.target.value;

            if(busqueda.length > 3){
                //expresion regular para buscar indiferente de mayusculas y minusculas
                const expresion = new RegExp(busqueda, "i");
                ponentesFiltrados = ponentes.filter( ponente => {
                    if(ponente.nombre.toLowerCase().search(expresion) != -1){
                        return ponente;
                    }
                    
                })
            } else {
                //vaciar ponentes si no tenemos tres letras
                ponentesFiltrados = '';
            }

            mostrarPonentes();
        }

       
        
        function mostrarPonentes(){
            //limpiar ponentes
            while(listadoPonentes.firstChild){
                listadoPonentes.removeChild(listadoPonentes.firstChild);
            }
            //si tenemos ponentes mostramos el ponente
            if(ponentesFiltrados.length > 0) {

                ponentesFiltrados.forEach( ponente => {

                    const ponenteHTML = document.createElement('li');
                    ponenteHTML.classList.add('listado-ponentes__ponente');
                    ponenteHTML.textContent = ponente.nombre
                    ponenteHTML.dataset.ponenteId = ponente.id;
                    ponenteHTML.onclick = seleccionarPonente;

                    //Añadir al DOM
                    listadoPonentes.appendChild(ponenteHTML);
            })}
            else {
                //sino
                const noResultado = document.createElement('P');
                noResultado.classList.add('listado-ponentes__no-resultado');
                noResultado.textContent = 'No se encontraron resultados';

                //Añadir al DOM
                listadoPonentes.appendChild(noResultado);
                    }
        }
        
        function seleccionarPonente(e){
            const ponente = e.target;

            //remover la clase previa
            const ponentePrevio = document.querySelector('.listado-ponentes__ponente--seleccionado');
            if(ponentePrevio){
                ponentePrevio.classList.remove('listado-ponentes__ponente--seleccionado');
            }

            ponente.classList.add('listado-ponentes__ponente--seleccionado');

            ponenteHidden.value = ponente.dataset.ponenteId;

        }
    }
})();