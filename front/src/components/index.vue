<template>
  <div class="index h-full bg-black p-6 flex">
    <div class="h-full w-1/2 bg-white opacity-10 rounded mr-3">
    </div>
    <div class="h-full w-1/2 bg-white opacity-10 rounded ml-3">
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'HelloWorld',
  data() {
    return {
      resp: null
    }
  },
  mounted() {
    axios
        .get('http://localhost/api/works')
        .then(response => (this.resp = response.data))
  }
}
</script>