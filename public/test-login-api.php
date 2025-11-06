<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Test Login API</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Test Login API</h1>

        <div class="mb-4">
            <button onclick="testLoginAPI()" class="bg-blue-500 text-white px-4 py-2 rounded">
                Test Login API
            </button>
        </div>

        <div id="result" class="mt-4"></div>
    </div>

    <script>
        async function testLoginAPI() {
            const resultDiv = document.getElementById('result');
            resultDiv.innerHTML = '<p class="text-gray-600">Testing...</p>';

            try {
                console.log('Sending request to /api/auth.php?action=login');

                const response = await fetch('/api/auth.php?action=login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    credentials: 'include',
                    body: JSON.stringify({
                        email: 'demo@allergy.tr',
                        password: 'password123',
                        remember: false
                    })
                });

                console.log('Response status:', response.status);
                console.log('Response headers:', response.headers);

                const contentType = response.headers.get('content-type');
                console.log('Content-Type:', contentType);

                const text = await response.text();
                console.log('Response text:', text);

                resultDiv.innerHTML = `
                    <div class="border rounded p-4">
                        <h3 class="font-bold mb-2">Response Status: ${response.status}</h3>
                        <h3 class="font-bold mb-2">Content-Type: ${contentType}</h3>
                        <h3 class="font-bold mb-2">Response Body:</h3>
                        <pre class="bg-gray-100 p-2 rounded overflow-auto">${text}</pre>
                    </div>
                `;

                // Try to parse as JSON
                try {
                    const data = JSON.parse(text);
                    resultDiv.innerHTML += `
                        <div class="border rounded p-4 mt-4">
                            <h3 class="font-bold mb-2 text-green-600">✅ Valid JSON:</h3>
                            <pre class="bg-gray-100 p-2 rounded overflow-auto">${JSON.stringify(data, null, 2)}</pre>
                        </div>
                    `;
                } catch (e) {
                    resultDiv.innerHTML += `
                        <div class="border rounded p-4 mt-4 border-red-500">
                            <h3 class="font-bold mb-2 text-red-600">❌ NOT Valid JSON</h3>
                            <p class="text-sm text-red-600">${e.message}</p>
                        </div>
                    `;
                }
            } catch (error) {
                console.error('Fetch error:', error);
                resultDiv.innerHTML = `
                    <div class="border border-red-500 rounded p-4">
                        <h3 class="font-bold text-red-600 mb-2">❌ Fetch Error:</h3>
                        <p class="text-sm">${error.message}</p>
                    </div>
                `;
            }
        }
    </script>
</body>
</html>
