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
                        <div class="flex justify-center w-full text-center">
                            <img
                            alt="Placeholder"
                            class="block h-auto w-full md:w-3/4 lg:w-6/12"
                            src="https://picsum.photos/600/400/?random"
                        /> 
                        </div>
                        <div class="w-full pt-4 flex flex-col justify-center">
                            <div class="text-left lg:w-6/12 w-3/4 mx-auto">
                            <h4 class="text-xl">beschrijving:</h4>
                            <p>{{product.product_description}}</p>
                        </div>
                        <div class="text-left pt-4 lg:w-6/12 w-3/4 mx-auto">
                            <h4 class="text-xl">Prijs: {{ product.product_price }}</h4>
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
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'
    // import ArticleCard from '@/Components/ArticleCard'
    import Button from '@/Jetstream/Button'
    export default {
        components: {
            AppLayout,
            Welcome,
            Button
            // ArticleCard
        },
        props:{
            product: Object,
        },
        created(){
            console.log(this.product);
        }
    }
</script>
