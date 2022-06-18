<template>
  <div class="index h-full bg-black p-6 flex">
    <div class="h-full w-1/2 bg-white bg-opacity-10 rounded mr-3 flex flex-col justify-center items-center">
      <div class="flex flex-col h-1/2 w-1/2 bg-white bg-opacity-10 rounded p-5 mb-1">
        <h1 v-if="edit" class="text-white text-3xl mb-7">Edita usuari</h1>
        <h1 v-if="!edit" class="text-white text-3xl mb-7">Crea usuaris</h1>
        <input class="my-2 rounded bg-opacity-20 bg-white p-2 focus:outline-0 text-white" type="text" placeholder="nom"
               v-model="form.name">
        <input class="my-2 rounded bg-opacity-20 bg-white p-2 focus:outline-0 text-white" type="text"
               v-model="form.email"
               placeholder="email">
        <input v-if="!edit" class="my-2 rounded bg-opacity-20 bg-white p-2 focus:outline-0 text-white" type="password"
               v-model="form.password"
               placeholder="contrassenya">
        <input v-if="edit" readonly class="my-2 rounded bg-opacity-5 bg-white p-2 focus:outline-0 text-white"
               type="password"
               v-model="form.password"
               placeholder="contrassenya">
        <button @click="handleSubmit" class="bg-white bg-opacity-50 rounded p-2 px-3 w-fit mt-8">ok</button>
      </div>
      <p v-for="error in errors" class="p-1.5 m-1 w-1/2 bg-red-500 bg-opacity-40 rounded text-white text-opacity-40"
         :key="error.id">
        {{ error }}
      </p>
    </div>
    <div class="h-full w-1/2 bg-white bg-opacity-10 rounded ml-3 flex flex-col justify-center p-5">
      <div v-for="user in users" class="flex flex-row w-full h-14 my-1" :key="user.id">
        <div class="w-full bg-white bg-opacity-10 rounded flex flex-row p-4 text-white">
          <p class="w-14 mr-10">
            {{ user.id }}
          </p>
          <p class="mr-20">
            {{ user.name }}
          </p>
          <p>
            {{ user.email }}
          </p>
        </div>
        <button @click="del(user.id)" class="w-16 bg-red-500 bg-opacity-40 ml-2 rounded"><i
            class="bi bi-trash text-white text-2xl"></i>
        </button>
        <button @click="editMode(user.id)" class="w-16 bg-blue-500 bg-opacity-40 ml-2 rounded"><i
            class="bi bi-pen text-white text-2xl"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UsersCrud',
  data() {
    return {
      edit: false,
      users: [],
      errors: [],
      form: {
        name: null,
        email: null,
        password: null
      },
      id: null,
    }
  },
  methods: {
    handleSubmit: function () {
      this.errors = [];
      let regex = /[^@ \t\r\n]+@[^@ \t\r\n]+\.[^@ \t\r\n]+/;

      if (!this.form.name) {
        this.errors.push('El nom no pot estar buit');
      }
      if (!this.form.email) {
        this.errors.push('El email no pot estar buit');
      } else if (!regex.test(this.form.email)) {
        this.errors.push('El email no es valid');
      }
      if (!this.edit) {
        if (!this.form.password) {
          this.errors.push('La contrasenya no pot estar buida');
        }
      }
      if (this.errors.length === 0 && !this.edit) {
        axios
            .post('http://localhost/api/users/add', this.form)
            .then(response => (this.users.push(response.data)));
        this.form.name = null;
        this.form.email = null;
        this.form.password = null;
      } else if (this.errors.length === 0 && this.edit) {
        axios
            .put(`http://localhost/api/users/edit/${this.id}`, this.form);
        let i = this.users.map(item => item.id).indexOf(this.id);
        this.users[i].name = this.form.name;
        this.users[i].email = this.form.email;
        this.form.name = null;
        this.form.email = null;
        this.form.password = null;
        this.edit = false;
      }
    },
    del: function (id) {
      axios
          .delete(`http://localhost/api/users/del/${id}`);

      let i = this.users.map(item => item.id).indexOf(id);
      this.users.splice(i, 1);
    },
    editMode: function (id) {
      this.edit = true;
      let i = this.users.map(item => item.id).indexOf(id);
      this.id = this.users[i].id;
      this.form.name = this.users[i].name;
      this.form.email = this.users[i].email;
      this.errors = [];
    },
  },
  mounted() {
    axios
        .get('http://localhost/api/users/all')
        .then(response => (this.users = response.data))
  }
}
</script>