<template>
    <section v-if="sastras">
        <div v-for="sastra in sastras" v-bind:key="sastra.id">
            <post-comp :sastra="sastra" @refreshSearchPage="hapus"></post-comp>
        </div>

        <div v-if="isLoading" class=" flex justify-center">
            <img class="w-11 h-11 rounded-full mt-4" :src="urlImg" alt="defaultImage">
        </div>

        <not-found-comp v-if="isNotFound"></not-found-comp>
    </section>
</template>

<script>
import axios from 'axios'
import PostComp from '../components/SastraComp.vue'
import { mapGetters } from 'vuex'
import { getScrollbarWidth } from '../utils/scrollFunction'
import NotFoundComp from '../components/NotFoundComp.vue'

export default {
    components: {
        PostComp,
        NotFoundComp
    },
    data() {
        return {
            sastras: '',
            q: this.$route.query.q,
            page: 1,
            isLoading: false,
            back: '',
            urlImg: '/img/loading.gif',
            isNotFound: false
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    watch: {
        '$route.query': {
            handler: function (newQuery) {
                if (newQuery.q) {
                    this.page = 1
                }
                this.getSearchSastras(newQuery.q)
                this.getNextSearchSastras(newQuery.q)
            },
            deep: true // To watch for changes in nested objects
        }
    },
    created() {
        this.getSastras()
    },
    mounted() {
        this.isLoading = true
        this.getSearchSastras(this.$route.query.q)
        window.onscroll = () => {
            this.getNextSearchSastras(this.$route.query.q)
        }
    },
    methods: {
        async getSastras() {
            if (!this.user) {
                try {
                    const response = await axios.get('/api/index')
                    this.sastras = response.data.data.sastras
                } catch (error) {
                    this.handleAxiosError(error)
                } finally{
                    this.isLoading = false
                }
            }
        },
        async getSearchSastras(q) {
            if(q !== undefined){
                try {
                   const response = await axios.get(`/api/search?q=${q}&page=${this.page}`)
                   this.sastras = response.data.data.sastras.data
                   if (response.data.data.sastras.data.length === 0) {
                        this.isNotFound = true
                    } else {
                        this.isNotFound = false
                    }
               } catch (error) {
                   this.handleAxiosError(error)
               } finally {
                    this.isLoading = false
                }
            }
        },
        handleAxiosError(error) {
            const { response, request } = error;
            if (response) {
                const { message } = response.data;
                console.log(message);
            } else if (request) {
                console.log(request);
            } else {
                console.log('Error', error.message);
            }
        },
        getNextSearchSastras(q) {
            let skrol = window.pageYOffset || document.documentElement.scrollTop;
            let bottomOfWindow = (skrol + window.innerHeight) >= document.documentElement.scrollHeight - getScrollbarWidth();

            if (bottomOfWindow) {
                this.page++;
                axios.get(`/api/search?q=${q}&page=${this.page}`)
                .then(response => {
                    this.$store.dispatch('getquery', null)
                    this.isLoading = true;
                    this.sastras.push(...response.data.data.sastras.data);
                    if (response.data.data.sastras.data.length === 0) {
                        this.page--;
                    }
                    this.back = response.data.data.sastras.current_page - 1;
                })
                .catch(error => {
                    console.log(error);
                    this.error = true;
                })
                .finally(() => this.isLoading = false);
            }
        },
        hapus() {
            if (this.back == '') {
                this.page = 1;
                this.getSearchSastras(this.q);
            }
            else if (this.back == 0) {
                this.page = 1;
                this.getSearchSastras(this.q);
            }
            else {
                this.page = 1;
                this.getSearchSastras(this.q);
            }
        },
    }
}
</script>

<style>

</style>
