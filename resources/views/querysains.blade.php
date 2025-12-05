<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanya AI</title>

<meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f7f7f7;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        textarea {
            width: 100%;
            height: 120px;
            resize: none;
            padding: 10px;
            font-size: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
        }

        textarea:focus {
            border-color: #6e9fff;
        }

        button {
            margin-top: 15px;
            padding: 12px 20px;
            background: #4B7BEC;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #3867d6;
        }

        .result-box, .error-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            line-height: 1.6;
        }

        .result-box {
            background: #e9f5ff;
            border-left: 4px solid #4B7BEC;
        }

        .error-box {
            background: #ffe6e6;
            border-left: 4px solid #ff4d4d;
            color: #d60000;
        }
    </style>
</head>

<body>

    <h1>Tanya AI</h1>

    <div class="container">
        <form id="aiForm">
            <label><strong>Tulis Pertanyaan Kamu:</strong></label>
            <textarea id="question" placeholder="Contoh: Jelaskan apa itu robotika cerdas..."></textarea>
            <button type="submit">Kirim ke AI</button>
        </form>

        <div id="response-area"></div>
    </div>

    <script>
        async function queryToFlowise(question) {
            const response = await fetch("/querysains/ask", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-Requested-With": "XMLHttpRequest",
        "Accept": "application/json",
        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
    },
    body: JSON.stringify({ question })
});


            return await response.json();
        }

        document.addEventListener("DOMContentLoaded", function () {
            const form = document.getElementById("aiForm");
            const textarea = document.getElementById("question");
            const responseArea = document.getElementById("response-area");

            form.addEventListener("submit", async function (e) {
                e.preventDefault();

                const prompt = textarea.value.trim();

                if (prompt === "") {
                    responseArea.innerHTML =
                        `<div class="error-box"><strong>Error:</strong> Pertanyaan tidak boleh kosong.</div>`;
                    return;
                }

                responseArea.innerHTML =
                    `<div class="result-box"><strong>Sedang memproses...</strong></div>`;

                try {
                    const data = await queryToFlowise(prompt);

                    responseArea.innerHTML = `
                        <div class="result-box">
                            <strong>Jawaban:</strong><br><br>
                            ${data.text || data.answer || JSON.stringify(data)}
                        </div>
                    `;

                } catch (err) {
                    responseArea.innerHTML =
                        `<div class="error-box"><strong>Error:</strong> Gagal memproses AI.</div>`;
                    console.error(err);
                }
            });
        });
    </script>

</body>
</html>
