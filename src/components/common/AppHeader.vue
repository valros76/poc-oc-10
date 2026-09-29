<template>
  <header class="app-header">
    <div class="header-container">
      <router-link to="/" class="brand-logo">
        <strong>Hébergements</strong> <span class="badge">PoC</span>
      </router-link>

      <nav class="main-nav">
        <router-link to="/gites" class="nav-item highlight">Gîtes (Audit)</router-link>
        <router-link to="/locations-vacances" class="nav-item">Locations</router-link>
        <router-link to="/chambres-hotes" class="nav-item">Chambres d'hôtes</router-link>
        <router-link to="/les-formules" class="nav-item">Formules</router-link>
      </nav>
    </div>
  </header>
</template>

<style scoped>
.app-header {
  background: #ffffff;
  border-bottom: 1px solid #e2e8f0;
  padding: 15px 0;
}
.header-container {
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.brand-logo {
  font-size: 1.2rem;
  text-decoration: none;
  color: #2c3e50;
}
.badge {
  background: #42b883;
  color: white;
  font-size: 0.75rem;
  padding: 2px 6px;
  border-radius: 4px;
}
.main-nav {
  display: flex;
  gap: 15px;
}
.nav-item {
  text-decoration: none;
  color: #4a5568;
  font-size: 0.95rem;
  font-weight: 500;
}
.nav-item.router-link-active {
  color: #42b883;
  font-weight: bold;
}
.nav-item.highlight {
  color: #2b6cb0;
  font-weight: bold;
}
</style>
