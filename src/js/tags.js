(function(){
    const tagsInput = document.querySelector('#tags_input')

    if(tagsInput){

        const tagsDiv = document.querySelector('#tags');
        const tagsInputHidden = document.querySelector('[name="tags"]');

        let tags = [];

        //recuperar del input oculto de los tags
        if(tagsInputHidden.value !== ''){
          tags = tagsInputHidden.value.split(',');
            mostrarTags();

        }

        //escuchar los cambios en el input
        tagsInput.addEventListener('keypress', guardarTag);

        function guardarTag(e){

            //evitamso agregar campos vacios
            if(e.keyCode === 44){
                if(e.target.value.trim() === '' || e.target.value < 1 ){
                    return
                }

                e.preventDefault();

                //añadimos a la copia del arreglo el nuevo valor
                tags = [...tags, e.target.value.trim()];

                //limpiar el tagInput de los valores anteriores
                tagsInput.value = '';

                mostrarTags();
            }
        }
        //mostrar en pantalla
        function mostrarTags(){
           tagsDiv.textContent = '';

           tags.forEach(tag => {

            const etiqueta = document.createElement('LI');
            etiqueta.classList.add('formulario__tag');

            etiqueta.textContent = tag;
            etiqueta.ondblclick = eliminarTag;
            tagsDiv.appendChild(etiqueta);

           })
           //cada vez que llamamos se actualiza
           actualizarInputHidden();
        }

        function eliminarTag(e){
            //eliminamos el tag y mostramos todos los no eliminados
            e.target.remove();
            tags = tags.filter(tag => tag !== e.target.textContent)
            actualizarInputHidden();
            }

        function actualizarInputHidden(){
        //actualizamos los inputs
        tagsInputHidden.value = tags.toString();
        }


    }
})()

