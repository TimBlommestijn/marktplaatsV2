<template>
  <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3 ">
    <!-- Article -->
    <article
      class="overflow-hidden rounded-lg shadow-lg selectedEffect border-4 border-solid border-white"
      @click="route('show-product', product.id)"
    >
      <div class="w-full h-80 flex justify-center">
        <inertia-link class="my-auto" :href="route('show-product', product.id)">
          <img
            alt="image placeholder"
            class="imageCard"
            :src="'/storage/' + imagesLoad[0]"
          />
        </inertia-link>
      </div>
      <header
        class="flex items-center justify-between leading-tight p-2 md:p-4"
      >
        <h1 class="text-lg">
          <inertia-link
            class="no-underline hover:underline text-black"
            :href="route('show-product', product.id)"
          >
            {{ product.product_name }}
          </inertia-link>
        </h1>
        <p class="text-grey-darker text-sm">{{ formattedDate }}</p>
      </header>

      <footer class="flex items-center justify-between leading-none p-2 md:p-4">
        <inertia-link
          class="flex items-center no-underline hover:underline text-black"
          :href="route('profile-products', this.product.uuid)"
        >
          <p class="ml-2 text-sm">
            {{ product.author ? product.author : "Uw product" }}
          </p>
        </inertia-link>
        <p>€{{ formattedPrice }}</p>
      </footer>
      <div class="flex items-center justify-between  p-2 md:p-4" v-if="rights">
        <inertia-link
          :href="route('edit', product.id)"
          class="no-underline hover:underline text-black"
          ><i class="far fa-edit text-xl"></i> Edit
        </inertia-link>
        <a
          href="#"
          @click="destroyProduct()"
          class="no-underline hover:underline text-black"
        >
          Destroy <i class="far fa-trash-alt text-xl"></i
        ></a>
      </div>
    </article>
    <!-- END Article -->
  </div>
</template>
<script>
export default {
  props: {
    product: Object,
    rights: Number,
    images: Array,
  },
  data: function() {
    return {
      product_date: new Date(this.product.created_at),
      image_load: false,
      imagesLoad: [],
    };
  },
  created() {},
  mounted() {
    for (let i = 0; i < this.images.length; i++) {
      const e = this.images[i];
      if (e.ProductId == this.product.id) {
        let arrayofpain = e.filePath.split("/");
        arrayofpain[1] = "Thumbnail_" + arrayofpain[1];
        console.log("arrayofpain: " + arrayofpain[1]);
        console.log(arrayofpain.join("/"));
        this.imagesLoad.push(arrayofpain.join("/"));
      }
    }
  },
  methods: {
    setImageStatus() {
      image_load = !image_load;
    },
    destroyProduct() {
      if (this.rights) {
        const userCheck = prompt(
          "please enter " + this.product.product_name,
          ""
        );
        if (userCheck == this.product.product_name) {
          this.product._method = "DELETE";
          this.$inertia
            .post("/product/destroy/" + this.product.id, this.product)
            .then(() => {
              alert(this.product.product_name + " has been deleted");
            })
            .catch((err) => error.log(err.message));
        }
      }
    },
  },
  computed: {
    formattedDate: function() {
      return `${this.product_date.getDate()}-${this.product_date.getMonth() +
        1}-${this.product_date.getFullYear()}`;
    },
    formattedPrice: function() {
      return this.product.product_price.toFixed(2);
    },
    profileLink: function() {
      return `/profile/${this.product.uuid}`;
    },
  },
};
</script>
<style scoped>
.imageCard {
  max-height: 20rem;
  max-width: 100%;
}
.selectedEffect:hover {
  border-color: black;
  border-style: solid;
  border-width: 0.25rem;
}
</style>
