<template>
  <app-layout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Product
      </h2>
    </template>

    <div class="py-12">
      <div class=" sm:px-6 lg:px-8">
        <div class="pb-4 bg-white overflow-hidden shadow-xl sm:rounded-lg">
          <h4 class="text-center text-3xl">{{ product.product_name }}</h4>
          <div class="flex  justify-center flex-wrap -mx-1 lg:mx-4">
            <div class="flex justify-center flex-row w-full text-center">
              <div class="flex px-4">
                <a
                  v-if="imagesCount.length > 1"
                  @click="changeImage('BACK')"
                  class="text-xl my-auto hover:text-blue-600 fas fa-arrow-left"
                ></a>
              </div>
              <div
                class="flex flex-col h-auto w-full justify-center md:w-3/4 lg:w-6/12"
              >
                <div class="flex justify-center">
                  <img
                    alt="Placeholder"
                    class="image"
                    :src="'/storage/' + displayImage"
                  />
                </div>
                <div
                  class="flex flex-row justify-center"
                  v-if="imagesCount.length > 1"
                >
                  <p
                    :key="count"
                    :class="currentStyle"
                    v-for="count in imagesCount"
                  >
                    {{ count }}
                  </p>
                </div>
              </div>
              <div class="flex px-4">
                <a
                  v-if="imagesCount.length > 1"
                  @click="changeImage('NEXT')"
                  class="text-xl my-auto hover:text-blue-600 fas fa-arrow-right"
                ></a>
              </div>
            </div>
            <div class="w-full pt-4 flex flex-col justify-center">
              <div class="text-left lg:w-6/12 w-3/4 mx-auto">
                <h4 class="text-xl">beschrijving:</h4>
                <p>{{ product.product_description }}</p>
              </div>
              <div class="text-left pt-4 lg:w-6/12 w-3/4 mx-auto">
                <h4 class="text-xl">Prijs: €{{ formattedPrice }}</h4>
              </div>
              <div class="text-left pt-4 lg:w-6/12 w-3/4 mx-auto">
                <Button>Koop</Button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";
import Button from "@/Jetstream/Button";

export default {
  components: {
    AppLayout,
    Welcome,
    Button,
  },
  props: {
    product: Object,
    images: Array,
  },
  data: () => {
    return {
      imagesLoad: [],
      imageState: 0,
      currentStyle: "text-black",
    };
  },
  created() {
    console.log(this.product);
    for (let i = 0; i < this.images.length; i++) {
      const e = this.images[i];
      if (e.ProductId == this.product.id) this.imagesLoad.push(e.filePath);
    }
    this.imagesCount;
  },
  methods: {
    changeImage(state) {
      if (state == "NEXT") {
        this.imagesLoad.length - 1 > this.imageState
          ? this.imageState++
          : (this.imageState = this.imageState);
      } else {
        0 < this.imageState ? this.imageState-- : this.imageState;
      }
    },
  },
  computed: {
    formattedPrice: function() {
      return this.product.product_price.toFixed(2);
    },
    displayImage: function() {
      return this.imagesLoad[this.imageState];
    },
    imagesCount: function() {
      const element = [];
      for (let i = 0; i < this.imagesLoad.length; i++) {
        let e = i;
        e++;
        element.push(e);
      }
      return element;
    },
  },
};
</script>
<style scoped>
.image {
  max-width: 100%;
  max-height: 24rem;
}
</style>
