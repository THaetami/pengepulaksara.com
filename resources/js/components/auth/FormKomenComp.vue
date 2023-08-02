<template>
<div class="inline-block w-full mt-2 border-black">
    <form class="pb-2">
        <textarea @input="resize()" v-model="comentar"  class="p-3 focus:outline-none overflow-hidden border-b-4 w-full" style="height: 68px;" ref="textarea" placeholder="Komentar disini" autofocus></textarea>

        <div class="flex justify-end">
            <button :disabled="!formValid" @click.prevent="handleSubmit" :class="{ 'bg-red-500': !formValid }" class="mt-0 bg-blue-500 px-5 py-0.5 mr-1 text-white block text-sm hover:bg-red-500 rounded-lg" type="submit">Komentar</button>
        </div>
    </form>
</div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'FormKomenComp',
    emits: ['refreshDetailPage'],
    props: ['sastraId'],
    data() {
        return {
            comentar: '',
            errorCommentMessage: ''
        }
    },
    computed: {
        formValid() {
            return this.comentar != 0;
        },
    },
    methods: {
        resize() {
            let element = this.$refs["textarea"];

            element.style.height = "20px";
            element.style.height = element.scrollHeight + "px";
        },
        async handleSubmit() {
            try {
                await axios.post('/api/comments', {
                    commentar: this.comentar,
                    sastra_id: this.sastraId,
                });
                this.comentar = ''
                let element = this.$refs.textarea;
                element.style.height = "70px";
                this.$emit('refreshDetailPage')

            } catch (error) {
                const { response, request } = error;
                if (response) {
                    const message = response.data.errors;
                    this.errorCommentMessage = message.commentar[0];
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
