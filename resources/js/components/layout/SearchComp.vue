<template>
    <div class="dropdown hover-animation w-full sticky top-0 z-10 -my-2 py-2">
        <div :tabindex="0">
            <div class="group flex items-center justify-between gap-4 rounded-full bg-main-search-background px-4 py-2  focus-within:bg-main-background focus-within:ring-2 focus-within:ring-main-accent bg-gray-200">
                <i>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-5 w-5 text-light-secondary transition-colors group-focus-within:text-main-accent dark:text-dark-secondary">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"></path>
                    </svg>
                </i>

                <input @input="searchUser" @keyup.enter="searchSastra" v-model.trim="search" class="peer flex-1 bg-transparent outline-none placeholder:text-light-secondary dark:placeholder:text-dark-secondary"
                    type="search" placeholder="Cari Pengepul, Judul atau penggalan sastra">

                <button aria-label="button search" class="custom-button main-tab accent-tab scale-50 bg-main-accent p-1 opacity-0 transition hover:brightness-90 disabled:opacity-0" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" class="h-3 w-3 stroke-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>

        <div tabindex="0" class="dropdown-content w-full overflow-y-auto mt-2 h-[13rem] shadow bg-white rounded-lg">
            <div v-for="user in users" v-bind:key="user.id" class="flow-root">
                <div class="p-8 py-3">
                    <router-link :to="{ name: 'SastraUser', params: { username: user.username }}"  class="flex items-center space-x-4 mb-2">
                        <div class="flex-shrink-0">
                            <no-image :sizes='12'></no-image>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="text-md font-medium">
                                <p class="hover:underline text-black cursor-pointer">{{ user.username }}</p>
                            </div>
                        </div>
                    </router-link>
                </div>
            </div>
            <div v-if="users.length" v-observe-visibility="handleSrolledBottom"></div>
        </div>
    </div>
</template>

<script>
import NoImage from '../utils/NoImage.vue';
import axios from 'axios';
import { mapActions } from 'vuex'


export default {
    name: 'SearchComp',
    components: {
        NoImage
    },
    data() {
        return {
            users: '',
            search: '',
            page: 1
        }
    },
    mounted() {
        this.search = this.$route.query.q
    },
    methods: {
        ...mapActions(["getquery"]),
        async searchUser() {
            if (this.search.trim() !== '') {
                try {
                    const response = await axios.get(`/api/search?user=${this.search}`)
                    this.users = response.data.data.users.data
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
        },
        handleSrolledBottom(isVisible) {
            if (!isVisible) { return }

            this.page++
            this.searchUser()
        },
        async searchSastra() {
            if (this.search.trim() !== '') {
                this.getquery(1)
                this.$router.push({
                    name: 'SearchPage',
                    query: {
                        q: this.search,
                    }
                })
            }
        }
    }
}
</script>

