<?php
session_start();

$apiKey = "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"; // no quotes inside the key

$code = $_POST['code'] ?? '';
if (trim($code) === '') {
    header("Location: index.php");
    exit;
}

$prompt = <<<PROMPT
Explain the following code in plain English.
Keep it accurate, concise (2–4 sentences), and do not guess behavior
that is not explicitly present in the code.

If something cannot be determined from the code alone, say so.

Code:
$code
PROMPT;

$data = [
    "model" => "llama-3.1-8b-instant",
    "messages" => [
        [
            "role" => "system",
            "content" => "You are a senior software engineer explaining code accurately."
        ],
        [
            "role" => "user",
            "content" => $prompt
        ]
    ],
    "temperature" => 0.2
];

$ch = curl_init("https://api.groq.com/openai/v1/chat/completions");

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ],

    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false
]);

$response = curl_exec($ch);

if ($response === false) {
    die("cURL Error: " . curl_error($ch));
}

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$result = json_decode($response, true);

if ($httpCode !== 200) {
    die("HTTP Error $httpCode:<pre>" . print_r($result, true) . "</pre>");
}

if (isset($result['error'])) {
    die("Groq API Error: " . $result['error']['message']);
}

if (!isset($result['choices'][0]['message']['content'])) {
    die("Unexpected API response:<pre>" . print_r($result, true) . "</pre>");
}

$explanation = $result['choices'][0]['message']['content'];

$_SESSION['history'][] = [
    "code" => htmlspecialchars($code),
    "explanation" => htmlspecialchars($explanation)
];

header("Location: index.php");
exit;


