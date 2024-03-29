const WIDTH  = window.innerWidth
const HEIGHT = window.innerHeight
const SCALE = WIDTH/20
const RAD = 4 * SCALE
const FAIL_RATIO = 0.1
const [LEFT, TOP, BOTTOM, RIGHT] = [0, 0, HEIGHT-SCALE, WIDTH-SCALE]
const canvas = document.getElementById('juego-canvas')
const ctx    = canvas.getContext("2d")
let imagesArray = []
let images = {}
let goalsArray = []
let goalsImagesArray = []
let startTime = 0
let timeLeft = 16
let score = 0
let gameStarted = false
let instructions = []

let isDragging = false
const imgUrls = [
    /* https://reffpixels.itch.io/genericicons */
    "/assets/triangleUp.png",
    "/assets/triangleDown.png",
    "/assets/triangleLeft.png",
    "/assets/triangleRight.png",
    "/assets/goalUp.png",
    "/assets/goalDown.png",
    "/assets/goalLeft.png",
    "/assets/goalRight.png",
    "/assets/failUp.png",
    "/assets/failDown.png",
    "/assets/failLeft.png",
    "/assets/failRight.png",
    "/assets/next.png"
    ]
let figures = []
let figuresOut = [] // non playable figures

class Triangle {
    constructor(x,y) {
        this.x = x || WIDTH / 2
        this.y = y || HEIGHT / 2
        this.touching = false
        this.image = undefined
    }

    isTouching(x,y) {
        const err    = 10 // ratio of error in pixels
        const top    = this.y - err
        const left   = this.x - err
        const bottom = this.y + SCALE + err
        const right  = this.x + SCALE + err

        return (x > left && x < right) && (y < bottom && y > top)
    }

    move(x, y) {
        this.x = x - SCALE / 2
        this.y = y - SCALE / 2
    }

    draw() {
        ctx.drawImage(this.image, this.x, this.y, SCALE, SCALE)
    }
}

class UpTriangle extends Triangle {
    constructor(x,y) {
        super(x,y)
        this.imageIndex = 0
        this.image = imagesArray[this.imageIndex]
        this.type = 'UP'
    }
}

class LeftTriangle extends Triangle {
    constructor(x,y) {
        super(x,y)
        this.imageIndex = 2
        this.image = imagesArray[this.imageIndex]
        this.type = 'LEFT'
    }
}

class DownTriangle extends Triangle {
    constructor(x,y) {
        super(x,y)
        this.imageIndex = 1
        this.image = imagesArray[this.imageIndex]
        this.type = 'DOWN'
    }
}

class RightTriangle extends Triangle {
    constructor(x,y) {
        super(x,y)
        this.imageIndex = 3
        this.image = imagesArray[this.imageIndex]
        this.type = 'RIGHT'
    }
}

canvas.onpointerdown = evt => {
    evt.preventDefault()
    let x = evt.clientX
    let y = evt.clientY

    if(!gameStarted) {
        if(x > WIDTH - 2*SCALE && y > HEIGHT - 2*SCALE) {
            gameStarted = true
            startTime = Date.now() + timeLeft * 1000
            update()
        }
        return
    }

    figures.forEach(fig => {
        let t = !isDragging && fig.isTouching(x, y)
        if(t) {
            fig.touching = isDragging = true
            fig.image = imagesArray[fig.imageIndex + 4]
        }
    })
}

canvas.onpointermove = evt => {
    evt.preventDefault()
    x = evt.clientX
    y = evt.clientY
    figures.forEach(fig => {
        if(fig.touching) fig.move(x,y)
    })
}

canvas.onpointerup = evt => {
    evt.preventDefault()
    let lastFigure
    figures.forEach((fig, index) => {
        fig.touching = false
        fig.image = imagesArray[fig.imageIndex]

        // Check for the upper left corner
        if((fig.x + SCALE)**2 + (fig.y + SCALE)**2 < RAD**2) {
            if( fig.type == goalsArray[0] )
            {
                fig.image = imagesArray[fig.imageIndex + 4]
                score += 5
            }
            else
            {
                fig.image = imagesArray[fig.imageIndex + 8]
                score -= 5
            }
            figuresOut.push(fig)
            figures.splice(index, 1)
        }

        // Check for the down left corner
        if((fig.x + SCALE)**2 + (fig.y - HEIGHT)**2 < RAD**2) {
            if( fig.type == goalsArray[1] )
            {
                fig.image = imagesArray[fig.imageIndex + 4]
                score += 5
            }
            else
            {
                fig.image = imagesArray[fig.imageIndex + 8]
                score -= 5
            }
            figuresOut.push(fig)
            figures.splice(index, 1)
        }

        // Check for the upper right corner
        if((fig.x - WIDTH)**2 + (fig.y + SCALE)**2 < RAD**2) {
            if( fig.type == goalsArray[2] )
            {
                fig.image = imagesArray[fig.imageIndex + 4]
                score += 5
            }
            else
            {
                fig.image = imagesArray[fig.imageIndex + 8]
                score -= 5
            }
            figuresOut.push(fig)
            figures.splice(index, 1)
        }

        // Check for the down right corner
        if((fig.x - WIDTH)**2 + (fig.y - HEIGHT)**2 < RAD**2) {
            if( fig.type == goalsArray[3] )
            {
                fig.image = imagesArray[fig.imageIndex + 4]
                score += 5
            }
            else
            {
                fig.image = imagesArray[fig.imageIndex + 8]
                score -= 5
            }
            figuresOut.push(fig)
            figures.splice(index, 1)
        }
    })
    isDragging = false
}

async function init(numObjs = 1) {
    canvas.width = WIDTH
    canvas.height = HEIGHT
    imagesArray = await preloadImages(imgUrls)
    images = {
        UP     : imagesArray[0],
        DOWN   : imagesArray[1],
        LEFT   : imagesArray[2],
        RIGHT  : imagesArray[3],
        GUP    : imagesArray[4],
        GDOWN  : imagesArray[5],
        GLEFT  : imagesArray[6],
        GRIGHT : imagesArray[7],
        FUP    : imagesArray[8],
        FDOWN  : imagesArray[9],
        FLEFT  : imagesArray[10],
        FRIGHT : imagesArray[11]
    }

    instructions = [
        "Cada esquina está marcada por una pieza",
        "Arrastra las piezas a la esquina correcta",
        "Ciudado, si te equivocas pierdes puntos",
        "Se rápido, que el timpo corre",
        "¿Estas listo?"
    ]

    goalsArray = shuffleArray(['UP', 'LEFT', 'RIGHT', 'DOWN'])
    // goalsImagesArray = [images.GUP, images.GLEFT, images.GRIGHT, images.GDOWN]
    goalsImagesArray = goalsArray.map(goal => {
        switch (goal) {
            case 'UP':
                return images.GUP
            case 'DOWN':
                return images.GDOWN
            case 'LEFT':
                return images.GLEFT
            case 'RIGHT':
                return images.GRIGHT
        }
    })

    for(let i = 0; i < numObjs; i++){
        const dir = goalsArray[Math.floor(Math.random() * 4)]
        const posX = (Math.random() * (WIDTH - 2*RAD + SCALE)) + RAD - SCALE
        const posY = (Math.random() * (HEIGHT - 2*RAD + SCALE)) + RAD - SCALE
        let fig
        switch (dir) {
            case 'UP':
                figures.push(new UpTriangle(posX, posY))
                break;
            case 'LEFT':
                figures.push(new LeftTriangle(posX, posY))
                break;
            case 'RIGHT':
                figures.push(new RightTriangle(posX, posY))
                break;
            case 'DOWN':
                figures.push(new DownTriangle(posX, posY))
                break;
        }

    }

    draw()
    update()
}

function draw() {
    ctx.clearRect(0,0,WIDTH,HEIGHT)

    // Initial screen
    if(!gameStarted) {
        ctx.strokeStyle = "#55FF55"
        ctx.fillStyle = "#006600"
        ctx.beginPath()
        ctx.arc(0,0, RAD*(1-FAIL_RATIO), 0, 2*Math.PI)
        ctx.stroke()
        ctx.fill()
        ctx.drawImage(imagesArray[4], LEFT,  TOP, SCALE, SCALE)
        ctx.drawImage(imagesArray[12], RIGHT - SCALE, BOTTOM - SCALE, SCALE * 2, SCALE * 2)
        ctx.fillStyle = "white"
        ctx.font = "bold 25px Sans"
        ctx.textAlign = "center"

        ctx.fillText(instructions[0], WIDTH/2, HEIGHT/2 - 70)
        ctx.fillText(instructions[1], WIDTH/2, HEIGHT/2 - 35)
        ctx.fillText(instructions[2], WIDTH/2, HEIGHT/2)
        ctx.fillText(instructions[3], WIDTH/2, HEIGHT/2 + 35)
        ctx.fillText(instructions[4], WIDTH/2, HEIGHT/2 + 70)
        return
    }

    // Draw the arcs
    ctx.strokeStyle = "#55FF55"
    ctx.fillStyle = "#006600"
    ctx.beginPath()
    ctx.arc(0,0, RAD*(1-FAIL_RATIO), 0, 2*Math.PI)
    ctx.stroke()
    ctx.fill()
    ctx.beginPath()
    ctx.arc(WIDTH,0, RAD*(1-FAIL_RATIO), 0, 2*Math.PI)
    ctx.stroke()
    ctx.fill()
    ctx.beginPath()
    ctx.arc(WIDTH,HEIGHT, RAD*(1-FAIL_RATIO), 0, 2*Math.PI)
    ctx.stroke()
    ctx.fill()
    ctx.beginPath()
    ctx.arc(0,HEIGHT, RAD*(1-FAIL_RATIO), 0, 2*Math.PI)
    ctx.stroke()
    ctx.fill()

    // Draw the clock
    let dt = startTime - Date.now()
    let segs = Math.floor(dt / 1000)
    let decs = Math.floor(dt / 100) % 10
    ctx.font = "bold 30px Sans"
    ctx.fillStyle = "white"
    ctx.textAlign = "center"
    ctx.fillText(`${segs}.${decs}`, WIDTH / 3, 40)

    // Draw score
    ctx.textAlign = "center"
    ctx.fillText(score, 2*(WIDTH / 3), 40)

    // Draw goal figures
    ctx.drawImage(goalsImagesArray[0], LEFT,  TOP, SCALE, SCALE)
    ctx.drawImage(goalsImagesArray[1], LEFT,  BOTTOM, SCALE, SCALE)
    ctx.drawImage(goalsImagesArray[2], RIGHT, TOP, SCALE, SCALE)
    ctx.drawImage(goalsImagesArray[3], RIGHT, BOTTOM, SCALE, SCALE)

    // Draw they in reverse order allows to pick the upper figure
    for(let i = figures.length - 1; i >= 0; i--){
        figures[i].draw()
    }
    figuresOut.forEach(fig => fig.draw())

}

function update() {
    if(startTime < Date.now()) return

    draw()
    requestAnimationFrame(update)
}

init(15)
