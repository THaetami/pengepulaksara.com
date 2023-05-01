<template>
<div v-if="addsastranotif || deletesastranotif" class="flex justify-center">
    <small class="fixed flex max-w-full p-2 text-md text-center text-white bg-blue-800 bottom-[5.5rem] rounded-md mt-1 md:mt-1 select-none hover:underline cursor-pointer">
        <slot name="header">
            <div v-if="deletesastranotif" class="p-2">Sastra berhasil dihapus</div>
            <div v-if="addsastranotif" @click="toSastra">Sastra berhasil ditambahkan, klik untuk melihat</div>
        </slot>
        <slot name="footer">
            <button v-if="addsastranotif" @click="this.$store.dispatch('getaddsastranotif', null)" type="button" class="ml-2 justify-end flex text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full p-0.5">
                <svg fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </slot>
    </small>
</div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';

export default {
    name: 'AddSastraNotif',
    props: ['show','slug'],
    computed: {
        ...mapGetters(['addsastranotif','deletesastranotif'])
    },
    methods: {
        ...mapActions(["getaddsastranotif"]),
        toSastra() {
            this.$router.push({
                name: 'DetailPage',
                params: { slug: `${this.addsastranotif}` },
            })
            this.$store.dispatch('getaddsastranotif', null)
        }
    }
}
</script>

<style>

</style>
