<script setup lang="ts">
import { useForm } from "vee-validate";
import { toTypedSchema } from "@vee-validate/zod";
import * as z from "zod";

const formSchema = toTypedSchema(
  z.object({
    username: z.string().min(2).max(50),
  })
);
const form = useForm({
  validationSchema: formSchema,
});
const onSubmit = form.handleSubmit((values) => {
  console.log("Form submitted!", values);
});
</script>

<template>
  <Section class="md:flex-row gap-4 *:px-4 *:md:p-8 *:md:-mt-14">
    <div class="hidden md:flex w-full h-full bg-muted xl:bg-transparent">
      <div class="mt-auto xl:my-auto xl:pt-[10vh]">
        <h1
          class="text-foreground scroll-m-20 text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight"
        >
          Jot
        </h1>
        <p class="w-full max-sm:text-sm leading-7 [&:not(:first-child)]:mt-4">
          Lets jotting down those beautiful thoughts.
        </p>
      </div>
    </div>
    <div class="w-full h-full flex py-14 md:p-0 md:items-center">
      <form class="w-full h-fit md:max-w-md space-y-6" @submit="onSubmit">
        <div class="md:text-center space-y-0 pt-20">
          <h4
            class="scroll-m-20 text-foreground text-2xl font-semibold tracking-tight"
          >
            Sign in
          </h4>
          <p class="text-sm leading-7 [&:not(:first-child)]:mt-6">
            Welcome back.
          </p>
        </div>
        <FormField v-slot="{ componentField }" name="Username">
          <FormItem>
            <FormControl>
              <Input placeholder="Username" v-bind="componentField" />
            </FormControl>
            <FormDescription />
            <FormMessage />
          </FormItem>
        </FormField>

        <FormField v-slot="{ componentField }" name="Password">
          <FormItem>
            <FormControl>
              <Input placeholder="Password" v-bind="componentField" />
            </FormControl>
            <FormDescription />
            <FormMessage />
          </FormItem>
        </FormField>
        <div>
          <Button class="w-full shadow" type="submit"> Sign in </Button>
          <div class="flex items-center py-4 space-x-2">
            <hr class="w-full border" />
            <span class="text-[12px]">or</span>
            <hr class="w-full border" />
          </div>
          <NuxtLink to="/auth/signup">
            <Button variant="outline" class="w-full shadow" type="submit">
              Sign up
            </Button>
          </NuxtLink>
        </div>
        <p class="text-center text-[12px]">
          By continuing, you agree to our
          <a href="/">Terms of Service</a> and <a href="/">Privacy Policy</a>.
        </p>
      </form>
    </div>
  </Section>
</template>
<style scoped>
a {
  color: var(--foreground);
  text-decoration: underline;
}
</style>
