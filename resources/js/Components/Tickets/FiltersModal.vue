<script setup>
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    filters: { required: true, type: Object }
})

function reset(){
    props.filters.title = '';
    props.filters.description = '';
    props.filters.userName = '';
    props.filters.userEmail = '';
    props.filters.date[0] = null;
    props.filters.date[1] = null;
    props.filters.priority = null;
    props.filters.status = null;
}
</script>

<template>
    <Modal
        :show="filters.show"
        @close="filters.show = false"
    >
        <div class="p-4 flex justify-between items-center text-white">
            <div>
                <h3 class="text-3xl">Filters</h3>
                <span class="text-gray-300 text-md">Filter are Real time</span>
            </div>
            <button class="p-2 uppercase text-white" @click="filters.show = false">&#x2715;</button>
        </div>
        <form ref="form" class="grid grid-cols-6 gap-2 p-4" @submit.prevent>
            <div class="col-span-6 md:col-span-2">
                <InputLabel value="Title" class="mb-1" />
                <TextInput
                    v-model="filters.title"
                    class="w-full"
                />
            </div>
        </form>
        <div class="w-full flex justify-center items-center p-4">
            <DangerButton type="button" @click="reset">Reset</DangerButton>
        </div>
    </Modal>
</template>

