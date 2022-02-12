<template>
    <app-layout title="Kweeks">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Les derniers kweeks
            </h2>
        </template>

        <kweek-create></kweek-create>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div v-for="kweek in kweeks" v-bind:key="kweek.id" class="flex items-center space-x-4 bg-white overflow-hidden rounded rounded-b-none border-b-2 border-gray-200 py-6 px-4">
                    <img class="h-16 w-16 object-cover rounded-full" :src="kweek.user.profile_photo_url">
                    <div class="flex flex-col w-2/3">
                        <div>
                            <a class="text-sm text-gray-900 font-bold hover:text-blue-400" href="#">
                                {{ kweek.user.name }}
                            </a>
                            <span class="font-thin text-gray-400">· le {{ kweek.created_at }}</span>
                        </div>
                    <div class="text-sm text-gray-400 font-thin">{{ kweek.content }}</div>
                    </div>
                    <inertia-link  class="bg-white text-blue-500 cursor-pointer px-5 py-2 hover:text-white border border-blue-500 leading-tight hover:bg-blue-500 rounded-full font-extrabold transition-all duration-300" preserve-scroll>Suivre</inertia-link>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';
    import KweekCreate from '@/Pages/Kweek/Create';

    export default {
        components: {
            AppLayout,
            KweekCreate,
        },
        props: {
            kweeks: Array
        }
    }
</script>
