<template>
<div class="px-4">
    <div class="flex justify-center">
        <my-upload field="img"
            @crop-success="cropSuccess"
            @crop-upload-success="cropUploadSuccess"
            @crop-upload-fail="cropUploadFail"
            v-model="show"
            :width="200"
            :langType="en"
            :height="200"
            url="/api/profilepicture"
            :headers="headers"
            img-format="png"></my-upload>
        <img v-if="user.image" :src="'/storage/upload/' + user.image" class="w-[200px] h-[200px] border-2 rounded-full" :alt="user.name">
        <svg v-else xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1"
            viewBox="0 0 400 400"
            class="cls-1 cls-2 cls-3 w-[200px] h-[200px] border rounded-full">
            <circle class="cls-1" cx="200" cy="200" r="195" />
            <path class="cls-2"
                d="M199.65,394.63a194,194,0,0,0,110-34,129,129,0,0,0-222.89-2A194.08,194.08,0,0,0,199.65,394.63Z" />
            <path class="cls-2"
                d="M128.15,170.13c7.09-50.41,34-79,86-71,27.27,4.18,46.85,24.31,57,64,6,43.92-1.48,72.51-23,85-10.49,6.47-29,8.48-52,8-26.83-.05-48-5.58-59-21C127.15,224.13,125.15,201.2,128.15,170.13Z" />
            <path class="cls-3"
                d="M17.48,130.32q5.15,2.19,10.38,4.48c3.65,1.6,7.25,3.22,10.79,4.83.33,1,.66,2,1,3l8-1c.44-.93.89-1.87,1.33-2.81l5,1v1l3-1v3l3-1v2l2-1,7,4,5,1,2,1,6,1,1,1,8,1,3,2,7,2,1,1,5,1,1,2,4-1,1,1,4,1,6,1,4,1,3,2,3,1h7v2h8l1,2h7l1,2h18v2h6v1h7l1,1h7l2,2h6v3h3l9,6h5v2l5,1v1h12l6,4h4l2,1h2l1,2,5-1,2,1,3,1,22,1s28.19,17.31,30,30v10l9,15h4l3,2,20,18v1l6,1,7,2h7v1h7a37.49,37.49,0,0,1,6-18l-8,21-17-1-3,1-8-2-1-5-15-13-7-4-4-2v-6l-8-10-1-13c-3.46-8.71-9.71-15.91-18-22l-2-2-3-2-7,1-13-1h-6l-1-1H247l-4-2-2-1-3-1h-2l-2-2h-5l-1-2h-6l-6-3-9-1-12-7-2-1-6-1-2-1-10-1-2-2-8-1v2h-4l-2-2h-5c-4.67-.07-7.83-1-9-3h-7l-5-3h-7a42.82,42.82,0,0,1-18-5l-10-3c-6.22-1.35-11-3.62-14-7H75l-7-2a32.32,32.32,0,0,1-16-9H33c-6.07-1.63-11.33-3.67-14-7H15l-2,7Z" />
            <path class="cls-3"
                d="M394.65,209.63a76.91,76.91,0,0,0-20-17c-13.77-.69-23.81,8.19-32.5,20.5a57.16,57.16,0,0,1,17-19,44.1,44.1,0,0,1,11-4,170.78,170.78,0,0,0-20.5-21.5,108.12,108.12,0,0,0-17-11,45.61,45.61,0,0,0-10-12c-3.39-4.08-8.39-8.06-14-12a100.07,100.07,0,0,1-17-13,61.86,61.86,0,0,0-15-8,34,34,0,0,0-14-3c-9.47-2.77-18-.72-26,4,3.92-2.82,7.73-5.24,11-6,6.89-.91,12.72-1,17,0a34.25,34.25,0,0,0-9-8c-1.32-4.75-4.58-8.46-10-11v-8l2,7a26.31,26.31,0,0,1,9,11,48.55,48.55,0,0,1,10,8l3,2,9,4,11,6,11,8,14,10,19,21,13,8,17,14,9,10,4,1a131.38,131.38,0,0,1,18,15Z" />
        </svg>
    </div>
    <div class="flex justify-center mt-3">
        <button class="text-black select-none cursor-pointer md:text-white font-semibold mb-2 bg-blue-900 md:bg-black hover:bg-red-500 focus:ring-none rounded-sm md:rounded text-md w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" @click="toggleShow">set avatar</button>
    </div>

    <form>
        <div class="mb-4">
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">Nama</label>
            <input v-model.trim="user.name" @input="validateName" type="text"  id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm md:rounded focus:outline-none focus:ring-1 focus:ring-black block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
            <small v-if="nameErrorMessage" class="text-red-500">{{ nameErrorMessage }}</small>
        </div>


        <div class="mb-4">
            <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">Username</label>
            <input v-model.trim="user.username" @input="validateUsername" id="username" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm md:rounded focus:outline-none focus:ring-1 focus:ring-black block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
            <small v-if="usernameErrorMessage" class="text-red-500">{{ usernameErrorMessage }}</small>
        </div>

        <div class="mb-4">
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">Masukan Email Baru (Ganti)</label>
            <input v-model.trim="user.email" @input="validateEmail" id="email" type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm md:rounded focus:outline-none focus:ring-1 focus:ring-black block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="">
            <small v-if="emailErrorMessage" class="text-red-500">{{ emailErrorMessage }}</small>
        </div>

        <div class="mb-4">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300 select-none">Masukan Password Baru (Ganti)</label>
            <input v-model.trim="user.password" @input="validatePassword" :type="passwordFieldType" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-sm md:rounded focus:outline-none focus:ring-1 focus:ring-black block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <small v-if="passwordErrorMessage" class="text-red-500">{{ passwordErrorMessage }}</small>
        </div>

        <div class="flex items-start mb-2 lg:mb-4">
            <div class="flex items-center h-5">
                <input v-model="showPassword" id="show-hide" aria-describedby="show-hide" type="checkbox" class="w-4 h-4 bg-gray-50 rounded-sm md:rounded border border-gray-300 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800">
            </div>
            <div class="ml-3 text-sm">
                <label for="show-hide" class="font-medium text-gray-900 dark:text-gray-300">show/hide</label>
            </div>
        </div>

        <div class="flex justify-end">
            <button @click="showModalUpdate = true" type="button" class="text-black md:text-white font-semibold mb-2 bg-blue-900 md:bg-black hover:bg-red-500 focus:ring-none rounded-sm md:rounded text-md w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
        </div>
    </form>
</div>

<modal-master :show="showModalUpdate">
    <template #header>
        <h2 class="text-lg ">Udate Profile</h2>
    </template>
    <template #body>
        Data anda akan diupdate, yakin??
    </template>
    <template #footer>
        <button class="justify-end p-2 pt-0 pb-0 rounded-md bg-yellow-400 hover:bg-yellow-600" style="font-weight: bold;" @click="showModalUpdate = false">Cancel</button>
        <button class="justify-end p-2 pt-0 pb-0 rounded-md bg-red-500 ml-1 hover:bg-red-800" style="font-weight: bold;" @click.prevent="updateUser">Update</button>
    </template>
</modal-master>
</template>



<script>
import myUpload from 'vue-image-crop-upload'
import axios from 'axios'
import { mapActions } from 'vuex'
import { validateInputName, validateInputUsername, validateInputEmail, validateInputPassword } from '../utils/validation';
import ModalMaster from '../components/utils/ModalMaster.vue'

export default {
    name: 'ProfilePage',
    props: ['id'],
    components: {
        ModalMaster,
        myUpload,
    },
    data() {
        return {
            showPassword: false,
            showModalUpdate: false,
            nameErrorMessage: '',
            usernameErrorMessage: '',
            emailErrorMessage: '',
            passwordErrorMessage: '',
            user: '',
            show: false,
            en: {
                hint: 'Click or drag the file here to upload',
                loading: 'Uploading…',
                noSupported: 'Browser is not supported, please use IE10+ or other browsers',
                success: 'Upload success',
                fail: 'Upload failed',
                preview: 'Preview',
                btn: {
                    off: 'Cancel',
                    close: 'Close',
                    back: 'Back',
                    save: 'Save'
                },
                error: {
                    onlyImg: 'Image only',
                    outOfSize: 'Image exceeds size limit: ',
                    lowestPx: 'Image\'s size is too low. Expected at least: '
                }
            },
        }
    },
    computed: {
        passwordFieldType() {
            return this.showPassword ? 'text' : 'password';
        },
    },
    mounted() {
        this.getUser()
    },
    methods: {
        toggleShow() {
            this.show = !this.show;
        },
        cropSuccess(imgDataUrl) {
            console.log('-------- crop success --------');
            this.imgDataUrl = imgDataUrl;
        },
        cropUploadSuccess(jsonData, field) {
            console.log('-------- upload success --------');
            console.log(jsonData);
            console.log('field: ' + field);
        },
        cropUploadFail(status, field) {
            console.log('-------- upload fail --------');
            console.log(status);
            console.log('field: ' + field);
        },

        ...mapActions(["gettitleheader"]),
        async getUser() {
            try {
                const response = await axios.get('/api/user')
                this.gettitleheader("Update Profile")
                this.user = response.data.data.user
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
            }
        },
        validateName() {
            this.nameErrorMessage = validateInputName(this.user.name);
        },
        validateUsername() {
            this.usernameErrorMessage = validateInputUsername(this.user.username);
        },
        validateEmail() {
            this.emailErrorMessage = validateInputEmail(this.user.email);
        },
        validatePassword() {
            this.passwordErrorMessage = validateInputPassword(this.user.password);
        },
        async updateUser() {
            try {
                await axios.patch('/api/users', {
                    name: this.user.name,
                    username: this.user.username,
                    email: this.user.email,
                    password: this.user.password
                })
                this.$router.go()
                this.getUser()
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
        },
    }
}
</script>

<style scoped>
.image-upload>input {
    visibility: hidden;
    width: 0;
    height: 0
}

.cls-1 {
    fill: #ec1c38;
}

.cls-2 {
    fill: #3b54a3;
}

.cls-3 {
    fill: #01080e;
}
</style>












