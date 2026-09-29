<script setup lang="ts">
import AppHeader from "@/components/common/AppHeader.vue";
</script>

<template>
  <div id="app-layout">
    <AppHeader />
    <div class="content-body">
      <router-view />
    </div>
  </div>
</template>

<style>
/* Reset & styles de base */
body {
  margin: 0;
  padding: 0;
  background-color: #f8fafc;
  color: #2d3748;
}
#app-layout {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
.content-body {
  flex: 1;
}
</style>
