<h1>AI-Powered Code Explainer</h1>
<h2>System Architecture & Technical Decisions :</h2>
This application is a lightweight PHP web service that analyzes user-submitted source code and generates concise explanations using a large language model (LLM).</br>
<b>The system follows a simple request–response architecture :</b></br>
  <ul>
  <li>The frontend submits code via an HTTP POST request.</li>
  <li>A PHP backend validates the input and constructs a constrained prompt.</li>
  <li>The backend calls the Groq Chat Completion API using cURL.</li>
  <li>The AI-generated explanation is validated, sanitized, and stored in the user’s session.</li>
  <li>The user is redirected back to the main page using the POST-Redirect-GET pattern to prevent duplicate submissions.</li>
  </ul>

<b>Key technical decisions include :</b></br>
  <ul>
  <li>Sessions instead of a database for lightweight state management and simplicity.</li>
  <li>Strict response validation to handle API errors and unexpected payloads safely.</li>
  <li>Low temperature and prompt constraints to prioritize accuracy over creativity.</li>
  <li>Output sanitization (htmlspecialchars) to prevent XSS vulnerabilities.</li>
  <li>Fail-fast error handling to avoid propagating unreliable AI output.</li>
  </ul>

This design keeps the system minimal, predictable, and easy to reason about while integrating AI safely.

<h2>AI Tools Used & Why :</h2> 
The main AI integration uses Groq’s OpenAI-compatible API with the llama-3.1-8b-instant model.</br>
<b>I selected this setup because :</b>
  <ul>
  <li>It’s very fast, which is important for a good user experience.</li>
  <li>The model follows instructions well, especially with constrained prompts.</li>
  <li>The OpenAI-style API makes it easy to swap models later if needed.</li>
  </ul>
<b>To reduce hallucinations and keep explanations accurate :</b>
  <ul>
  <li>The prompt clearly tells the model not to guess and to say when something can’t be determined.</li>
  <li>The model temperature is set low (0.2) to reduce randomness.</li>
  <li>The system treats AI output as untrusted until it’s validated and sanitized.</li>
  </ul>

<h3>Note on OpenAI Usage :</h3>
I initially planned to use OpenAI’s API, and the prompt and request structure are fully compatible with it.
However, OpenAI requires completing a payment setup before making API calls, so for this project I used Groq as a drop-in alternative to keep development and testing simple.
