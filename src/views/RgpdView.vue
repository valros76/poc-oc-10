<template>
  <main class="legal-view">
    <h1>RGPD</h1>
    <section class="legal-content">
      <h2>1. Éditeur du site</h2>
      <p>Ce site est un Proof of Concept (PoC) édité à des fins de démonstration technique.</p>

      <h2>2. Hébergement</h2>
      <p>Hébergement local sous environnement Laragon / PHP 8.5.</p>

      <h2>3. Propriété intellectuelle</h2>
      <p>Tous les contenus présentés dans ce PoC sont protégés au titre du droit d'auteur.</p>
    </section>
    <router-link to="/" class="back-link">&larr; Retour à l'accueil</router-link>
  </main>
</template>

<style scoped>
.legal-view {
  max-width: 800px;
  margin: 40px auto;
  padding: 0 20px;
  font-family: sans-serif;
  line-height: 1.6;
}
.legal-content {
  margin: 30px 0;
}
.legal-content h2 {
  color: #2c3e50;
  font-size: 1.2rem;
  margin-top: 20px;
}
.back-link {
  color: #42b883;
  text-decoration: none;
  font-weight: bold;
}
</style>
