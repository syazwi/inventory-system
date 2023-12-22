<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Popup Example</title>
    <style>
        /* Styles for the overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }



        /* Styles for the popup */
       .popup {
        width: 45%;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    padding: 60px;
    background-color: #ffffff;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    text-align: justify;
    z-index: 1001;
    display: flex;
    align-items: center;
}



        /* Styles for the close button */
        .popup #closeBtn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 16px;
        }

        /* Hover effect for the close button */
        .popup #closeBtn:hover {
            background-color: #dc0b80;
        }

        /* Styles for the text and image container */
        .popup-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .popup-content {
    padding-right: 100px;
}

        /* Styles for the image */
        .popup-content img {
            max-width: 100%;
            height: auto;
            margin-top: 16px;
        }

img#me {
    border-radius: 100px;
}


    </style>
</head>
<body>
    <!-- Overlay -->
    <div class="overlay" id="overlay"></div>

    <div class="popup" id="popup">
        <div class="popup-content">
            <div id="greeting" style="font-weight: bold; font-size: 24px;"></div>
            <p>I'm Syazwi, the wizard who conjured up this amazing inventory system. Delighted to meet you all and can't wait to embark on this adventure together!</p>
            <button id="closeBtn">Close</button>
        </div>
        <img id="me" src="Anime_Pastel.jpg" alt="Wizard" width="200">
    </div>

    <script>
        function showPopup() {
            var overlay = document.getElementById("overlay");
            var popup = document.getElementById("popup");
            overlay.style.display = "block";
            popup.style.display = "flex";

            var currentHour = new Date().getHours();
            var greeting = document.getElementById("greeting");

            if (currentHour >= 5 && currentHour < 12) {
                greeting.innerHTML = "Good morning!";
            } else if (currentHour >= 12 && currentHour < 18) {
                greeting.innerHTML = "Good afternoon!";
            } else {
                greeting.innerHTML = "Good evening!";
            }
        }

        function closePopup() {
            var overlay = document.getElementById("overlay");
            var popup = document.getElementById("popup");
            overlay.style.display = "none";
            popup.style.display = "none";
        }

        window.onload = function() {
            showPopup();
        };

        var closeBtn = document.getElementById("closeBtn");
        closeBtn.addEventListener("click", closePopup);
    </script>
</body>
</html>
