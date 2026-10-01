// src/router/index.ts
import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '@/views/HomeView.vue';
import GitesView from '@/views/GitesView.vue'; // Le cœur du PoC (Audit Gîtes)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: HomeView,
        meta: {
            title: "Accueil - Hébergements | Webdevoo",
            description: "Vous êtes propriétaire d'un hébergement touristique ? Trouvez dès maintenant la solution en ligne la plus adéquate à vos besoins."
        }
    },
    // Pages d'hébergements
    { 
        path: '/gites', 
        name: 'Gites', 
        component: GitesView,
        meta: {
            title: "Création de site internet pour gîte | Webdevoo",
            description: "Votre gîte est-il suffisamment visible pour générer des réservations directes en Baie de Somme ? Évaluez votre potentiel."
        }
    },
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
    { 
        path: '/mentions-legales', 
        name: 'MentionsLegales', 
        component: () => import('@/views/MentionsLegalesView.vue'),
        meta: {
            title: "Mentions légales | Webdevoo",
            description: "Consultez les mentions légales de Webdevoo Hébergements."
        } 
    },
    { 
        path: '/cgu-cgv', 
        name: 'CguCgv', 
        component: () => import('@/views/CguCgvView.vue'),
        meta: {
            title: "CGU & CGV | Webdevoo",
            description: "Consultez les conditions générales d'utilisation et de vente de Webdevoo Hébergements."
        } 
    },
    { 
        path: '/rgpd', 
        name: 'Rgpd', 
        component: () => import('@/views/RgpdView.vue'),
        meta: {
            title: "RGPD | Webdevoo",
            description: "Consultez les informations en lien avec la conformité RGPD de Webdevoo Hébergements."
        } 
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior() {
        return { top: 0 };
    }
});

// Hook beforeEach pour injecter dynamiquement le SEO
router.beforeEach((to, from, next) => {
    const defaultTitle = "Webdevoo Hébergements - Solutions digitales";
    document.title = (to.meta.title as string) || defaultTitle;

    const metaDescriptionTag = document.querySelector('meta[name="description"]');
    const defaultDescription = "Plateforme d'acquisition et de solutions digitales pour hébergements touristiques.";

    if (metaDescriptionTag) {
        const metaDesc = to.meta.description as string;
        metaDescriptionTag.setAttribute('content', metaDesc || defaultDescription);
    }

    next();
});

export default router;