<script setup lang="ts">
import { reactive, ref } from "vue";
import { useAuditStore } from "@/stores/auditStore";
import type { Prospect } from "@/interfaces/prospect.interface";

const auditStore = useAuditStore();

const form = reactive<Prospect>({
  nom_etablissement: "",
  type_hebergement: "Gîte",
  url_actuelle: "",
  email: "",
  website_hp: "", // Champ honeypot (doit rester vide)
});

const validationError = ref<string | null>(null);

const handleSubmit = async () => {
  // Vérification du Honeypot anti-spam
  if (form.website_hp) {
    console.warn("Spam détecté via honeypot.");
    return;
  }

  if (!form.nom_etablissement || !form.email) {
    validationError.value = "Veuillez renseigner le nom de l’établissement et votre email.";
    return;
  }

  validationError.value = null;

  try {
    await auditStore.submitAudit(form);
  } catch {
    // L'erreur est déjà gérée et stockée dans le store
  }
};
</script>

<template>
  <div class="audit-form-container">
    <h2>Lancez l'audit de votre Gîte</h2>
    <p>
      Remplissez les informations ci-dessous pour obtenir instantanément votre score de visibilité
      et notre recommandation stratégique.
    </p>

    <form @submit.prevent="handleSubmit" class="audit-form">
      <div v-if="validationError" class="alert-error">{{ validationError }}</div>
      <div v-if="auditStore.error" class="alert-error">{{ auditStore.error }}</div>

      <!-- Champ Honeypot masqué pour les robots -->
      <div class="hp-field" style="display: none">
        <label for="website_hp">Ne pas remplir ce champ si vous êtes humain</label>
        <input type="text" id="website_hp" v-model="form.website_hp" autocomplete="off" />
      </div>

      <div class="form-group">
        <label for="nom">Nom de l'établissement *</label>
        <input
          type="text"
          id="nom"
          v-model="form.nom_etablissement"
          required
          placeholder="Ex: Gîte du Val de Loire"
        />
      </div>

      <div class="form-group">
        <label for="url">Site web actuel (URL)</label>
        <input
          type="url"
          id="url"
          v-model="form.url_actuelle"
          placeholder="https://www.mon-gite.com"
        />
      </div>

      <div class="form-group">
        <label for="email">Email de contact *</label>
        <input
          type="email"
          id="email"
          v-model="form.email"
          required
          placeholder="contact@mon-gite.com"
        />
      </div>

      <button type="submit" class="btn-submit" :disabled="auditStore.loading">
        {{ auditStore.loading ? "Analyse en cours..." : "Évaluer ma visibilité" }}
      </button>
    </form>
  </div>
</template>

<style scoped>
.audit-form-container {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 30px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
}
.form-group {
  margin-bottom: 20px;
}
.form-group label {
  display: block;
  margin-bottom: 6px;
  font-weight: 600;
  color: #2d3748;
}
.form-group input {
  width: 100%;
  padding: 10px 12px;
  border: 1px solid #cbd5e0;
  border-radius: 6px;
  font-size: 1rem;
}
.btn-submit {
  width: 100%;
  padding: 12px;
  background-color: #42b883;
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s;
}
.btn-submit:hover:not(:disabled) {
  background-color: #35495e;
}
.btn-submit:disabled {
  background-color: #a0aec0;
  cursor: not-allowed;
}
.alert-error {
  background: #fed7d7;
  color: #9b2c2c;
  padding: 10px;
  border-radius: 6px;
  margin-bottom: 15px;
}
</style>
