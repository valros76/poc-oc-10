// src/services/apiService.ts
import type { ApiResponse } from '@/interfaces/prospect.interface';

// Ajuste l'URL de base selon ton environnement local Laragon/PHP
const API_BASE_URL = import.meta.env.VITE_API_BASE_URL ?? "http://localhost/poc-oc-10/backend";

async function handleResponse<T>(response: Response): Promise<ApiResponse<T>> {
    const contentType = response.headers.get('content-type');
    let data: any = null;

    if (contentType && contentType.includes('application/json')) {
        data = await response.json();
    } else {
        data = await response.text();
    }

    if (!response.ok) {
        const errorMessage = (typeof data === 'object' && data?.message) 
            || `Erreur HTTP ${response.status}: ${response.statusText}`;
        throw new Error(errorMessage);
    }

    // Si le backend renvoie déjà un format standardisé { success, data }
    if (data && typeof data === 'object' && 'success' in data) {
        return data as ApiResponse<T>;
    }

    // Fallback enveloppé si le backend renvoie directement la donnée brute
    return {
        success: true,
        data: data as T
    };
}

export const apiService = {
    async get<T>(endpoint: string): Promise<ApiResponse<T>> {
        const response = await fetch(`${API_BASE_URL}/${endpoint}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });
        return handleResponse<T>(response);
    },

    async post<T>(endpoint: string, payload: unknown): Promise<ApiResponse<T>> {
        const response = await fetch(`${API_BASE_URL}/${endpoint}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        return handleResponse<T>(response);
    }
};