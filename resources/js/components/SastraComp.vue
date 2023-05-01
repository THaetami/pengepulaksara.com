<template>
<div class=" max-w-full bg-slate-200 mt-1 rounded-none xs:rounded-xl ">
    <div class="flow-root">
        <div class="p-2">
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0">
                    <router-link :to="{ name: 'SastraUser', params: { username: sastra.user.username } }" aria-label="to profile page">
                        <img v-if="sastra.user.image" :src="'/storage/upload/' + sastra.user.image" class="h-12 w-12 rounded-full" :alt="sastra.user.username">
                        <no-image v-else :sizes='12'></no-image>
                    </router-link>
                </div>

                <div class="flex-1 min-w-0 p-0">
                    <div class="text-md font-medium flex">
                        <div class="flex justify-center dropdown-hover">
                            <router-link :to="{ name: 'SastraUser', params: { username: sastra.user.username }}" style="font-weight: 400; color: black;" class="hover:underline text-black cursor-pointer">
                                {{ sastra.user.username }}
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
                        {{ formatDate(sastra.created_at) }}
                        <div class="invisible absolute left-1/2 -translate-x-1/2 whitespace-nowrap rounded bg-[#666666] px-1 py-0.5 text-xs text-white opacity-0 [transition:visibility_0ms_ease_200ms,opacity_200ms_ease] dark:bg-[#495A69] group-hover:visible group-hover:opacity-100 group-hover:delay-500 group-focus-visible:visible group-focus-visible:opacity-100 translate-y-3">
                            <span>{{ isoToWIB(sastra.created_at) }} </span>
                        </div>
                    </small>
                </div>

                <section>
                    <div class="dropdown dropdown-left">
                        <label :tabindex="sastra.id" class="inline-flex justify-center w-full p-0.5 hover:bg-white rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                            </svg>
                        </label>
                        <ul v-if="user" :tabindex="sastra.id" class="menu dropdown-content bg-base-100 rounded-md w-32 font-bold text-sm mr-1">
                            <li v-if="user.id === sastra.user.id">
                                <span class="cursor-pointer hover:bg-red-500 hover:rounded-md" @click="bukamodal(sastra.id)">Hapus</span>
                            </li>
                        </ul>
                    </div>
                </section>
            </div>
        </div>
    </div>

    <div class="px-4 sl:px-6 lg:px-10 mb-0 mt-1 pointer ">
        <router-link :to="{ name: 'DetailPage', params: { slug: sastra.slug } }">
            <h3 class="font-medium text-black text-center text-xl mb-2">{{ sastra.title }}</h3>
            <div style="font-weight: 400" class="text-black px-4 mx-auto whitespace-pre-wrap break-words pb-2 rounded md:rounded-none">{{ sastra.body }}</div>
        </router-link>
    </div>

    <div class="flow-root">
        <div class="flex items-center space-x-4 px-4">

            <div class="flex px-4 sl:px-6 lg:px-10 mb-0 pb-3 mt-2 ml-2 box-content">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 sd:h-8 sd:w-8 rounded-sm cursor-pointer" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                </svg>
                <p class=" text-sm sd:text-lg py-0 select-none">
                    {{ sastra.comment.length }}
                </p>
            </div>

            <div class="flex-1 min-w-0">
                <div class="flex mb-0 pb-3 mt-2 mr-10 box-content justify-end">
                    <p v-if="user" class="sm-text">
                        <svg xmlns="http://www.w3.org/2000/svg" :class="sastra.like.includes(sastra.like.find(like => like.author_id == user.id)) ? 'aktip' : ''" class="cursor-pointer h-6 w-6 sd:h-8 sd:w-8 rounded-sm  hover:scale-110" viewBox="0 0 20 20" fill="currentColor">
                            <path @click.prevent="addLikes(sastra.id, $event)" fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </p>
                    <router-link :to="{ name: 'LoginPage' }" v-else class="sm-text" aria-label="go to login page">
                        <svg  xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 sd:h-8 sd:w-8 rounded-sm cursor-pointer" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                        </svg>
                    </router-link>
                    <p class=" text-sm sd:text-lg py-0 select-none" ref="count">
                        {{ sastra.like.length }}
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>

<modal-master :show="showDeleteModal" @close="showDeleteModal = false" @delete="deleteSastra(id)">
    <template #header>
        <h2 class="text-lg ">Hapus Sastra</h2>
    </template>
    <template #body>
        <p>Yakin sastra dihapus??</p>
    </template>
</modal-master>
</template>

<script>
import axios from 'axios';
import NoImage from './NoImage.vue'
import { mapGetters, mapActions } from 'vuex';
import ModalMaster from './ModalMaster.vue';
import { formatDate, isoToWIB } from '../utils/timeSetting'


export default {
    props: ['sastra'],
    emits: ['refreshHome','refreshUserPage','refresLikePage','refreshDetailPage','refreshSearchPage','back'],
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
        ...mapActions(["getdeletesastranotif"]),
        async addLikes(sastra_id, e) {
            try {
                const response = await axios.post(`/api/likes/${sastra_id}`)
                e.target.parentElement.parentElement.nextSibling.innerHTML = response.data.count
                const parentClassList = e.target.parentElement.classList;

                if (parentClassList.contains('aktip')) {
                    parentClassList.remove('aktip');
                } else {
                    parentClassList.add('aktip');
                }
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
        bukamodal(sastra_id) {
            this.id = sastra_id
            this.showDeleteModal = true
        },
        async deleteSastra(id) {
             try {
                await axios.delete(`/api/sastras/${id}`)
                this.showDeleteModal = false
                this.$emit('refreshHome')
                this.$emit('refreshUserPage')
                this.$emit('refresLikePage')
                this.$emit('refreshDetailPage')
                this.$emit('back')
                this.$emit('refreshSearchPage')

                this.getdeletesastranotif(true)
                setTimeout(() => {
                    this.$store.dispatch('getdeletesastranotif', null)
                }, 3000)
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

