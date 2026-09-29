<script setup lang="ts">
import { useAuditStore } from "@/stores/auditStore";

const auditStore = useAuditStore();
</script>

<template>
  <div v-if="auditStore.evaluationResult" class="audit-result-card">
    <h3>Résultats de votre Audit</h3>

    <div class="score-display">
      <span class="score-number">{{ auditStore.evaluationResult.score_visibilite }}/100</span>
      <span class="score-label">Score de visibilité numérique</span>
    </div>

    <div class="recommendation-box">
      <h4>Formule recommandée :</h4>
      <p class="formule-title">
        {{ auditStore.evaluationResult.formule_nom || "Formule Essentielle" }}
      </p>
      <p>{{ auditStore.evaluationResult.formule_description }}</p>
    </div>

    <button @click="auditStore.resetAudit()" class="btn-reset">Effectuer un autre audit</button>
  </div>
</template>

<style scoped>
.audit-result-card {
  background: #f0fdf4;
  border: 1px solid #42b883;
  border-radius: 10px;
  padding: 30px;
  text-align: center;
}
.score-display {
  margin: 20px 0;
}
.score-number {
  display: block;
  font-size: 3rem;
  font-weight: bold;
  color: #2f855a;
}
.score-label {
  color: #4a5568;
  font-size: 0.95rem;
}
.recommendation-box {
  background: white;
  padding: 20px;
  border-radius: 8px;
  border: 1px solid #c6f6d5;
  margin-bottom: 20px;
  text-align: left;
}
.formule-title {
  font-weight: bold;
  color: #2b6cb0;
  font-size: 1.1rem;
}
.btn-reset {
  padding: 8px 16px;
  background: #edf2f7;
  border: 1px solid #cbd5e0;
  border-radius: 6px;
  cursor: pointer;
  font-weight: 600;
}
.btn-reset:hover {
  background: #e2e8f0;
}
</style>
