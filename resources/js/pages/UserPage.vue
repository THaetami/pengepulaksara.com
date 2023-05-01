<template>
    <section style="opacity: 1;">
        <div class="mt-0.5 h-36">
            <div class="h-full" style="background: radial-gradient(circle, rgba(198,46,62,1) 8%, rgba(38,126,230,1) 100%);"></div>
        </div>
        <div class="relative flex flex-col gap-3 px-2 py-3">
            <div class="flex justify-between">
                <div class="mb-0">
                    <button v-if="userpage" aria-label="photo profile" class="custom-button main-tab accent-tab absolute -mt-3 aspect-square w-24 -translate-y-1/2 overflow-hidden p-0 disabled:cursor-auto disabled:opacity-100 xs:w-32 sm:w-36">
                        <figure class="hover-animation relative h-full w-full bg-main-background inner:!m-1 inner:rounded-full inner:transition inner:duration-200">
                            <span style="box-sizing: border-box; display: block; overflow: hidden; width: initial; height: initial; background: none; opacity: 1; border: 0px; margin: 0px; padding: 0px; position: absolute; inset: 0px;">
                                <img v-if="userpage.user.image" :src="'/storage/upload/' + userpage.user.image" :alt="userpage.user.username" style="position: absolute; inset: 0px; box-sizing: border-box; padding: 0px; border: none; margin: auto; display: block; width: 0px; height: 0px; min-width: 100%; max-width: 100%; min-height: 100%; max-height: 100%;" class="rounded-full object-cover" sizes="100vw">
                                <svg v-else xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" class="cls-ahad cls-isnani cls-salasatun cls-arbangatun cls-khomsatun cursor-pointer" viewBox="0 0 1500 1500">
                                    <logo-comp></logo-comp>
                                </svg>
                            </span>
                        </figure>
                    </button>
                </div>
            </div>
            <div v-if="userpage" class="cover-des">
                <div class="flex justify-end ">
                    <svg viewBox="0 0 24 24" aria-label="Verified account" class="h-4 w-4 cursor-pointer" fill="currentColor"
                        style="color: rgb(29, 155, 240); border-color: rgb(29, 155, 240);">
                        <g>
                            <path
                                d="M22.5 12.5c0-1.58-.875-2.95-2.148-3.6.154-.435.238-.905.238-1.4 0-2.21-1.71-3.998-3.818-3.998-.47 0-.92.084-1.336.25C14.818 2.415 13.51 1.5 12 1.5s-2.816.917-3.437 2.25c-.415-.165-.866-.25-1.336-.25-2.11 0-3.818 1.79-3.818 4 0 .494.083.964.237 1.4-1.272.65-2.147 2.018-2.147 3.6 0 1.495.782 2.798 1.942 3.486-.02.17-.032.34-.032.514 0 2.21 1.708 4 3.818 4 .47 0 .92-.086 1.335-.25.62 1.334 1.926 2.25 3.437 2.25 1.512 0 2.818-.916 3.437-2.25.415.163.865.248 1.336.248 2.11 0 3.818-1.79 3.818-4 0-.174-.012-.344-.033-.513 1.158-.687 1.943-1.99 1.943-3.484zm-6.616-3.334l-4.334 6.5c-.145.217-.382.334-.625.334-.143 0-.288-.04-.416-.126l-.115-.094-2.415-2.415c-.293-.293-.293-.768 0-1.06s.768-.294 1.06 0l1.77 1.767 3.825-5.74c.23-.345.696-.436 1.04-.207.346.23.44.696.21 1.04z">
                            </path>
                        </g>
                    </svg>
                    <div class="profile-name font-bold pointer-events-none -mb-1 text-xl truncate">{{ userpage.user.name }}</div>
                </div>

                <div class="flex justify-end font-bold pointer-events-none -mb-1 text-lg">
                    <div>{{ userpage.user.username }}</div>
                </div>
                <div class="flex justify-end ">
                    <p>{{ sastracount }} Sastra </p>
                </div>
                <div class="flex justify-end ">
                    <small>Joined: {{ formatDate(userpage.user.created_at) }}</small>
                </div>
            </div>
            <div v-else class="cover-des">
                <div class="flex justify-end ">
                    <div class="profile-name font-bold pointer-events-none -mb-1 text-xl truncate">Not Found</div>
                </div>
            </div>
        </div>
    </section>

    <nav v-if="userpage" class="nav list-reset flex flex-row">
        <div class="nav mr-0 flex-1">
            <router-link :to="{ name: 'SastraUser', params: { username: this.$route.params.username} }" class="nav-link flex align-middle font-semibold md:text-base border-b-2 border-t-2 select-none">
                <div dir="auto" class="py-1 mx-auto bg-white inline-block text-md">
                    {{ sastracount }} Sastra
                </div>
            </router-link>
        </div>
        <div class="nav mr-0 flex-1 cursor-pointer">
            <router-link :to="{ name: 'LikePage', params: { username: this.$route.params.username} }" v-if="user" class="nav-link flex align-middle font-semibold md:text-base border-b-2 border-t-2 select-none">
                <div dir="auto" class="bg-white py-1 mx-auto inline-block text-md">
                    {{ likecount }} Likes
                </div>
            </router-link>
            <router-link :to="{ name: 'LoginPage' }" v-else class="nav-link flex align-middle font-semibold md:text-base border-b-2 border-t-2 select-none">
                    <div dir="auto" class="py-1 bg-white mx-auto inline-block text-md">
                        {{ likecount }} Likes
                    </div>
                </router-link>
        </div>
    </nav>

    <router-view></router-view>
</template>

<script>
import LogoComp from '../components/LogoComp.vue'
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            }
    },
    components: {
        LogoComp
    },
    computed: {
        ...mapGetters(['userpage','user', 'likecount', 'sastracount'])
    },
    methods: {
        formatDate(dateStr) {
            const date = new Date(dateStr);
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            const formattedDate = date.toLocaleDateString('id-ID', options);
            return formattedDate;
        },
    }

}
</script>

<style></style>
