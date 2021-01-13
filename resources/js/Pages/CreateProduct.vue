<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Voeg nieuwe producten toe om te verkopen
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
                  v-model="productForm.name"
                  type="text"
                  class="border-2 border-black"
                  name="naam"
                  id="naam"
                />
              </div>
              <div class="flex flex-col mt-8">
                <label for="description" class="text-xl"
                  >Beschrijving product:</label
                >
                <textarea
                  required
                  v-model="productForm.description"
                  type="text"
                  rows="6"
                  class="border-2 border-black"
                  name="naam"
                  id="description"
                ></textarea>
              </div>
              <div class="flex flex-row mt-8">
                <label for="price" class="text-xl">Images:</label>
                <input
                  required
                  type="file"
                  @change="changeHandler"
                  class="form-control"
                  id="file"
                  name="product-image"
                  placeholder="address"
                  multiple
                />
              </div>
              <div class="flex flex-row mt-8">
                <label for="price" class="text-xl">price:</label>
                <input
                  required
                  v-model="productForm.price"
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
                  plaats
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
  data: function() {
    return {
      productForm: {
        name: "",
        description: "",
        price: 0.0,
        image: [],
        imagesCount: 0,
      },
      formData: [],
    };
  },
  created() {
    console.log(this.products);
  },
  methods: {
    createProduct() {
      let formData = new FormData();
      for (let i = 0; i < this.productForm.imagesCount; i++) {
        const e = this.formData[i];
        formData.append("images_" + i, e);
      }
      formData.set("name", this.productForm.name);
      formData.set("description", this.productForm.description);
      formData.set("price", this.productForm.price);
      formData.set("imagesCount", this.productForm.imagesCount);
      this.$inertia.post("/product", formData).then(() => {
        alert("waddup");
      });
    },
    changeHandler(e) {
      // this.productForm.image = e.target.files;
      this.productForm.imagesCount = e.target.files.length;
      // console.log(e.target.files);
      for (let i = 0; i < this.productForm.imagesCount; i++) {
        const element = e.target.files[i];
        this.formData.push(element);
      }
    },
  },
};
</script>
