export default defineNuxtRouteMiddleware((to) => {
  // Skip middleware on the server
  if (import.meta.server) return;

  // Check if the user is logged in
  const user = useCookie("loggedInUser").value;

  if (!user) {
    return navigateTo("/auth"); // Redirect to the sign-in page if not logged in
  }
});
