<script setup lang="ts">
import AuditForm from "@/components/gites/AuditForm.vue";
import AuditResult from "@/components/gites/AuditResult.vue";
import { useAuditStore } from "@/stores/auditStore";

const auditStore = useAuditStore();
</script>

<template>
  <main class="gites-view">
    <header class="gites-header">
      <h1>Création de site internet pour gîte</h1>
      <p>
        Propriétaires de gîtes et meublés de tourisme, mesurez l'impact de votre présence en ligne.
      </p>
      <router-link to="/" class="back-link">&larr; Retour à l'accueil</router-link>
    </header>

    <section class="gites-content">
      <AuditResult v-if="auditStore.evaluationResult" />
      <AuditForm v-else />
    </section>
  </main>
</template>

<style scoped>
.gites-view {
  max-width: 800px;
  margin: 40px auto;
  padding: 0 20px;
  font-family: sans-serif;
}
.gites-header {
  text-align: center;
  margin-bottom: 30px;
}
.gites-header h1 {
  color: #2c3e50;
}
.back-link {
  display: inline-block;
  margin-top: 10px;
  color: #42b883;
  text-decoration: none;
  font-weight: 500;
}
.back-link:hover {
  text-decoration: underline;
}
</style>
