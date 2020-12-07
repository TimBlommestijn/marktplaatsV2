<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Verander uw product
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <h3 class="text-2xl text-center">Voeg een nieuw product toe</h3>
          <div class="mx-auto flex justify-center w-11/12 lg:w-3/4">
            <form
              @submit.prevent="createProduct"
              class="lg:w-3/4 w-full"
              ref="form"
              enctype="multipart/form-data"
            >
              <div class="flex flex-col mt-8">
                <label for="naam" class="text-xl">Naam product:</label>
                <input
                  required
                  v-model="product.product_name"
                  type="text"
                  class="border-2 border-black"
                  name="naam"
                  id="naam"
                />
              </div>
              <div class="flex flex-col mt-8">
                <label for="description" class="text-xl">Beschrijving product:</label>
                <textarea
                  required
                  v-model="product.product_description"
                  type="text"
                  rows="6"
                  class="border-2 border-black"
                  name="naam"
                  id="description"
                ></textarea>
              </div>
              <div class="flex flex-row mt-8">
                <label for="price" class="text-xl">price:</label>
                <input
                  required
                  v-model="product.product_price"
                  type="number"
                  min="1"
                  step="any"
                  class="border-2 border-black lg:w-6/12 w-full lg:ml-10"
                  name="naam"
                  id="price"
                />
              </div>
              <div class="flex justify-center">
                <button
                  class="mt-8 text-white bg-black px-3 py-1 border border-solid border-gray hover:bg-white hover:text-black rounded"
                  type="submit"
                >
                  update
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";

export default {
  components: {
    AppLayout,
    Welcome,
  },
  props:{
    product: Object
  },  
  created() {
    console.log(this.product);
  },
  methods: {
    createProduct() {
      this.product._method = 'PUT'
      this.$inertia.post('/product/'+this.product.id, this.product )
      .then(()=>{
        alert('waddup')
      })
    },
  },
};
</script>
