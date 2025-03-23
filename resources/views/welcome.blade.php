<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        @vite(['resources/js/app.js', 'resources/css/app.css'])

        <style>

            /* Center the loader vertically, and position it 30px from the left */
            #loading {
                position: fixed;
                top: 30%;
                left: 800px; /* Set the left position to 30px */
                transform: translateY(-50%); /* Center vertically */
                z-index: 9999; /* Ensure the loader appears above other content */
            }

            /* Larger Loader Style */
            .loader {
                --c1: #120339;
                --c2: #1a074a;
                width: 100px; /* Increased width */
                height: 200px; /* Increased height */
                border-top: 8px solid var(--c1); /* Increased border size */
                border-bottom: 8px solid var(--c1); /* Increased border size */
                background: linear-gradient(90deg, var(--c1) 4px, var(--c2) 0 10px, var(--c1) 0) 50%/14px 16px no-repeat; /* Adjusted background for size */
                display: grid;
                overflow: hidden;
                animation: l5-0 2s infinite linear;
            }

            .loader::before,
            .loader::after {
                content: "";
                grid-area: 1/1;
                width: 75%;
                height: calc(50% - 8px); /* Increased height for elements inside the loader */
                margin: 0 auto;
                border: 4px solid var(--c1); /* Increased border size */
                border-top: 0;
                box-sizing: content-box;
                border-radius: 0 0 40% 40%;
                -webkit-mask: linear-gradient(#000 0 0) bottom/8px 4px no-repeat, linear-gradient(#000 0 0);
                -webkit-mask-composite: destination-out;
                mask-composite: exclude;
                background: linear-gradient(var(--d, 0deg), var(--c2) 50%, #0000 0) bottom / 100% 410%, linear-gradient(var(--c2) 0 0) center/0 200%;
                background-repeat: no-repeat;
                animation: inherit;
                animation-name: l5-1;
            }

            .loader::after {
                transform-origin: 50% calc(100% + 4px);
                transform: scaleY(-1);
                --s: 6px; /* Increased size of the second element */
                --d: 180deg;
            }

            @keyframes l5-0 {
                80% {
                    transform: rotate(0)
                }

                100% {
                    transform: rotate(0.5turn)
                }
            }

            @keyframes l5-1 {
                10%, 70% {
                    background-size: 100% 410%, var(--s, 0) 100%
                }

                70%, 100% {
                    background-position: top, center
                }
            }
        </style>
    </head>
    <body>
        <!-- Loader positioned 30px from the left -->
        <div id="loading" class="loader"></div>

        <!-- Vue App -->
        <div id="app" style="display: none;">
            <example-component></example-component>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const app = document.getElementById("app");
                const loading = document.getElementById("loading");

                setTimeout(() => {
                    app.style.display = "block"; // Show Vue app after delay
                    loading.style.display = "none"; // Hide loader after delay
                }, 1000);
            });
        </script>

    </body>
</html>
