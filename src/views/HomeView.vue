<script setup lang="ts">
import { ref } from "vue";

const hostingCategories = ref([
  {
    name: "Gîtes & Meublés",
    path: "/gites",
    desc: "Audit de visibilité et recommandations sur-mesure (PoC actif)",
    highlight: true,
  },
  {
    name: "Locations de vacances",
    path: "/locations-vacances",
    desc: "Optimisez vos réservations directes.",
  },
  {
    name: "Chambres d’hôtes",
    path: "/chambres-hotes",
    desc: "Mettez en valeur votre art de recevoir.",
  },
  { name: "Maisons d’hôtes", path: "/maisons-hotes", desc: "Développez votre image de marque." },
  { name: "Hôtels", path: "/hotels", desc: "Solutions web pour hôteliers indépendants." },
  {
    name: "Résidences touristiques",
    path: "/residences-touristiques",
    desc: "Gérez l’afflux de saisonniers.",
  },
  {
    name: "Logements insolites",
    path: "/logements-insolites",
    desc: "Démarquez-vous avec une vitrine unique.",
  },
  { name: "Campings", path: "/campings", desc: "Boostez votre taux de remplissage." },
]);
</script>

<template>
  <main class="home-view">
    <section class="hero">
      <h1>Optimisez la visibilité de votre hébergement</h1>
      <p>Découvrez nos solutions adaptées à chaque type de structure touristique.</p>
      <router-link to="/gites" class="btn-primary">Tester l'Audit Gîte (PoC)</router-link>
    </section>

    <section class="grid-section">
      <h2>Nos expertises par type d'hébergement</h2>
      <div class="cards-grid">
        <div
          v-for="cat in hostingCategories"
          :key="cat.path"
          class="card"
          :class="{ 'highlight-card': cat.highlight }"
        >
          <h3>{{ cat.name }}</h3>
          <p>{{ cat.desc }}</p>
          <router-link :to="cat.path" class="link-arrow">Découvrir &rarr;</router-link>
        </div>
      </div>
    </section>

    <footer class="home-footer">
      <router-link to="/les-formules">Les Formules</router-link> |
      <router-link to="/payer-un-acompte">Payer un acompte</router-link> |
      <router-link to="/contactez-nous">Contactez-nous</router-link> |
      <router-link to="/mentions-legales">Mentions légales</router-link> |
      <router-link to="/cgu-cgv">CGU/CGV</router-link> |
      <router-link to="/rgpd">RGPD</router-link>
    </footer>
  </main>
</template>

<style scoped>
.home-view {
  max-width: 1100px;
  margin: 0 auto;
  padding: 40px 20px;
  font-family: sans-serif;
}
.hero {
  text-align: center;
  padding: 40px 20px;
  background: #f4f7f6;
  border-radius: 12px;
  margin-bottom: 40px;
}
.hero h1 {
  font-size: 2rem;
  color: #2c3e50;
}
.btn-primary {
  display: inline-block;
  margin-top: 15px;
  padding: 10px 20px;
  background-color: #42b883;
  color: white;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
}
.cards-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 20px;
  margin-bottom: 40px;
}
.card {
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 20px;
  transition: transform 0.2s;
}
.card:hover {
  transform: translateY(-3px);
}
.highlight-card {
  border-color: #42b883;
  background: #f0fdf4;
}
.link-arrow {
  color: #42b883;
  font-weight: bold;
  text-decoration: none;
}
.home-footer {
  text-align: center;
  font-size: 0.9rem;
  color: #666;
  border-top: 1px solid #eee;
  padding-top: 20px;
}
.home-footer a {
  margin: 0 8px;
  color: #555;
  text-decoration: none;
}
.home-footer a:hover {
  text-decoration: underline;
}
</style>
