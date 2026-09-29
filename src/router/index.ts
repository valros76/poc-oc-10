// src/router/index.ts
import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '@/views/HomeView.vue';
import GitesView from '@/views/GitesView.vue'; // Le cœur du PoC (Audit Gîtes)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomeView,
        meta: { title: 'Accueil - Hébergements' }
    },
    // Pages d'hébergements
    { path: '/gites', name: 'Gites', component: GitesView },
    { path: '/locations-vacances', name: 'LocationsVacances', component: () => import('@/views/PlaceholderView.vue') },
    { path: '/chambres-hotes', name: 'ChambresHotes', component: () => import('@/views/PlaceholderView.vue') },
    { path: '/maisons-hotes', name: 'MaisonsHotes', component: () => import('@/views/PlaceholderView.vue') },
    { path: '/hotels', name: 'Hotels', component: () => import('@/views/PlaceholderView.vue') },
    { path: '/residences-touristiques', name: 'ResidencesTouristiques', component: () => import('@/views/PlaceholderView.vue') },
    { path: '/logements-insolites', name: 'LogementsInsolites', component: () => import('@/views/PlaceholderView.vue') },
    { path: '/campings', name: 'Campings', component: () => import('@/views/PlaceholderView.vue') },

    // Pages fonctionnelles & commerciales
    { path: '/les-formules', name: 'LesFormules', component: () => import('@/views/PlaceholderView.vue') },
    { path: '/payer-un-acompte', name: 'PayerAcompte', component: () => import('@/views/PlaceholderView.vue') },
    { path: '/contactez-nous', name: 'Contact', component: () => import('@/views/PlaceholderView.vue') },

    // Pages légales
    { path: '/mentions-legales', name: 'MentionsLegales', component: () => import('@/views/MentionsLegalesView.vue') },
    { path: '/cgu-cgv', name: 'CguCgv', component: () => import('@/views/CguCgvView.vue') },
    { path: '/rgpd', name: 'Rgpd', component: () => import('@/views/RgpdView.vue') }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    }
});

export default router;