// src/stores/auditStore.ts
import { defineStore } from 'pinia';
import { ref } from 'vue';
import type { Prospect, Evaluation, ApiResponse } from '@/interfaces/prospect.interface';
import { apiService } from '@/services/apiService';

export const useAuditStore = defineStore('audit', () => {
    const loading = ref(false);
    const error = ref<string | null>(null);
    const evaluationResult = ref<Evaluation | null>(null);

    async function submitAudit(prospect: Prospect) {
        loading.value = true;
        error.value = null;
        try {
            // On type explicitement la réponse de l'API avec Evaluation
            const response = await apiService.post<Evaluation>('api/audit', prospect);
            
            // On extrait uniquement le champ .data pour correspondre au type Evaluation
            evaluationResult.value = response.data;
        } catch (err: any) {
            error.value = err.message || "Erreur lors de la soumission de l'audit.";
            throw err;
        } finally {
            loading.value = false;
        }
    }

    function resetAudit() {
        evaluationResult.value = null;
        error.value = null;
    }

    return {
        loading,
        error,
        evaluationResult,
        submitAudit,
        resetAudit
    };
});