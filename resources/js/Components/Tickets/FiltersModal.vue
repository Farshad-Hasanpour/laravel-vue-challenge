<script setup>
import Modal from '@/Components/Modal.vue';
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Dropdown from '@/Components/Dropdown.vue';
import { DatePicker } from 'v-calendar';

const emit = defineEmits(['update:model-value']);
const props = defineProps({
    modelValue: { required: true, type: Boolean },
    filters: { required: true, type: Object }
})

function reset(){
    props.filters.title = '';
    props.filters.description = '';
    props.filters.userName = '';
    props.filters.userEmail = '';
    props.filters.startDate = null;
    props.filters.endDate = null;
    props.filters.priority = null;
    props.filters.status = null;
}
</script>

<template>
    <Modal
        :show="modelValue"
        @close="emit('update:model-value', false)"
    >
        <div class="p-4 flex justify-between items-center text-white">
            <div>
                <h3 class="text-3xl">Filters</h3>
                <span class="text-gray-300 text-md">Filter are real time</span>
            </div>
            <button class="p-2 uppercase text-white" @click="emit('update:model-value', false)">&#x2715;</button>
        </div>
        <form ref="form" class="grid grid-cols-6 gap-4 p-4" @submit.prevent>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Title" class="mb-1" />
                <TextInput
                    v-model="filters.title"
                    class="w-full"
                />
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Content" class="mb-1" />
                <TextInput
                    v-model="filters.description"
                    class="w-full"
                />
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Username" class="mb-1" />
                <TextInput
                    v-model="filters.userName"
                    class="w-full"
                />
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="User Email" class="mb-1" />
                <TextInput
                    v-model="filters.userEmail"
                    type="email"
                    inputmode="email"
                    class="w-full"
                />
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Start From" class="mb-1" />
                <DatePicker
                    v-model="filters.startDate"
                    mode="date"
                    :popover="{visibility: 'click'}"
                >
                    <template #default="{ inputValue, inputEvents }">
                        <TextInput
                            :value="inputValue"
                            v-on="inputEvents"
                            readonly
                            class="w-full"
                        />
                    </template>
                </DatePicker>
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Until" class="mb-1" />
                <DatePicker
                    v-model="filters.endDate"
                    mode="date"
                    readonly
                    :popover="{visibility: 'click'}"
                >
                    <template #default="{ inputValue, inputEvents }">
                        <TextInput
                            :value="inputValue"
                            v-on="inputEvents"
                            class="w-full"
                        />
                    </template>
                </DatePicker>
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Priority" class="mb-1" />

            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Status" class="mb-1" />

            </div>
        </form>
        <div class="w-full flex justify-center items-center p-4 space-x-2">
            <DangerButton type="button" @click="reset">Reset</DangerButton>
            <PrimaryButton
                type="button"
                @click="emit('update:model-value', false)"
            >Close</PrimaryButton>
        </div>
    </Modal>
</template>

<style>
@import 'v-calendar/dist/style.css';
</style>

<style scoped></style>
