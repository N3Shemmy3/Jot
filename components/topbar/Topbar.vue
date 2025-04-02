<script setup lang="ts">
import type MenuItem from "~/types/Menu";

const props = defineProps({
  isLifted: {
    type: Boolean,
    default: false,
  },
});

const menu = ref<MenuItem[]>([
  { title: "notes", path: "/notes" },
  { title: "about", path: "/about" },
]);

const { $event } = useNuxtApp();

const toggleCommand = () => {
  $event("toggleCommand");
};
</script>

<template>
  <header
    class="z-20 fixed left-0 top-0 right-0 flex items-center transition-all duration-300"
    :class="{
      'shadow-sm border-b-[.5px] border-opacity-30 backdrop-blur-xl':
        props.isLifted,
    }"
  >
    <div
      class="w-full py-2 max-w-screen-xl mx-auto flex items-center justify-between px-4 md:px-8"
    >
      <!-- Logo-->
      <div id="logo" class="flex items-center">
        <NuxtLink
          to="/"
          class="cursor-pointer transition-colors duration-300 text-foreground hover:text-muted-foreground"
        >
          <h4 class="scroll-m-20 text-xl font-semibold tracking-tight">Jot</h4>
        </NuxtLink>
      </div>
      <!-- Desktop nav-->
      <NavigationMenu id="desktop-nav" class="flex gap-4">
        <NavigationMenuList class="hidden md:flex gap-4">
          <NavigationMenuItem
            v-for="menuItem in menu"
            :key="menuItem.title.toString()"
          >
            <NuxtLink
              v-slot="{ isActive, href, navigate }"
              :to="menuItem.path.toString()"
              custom
            >
              <NavigationMenuLink
                :active="isActive"
                :href
                @click="navigate"
                class="transition-colors duration-300 hover:text-foreground"
                :class="{
                  'text-foreground': isActive,
                }"
              >
                {{ menuItem.title }}
              </NavigationMenuLink>
            </NuxtLink>
          </NavigationMenuItem>
        </NavigationMenuList>

        <Avatar class="border cursor-pointer aspect-square size-8 p-0">
          <AvatarImage src="/avatar.jpg" alt="@unovue" />
          <AvatarFallback>SN</AvatarFallback>
        </Avatar>
      </NavigationMenu>
    </div>
  </header>
</template>
