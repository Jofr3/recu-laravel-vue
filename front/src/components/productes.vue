<template>
  <div class="index h-full bg-black p-6 flex">
    <div class="h-full w-1/2 bg-white bg-opacity-10 rounded mr-3 flex flex-col justify-center items-center">
      <div class="flex flex-col h-1/2 w-1/2 bg-white bg-opacity-10 rounded p-5 mb-1">
        <h1 v-if="edit" class="text-white text-3xl mb-7">Edita producte</h1>
        <h1 v-if="!edit" class="text-white text-3xl mb-7">Crea productes</h1>
        <input class="my-2 rounded bg-opacity-20 bg-white p-2 focus:outline-0 text-white" type="text" placeholder="nom"
               v-model="form.name">
        <div class="flex flex-row">

          <input class="my-2 rounded bg-opacity-20 bg-white p-2 focus:outline-0 text-white" type="text"
                 v-model="form.price"
                 placeholder="preu">
          <div class="m-auto">
            <i class="bi bi-currency-euro bg-white p-2 px-6 ml-2 rounded bg-opacity-60"></i>
          </div>
        </div>
        <input class="my-2 rounded bg-opacity-20 bg-white p-2 focus:outline-0 text-white" type="text"
               v-model="form.stock"
               placeholder="stock">
        <button @click="handleSubmit" class="bg-white bg-opacity-50 rounded p-2 px-3 w-fit mt-8">ok</button>
      </div>
      <p v-for="error in errors" class="p-1.5 m-1 w-1/2 bg-red-500 bg-opacity-40 rounded text-white text-opacity-40"
         :key="error.id">
        {{ error }}
      </p>
    </div>
    <div class="h-full w-1/2 bg-white bg-opacity-10 rounded ml-3 flex flex-col justify-center p-5">
      <div v-for="product in products" class="flex flex-row w-full h-14 my-1" :key="product.id">
        <div class="w-full bg-white bg-opacity-10 rounded flex flex-row p-4 text-white">
          <p class="w-14 mr-10">
            {{ product.id }}
          </p>
          <p class="mr-20">
            {{ product.name }}
          </p>
          <p class="mr-20">
            {{ product.price }}
            <i class="bi bi-currency-euro"></i>
          </p>
          <p>
            <i class="bi bi-box"></i> {{ product.stock }}
          </p>
        </div>
        <button @click="del(product.id)" class="w-16 bg-red-500 bg-opacity-40 ml-2 rounded"><i
            class="bi bi-trash text-white text-2xl"></i>
        </button>
        <button @click="editMode(product.id)" class="w-16 bg-blue-500 bg-opacity-40 ml-2 rounded"><i
            class="bi bi-pen text-white text-2xl"></i>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ProductesCrud',
  data() {
    return {
      edit: false,
      products: [],
      errors: [],
      form: {
        name: null,
        price: null,
        stock: null
      },
      id: null,
    }
  },
  methods: {
    handleSubmit: function () {
      this.errors = [];

      if (!this.form.name) {
        this.errors.push('El nom no pot estar buit');
      }
      if (!this.form.price) {
        this.errors.push('El preu no pot estar buit');
      } else if (isNaN(this.form.price)) {
        this.errors.push('El preu ha de ser un numero');
      }
      if (!this.form.stock) {
        this.errors.push('El stock no pot estar buit');
      } else if (isNaN(this.form.stock)) {
        this.errors.push('El stock ha de ser un numero');
      }
      if (this.errors.length === 0 && !this.edit) {
        axios
            .post('http://localhost/api/products/add', this.form)
            .then(response => (this.products.push(response.data)));
        this.form.name = null;
        this.form.price = null;
        this.form.stock = null;
      } else if (this.errors.length === 0 && this.edit) {
        axios
            .put(`http://localhost/api/products/edit/${this.id}`, this.form);
        let i = this.products.map(item => item.id).indexOf(this.id);
        this.products[i].name = this.form.name;
        this.products[i].price = this.form.price;
        this.products[i].stock = this.form.stock;
        this.form.name = null;
        this.form.price = null;
        this.form.stock = null;
        this.edit = false;
      }
    },
    del: function (id) {
      axios
          .delete(`http://localhost/api/products/del/${id}`);

      let i = this.products.map(item => item.id).indexOf(id);
      this.products.splice(i, 1);
    },
    editMode: function (id) {
      this.edit = true;
      let i = this.products.map(item => item.id).indexOf(id);
      this.id = this.products[i].id;
      this.form.name = this.products[i].name;
      this.form.price = this.products[i].price;
      this.form.stock = this.products[i].stock;
      this.errors = [];
    },
  },
  mounted() {
    axios
        .get('http://localhost/api/products/all')
        .then(response => (this.products = response.data))
  }
}
</script>