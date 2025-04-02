<template>
  <div
    id="grid-background"
    class="pattern pointer-events-none opacity-35"
  ></div>
</template>
<style scoped>
.pattern {
  background-image: repeating-linear-gradient(
      theme("colors.border") 0 1px,
      transparent 1px 100%
    ),
    repeating-linear-gradient(
      90deg,
      theme("colors.border") 0 1px,
      transparent 1px 100%
    );
  background-size: 24px 24px;
}
</style>
