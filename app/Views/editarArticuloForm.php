<?php if($nuevo): ?>
    <div class="w-3/4 m-auto">
        <h1 class="text-3xl">Nuevo artículo</h1>
    </div>
<?php else: ?>
    <div class="w-3/4 m-auto">
        <h1 class="text-3xl">Editar articulo: <strong><em><?=$titulo;?></em></strong></h1>
    </div>
<?php endif; ?>



<form
    class="md:w-3/4 m-auto p-4 bg-gray-200 dark:bg-gray-700 rounded shadow-lg"
    action=""
    method="post">

    <div id="error-messages" class="mb-2 p-3 rounded bg-red-300 text-black"></div>

    <div class="mb-4">
        <label>
            Título
            <br/>
            <input
                type="text"
                name="titulo"
                class="text-black shadow-md w-full rounded p-1"
                value="<?= set_value('titulo') ?>">
        </label>
    </div>

    <div class="mb-4">
        <label>
            Palabras clave
            <br/>
            <textarea
                name="palabrasClave"
                rows="3"
                maxlength="200"
                class="text-black shadow-md w-full rounded p-1 resize-none"
                placeholder="Separadas por espacios"></textarea>
        </label>
    </div>

    <div class="mb-4">
        <label>
            Edad mínima
            <input
                type="number"
                name="edadMinima"
                min="0"
                max="9"
                class="text-black shadow-md rounded p-1"
                value="<?= set_value('edadMinima') ?>">
        </label>
    </div>

    <div class="mb-4">
        <label>
            Edad máxima
            <input
                type="number"
                name="edadMaxima"
                min="0"
                max="9"
                class="text-black shadow-md rounded p-1"
                value="<?= set_value('edadMaxima') ?>">
        </label>
    </div>

    <div class="mb-4">
        <label>
            Imagen de portada
            <br/>
        </label>
    </div>

    <div class="mb-4">
        <label>
            Síntesis
            <br/>
            <textarea
                name="sintesis"
                rows="5"
                maxlength="200"
                class="text-black shadow-md w-full rounded p-1 resize-none"></textarea>
        </label>
    </div>

    <div class="mb-4">
        <label>
            Contenido
            <br/>
            <textarea
                name="contenido"
                id="contenido-text-area"
                rows="10"></textarea>
        </label>
    </div>

    <?php if($nuevo): ?>
    <div class="flex justify-end">
        <input
            class="bg-indigo-200 text-black hover:bg-indigo-400 hover:cursor-pointer rounded py-2 px-6"
            type="submit"
            value="Crear artículo">
    </div>
    <?php else: ?>
    <div class="flex justify-end">
        <input
            class="bg-indigo-200 text-black hover:bg-indigo-400 hover:cursor-pointer rounded py-2 px-6"
            type="submit"
            value="Actualizar">
    </div>
    <?php endif; ?>
</form>

<script src="/js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    selector: '#contenido-text-area',
    menubar: false,
    plugins: 'lists',
    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist'
})
</script>
