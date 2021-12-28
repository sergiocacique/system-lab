<template>
  <v-app>
    <v-main class="theme-app">
      <v-container fluid class="d-flex justify-center align-center min-height">
        <slot></slot>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {};
</script>

<style>
.min-height {
  min-height: 100%;
}
.theme-app {
  background: #8e9eab;
  background: -webkit-linear-gradient(to right, #eef2f3, #bcc6ce);
  background: linear-gradient(to right, #eef2f3, #bcc6ce);
}
</style>
