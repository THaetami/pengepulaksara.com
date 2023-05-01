<template>
<div class="hover-animation even z-10 bg-main-background/60 px-4 py-2 backdrop-blur-md sticky top-0 flex items-center justify-between">
    <search-comp v-if="isSearchPage"></search-comp>

    <template v-else>
        <div class="flex gap-4">
            <button v-if="user" @click="$emit('showSidebar')" aria-label="button sidebar" class="custom-button main-tab accent-tab p-0 xs:hidden">
                <div class="blur-picture flex self-start pointer-events-none">
                    <figure style="width: 30px;">
                        <span style="box-sizing: border-box; display: block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: relative;">
                            <img v-if="user.image" :src="'/storage/upload/' + user.image" class="rounded-full w-7 h-7" :alt="user.username">
                            <no-image v-else></no-image>
                        </span>
                    </figure>
                </div>
            </button>
            <h2 class="text-md font-medium md:text-xl md:font-bold">{{ titleheader }}</h2>
        </div>
        <button v-if="isShowButtonBack" @click="$router.go(-1)" aria-label="button back" class=" custom-button main-tab dark-bg-tab group relative p-2 md:p-0 hover:bg-light-primary/10 active:bg-light-primary/20 dark:hover:bg-dark-primary/10 dark:active:bg-dark-primary/20">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 md:h-8 md:w-8 hover:text-red-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="1">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
            </svg>
            <div class="invisible absolute left-1/2 -translate-x-1/2 whitespace-nowrap rounded bg-[#666666] px-1 py-0.5 text-xs text-white opacity-0 [transition:visibility_0ms_ease_200ms,opacity_200ms_ease] dark:bg-[#495A69] group-hover:visible group-hover:opacity-100 group-hover:delay-500 group-focus-visible:visible group-focus-visible:opacity-100 translate-y-3">
                <span>Back</span>
            </div>
        </button>
    </template>
</div>
</template>

<script>
import NoImage from './NoImage.vue'
import SearchComp from '../components/SearchComp.vue'
import { mapGetters } from 'vuex';

export default {
    name: 'HeaderComp',
    components: {
        NoImage,
        SearchComp,
    },
    computed: {
        isSearchPage() {
            return this.$route.name === 'SearchPage';
        },
        isShowButtonBack() {
            return this.$route.name !== 'HomePage';
        },
        ...mapGetters(['titleheader','user'])
    }
}
</script>
