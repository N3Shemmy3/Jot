export default defineEventHandler(async (event) => {
  // Get the PHP server URL from runtime config
  const config = useRuntimeConfig();
  const phpServerUrl = config.phpServerUrl;

  try {
    // Fetch the response from the PHP server
    const response = await fetch(phpServerUrl);

    // Parse the response as text
    const result = await response.text();

    // Return the result
    return { result };
  } catch (error) {
    // Handle errors
    return { error: (error as Error).message };
  }
});
