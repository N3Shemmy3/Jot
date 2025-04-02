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
  <div ref="content" class="w-full flex flex-col overflow-y-scroll">
    <Topbar :isLifted="y > 50" />
    <main class="w-full h-full pt-14 max-w-screen-xl mx-auto">
      <NuxtPage />
    </main>
    <CommandDialog v-model:open="open">
      <CommandInput placeholder="Type a command or search..." />
      <CommandList>
        <CommandEmpty>No results found.</CommandEmpty>
        <CommandGroup heading="Suggestions">
          <CommandItem value="calendar"> Calendar </CommandItem>
          <CommandItem value="search-emoji"> Search Emoji </CommandItem>
          <CommandItem value="calculator"> Calculator </CommandItem>
        </CommandGroup>
        <CommandSeparator />
        <CommandGroup heading="Settings">
          <CommandItem value="profile"> Profile </CommandItem>
          <CommandItem value="billing"> Billing </CommandItem>
          <CommandItem value="settings"> Settings </CommandItem>
        </CommandGroup>
      </CommandList>
    </CommandDialog>
  </div>
</template>
<style scoped></style>
