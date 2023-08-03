<template>
    <div v-for="sastra in sastras" v-bind:key="sastra.id">
        <post-comp :sastra="sastra" @refresLikePage="hapus"></post-comp>
    </div>

    <div v-if="isLoading" class=" flex justify-center">
        <img class="w-11 h-11 rounded-full mt-4" :src="urlImg" alt="defaultImage">
    </div>

    <not-found-comp v-if="isNotFound"></not-found-comp>
</template>

<script>
import PostComp from '../components/auth/SastraComp.vue'
import axios from 'axios'
import { mapActions } from 'vuex'
import { getScrollbarWidth } from '../utils/scrollFunction';
import NotFoundComp from '../components/utils/NotFoundComp.vue'


export default {
    data() {
        return {
            sastras: '',
            page: 1,
            isLoading: false,
            back: '',
            urlImg: '/img/loading.gif',
            isNotFound: false
        }
    },
    components: {
        PostComp,
        NotFoundComp
    },
    beforeMount() {
        this.getSastras()
    },
    mounted() {
        this.isLoading = true,
        window.onscroll = () => {
            this.getNextSastras()
        }
    },
    methods: {
        ...mapActions(["getuserpage", "gettitleheader", "getlikecount"]),
        async getSastras() {
            try {
                const response = await axios.get(`/api/sastras/${this.$route.params.username}/likes?page=${this.page}`)
                this.sastras = response.data.data.sastras.data
                this.getuserpage({
                    user: response.data.data.user,
                })
                this.getlikecount(response.data.data.count)
                this.gettitleheader(`${response.data.data.user.username}/likes`)
                document.title = `${response.data.data.user.username} likes | Pengepulaksara`
                if (response.data.data.sastras.data.length === 0) {
                    this.isNotFound = true
                }
                this.isLoading = true
            } catch (error) {
                const { response, request } = error;
                if (response) {
                    const { message } = response.data;
                    document.title = `Not Found | Pengepulaksara`
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
         getNextSastras() {
            let skrol = window.pageYOffset || document.documentElement.scrollTop;
            let bottomOfWindow = (skrol + window.innerHeight) >= document.documentElement.scrollHeight - getScrollbarWidth();

            if (bottomOfWindow) {
                this.page++;
                axios.get(`/api/sastras/${this.$route.params.username}/likes?page=${this.page}`)
                .then(response => {
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

<style></style>
