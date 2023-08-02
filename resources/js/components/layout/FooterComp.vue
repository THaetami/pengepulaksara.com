<template>
<div class="flex w-full fixed bottom-0 inset-x-0 bg-blue-600 p-2 md:p-4 justify-center gap-0 lg:gap-4">
    <div class="hidden md:flex w-0 shrink-0 xs:w-20 md:w-24 lg:max-w-none xl:-mr-4 xl:w-full xl:max-w-xs xl:justify-end"></div>
    <div class="text-white hidden md:flex w-full max-w-xl flex-col">
        <p class="text-xl font-extrabold">Jangan Hawatir,</p>
        <p>Masih banyak sastra yang lain, silahkan login untuk melihat.</p>
    </div>
    <div class="flex w-96 gap-4 p-0 md:px-4 md:py-3 pt-1 justify-start font-bold md:justify-end">
        <button @click="$router.push({ name: 'LoginPage' })" class="rounded-full bg-white p-2 w-full md:w-[6rem]">Log in</button>
        <button @click="$router.push({ name: 'RegisterPage' })"  class="rounded-full bg-white p-2 w-full md:w-[6rem]">Signup</button>
    </div>
</div>
</template>

<script>
export default {
    name: 'FooterComp',
}
</script>
