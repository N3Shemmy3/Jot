export default defineEventHandler(async (event) => {
  const config = useRuntimeConfig();
  const phpServerUrl = config.phpServerUrl; // Ensure this is set in your runtime config

  // Parse the request body
  const body = await readBody(event);

  try {
    // Determine the action (login, logout, or signup)
    const action = body.action;

    if (action === "login" || action === "signup") {
      // Send login or signup request to PHP API
      const response = await fetch(phpServerUrl, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({
          action: action, // Either 'login' or 'signup'
          username: body.username,
          password: body.password,
        }),
      });

      // Parse the response from the PHP API
      const result = await response.json();
      return result;
    } else {
      return { error: "Invalid action." };
    }
  } catch (error) {
    // Handle errors
    return { error: (error as Error).message };
  }
});
