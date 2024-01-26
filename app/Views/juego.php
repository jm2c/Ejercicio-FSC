<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            overflow: hidden;
        }

        #juego-canvas {
            margin: 0 auto;
            background-color: #222;
            cursor: pointer
        }
    </style>
    <title>Juego</title>
</head>
<body>
    <canvas id="juego-canvas"></canvas>

    <script src="/js/tools.js"></script>
    <script>
        const WIDTH  = window.innerWidth
        const HEIGHT = window.innerHeight
        const SCALE = WIDTH/15
        const [LEFT, TOP, BOTTOM, RIGHT] = [0, 0, HEIGHT-SCALE, WIDTH-SCALE]
        const canvas = document.getElementById('juego-canvas')
        const ctx    = canvas.getContext("2d")
        let imagesArray = []
        let images = {}
        let goalsImagesArray = []

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
            "/assets/goalRight.png"
            ]
        let figures = []

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
            figures.forEach(fig => {
                fig.touching = false
                fig.image = imagesArray[fig.imageIndex]
            })
            isDragging = false
        }

        async function init() {
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
                GRIGHT : imagesArray[7]
            }
            goalsImagesArray = shuffleArray([images.GUP, images.GDOWN, images.GLEFT, images.GRIGHT])

            const dirs = ['UP', 'LEFT', 'RIGHT', 'DOWN']
            for(let i = 0; i < 4; i++){
                const dir = dirs[Math.floor(Math.random() * 4)]
                const posX = (Math.random() * (WIDTH - 5*SCALE)) + 2*SCALE
                const posY = (Math.random() * (HEIGHT - 5*SCALE)) + 2*SCALE
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
            // Draw the arcs
            ctx.strokeStyle = "#55FF55"
            ctx.fillStyle = "#006600"
            ctx.beginPath()
            ctx.arc(0,0, 2.5*SCALE, 0, 2*Math.PI)
            ctx.stroke()
            ctx.fill()
            ctx.beginPath()
            ctx.arc(WIDTH,0, 2.5*SCALE, 0, 2*Math.PI)
            ctx.stroke()
            ctx.fill()
            ctx.beginPath()
            ctx.arc(WIDTH,HEIGHT, 2.5*SCALE, 0, 2*Math.PI)
            ctx.stroke()
            ctx.fill()
            ctx.beginPath()
            ctx.arc(0,HEIGHT, 2.5*SCALE, 0, 2*Math.PI)
            ctx.stroke()
            ctx.fill()

            // Draw goal figures
            ctx.drawImage(goalsImagesArray[0], LEFT,  TOP, SCALE, SCALE)
            ctx.drawImage(goalsImagesArray[1], LEFT,  BOTTOM, SCALE, SCALE)
            ctx.drawImage(goalsImagesArray[2], RIGHT, TOP, SCALE, SCALE)
            ctx.drawImage(goalsImagesArray[3], RIGHT, BOTTOM, SCALE, SCALE)

            // Draw they in reverse order allows to pick the upper figure
            for(let i = figures.length - 1; i >= 0; i--){
                figures[i].draw()
            }

        }

        function update() {
            ctx.clearRect(0,0,WIDTH,HEIGHT)
            draw()
            requestAnimationFrame(update)
        }

        init()

    </script>
</body>
</html>
