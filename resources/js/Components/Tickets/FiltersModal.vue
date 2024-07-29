<script setup>
import Modal from '@/Components/Modal.vue';
import {Link} from "@inertiajs/vue3";
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Dropdown from '@/Components/Dropdown.vue';
import { DatePicker } from 'v-calendar';

const emit = defineEmits(['update:model-value']);
const props = defineProps({
    modelValue: { required: true, type: Boolean },
    filters: { required: true, type: Object },
    currentPage: { required: true, type: Number},
    allPriorities: { required: true, type: Array },
    allStatus: { required: true, type: Array },
})
</script>

<template>
    <Modal
        :show="modelValue"
        @close="emit('update:model-value', false)"
    >
        <div class="p-4 flex justify-between items-center text-white">
            <div>
                <h3 class="text-3xl">Filters</h3>
                <span class="text-gray-300 text-md">values are evaluated using "OR" logic</span>
            </div>
            <button class="p-2 uppercase text-white" @click="emit('update:model-value', false)">&#x2715;</button>
        </div>
        <form ref="form" class="grid grid-cols-6 gap-4 p-4 mb-12" @submit.prevent>
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
                <InputLabel value="Priority" class="mb-1" />
                <Dropdown width="full">
                    <template #trigger>
                        <TextInput
                            :model-value="filters.priority || ''"
                            class="w-full capitalize"
                            readonly
                        />
                    </template>

                    <template #content>
                        <div class="w-full text-white flex flex-col items-stretch">
                            <button
                                v-for="priority in allPriorities"
                                :key="priority.title"
                                class="py-1 px-4 capitalize text-start hover:bg-white hover:bg-opacity-10"
                                :class="{'hover:bg-white hover:bg-opacity-10': filters.priority === priority.value}"
                                @click="filters.priority = priority.value"
                            >{{priority.title}}</button>
                        </div>
                    </template>
                </Dropdown>
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Status" class="mb-1" />
                <Dropdown width="full">
                    <template #trigger>
                        <TextInput
                            :model-value="filters.status || ''"
                            class="w-full capitalize"
                            readonly
                        />
                    </template>

                    <template #content>
                        <div class="w-full text-white flex flex-col items-stretch">
                            <button
                                v-for="status in allStatus"
                                :key="status.title"
                                class="py-1 px-4 capitalize text-start hover:bg-white hover:bg-opacity-10"
                                :class="{'hover:bg-white hover:bg-opacity-10': filters.status === status.value}"
                                @click="filters.status = status.value"
                            >{{status.title}}</button>
                        </div>
                    </template>
                </Dropdown>
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Start From" class="mb-1" />
                <DatePicker
                    v-model="filters.dateStart"
                    mode="date"
                    :popover="{visibility: 'click'}"
                    :max-date="filters.dateEnd"
                >
                    <template #default="{ inputValue, inputEvents }">
                        <TextInput
                            :model-value="inputValue || ''"
                            readonly
                            class="w-full"
                            v-on="inputEvents"
                        />
                    </template>
                </DatePicker>
            </div>
            <div class="col-span-6 md:col-span-3">
                <InputLabel value="Until" class="mb-1" />
                <DatePicker
                    v-model="filters.dateEnd"
                    mode="date"
                    :popover="{visibility: 'click'}"
                    :min-date="filters.dateStart"
                >
                    <template #default="{ inputValue, inputEvents }">
                        <TextInput
                            :model-value="inputValue || ''"
                            readonly
                            class="w-full"
                            v-on="inputEvents"
                        />
                    </template>
                </DatePicker>
            </div>
        </form>
        <div class="w-full flex justify-center items-center p-4 space-x-2">
            <Link
                :href="route('tickets.index', {
                    ...Object.fromEntries(
                        Object.entries(filters)
                        .filter(([_, value]) => value)
                    ),
                    page: currentPage
                })"
            >
                <PrimaryButton type="button">
                    Filter
                </PrimaryButton>
            </Link>
            <Link :href="route('tickets.index', {page: currentPage})">
                <DangerButton type="button">
                    Reset
                </DangerButton>
            </Link>
            <SecondaryButton
                type="button"
                @click="emit('update:model-value', false)"
            >Close</SecondaryButton>
        </div>
    </Modal>
</template>

<style>
@import 'v-calendar/dist/style.css';
</style>

<style scoped>

</style>
