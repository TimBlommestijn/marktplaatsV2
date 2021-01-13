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
                <label for="description" class="text-xl"
                  >Beschrijving product:</label
                >
                <textarea
                  required
                  v-model="product.product_description"
                  type="text"
                  rows="6"
                  class="border-2 border-black"
                  name="naam"
                  id="description"
                ></textarea>
                <div
                  class="flex flex-col lg:flex-row md:flex-row py-4 justify-center"
                >
                  <div
                    v-for="img in allImages"
                    :key="img.id"
                    class="mx-2 flex-col"
                  >
                    <img
                      alt="Placeholder"
                      class="w-full "
                      :src="'/storage/' + img.filePath"
                    />
                    <div
                      class="flex flex-row w-full text-center bg-red-600 hover:bg-black hover:text-white"
                      @click="deleteImage(img.id)"
                    >
                      <a class="mx-auto ">delete</a>
                    </div>
                  </div>
                  <div class="w-full h-max py-4 flex">
                    <label
                      for="file"
                      class="far fa-plus-square m-auto text-4xl hover:text-blue-600"
                    ></label>
                    <input
                      name="file"
                      type="file"
                      @change="saveImg"
                      class="form-control hidden"
                      id="file"
                    />
                    <!-- <i class="far fa-plus-square m-auto text-3xl"></i> -->
                  </div>
                </div>
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
  props: {
    product: Object,
    images: Array,
  },
  data() {
    return {
      added: false,
      addedImages: [],
      allImages: [],
    };
  },
  created() {
    this.mergeImageArrays();
  },
  methods: {
    mergeImageArrays() {
      this.allImages = this.images.concat(this.addedImages);
    },
    saveImg(e) {
      let formData = new FormData();
      formData.append("image", e.target.files[0]);
      axios
        .post(`/product/image/save/${this.product.id}`, formData)
        .then((response) => {
          this.added = true;
          this.allImages.push(response.data.img);
        })
        .catch((error) => {
          console.error(error.message);
        });
    },
    createProduct() {
      this.product._method = "PUT";
      this.$inertia
        .post("/product/" + this.product.id, this.product)
        .then(() => {
          alert("succes");
        })
        .catch((err) => {
          console.error(err.message);
        });
    },
    deleteImage(id) {
      axios
        .post(`/product/image/delete/${id}`)
        .then((res) => {
          this.allImages.forEach((element, index) => {
            if (element.id == id) this.allImages.splice(index, 1);
          });
        })
        .catch((error) => {
          console.error(error);
        });
    },
  },
};
</script>
