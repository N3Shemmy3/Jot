<script setup lang="ts">
import type MenuItem from "./types/Menu";
const { $listen } = useNuxtApp();
const root = ref<HTMLElement>();
const { x, y } = useScroll(root);
const open = ref(false);

const { Meta_J, Ctrl_J } = useMagicKeys({
  passive: false,
  onEventFired(e) {
    if (e.key === "j" && (e.metaKey || e.ctrlKey)) e.preventDefault();
  },
});

watch([Meta_J, Ctrl_J], (v) => {
  if (v[0] || v[1]) toggleCommand();
});

const toggleCommand = () => {
  open.value = !open.value;
};

onMounted(() => {
  $listen("toggleCommand", toggleCommand);
});
</script>

<template>
  <div ref="root" class="w-full h-dvh overflow-y-scroll">
    <Grid
      class="fixed -z-50 left-0 top-0 right-0 bottom-0"
      :class="{ 'blur-[2px]': $route.path != '/' }"
    />
    <Topbar :isLifted="y > 50" />
    <main class="pt-14 max-w-screen-xl mx-auto">
      <NuxtPage />
    </main>

    <CommandDialog v-model:open="open">
      <CommandInput placeholder="search..." class="flex items-center" />
      <CommandList>
        <CommandEmpty>No results found.</CommandEmpty>
        <CommandGroup heading="">
          <CommandItem value="calendar"> Calendar </CommandItem>
          <CommandItem value="search-emoji"> Search Emoji </CommandItem>
          <CommandItem value="calculator"> Calculator </CommandItem>
        </CommandGroup>
      </CommandList>
    </CommandDialog>
  </div>
</template>
<style scoped></style>
