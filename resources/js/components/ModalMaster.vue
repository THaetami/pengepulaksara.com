<template>
    <Transition name="modal">
        <div v-if="show" class="modal-mask"
            :style="bg != null ? 'background-color: white;' : 'background-color: rgba(0, 0, 0, 0.5)'">
            <div class="modal-wrapper">
                <div class="modal-container p-5 w-[70%] md:w-[25%]" :class="bg != null ? 'shadow-lg' : ''">
                    <div class="modal-header">
                        <slot name="header">

                        </slot>
                    </div>

                    <div class="modal-body text-sm">
                        <slot name="body">

                        </slot>
                    </div>

                    <div class="modal-footer mt-2 flex justify-end">
                        <slot name="footer">
                            <button class="justify-end p-2 pt-0 pb-0 rounded-md bg-yellow-400 hover:bg-yellow-600"
                                style="font-weight: bold;" @click="$emit('close')">Cancel</button>
                            <button class="justify-end p-2 pt-0 pb-0 rounded-md bg-red-500 ml-1 hover:bg-red-800"
                                style="font-weight: bold;" @click="$emit('delete')">Hapus</button>
                        </slot>
                    </div>
                </div>
            </div>
        </div>
    </Transition>
</template>

<script>
export default {
    name: 'ModalMaster',
    props: ['show', 'bg'],
}
</script>

<style scoped>
.modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: table;
}

.modal-wrapper {
    display: table-cell;
    vertical-align: middle;
}

.modal-container {
    margin: 0px auto;
    background-color: rgba(255, 255, 255, 1.00);
    border-radius: 16px;
    transition: all 0.3s ease;
}

.modal-header h2 {
    margin-top: 0;
    font-size: large;
    font-weight: bold;
}
</style>
