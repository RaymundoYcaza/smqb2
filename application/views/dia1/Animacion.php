<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Somos Más que Banano - Semana de la Calidad</title>
    <!-- Incluyendo Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css'); ?>">
</head>

<body>
    <div id="preloader">
        <div class="loader-text">Cargando...</div>
    </div>
    <video id="video-background" type="video/mp4"></video>
    <div id="overlay" style="background-color: aquamarine">
        <button id="button">Reproducir Video</button>
    </div>
    <div id="end-overlay" class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <img src="<?= base_url('assets/images/platano.png'); ?>" alt="Plátano" class="img-fluid" />
            </div>
            <div class="col-md-6 text-center">
                <h1>Día 1: Plátano</h1>
                <p>
                    El plátano, una de las frutas más consumidas en todo el mundo, es
                    conocido por su sabor dulce y su versatilidad. Se puede disfrutar de
                    diversas formas: frito, asado, en batidos o incluso como base para
                    postres. Es una excelente fuente de energía y potasio.
                </p>
                <button class="btn-orange" id="start-quiz">
                    Contesta las preguntas
                </button>
            </div>
        </div>
    </div>
    <div id="quiz-overlay" class="text-center">
        <h3 id="quiz-question">Pregunta</h3>
        <div id="quiz-options" class="text-left"></div>
        <div class="quiz-buttons">
            <button class="btn-prev" id="prev-btn">Regresar</button>
            <button class="btn-next" id="next-btn">Siguiente</button>
            <button class="btn-submit" id="submit-btn" style="display: none">
                Enviar
            </button>
        </div>
    </div>

    <div id="results-overlay" style="display: none">
        <div class="results-content">
            <h1 id="results-score"></h1>
            <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h4>
            <button id="continue-btn" class="btn">Continuar</button>
        </div>
    </div>

    <div id="nextaction-overlay" style="display: none">
        <div class="results-content">
            <h1>Vuelve mañana</h1>
            <h4>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h4>
        </div>
    </div>

    <!-- Incluyendo Bootstrap JS y dependencias -->
    <script src="<?= base_url('assets/js/jquery-3.5.1.slim.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/popper.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <!-- <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script> -->
    <script>
        const video = document.getElementById("video-background");
        const overlay = document.getElementById("overlay");
        const button = document.getElementById("button");
        const endOverlay = document.getElementById("end-overlay");
        const preloader = document.getElementById("preloader");
        const quizOverlay = document.getElementById("quiz-overlay");
        const startQuizButton = document.getElementById("start-quiz");

        let selectedAnswers = {}; // Objeto para guardar las respuestas seleccionadas

        // const questions = [{
        //         text: "¿Cuál es el principal nutriente del plátano?",
        //         options: ["Potasio", "Proteína", "Vitamina C"],
        //     },
        //     {
        //         text: "¿Cómo se puede consumir el plátano?",
        //         options: ["Asado", "Congelado", "Todo lo anterior"],
        //     },
        //     {
        //         text: "¿De qué color es el plátano maduro?",
        //         options: ["Amarillo", "Verde", "Rojo"],
        //     },
        // ];

        function shuffle(array) {
            for (let i = array.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [array[i], array[j]] = [array[j], array[i]];
            }
        }

        const doleSourceQuestions = [{
                text: "¿Cuál es el principal nutriente del plátano?",
                options: ["Potasio", "Proteína", "Vitamina C"],
            },
            {
                text: "¿Cómo se puede consumir el plátano?",
                options: ["Asado", "Congelado", "Todo lo anterior"],
            },
            {
                text: "¿De qué color es el plátano maduro?",
                options: ["Amarillo", "Verde", "Rojo"],
            },
        ];

        // Aleatoriza las preguntas
        const questions = [...doleSourceQuestions];
        shuffle(questions);

        // Aleatoriza las opciones de cada pregunta
        questions.forEach(question => shuffle(question.options));

        let currentQuestionIndex = 0;
        const quizQuestion = document.getElementById("quiz-question");
        const quizOptions = document.getElementById("quiz-options");
        const prevBtn = document.getElementById("prev-btn");
        const nextBtn = document.getElementById("next-btn");
        const submitBtn = document.getElementById("submit-btn");

        // function shuffle(array) {
        //     return array.sort(() => Math.random() - 0.5);
        // }

        function renderQuestion() {
            const question = questions[currentQuestionIndex];

            // Limpiar el contenido del cuestionario
            quizOverlay.innerHTML = "";

            // Crear el contenedor para la pregunta y las opciones
            const questionContainer = document.createElement("div");
            questionContainer.id = "question-container";
            questionContainer.classList.add("slide-in");

            // Agregar el contenido de la pregunta
            questionContainer.innerHTML = `
      <h3 id="quiz-question">${question.text}</h3>
      <div id="quiz-options">
          ${question.options
            .map(
              (option) => `
                  <div>
                      <label>
                          <input type="radio" name="quiz-option" value="${option}" ${
                            selectedAnswers[currentQuestionIndex] === option
                              ? "checked"
                              : ""
                          }> ${option}
                      </label>
                  </div>`
            )
            .join("")}
      </div>
      <div class="quiz-buttons">
          <button id="prev-btn" class="btn-prev" ${
            currentQuestionIndex === 0 ? 'style="display:none;"' : ""
          }>Regresar</button>
          <button id="next-btn" class="btn-next" ${
            currentQuestionIndex < questions.length - 1
              ? ""
              : 'style="display:none;"'
          }>Siguiente</button>
          <button id="submit-btn" class="btn-submit" ${
            currentQuestionIndex === questions.length - 1
              ? ""
              : 'style="display:none;"'
          }>Enviar</button>
      </div>
  `;

            // Insertar el contenido en el overlay del cuestionario
            quizOverlay.appendChild(questionContainer);

            // Configurar animación
            questionContainer.addEventListener("animationend", () => {
                questionContainer.classList.remove("slide-in");
            });

            // Agregar eventos a los botones
            setupNavigationButtons();

            // Registrar la respuesta seleccionada
            const options = document.querySelectorAll('input[name="quiz-option"]');
            options.forEach((option) => {
                option.addEventListener("change", (event) => {
                    selectedAnswers[currentQuestionIndex] = event.target.value;
                });
            });
        }

        function setupNavigationButtons() {
            // Seleccionar los botones dinámicamente después de renderizar
            const prevBtn = document.getElementById("prev-btn");
            const nextBtn = document.getElementById("next-btn");
            const submitBtn = document.getElementById("submit-btn");

            // Evento para el botón "Regresar"
            if (prevBtn) {
                prevBtn.onclick = () => {
                    changeQuestion(-1);
                };
            }

            // Evento para el botón "Siguiente"
            if (nextBtn) {
                nextBtn.onclick = () => {
                    changeQuestion(1);
                };
            }

            // Evento para el botón "Enviar"
            if (submitBtn) {
                submitBtn.onclick = async () => {

                    // Obtener las respuestas seleccionadas
                    const selectedAnswers = getSelectedAnswers();

                    console.log(selectedAnswers);

                    // Verifica si hay preguntas sin responder
                    const unansweredQuestions = questions.filter(
                        (_, index) => !selectedAnswers[index]
                    );

                    if (unansweredQuestions.length > 6) {
                        alert("Por favor, responde todas las preguntas antes de enviar.");
                        return;
                    }


                    // Realizar la consulta al endpoint
                    const userScore = await getUserScore(selectedAnswers);

                    // Verificar si se obtuvo el puntaje
                    if (userScore !== null) {
                        // Mostrar el overlay de resultados
                        const resultsOverlay = document.getElementById("results-overlay");
                        const resultsScore = document.getElementById("results-score");
                        resultsOverlay.style.display = "flex"; // Mostrar el overlay
                        resultsScore.innerHTML = `¡Has obtenido <br /><span class="points">${userScore}</span><br /> puntos!`;

                        const nextactionOverlay =
                            document.getElementById("nextaction-overlay");

                        // Configurar el botón "Continuar"
                        const continueBtn = document.getElementById("continue-btn");
                        continueBtn.onclick = () => {
                            resultsOverlay.style.display = "none"; // Ocultar el overlay
                            quizOverlay.style.display = "none"; // Ocultar el cuestionario
                            nextactionOverlay.style.display = "flex";
                        };
                    } else {
                        alert(
                            "Hubo un error al calcular tu puntaje. Por favor, inténtalo de nuevo."
                        );
                    }
                };
            }
        }

        function changeQuestion(direction) {
            // Actualizar el índice de la pregunta
            currentQuestionIndex += direction;

            // Validar que no exceda los límites
            if (currentQuestionIndex < 0) currentQuestionIndex = 0;
            if (currentQuestionIndex >= questions.length)
                currentQuestionIndex = questions.length - 1;

            // Renderizar la nueva pregunta
            renderQuestion();
        }

        function setVideoSource() {
            video.src =
                window.innerWidth <= 768 ?
                "<?= base_url('assets/videos/dummy-video_16-9.mp4'); ?>" :
                "<?= base_url('assets/videos/dummy-video_9-16.mp4'); ?>";
        }

        setVideoSource();

        video.addEventListener("canplaythrough", () => {
            preloader.style.display = "none";
            video.style.display = "block";
        });

        button.addEventListener("click", () => {
            video.play();
            overlay.style.display = "none";
        });

        video.addEventListener("ended", () => {
            endOverlay.style.display = "flex";
        });

        startQuizButton.addEventListener("click", () => {
            endOverlay.style.display = "none"; // Ocultar el overlay de finalización del video
            quizOverlay.style.display = "flex"; // Mostrar el cuestionario
            renderQuestion(); // Renderizar la primera pregunta
        });

        prevBtn.addEventListener("click", () => {
            if (currentQuestionIndex > 0) changeQuestion(-1);
        });

        nextBtn.addEventListener("click", () => {
            if (currentQuestionIndex < questions.length - 1) changeQuestion(1);
        });

        submitBtn.addEventListener("click", async () => {
            // Obtener las respuestas seleccionadas
            const selectedAnswers = getSelectedAnswers();

            // Realizar la consulta al endpoint
            const userScore = await getUserScore(selectedAnswers);

            // Verificar si se obtuvo el puntaje
            if (userScore !== null) {
                alert(`¡Gracias por participar! Has obtenido ${userScore} puntos.`);
            } else {
                alert(
                    "Hubo un error al calcular tu puntaje. Por favor, inténtalo de nuevo."
                );
            }

            // Aquí puedes agregar cualquier otra lógica que estuviera en el segundo listener
            quizOverlay.style.display = "none"; // Ocultar el cuestionario
        });

        async function getUserScore() {
            // const randomValue = Math.floor(Math.random() * (100 - 50 + 1)) + 50;
            // return randomValue;
            try {
                // Realizar la solicitud al endpoint
                const response = await fetch(
                    "http://192.168.0.5:3001/validateAnswers", {
                        method: "POST", // Cambia esto a POST si el endpoint lo requiere
                        headers: {
                            "Content-Type": "application/json", // Ajustar si el endpoint requiere otros encabezados
                        },
                        body: JSON.stringify({
                            answers: getSelectedAnswers()
                        }),
                    }
                );

                console.warn(response);

                if (!response.ok) {
                    throw new Error(`Error al obtener el puntaje: ${response.status}`);
                }

                const data = await response.json(); // Parsear la respuesta JSON
                return data.value; // Devolver el valor del puntaje
            } catch (error) {
                console.error("Error al obtener el puntaje:", error);
                return null; // En caso de error, devolver null
            }
        }

        function getSelectedAnswers() {
            const selectedOptions = document.querySelectorAll(
                'input[name="quiz-option"]:checked'
            );
            return Array.from(selectedOptions).map((option) => option.value);
        }
    </script>
</body>

</html>