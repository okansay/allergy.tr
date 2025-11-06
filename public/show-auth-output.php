<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Auth.php Output</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Auth.php Raw Output</h1>
        <button onclick="testAuth()" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">
            Test Auth.php
        </button>
        <div id="output"></div>
    </div>

    <script>
        async function testAuth() {
            const outputDiv = document.getElementById('output');
            outputDiv.innerHTML = '<p>Loading...</p>';

            try {
                const response = await fetch('/api/auth.php?action=login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        email: 'demo@allergy.tr',
                        password: 'password123'
                    })
                });

                const text = await response.text();

                outputDiv.innerHTML = `
                    <div class="mb-4">
                        <h2 class="font-bold text-lg">Status: ${response.status}</h2>
                    </div>
                    <div class="border rounded p-4 bg-gray-50">
                        <h3 class="font-bold mb-2">Raw Response (first 2000 chars):</h3>
                        <pre class="whitespace-pre-wrap text-xs">${escapeHtml(text.substring(0, 2000))}</pre>
                    </div>
                    ${text.length > 2000 ? `<p class="mt-2 text-sm text-gray-600">... (${text.length} total characters)</p>` : ''}
                `;
            } catch (error) {
                outputDiv.innerHTML = `<p class="text-red-600">Error: ${error.message}</p>`;
            }
        }

        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }
    </script>
</body>
</html>
