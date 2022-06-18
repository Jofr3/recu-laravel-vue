<template>
  <div class="h-14 w-fit absolute left-8 top-10">
    <router-link class="m-2 bg-white bg-opacity-20 rounded p-2" to="/">Usuaris</router-link>
    <router-link class="m-2 bg-white bg-opacity-20 rounded p-2" to="/productes">Productes</router-link>
  </div>
  <router-view/>
</template>

<script>
import './index.css'

export default {
  name: 'App'
}
</script>