<template>
    <login-register-modal>
        <template #form>
           <form class="overflow-auto py-2 md:py-4 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
                <div class="relative">
                    <input v-model.trim="name" @input="validateName"  autocomplete name="name" type="text" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600" placeholder="name" />
                    <label for="name" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Nama</label>
                    <small v-if="nameErrorMessage" class="text-red-500">{{ nameErrorMessage }}</small>
                </div>
                <div class="relative">
                    <input v-model.trim="username" @input="validateUsername"  autocomplete name="username" type="text" class="peer placeholder-transparent h-10 w-full border-b-2 border-gray-300 text-gray-900 focus:outline-none focus:borer-rose-600" placeholder="username" />
                    <label for="username" class="absolute left-0 -top-3.5 text-gray-600 text-sm peer-placeholder-shown:text-base peer-placeholder-shown:text-gray-440 peer-placeholder-shown:top-2 transition-all peer-focus:-top-3.5 peer-focus:text-gray-600 peer-focus:text-sm">Username</label>
                    <small v-if="usernameErrorMessage" class="text-red-500">{{ usernameErrorMessage }}</small>
                </div>
                <div class="relative">
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
                <div class="relative mt-0">
                    <button :disabled="!formValid" @click.prevent="handleSubmit" :class="{ 'bg-blue-300': !formValid }" class="w-full bg-blue-500 text-white rounded-md px-2 py-1">Register</button>
                    <p><small> Have an account already? <router-link :to="{name: 'LoginPage'}" class="hover:underline hover:text-blue-500 cursor-pointer" @click="setPage" >Sign in</router-link> </small></p>
                </div>
            </form>
        </template>
    </login-register-modal>
</template>

<script>
import axios from 'axios'
import LoginRegisterModal from '../components/guest/LoginRegisterModal.vue';
import { validateInputName, validateInputUsername, validateInputEmail, validateInputPassword } from '../utils/validation';


export default {
    name: 'RegisterPage',
    components: {
        LoginRegisterModal
    },
    data() {
        return {
            name: '',
            email: '',
            username: '',
            password: '',
            showPassword: false,
            nameErrorMessage: '',
            usernameErrorMessage: '',
            emailErrorMessage: '',
            passwordErrorMessage: '',
        }
    },
    mounted() {
        document.title = `Register | Pengepulaksara`
    },
    computed: {
        passwordFieldType() {
            return this.showPassword ? 'text' : 'password';
        },
        formValid() {
            return this.name.length > 0 && this.username.length > 0 && this.email.length > 0 && this.password.length > 0;
        },
    },
    methods: {
        setPage() {
            const page = localStorage.getItem('page')
            if (page) {
                localStorage.setItem('page', parseInt(page) + 1)
            } else {
                localStorage.setItem('page', 1)
            }
        },
        validateName() {
            this.nameErrorMessage = validateInputName(this.name);
        },
        validateUsername() {
            this.usernameErrorMessage = validateInputUsername(this.username);
        },
        validateEmail() {
            this.emailErrorMessage = validateInputEmail(this.email);
        },
        validatePassword() {
            this.passwordErrorMessage = validateInputPassword(this.password);
        },
        async handleSubmit() {
            try {
                await axios.post('/api/users', {
                    name: this.name,
                    email: this.email,
                    username: this.username,
                    password: this.password,
                });
                this.valid = false
                this.name = ''
                this.email = ''
                this.username = ''
                this.password = ''
                this.$router.push({ name: 'LoginPage' })
            } catch (error) {
                const { response, request } = error;
                if (response) {
                    const message = response.data.errors;
                    this.usernameErrorMessage = message.username;
                    this.emailErrorMessage = message.email;
                    this.nameErrorMessage = message.name;
                    this.passwordErrorMessage = message.password;
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


