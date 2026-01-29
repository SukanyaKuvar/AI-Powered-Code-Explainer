System Architecture & Technical Decisions :
This application is a lightweight PHP web service that analyzes user-submitted source code and generates concise explanations using a large language model (LLM).
The system follows a simple request–response architecture:
  1) The frontend submits code via an HTTP POST request.
  2) A PHP backend validates the input and constructs a constrained prompt.
  3) The backend calls the Groq Chat Completion API using cURL.
  4) The AI-generated explanation is validated, sanitized, and stored in the user’s session.
  5) The user is redirected back to the main page using the POST-Redirect-GET pattern to prevent duplicate submissions.

Key technical decisions include:
  1) Sessions instead of a database for lightweight state management and simplicity.
  2) Strict response validation to handle API errors and unexpected payloads safely.
  3) Low temperature and prompt constraints to prioritize accuracy over creativity.
  4) Output sanitization (htmlspecialchars) to prevent XSS vulnerabilities.
  5) Fail-fast error handling to avoid propagating unreliable AI output.

This design keeps the system minimal, predictable, and easy to reason about while integrating AI safely.

AI Tools Used & Why : 
The main AI integration uses Groq’s OpenAI-compatible API with the llama-3.1-8b-instant model.
I selected this setup because:
  1) It’s very fast, which is important for a good user experience.
  2) The model follows instructions well, especially with constrained prompts.
  3) The OpenAI-style API makes it easy to swap models later if needed.
To reduce hallucinations and keep explanations accurate:
  1) The prompt clearly tells the model not to guess and to say when something can’t be determined.
  2) The model temperature is set low (0.2) to reduce randomness.
  3) The system treats AI output as untrusted until it’s validated and sanitized.

Note on OpenAI Usage :
I initially planned to use OpenAI’s API, and the prompt and request structure are fully compatible with it.
However, OpenAI requires completing a payment setup before making API calls, so for this project I used Groq as a drop-in alternative to keep development and testing simple.
