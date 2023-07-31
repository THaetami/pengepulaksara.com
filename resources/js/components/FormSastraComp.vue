<template>
<form class="mt-1 w-full">
    <label for="judul">
        <span class="block font-semibold text-slate-700 after:content-['*'] after:text-pink-500 ml-2 mb-1 select-none">Judul</span>
        <input v-model.trim="title" type="text" maxlength="30" placeholder="Tulis judul puisi disini.." class="mb-3 px-2 py-2 border-black shadow-sm w-full block text-sm placeholder:text-slate-600 focus:outline-none" />
        <small v-if="titleErrorMessage" class="text-red-500 mt-0">{{ titleErrorMessage }}</small>
    </label>
    <label for="body">
        <span class="block font-semibold text-slate-700 after:content-['*'] after:text-pink-500 ml-2 mb-1 select-none">Body</span>
        <textarea v-model.trim="body" @input="resize" type="text" class="p-2 focus:outline-none text-sm w-full border-black shadow-sm placeholder:text-slate-600" ref="textarea" placeholder="Tulis Puisimu disini" id="body">
        </textarea>
        <small v-if="bodyErrorMessage" class="text-red-500">{{ bodyErrorMessage }}</small>
    </label>

    <div class="flex justify-end">
        <div class="flex justify-end">
            <button :disabled="!formValid" @click.prevent="handleSubmit" :class="{ 'bg-red-500': !formValid }" class=" bg-blue-500 px-5 mb-4 py-0.5 mr-1 text-white block text-sm rounded md:rounded-none">Posting</button>
        </div>
    </div>
</form>
</template>

<script>
import axios from 'axios';
import { mapActions } from 'vuex';

export default {
    name: 'FormComp',
    data() {
        return{
            title: '',
            body: '',
            titleErrorMessage: '',
            bodyErrorMessage: '',
        }
    },
    computed: {
        formValid() {
            return this.title.length != 0 && this.body.length != 0;
        },
    },
    methods: {
        ...mapActions(["getaddsastranotif"]),
        resize() {
            let element = this.$refs["textarea"];

            element.style.height = "18px";
            element.style.height = element.scrollHeight + "px";
        },
         async handleSubmit() {
            try {
                const response = await axios.post('/api/sastras', {
                    title: this.title,
                    body: this.body,
                });
                this.title = ''
                this.body = ''
                this.$emit('refreshSastra')
                let element = this.$refs.textarea;
                element.style.height = "70px";

                console.log(response)
                this.getaddsastranotif(response.data.data.addedSastra.slug)
                this.$emit('close')
                setTimeout(() => {
                    this.$store.dispatch('getaddsastranotif', null)
                }, 5000)
            } catch (error) {
                const { response, request } = error;
                if (response) {
                    const message = response.data.errors;
                    this.titleErrorMessage = message.title[0];
                    this.bodyErrorMessage = message.body[0];
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

