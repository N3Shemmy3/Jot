<script setup lang="ts">
definePageMeta({
  middleware: "notes", // Apply the auth middleware to this page
});
</script>

<template>
  <div class="flex flex-col gap-4 px-4 md:px-8">
    <div class="flex items-center justify-between py-20 pb-10">
      <h2
        class="scroll-m-20 text-4xl font-semibold tracking-tight transition-colors first:mt-0"
      >
        Notes
      </h2>

      <Button class="hidden md:flex py-1 px-2 rounded">
        <LucidePlus :size="24" />
        <p>New note</p>
      </Button>
    </div>
    <ul
      class="list-none grid gap-4"
      style="
        grid-area: span;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      "
    >
      <LazyCard
        v-for="n in 100"
        :key="n"
        class="relative w-full h-full group transition-all duration-300 hover:shadow hover:bg-background cursor-pointer"
      >
        <Button
          :id="n + '-button'"
          variant="ghost"
          class="absolute right-4 top-4 hidden h-8 w-8 p-0 transition-all duration-1000 group-hover:md:flex"
        >
          <LucideTrash class="w-4 h-4" />
        </Button>
        <CardHeader class="flex-row justify-between items-center p-4">
          <CardTitle class="m-0 text-[1.2rem] font-semibold"
            >Note title</CardTitle
          >
        </CardHeader>
        <CardContent class="px-4">
          <p class="text-pretty font-medium leading-[1.25]">
            Make a pretty sizeable codeview with the hello there text in the
            center in it
          </p>
        </CardContent>
      </LazyCard>
    </ul>
    <Button
      id="fab"
      class="md:hidden fixed bottom-4 right-4 py-1 px-2 size-14 rounded-xl"
    >
      <LucidePlus class="p-0" />
    </Button>
  </div>
</template>
