<template>
    <div class="hidden md:inline-block">
        <form-comp v-if="user" @refreshSastra="getSastras"></form-comp>
    </div>

    <div v-for="sastra in sastras" v-bind:key="sastra.id">
        <post-comp :sastra="sastra" @refreshHome="hapus"></post-comp>
    </div>

    <div v-if="isLoading" class=" flex justify-center">
        <img class="w-11 h-11 rounded-full mt-4" :src="urlImg" alt="defaultImage">
    </div>
</template>

<script>
import axios from 'axios'
import FormComp from '../components/auth/FormSastraComp.vue'
import PostComp from '../components/auth/SastraComp.vue'
import { mapActions, mapGetters } from 'vuex'
import { getScrollbarWidth } from '../utils/scrollFunction';


export default {
    components: {
        FormComp,
        PostComp,
    },
    data() {
        return {
            sastras: '',
            page: 1,
            isLoading: false,
            back: '',
            urlImg: '/img/loading.gif'
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    beforeMount() {
        this.getSastras()
    },
    mounted() {
        this.isLoading = true
        window.onscroll = () => {
            this.getNextSastras();
        }
    },
    methods: {
        ...mapActions(["gettitleheader"]),
        async getSastras() {
            try {
                const response = await axios.get(`/api/sastras?page=${this.page}`)
                this.sastras = response.data.data.sastras.data
                this.isLoading = true
                this.gettitleheader("Home")
            } catch (error) {
                const { response, request } = error;
                if (response) {
                    const { message } = response.data;
                    console.log(message);
                } else if (request) {
                    console.log(request);
                } else {
                    console.log('Error', error.message);
                }
            } finally {
                this.isLoading = false
            }
        },
        getNextSastras () {
            let skrol = window.pageYOffset || document.documentElement.scrollTop;
            let bottomOfWindow = (skrol + window.innerHeight) >= document.documentElement.scrollHeight - getScrollbarWidth();

            if (bottomOfWindow) {
                this.page++;
                axios.get(`/api/sastras?page=${this.page}`)
                .then(response => {
                    this.isLoading = true;
                    this.sastras.push(...response.data.data.sastras.data);

                    if (response.data.data.sastras.data.length === 0) {
                        this.page--;
                    }
                    this.back = response.data.sastras.current_page - 1;
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => this.isLoading = false);
            }
        },
        hapus() {
            if (this.back == '') {
                this.page = 1;
                this.getSastras();
            }
            else if (this.back == 0) {
                this.page = 1;
                this.getSastras();
            }
            else {
                this.page = 1;
                this.getSastras();
            }
        },
    }
}
</script>

<style>

</style>
