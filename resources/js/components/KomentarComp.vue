<template>
<div class=" max-w-full bg-slate-200 mt-1 rounded-none xs:rounded-xl ">
    <div class="flow-root">
        <div class="p-2">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <img v-if="comment.user.image" :src="'/storage/upload/' + comment.user.image" class="h-12 w-12 rounded-full" :alt="comment.user.username">
                    <no-image v-else :sizes='12'></no-image>
                </div>

                <div class="flex-1 min-w-0 p-0">
                    <div class="text-md font-medium flex">
                        <div class="flex justify-center dropdown-hover">
                            <router-link :to="{ name: 'SastraUser', params: { username: comment.user.username }}" style="font-weight: 400; color: black;" class="hover:underline text-black cursor-pointer">
                                {{ comment.user.username }}
                            </router-link>
                        </div>
                        <svg viewBox="0 0 24 24" aria-label="Verified account" class="h-5 w-5 select-none focus:ring-0 " fill="currentColor" style="color: rgb(29, 155, 240);">
                            <g>
                                <path d="M22.5 12.5c0-1.58-.875-2.95-2.148-3.6.154-.435.238-.905.238-1.4 0-2.21-1.71-3.998-3.818-3.998-.47 0-.92.084-1.336.25C14.818 2.415 13.51 1.5 12 1.5s-2.816.917-3.437 2.25c-.415-.165-.866-.25-1.336-.25-2.11 0-3.818 1.79-3.818 4 0 .494.083.964.237 1.4-1.272.65-2.147 2.018-2.147 3.6 0 1.495.782 2.798 1.942 3.486-.02.17-.032.34-.032.514 0 2.21 1.708 4 3.818 4 .47 0 .92-.086 1.335-.25.62 1.334 1.926 2.25 3.437 2.25 1.512 0 2.818-.916 3.437-2.25.415.163.865.248 1.336.248 2.11 0 3.818-1.79 3.818-4 0-.174-.012-.344-.033-.513 1.158-.687 1.943-1.99 1.943-3.484zm-6.616-3.334l-4.334 6.5c-.145.217-.382.334-.625.334-.143 0-.288-.04-.416-.126l-.115-.094-2.415-2.415c-.293-.293-.293-.768 0-1.06s.768-.294 1.06 0l1.77 1.767 3.825-5.74c.23-.345.696-.436 1.04-.207.346.23.44.696.21 1.04z">
                                </path>
                            </g>
                        </svg>
                    </div>

                    <small class="custom-button main-tab dark-bg-tab group relative pointer hover:bg-light-primary/10 active:bg-light-primary/20 dark:hover:bg-dark-primary/10 dark:active:bg-dark-primary/20">
                        {{ formatDate(comment.created_at) }}
                        <div class="invisible absolute left-1/2 -translate-x-1/2 whitespace-nowrap rounded bg-[#666666] px-1 py-0.5 text-xs text-white opacity-0 [transition:visibility_0ms_ease_200ms,opacity_200ms_ease] dark:bg-[#495A69] group-hover:visible group-hover:opacity-100 group-hover:delay-500 group-focus-visible:visible group-focus-visible:opacity-100 translate-y-3">
                            <span>{{ isoToWIB(comment.created_at) }}</span>
                        </div>
                    </small>
                </div>

                <section>
                    <div class="dropdown dropdown-left">
                        <label :tabindex="comment.id" class="inline-flex justify-center w-full p-0.5 hover:bg-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </label>
                        <ul v-if="user" :tabindex="comment.id" class="menu dropdown-content bg-base-100 rounded-md w-32 font-bold text-sm mr-1">
                            <li v-if="user.id === comment.user.id">
                                <span @click="openModal(comment.id)" class="cursor-pointer hover:bg-red-500 hover:rounded-md">Hapus</span>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="px-4 sl:px-6 lg:px-10 mb-0 mt-1 pointer ">
        <div style="font-weight: 400" class="text-black px-4 mx-auto whitespace-pre-wrap break-words pb-2 rounded md:rounded-none">{{ comment.commentar }}</div>
    </div>
</div>

<modal-master :show="showDeleteModal" @close="showDeleteModal = false" @delete="deleteComment(id)">
    <template #header>
        <h2 class="text-lg ">Hapus Komentar</h2>
    </template>
    <template #body>
        <p>Yakin commentar dihapus??</p>
    </template>
</modal-master>
</template>

<script>
import NoImage from './NoImage.vue';
import { formatDate, isoToWIB } from '../utils/timeSetting'
import { mapGetters } from 'vuex'
import ModalMaster from './ModalMaster.vue'
import axios from 'axios'

export default {
    name: 'KomentarComp',
    props: ['comment'],
    emits: ['refreshDetailPage'],
    components: {
        NoImage,
        ModalMaster
    },
    data() {
        return {
            showDeleteModal: false,
            id: ''
        }
    },
    computed: {
        ...mapGetters(['user'])
    },
    methods: {
        formatDate,
        isoToWIB,
        openModal(commentId) {
            this.id = commentId
            this.showDeleteModal = true
        },
        async deleteComment(id) {
            try {
                await axios.delete(`/api/comments/${id}`)
                this.showDeleteModal = false
                this.$emit('refreshDetailPage')
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
        }
    }
}
</script>

<style>

</style>
