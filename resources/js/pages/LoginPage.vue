<template>
    <login-register-modal>
        <template #form>
          <div class="max-w-md mx-auto overflow-auto">
            <div class="divide-y divide-gray-200">
              <form class="py-3 md:py-4 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                <div class="relative overflow-auto">
                    <form class="py-3 md:py-4 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7 overflow-auto">
                        <div class="relative ">
                            <input v-model.trim="email" @input="validateEmail" autocomplete type="email" name="email" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600" placeholder="Email address" />
                            <label for="email" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Alamat Email</label>
                            <small v-if="emailErrorMessage" class="text-red-500">{{ emailErrorMessage }}</small>
                        </div>
                        <div class="relative">
                            <input v-model.trim="password" @input="validatePassword" :type="passwordFieldType" autocomplete name="password" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600" placeholder="Password" />
                            <label for="password" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Password</label>
                            <small v-if="passwordErrorMessage" class="text-red-500">{{ passwordErrorMessage }}</small>
                        </div>
                        <div class="relative items-center justify-between">
                            <div class="flex items-center">
                                <input v-model="showPassword"  name="show-hide" id="show-hide" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                                <label for="show-hide" class="ml-2 block text-sm text-gray-900">Show/Hide</label>
                            </div>
                        </div>
                        <div class="relative">
                            <button :disabled="!formValid" @click.prevent="handleSubmit" :class="{ 'bg-blue-300': !formValid }" class="w-full bg-blue-500 text-white rounded-md px-2 py-1">Login</button>
                            <p><small> Don't have an account? <router-link :to="{name: 'RegisterPage'}" class="hover:underline hover:text-blue-500 cursor-pointer" @click="setPage">Sign up</router-link> </small></p>
                        </div>
                        <div class="relative">
                            <button  @click.prevent="handleGithubLogin" class="w-full bg-red-500 text-white rounded-md px-2 py-1">Login with Github</button>
                        </div>
                    </form>
                </div>
            </form>
            </div>
            </div>
        </template>
    </login-register-modal>
</template>

<script>
import axios from 'axios';
import LoginRegisterModal from '../components/guest/LoginRegisterModal.vue';
import { validateInputEmail, validateInputPassword } from '../utils/validation';

export default {
    name: 'LoginPage',
    components: {
        LoginRegisterModal
    },
    data() {
        return {
            email: '',
            password: '',
            showPassword: false,
            emailErrorMessage: '',
            passwordErrorMessage: '',
        }
    },
    computed: {
        passwordFieldType() {
            return this.showPassword ? 'text' : 'password';
        },
        formValid() {
            return  this.email.length > 0 && this.password.length > 0;
        },
    },
    methods: {
        setPage() {
            const page = localStorage.getItem('page')
            if (page) {
                localStorage.setItem('page', parseInt(page)+ 1)
            } else {
                localStorage.setItem('page', 1)
            }
        },
        validateEmail() {
            this.emailErrorMessage = validateInputEmail(this.email);
        },
        validatePassword() {
            this.passwordErrorMessage = validateInputPassword(this.password);
        },
        async handleSubmit() {
            try {
                const response = await axios.post('/api/authentications', {
                    email: this.email,
                    password: this.password,
                });
                this.valid = false
                this.email = ''
                this.password = ''
                document.cookie = `jwt_token=${response.data.token.accessToken}; path=/; secure; sameSite=lax`;
                this.$router.go()
                this.$router.push({ name: 'HomePage' })
            } catch (error) {
                const { response, request } = error;
                if (response) {
                    const message = response.data.message;
                    this.emailErrorMessage = message
                    this.passwordErrorMessage = message;
                } else if (request) {
                    console.log(request);
                } else {
                    console.log('Error', error.message);
                }
            }
        },
        async handleGithubLogin() {
            try {
                const response = await axios.get('/api/auth/github');
                if (response.data.url) {
                    window.location.href = response.data.url
                }

            } catch (error) {
                console.log(error)
            }
        }
    }
}
</script>

<style scoped>
</style>
