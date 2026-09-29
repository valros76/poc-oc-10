<script setup lang="ts">
import { useRoute } from "vue-router";
import { computed } from "vue";

const route = useRoute();
const pageTitle = computed(() => {
  return (route.name as string)?.replace(/([A-Z])/g, " $1").trim() || "Rubrique";
});
</script>

<template>
  <main class="placeholder-view">
    <h1>Section : {{ pageTitle }}</h1>
    <p>Cette section est en cours de développement pour la version finale.</p>

    <div class="info-box">
      <p>💡 Le PoC est actuellement centré sur la catégorie <strong>Gîtes</strong>.</p>
      <router-link to="/gites" class="btn-primary">Accéder à l'audit Gîtes</router-link>
    </div>
  </main>
</template>

<style scoped>
.placeholder-view {
  max-width: 800px;
  margin: 60px auto;
  padding: 0 20px;
  text-align: center;
  font-family: sans-serif;
}
.info-box {
  margin-top: 30px;
  padding: 20px;
  background: #f7fafc;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
}
.btn-primary {
  display: inline-block;
  margin-top: 15px;
  padding: 10px 18px;
  background-color: #42b883;
  color: white;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
}
</style>
