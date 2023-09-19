//funcion para poder seleccionar dia y hora
(function() { 
    const horas = document.querySelector('#horas');

    if(horas){


        const categoria = document.querySelector('[name="categoria_id"]');
        const dias = document.querySelectorAll('[name="dia"]');
        const inputHiddenDia = document.querySelector('[name="dia_id"]');
        const inputHiddenHora = document.querySelector('[name="hora_id"]');

        categoria.addEventListener('change', terminoBusqueda);
        dias.forEach(dia => dia.addEventListener('change', terminoBusqueda));

        let busqueda = {
            categoria_id: +categoria.value || '',
            dia: +inputHiddenDia.value || ''
        }
        if(!Object.values(busqueda).includes('')){
        
            (async () =>{
    
                await buscarEventos();

                const id = inputHiddenHora.value;
                //resaltar la hora actual
                const horaSeleccionada = document.querySelector(`[data-hora-id="${id}"]`);

                horaSeleccionada.classList.remove('horas__hora--deshabilitada');
                horaSeleccionada.classList.add('horas__hora--seleccionada');

                //para poder cambiar horas seleccionadas
                horaSeleccionada.onclick = seleccionarHora;
            })()
        }
        
    

        function terminoBusqueda(e){
            busqueda[e.target.name] = e.target.value;

            //reiniciar los campos ocultos y el selector de horas
            inputHiddenHora.value = '';
            inputHiddenDia.value = '';

            //deshabilitar la hora previa si existe un nuevo click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia){
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }
            //una vez lleno buscamos los eventos para ver los disponibles
            if(Object.values(busqueda).includes('')){
                return;
            }

            buscarEventos();
        }

        async function buscarEventos() {

            const {dia, categoria_id} = busqueda; 
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;

            const resultado = await fetch(url);
            const eventos = await resultado.json();

            obtenerHorasDisponibles(eventos);
        }
        
        function obtenerHorasDisponibles(eventos) {
            //reiniciar las horas
            const listaHoras = document.querySelectorAll('#horas li');
            listaHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'));

            //comprobar eventos ya seleccionados y quitar la variable deshabilitada
            const horasSeleccionadas = eventos.map(evento => evento.hora_id);
            
            const listaHorasArray = Array.from(listaHoras);
            //teniamos que convertirlo en un array para el filter
            const resultado = listaHorasArray.filter(li => !horasSeleccionadas.includes(li.dataset.horaId));
            resultado.forEach( li => li.classList.remove('horas__hora--deshabilitada'));



            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada');
            horasDisponibles.forEach(hora => hora.addEventListener('click', seleccionarHora));
        }    

        function seleccionarHora(e) {
            //deshabilitar la hora previa si existe un nuevo click
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia){
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }

            //agregar la clase seleccionado
            e.target.classList.add('horas__hora--seleccionada');

            inputHiddenHora.value = e.target.dataset.horaId;

            //llenar el campo oculto de día
            inputHiddenDia.value = document.querySelector('[name="dia"]:checked').value;
        }
    
    }
})();