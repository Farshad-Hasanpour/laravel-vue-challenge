<script setup>
import Modal from '@/Components/Modal.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';

const props = defineProps({
    filters: { required: true, type: Object }
})
</script>

<template>
    <Modal
        :show="filters.show"
        @close="filters.show = false"
    >
        <div class="p-4 flex justify-between items-center text-white">
            <h3 class="text-3xl">Filters</h3>
            <button class="p-2 uppercase text-white" @click="filters.show = false">Close</button>
        </div>
        <div class="grid grid-cols-6 gap-2 p-4">
            <div class="col-span-6 md:col-span-2">
                <InputLabel value="Title" class="mb-1" />
                <TextInput
                    v-model="filters.title"
                    class="w-full"
                />
            </div>
        </div>
    </Modal>
</template>

