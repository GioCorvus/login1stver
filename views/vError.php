<img id="rotatingImage" src="img/cat.png" alt="Rotating Elf Image">

<script>
        document.addEventListener('DOMContentLoaded', function () {
            const imgElf = document.getElementById('imgElf');

            imgElf.addEventListener('click', function () {
                const x = Math.random() * window.innerWidth;
                const y = Math.random() * window.innerHeight;

                imgElf.style.transform = `translate(${x}px, ${y}px)`;
            });

            document.addEventListener('mousemove', function (event) {
                const x = event.clientX;
                const y = event.clientY;

                imgElf.style.transform = `translate(${x}px, ${y}px)`;
            });
        });
    </script>