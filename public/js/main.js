const section = document.getElementById('ultimos')
const baseUrl = window.location
const url = baseUrl + 'listaArticulosPortada'
const xhr = new XMLHttpRequest()
let data

xhr.open('GET', url)
xhr.onload = evt => {
    if(xhr.status == 200) {
        data = JSON.parse(xhr.responseText)
        console.log(data)

        data.forEach(element => {
            let article   = document.createElement('article')
            let anchor    = document.createElement('a')
            let header    = document.createElement('h2')
            let thumbnail = document.createElement('img')
            let resume    = document.createElement('p')

            section.classList.add('grid', 'grid-cols-1', 'md:grid-cols-3', 'gap-4')

            anchor.href = baseUrl + 'articulo/' + element.id

            header.innerText = element.titulo
            header.classList.add('text-2xl', 'font-bold')

            thumbnail.src = element.imagen_previa

            resume.innerText = element.sintesis

            anchor.appendChild(header)
            anchor.appendChild(thumbnail)
            article.appendChild(anchor)
            article.appendChild(resume)
            section.appendChild(article)
        });
    }
}
xhr.send()
