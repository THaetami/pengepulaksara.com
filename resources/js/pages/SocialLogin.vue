<template>
    <login-register-modal>
        <template #form>
        <h1>Login with github, please await...</h1>
    </template>
    </login-register-modal>
</template>

<script>
import axios from 'axios';
import LoginRegisterModal from '../components/guest/LoginRegisterModal.vue';
export default {
    name: 'SocialLogin',
    components: {
        LoginRegisterModal
    },
    beforeMount() {
        this.getAuth()
    },
    methods: {
        async getAuth() {
            try {
                const response = await axios.get(`/api/auth/${this.$route.params.provider}/call-back?code=${this.$route.query.code}`)
                console.log(response.data.token.accessToken)

                document.cookie = `jwt_token=${response.data.token.accessToken}; path=/; secure; sameSite=lax`;

                this.$router.go()
                this.$router.push({ name: 'HomePage' })
            } catch (error) {
                 console.log('Error', error.message);

            }
        },
    }
}
</script>
