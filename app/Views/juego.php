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
        const SCALE = WIDTH/20
        const [LEFT, TOP, BOTTOM, RIGHT] = [0, 0, HEIGHT-SCALE, WIDTH-SCALE]
        const canvas = document.getElementById('juego-canvas')
        const ctx    = canvas.getContext("2d")
        let images = []
        const imgUrls = [
            /* https://reffpixels.itch.io/genericicons */
            "/assets/triangleUp.png",
            "/assets/triangleDown.png",
            "/assets/triangleLeft.png",
            "/assets/triangleRight.png"
            ]

        async function init() {
            canvas.width = WIDTH
            canvas.height = HEIGHT
            images = await preloadImages(imgUrls)

            draw()
            update()
        }

        function draw() {
            ctx.drawImage(images[0], LEFT,  TOP, SCALE, SCALE)
            ctx.drawImage(images[1], LEFT,  BOTTOM, SCALE, SCALE)
            ctx.drawImage(images[2], RIGHT, TOP, SCALE, SCALE)
            ctx.drawImage(images[3], RIGHT, BOTTOM, SCALE, SCALE)
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
