<script setup lang="ts">
const { $event } = useNuxtApp();

const toggleCommand = () => {
  $event("toggleCommand");
};
const kanji = ref("やってみて！");
</script>
<template>
  <div class="flex flex-col gap-4">
    <section
      id="hero-section"
      class="relative w-full h-dvh xl:h-fit flex flex-col items-center gap-4 *:px-4 *:md:px-8"
    >
      <div
        id="hero-section-text"
        class="w-full h-fit flex items-center justify-center flex-col"
      >
        <div
          class="md:max-w-screen-sm flex flex-col justify-center text-center py-[10vh]"
        >
          <h1
            class="text-foreground scroll-m-20 text-3xl md:text-5xl lg:text-6xl font-extrabold tracking-tight"
          >
            The simplest way <br />
            to keep notes
          </h1>
          <p class="w-full max-sm:text-sm leading-7 [&:not(:first-child)]:mt-4">
            Jot down your thoughts, and let them follow you wherever you go.
          </p>
          <div class="flex gap-4 items-center justify-center">
            <Button class="w-fit mt-6 rounded-full" @click="toggleCommand()">
              <p>Start Taking Notes</p>
              <LucideArrowRight class="size-6" />
            </Button>
          </div>
        </div>
      </div>
      <div
        id="hero-section-image"
        class="w-full h-fit flex items-center justify-center px-4 md:px-8"
      >
        <NuxtImg
          src="/screenshot.png"
          alt="image"
          class="w-full md:max-w-screen-sm object-contain rounded-[--radius] aspect-video transition-all duration-300"
          :custom="true"
          v-slot="{ src, isLoaded, imgAttrs }"
        >
          <img v-if="isLoaded" v-bind="imgAttrs" :src="src" />

          <!-- Show a placeholder while loading -->
          <div
            v-else
            alt="placeholder"
            :v-bind="imgAttrs"
            class="w-full md:max-w-screen-sm aspect-video bg-secondary rounded-[--radius] flex items-center justify-center"
          >
            <LucideLoaderCircle
              class="size-8 text-muted-foreground animate-spin"
            />
          </div>
        </NuxtImg>
      </div>
    </section>

    <section
      class="w-full h-dvh flex gap-4 md:justify-between px-4 md:px-8"
    ></section>
    <section>
      <div
        v-for="n in 12"
        class="hidden md:flex w-14 h-full bg-muted opacity-75"
      ></div>
      <div
        v-for="n in 6"
        class="md:hidden w-14 h-full bg-muted opacity-75"
      ></div>
    </section>
  </div>
</template>
<style scoped></style>
