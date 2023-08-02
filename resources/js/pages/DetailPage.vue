<template>
    <div v-for="sastra in sastras" v-bind:key="sastra.id">
        <post-comp :sastra="sastra" @refreshDetailPage="getSastra" @back="$router.go(-1)"></post-comp>
    </div>
    <error-message v-if="message">
        <template #message>
            <div class="text-center p-2">
                {{ message }}
            </div>
        </template>
    </error-message>

    <form-komen-comp v-if="user && sastras" :sastraId="sastra_id" @refreshDetailPage="getSastra"></form-komen-comp>

    <hr v-if="!user" class="border-b-2 my-2">

    <div v-for="komen in commentar" v-bind:key="komen.id">
        <komentar-comp :comment="komen" @refreshDetailPage="getSastra"></komentar-comp>
    </div>
</template>

<script>
import PostComp from '../components/auth/SastraComp.vue'
import ErrorMessage from '../components/utils/ErrorMessage.vue'
import axios from 'axios'
import { mapActions, mapGetters } from 'vuex'
import FormKomenComp from '../components/auth/FormKomenComp.vue'
import KomentarComp from '../components/auth/KomentarComp.vue'

export default {
    components: {
        PostComp,
        ErrorMessage,
        FormKomenComp,
        KomentarComp
    },
    data() {
        return {
            sastras: '',
            message: '',
            sastra_id: '',
            commentar: ''
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    watch: {
        '$route'(to, from) {
            if (to !== from) {
                this.sastras = this.getSastra();
            }
        }
    },
    mounted() {
        this.getSastra()
    },
    methods: {
        ...mapActions(["gettitleheader"]),
        async getSastra() {
            try {
                const response = await axios.get(`/api/sastras/p/${this.$route.params.slug}`)
                this.sastras = response.data.data.sastras
                this.commentar = response.data.data.sastras[0].comment.reverse()
                this.sastra_id = response.data.data.sastras[0].id
                this.gettitleheader(response.data.data.sastras[0].title)
            } catch (error) {
                const { response, request } = error;
                if (response.status == 404) {
                    this.sastras = ''
                    this.message = 'Hmm...this page doesn’t exist. Try searching for something else.'
                } else if (request) {
                    console.log(request);
                } else {
                    console.log('Error', error.message);
                }
            }
        }
    }
}
</script>

<style>

</style>
