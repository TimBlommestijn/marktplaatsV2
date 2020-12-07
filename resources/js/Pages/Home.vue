<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Home
            </h2>
        </template>

        <div class="py-12">
            <div class=" sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <h4 class="text-center">Producten</h4>
                    <div class="flex flex-wrap -mx-1 lg:mx-4">
                        <ArticleCard :images="images" :product="product" v-for="product in products" :key="product.id"
                            :rights="false"
                        />
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    import ArticleCard from '@/Components/ArticleCard'
    export default {
        components: {
            AppLayout,
            Welcome,
            ArticleCard
        },
        props:{
            products: Array,
            images: Array
        },
        created(){
            console.log(this.products);
        },
        computed:{

        }
    }
</script>
