// src/interfaces/prospect.interface.ts

export interface Prospect {
    id?: number;
    nom_etablissement: string;
    type_hebergement?: string;
    url_actuelle?: string;
    email: string;
    website_hp?: string; // Champ Honeypot anti-spam
}

export interface Formule {
    id: number;
    nom: string;
    description: string;
}

export interface Evaluation {
    id: number;
    prospect_id: number;
    score_visibilite: number;
    formule_recommandee_id: number;
    date_creation: string;
    formule_nom?: string;
    formule_description?: string;
}

export interface ApiResponse<T> {
    success: boolean;
    data: T;
    message?: string;
}