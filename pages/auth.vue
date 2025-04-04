<script setup lang="ts">
import { ref } from "vue";
import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";
import { useRouter } from "vue-router";
import { useFetch, useCookie } from "#app"; // Nuxt's composables for making API requests and handling cookies

// Define the form validation schema
const formSchema = toTypedSchema(
  z.object({
    username: z.string().min(2).max(50),
    password: z.string().min(6).max(50), // Add password validation
  })
);

// Initialize the form
const form = useForm({
  validationSchema: formSchema,
});

// Use the router for navigation
const router = useRouter();

// State to toggle between Sign In and Sign Up
const isSignIn = ref(true);

// Reactive state for error messages
const errorMessages = ref<string[]>([]);
const showErrorDialog = ref(false);

// Handle form submission
const onSubmit = form.handleSubmit(async (values) => {
  try {
    // Determine the action based on the current mode
    const action = isSignIn.value ? "login" : "signup";

    // Make a POST request to the /api/auth endpoint
    const { data, error } = await useFetch("/api/auth", {
      method: "POST",
      body: {
        action, // Either 'login' or 'signup'
        username: values.username,
        password: values.password,
      },
    });

    if (error.value) {
      console.error(`${action} failed:`, error.value.message);
      errorMessages.value = [`${action} failed: ${error.value.message}`];
      showErrorDialog.value = true; // Show the error dialog
    } else if (data.value?.status === "success") {
      console.log(`${action} successful:`, data.value.message);

      // Save the logged-in user instance in a cookie
      const userCookie = useCookie("loggedInUser");
      userCookie.value = JSON.stringify({
        username: values.username,
        password: values.password,
      });

      // Redirect to the notes page after successful login/signup
      router.push("/notes");
    } else {
      console.error("Unexpected response:", data.value);
      errorMessages.value = [`${action} failed: ${data.value?.message}`];
      showErrorDialog.value = true; // Show the error dialog
    }
  } catch (err) {
    console.error("Error during submission:", err);
    errorMessages.value = ["An error occurred. Please try again."];
    showErrorDialog.value = true; // Show the error dialog
  }
});

// Logout function
const logout = () => {
  const userCookie = useCookie("loggedInUser");
  userCookie.value = null; // Clear the cookie
  router.push("/auth"); // Redirect to the sign-in page
};
</script>

<template>
  <Section class="*:px-4 *:md:p-8">
    <form class="w-full h-fit md:max-w-md md:m-auto" @submit="onSubmit">
      <div class="md:text-center space-y-0">
        <h4
          class="scroll-m-20 text-foreground text-2xl font-semibold tracking-tight"
        >
          {{ isSignIn ? "Sign in" : "Create an account" }}
        </h4>
        <p class="text-sm leading-7 [&:not(:first-child)]:mt-6">
          {{
            isSignIn
              ? "Welcome back."
              : "Create an account to start jotting down your thoughts and access them anytime, anywhere."
          }}
        </p>
      </div>
      <FormField v-slot="{ componentField }" name="username">
        <FormItem>
          <FormControl>
            <Input placeholder="Username" v-bind="componentField" />
          </FormControl>
          <FormDescription />
          <FormMessage />
        </FormItem>
      </FormField>

      <FormField v-slot="{ componentField }" name="password">
        <FormItem>
          <FormControl>
            <Input
              type="password"
              placeholder="Password"
              v-bind="componentField"
            />
          </FormControl>
          <FormDescription />
          <FormMessage />
        </FormItem>
      </FormField>
      <div>
        <Button class="w-full shadow" type="submit">
          {{ isSignIn ? "Sign in" : "Sign up" }}
        </Button>
        <div class="flex items-center py-4 space-x-2">
          <hr class="w-full border" />
          <span class="text-[12px]">or</span>
          <hr class="w-full border" />
        </div>
        <Button
          variant="outline"
          class="w-full shadow"
          type="button"
          @click="isSignIn = !isSignIn"
        >
          {{ isSignIn ? "Sign up" : "Sign in" }}
        </Button>
      </div>
      <p class="text-center text-[12px]">
        By continuing, you agree to our
        <a href="/">Terms of Service</a> and <a href="/">Privacy Policy</a>.
      </p>
    </form>

    <!-- Error Dialog -->
    <AlertDialog :open="showErrorDialog">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Authentication Error</AlertDialogTitle>
          <AlertDialogDescription>
            <ul>
              <li v-for="(error, index) in errorMessages" :key="index">
                {{ error }}
              </li>
            </ul>
          </AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogCancel @click="showErrorDialog = false"
            >Close</AlertDialogCancel
          >
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  </Section>
</template>

<style scoped>
a {
  color: var(--foreground);
  text-decoration: underline;
}
</style>
