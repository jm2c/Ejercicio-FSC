<div class="flex flex-col md:flex-row justify-between my-4">
    <h1 class="text-4xl">Administrador de artículos</h1>
    <a class="bg-indigo-100 px-6 py-2 rounded text-black hover:bg-indigo-400 hover:cursor-poiner" href="/articulo/editar/nuevo">Añadir nuevo artículo</a>
</div>

<table class="w-full text-left table-auto min-w-max"><tbody></tbody></table>

<script defer>
const baseUrl = window.location.origin
const url = baseUrl + '/listaArticulos'
const table = document.querySelector('table tbody')
const xhr = new XMLHttpRequest()
let data

xhr.open('GET', url)
xhr.onload = evt => {
    if (xhr.readyState === 4) {
        if (xhr.status === 200) {
            data = JSON.parse(xhr.responseText)
            data.forEach(element => {
                const tableRow    = document.createElement('tr')
                const articleCell = document.createElement('td')
                const editCell    = document.createElement('td')
                const deleteCell  = document.createElement('td')
                const articleLink = document.createElement('a')
                const editLink    = document.createElement('a')
                const deleteLink  = document.createElement('a')

                articleCell.classList.add('p-4', 'border-b', 'border-blue-gray-50')
                editCell.classList.add(   'p-4', 'border-b', 'border-blue-gray-50')
                deleteCell.classList.add( 'p-4', 'border-b', 'border-blue-gray-50')
                editLink.classList.add('rounded', 'p-3', 'text-black', 'bg-green-200', 'hover:bg-green-500')
                deleteLink.classList.add('rounded', 'p-3', 'text-white', 'bg-red-500', 'hover:bg-red-900')

                articleLink.href = baseUrl + '/articulo/'        + element.id
                editLink.href    = baseUrl + '/articulo/editar/' + element.id
                deleteLink.href  = baseUrl + '/articulo/borrar/' + element.id

                articleLink.innerText = element.titulo
                editLink.innerText    = 'Editar'
                deleteLink.innerText  = 'Borrar'

                articleCell.appendChild(articleLink)
                editCell.appendChild(editLink)
                deleteCell.appendChild(deleteLink)
                tableRow.appendChild(articleCell)
                tableRow.appendChild(editCell)
                tableRow.appendChild(deleteCell)
                table.appendChild(tableRow)
            })
        } else {
            console.error(xhr.statusText)
        }
    }
}
xhr.onerror = evt => {
  console.error(xhr.statusText)
}
xhr.send(null)
</script>
