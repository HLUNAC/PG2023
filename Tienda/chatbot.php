<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Página de Productos</title>
    <style>
        /* Estilos para el chatbot */
        #chatbot-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            max-width: 300px;
            border: 1px solid #007BFF;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: max-height 0.5s ease;
            max-height: 40;
            z-index: 9999;
        }

        #chatbot-container.closed {
            max-height: 500px;
        }

        #chat-icon {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 40px; /* Aumentado el relleno izquierdo y derecho */
    cursor: pointer;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
    text-align: center; 
    z-index: 10000;
}


        #chat-icon:hover {
            background-color: #0056b3;
        }


        #chat-window {
            padding: 10px;
            background-color: white;
            height: 400px;
            overflow-y: auto;
        }

 

        /* Estilos para los mensajes del chat */
        .user-message {
            background-color: #007BFF;
            color: #fff;
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            margin: 10px;
            text-align: right;
        }

        .bot-message {
            background-color: #555;
            color: #fff;
            max-width: 70%;
            padding: 10px;
            border-radius: 10px;
            margin: 10px;
            text-align: left;
        }
    </style>
</head>

<body>
    <?php
    // Aquí deberías incluir tu lógica para el carrito en PHP
    // Asegúrate de que la lógica del carrito esté en 'templates/carrito.php'
    // y que funcione correctamente.
    ?>

    <div id="chatbot-container" class="closed">
        <div id="chat-icon" onclick="toggleChat()">Chat</div>
        <div id="chat-window">
            <div id="output"></div>
            <input type="text" id="user-input" placeholder="Escribe tu pregunta...">
            <button onclick="sendMessage()">Enviar</button>
        </div>
    </div>

    <script>
        const preguntasRespuestas = {
            "¿Qué productos ofrecen?": "Ofrecemos una amplia gama de productos, incluyendo The Legend of Zelda: Breath of the Wild, Splatoon 2, Luigi's Mansion 3 y Super Smash Bros. Ultimate.",
            "The Legend of Zelda Breath of the Wild": "The Legend of Zelda: Breath of the Wild es un videojuego de acción y aventura para Nintendo Switch. Su precio es de Q600.00.",
            "ZELDA": "The Legend of Zelda: Breath of the Wild es un videojuego de acción y aventura para Nintendo Switch. Su precio es de Q600.00.",
            "zelda": "The Legend of Zelda: Breath of the Wild es un videojuego de acción y aventura para Nintendo Switch. Su precio es de Q600.00.",
            "¿Cuál es el precio de zelda?": "El precio de Zelda Breath of the Wild es de Q600.00.",
            "cuanto cuesta zelda?": "El precio de Zelda Breath of the Wild es de Q600.00.",
            "a cuanto esta zelda?": "El precio de Zelda Breath of the Wild es de Q600.00.",
            "cuanto cuesta zelda": "El precio de Zelda Breath of the Wild es de Q600.00.",
            "Cuanto cuesta zelda": "El precio de Zelda Breath of the Wild es de Q600.00.",
            "Cuanto cuesta Zelda?": "El precio de Zelda Breath of the Wild es de Q600.00.",
            "cuanto vale zelda?": "El precio de Zelda Breath of the Wild es de Q600.00.",
            "gracias": "Para servirte, si necesitas ayuda adicional puedes comentármelo.",
            "Muchas gracias": "Para servirte, si necesitas ayuda adicional puedes comentármelo.",
            "precio": "Sobre qué producto deseas saber el precio?",
            "Hola": "Bienvenido, mi nombre es Lunita, ¿en qué puedo ayudarte el día de hoy?",
            "hola": "Bienvenido, mi nombre es Lunita, ¿en qué puedo ayudarte el día de hoy?",
            ".": "Bienvenido, mi nombre es Lunita, ¿en qué puedo ayudarte el día de hoy?",
            "Precio": "Sobre qué producto deseas saber el precio?",
            "Splatoon 2": "Splatoon 2 es un videojuego de disparos en tercera persona para Nintendo Switch. Su precio es de Q550.00.",
            "Luigi's Mansion 3": "Luigi's Mansion 3 es un videojuego de acción y aventura para Nintendo Switch. Su precio es de Q550.00.",
            "luigi": "Luigi's Mansion 3 es un videojuego de acción y aventura para Nintendo Switch. Su precio es de Q550.00.",
            "Luigis Mansion 3": "Luigi's Mansion 3 es un videojuego de acción y aventura para Nintendo Switch. Su precio es de Q550.00.",
            "luigi's Mansion 3": "Luigi's Mansion 3 es un videojuego de acción y aventura para Nintendo Switch. Su precio es de Q550.00.",
            "Super Smash Bros Ultimate": "Super Smash Bros. Ultimate es un videojuego de lucha para Nintendo Switch. Su precio es de Q600.00.",
            "¿Cuál es el precio de The Legend of Zelda Breath of the Wild?": "El precio de The Legend of Zelda: Breath of the Wild es de Q600.00.",
            "¿Cuál es el precio de Splatoon 2?": "El precio de Splatoon 2 es de Q550.00.",
            "splatoon": "El precio de Splatoon 2 es de Q550.00.",
            "splatoon 2": "El precio de Splatoon 2 es de Q550.00.",
            "Splatoon 2": "El precio de Splatoon 2 es de Q550.00.",
            "¿Cuál es el precio de Luigi's Mansion 3?": "El precio de Luigi's Mansion 3 es de Q550.00.",
            "¿Cuál es el precio deSuper Smash Bros Ultimate?": "El precio de Super Smash Bros. Ultimate es de Q600.00.",
            "¿Puedes darme más detalles sobre The Legend of Zelda Breath of the Wild?": "The Legend of Zelda: Breath of the Wild es un emocionante videojuego de acción y aventura para Nintendo Switch.",
            "¿Puedes darme más detalles sobre Splatoon 2?": "Splatoon 2 es un divertido juego de disparos en tercera persona para Nintendo Switch.",
            "¿Puedes darme más detalles sobre Luigi's Mansion 3?": "Luigi's Mansion 3 es un emocionante videojuego de acción y aventura para Nintendo Switch.",
            "¿Puedes darme más detalles sobre Super Smash Bros Ultimate?": "Super Smash Bros. Ultimate es un emocionante juego de lucha para Nintendo Switch.",
            "DEFAULT_MESSAGE": "¡Hola! Soy el chatbot de la tienda. Puedo proporcionarte información sobre nuestros productos. Prueba preguntándome sobre algún juego o su precio, por ejemplo: '¿Cuál es el precio de Zelda?'"
        };

        function sendMessage() {
            var userInput = document.getElementById('user-input').value;
            if (userInput.trim() === '') {
                alert('Por favor, escribe una pregunta.');
                return;
            }

            displayMessage('user', userInput);
            document.getElementById('user-input').value = '';

            var respuesta = buscarRespuesta(userInput);

            if (respuesta) {
                displayMessage('bot', respuesta);
            } else {
                displayMessage('bot', 'Lo siento, no tengo información sobre esa pregunta.');
            }
        }

        function buscarRespuesta(pregunta) {
            pregunta = pregunta.toLowerCase();
            for (var key in preguntasRespuestas) {
                if (pregunta.includes(key.toLowerCase())) {
                    return preguntasRespuestas[key];
                }
            }
            return preguntasRespuestas["DEFAULT_MESSAGE"];
        }

        function displayMessage(sender, message) {
            var outputDiv = document.getElementById('output');
            var messageDiv = document.createElement('div');
            messageDiv.className = sender + '-message';
            messageDiv.textContent = message;
            outputDiv.appendChild(messageDiv);

            if (sender === 'bot') {
                const cartCount = (typeof $_SESSION['CARRITO'] !== 'undefined' && $_SESSION['CARRITO'] !== null) ?
                    $_SESSION['CARRITO'].length :
                    0;
                const cartCountMessage = `Tienes ${cartCount} productos en tu carrito.`;
                var cartCountDiv = document.createElement('div');
                cartCountDiv.className = 'bot-message';
                cartCountDiv.textContent = cartCountMessage;
                outputDiv.appendChild(cartCountDiv);
            }

            outputDiv.scrollTop = outputDiv.scrollHeight;
        }

        function toggleChat() {
            var chatbotContainer = document.getElementById('chatbot-container');
            chatbotContainer.classList.toggle('closed');
        }

        function handleKeyDown(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                sendMessage();
            }
        }

        document.getElementById("user-input").addEventListener("keydown", handleKeyDown);

    </script>
</body>

</html>

