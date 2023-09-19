    <!--Formulario informacion evento-->
<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Evento</legend>

<!--Nombre del evento-->
    <div class="formulario__campo">
        <label for="nombre" class="formulario__label">Nombre</label>
        <input 
        type="text"
        class="formulario__input"
        id="nombre"
        name="nombre"
        placeholder="Nombre Evento"
        value="<?php echo $evento->nombre;?>">
    </div>

<!--Descripción-->
    <div class="formulario__campo">
        <label for="descripcion" class="formulario__label">Descripción</label>
        <textarea 
        class="formulario__input"
        id="descripcion"
        name="descripcion"
        placeholder="Descripcion Evento"
        rows= "8"
        ><?php echo $evento->descripcion;?></textarea>
    </div>

<!--Selección de categoría-->
    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Categoría</label>
        <select class="formulario__select" name="categoria_id" id="categoria">
            <option value="">- Seleccionar -</option>
            <?php foreach($categorias as $categoria) { ?>
                <option <?php echo ($evento->categoria_id === $categoria->id) ? 'selected' : '';?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
            <?php } ?>
        </select>
    </div>

<!--Selección de día-->
    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Selecciona el día</label>
                <div class="formulario__radio">
                    <?php foreach($dias as $dia) { ?>
                        <div>
                            <label for="<?php echo strtolower($dia->nombre); ?>"><?php echo $dia->nombre; ?></label>
                            <input type="radio" name="dia" id="<?php echo strtolower($dia->nombre);?>" value="<?php echo $dia->id;?>"
                            <?php echo ($evento->dia_id === $dia->id) ? 'checked' : ''; ?>
                            />
                        </div>
                    <?php } ?>
                </div>
            <input type="hidden" name="dia_id" value="<?php echo $evento->dia_id; ?>">
    </div>

<!--Selección de hora-->
    <div class="formulario__campo">
        <label for="categoria" class="formulario__label">Selecciona la hora</label>
                <ul id="horas" class="horas">
                    <?php foreach($horas as $hora) { ?>
                        <li data-hora-id="<?php echo $hora->id; ?>" class="horas__hora horas__hora--deshabilitada"><?php echo $hora->hora; ?></li>
                    <?php } ?>
                </ul>
        <input type="hidden" name="hora_id" value="<?php echo $evento->hora_id; ?>">
    </div>
</fieldset>

<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Extra</legend>

<!--Ponente del evento-->
    <div class="formulario__campo">
        <label for="ponentes" class="formulario__label">Ponente</label>
        <input 
        type="text"
        class="formulario__input"
        id="ponentes"
        placeholder="Buscar Ponente">

        <ul id="listado-ponentes" class="listado-ponentes"></ul>
        <input type="hidden" name="ponente_id" value="<?php echo $evento->ponente_id; ?>">
    </div>

<!--Lugares disponibles para el evento-->
    <div class="formulario__campo">
        <label for="disponibles" class="formulario__label">Lugares Disponibles</label>
        <input 
        type="number"
        min="1"
        class="formulario__input"
        id="disponibles"
        name="disponibles"
        placeholder="Ej. 20"
        value="<?php echo $evento->disponibles;?>">
    </div>
</fieldset>  