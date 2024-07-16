<script setup>
import { computed, watch } from 'vue';

const props = defineProps({
    totalItems: Number,
    currentPage: Number,
    perPage: Number
});

const emits = defineEmits(['update:currentPage']);

const totalPages = computed(() => {
    return Math.ceil(props.totalItems / props.perPage);
});
watch(totalPages, (newVal, oldVal) => {
    if(newVal < oldVal && newVal && props.currentPage > newVal){
        goToPage(newVal)
    }
})

function goToPage(page) {
    emits('update:currentPage', page);
}
</script>

<template>
    <div class="pagination flex justify-between items-center my-4">
        <button
            type="button"
            :disabled="currentPage === 1"
            class="bg-gray-800 py-2 px-4 text-sm font-medium text-gray-300 hover:bg-gray-700"
            @click="goToPage(currentPage - 1)"
        >
            Previous
        </button>
        <div class="flex space-x-1">
            <button
                v-for="page in totalPages"
                :key="page"
                type="button"
                class="py-2 px-4 leading-tight bg-gray-800 border border-gray-600 text-gray-400 hover:bg-gray-700 hover:text-white"
                :class="{ 'bg-blue-600 text-white': page === currentPage }"
                @click="goToPage(page)"
            >
                {{ page }}
            </button>
        </div>
        <button
            type="button"
            :disabled="currentPage === totalPages"
            class="bg-gray-800 py-2 px-4 text-sm font-medium text-gray-300 hover:bg-gray-700"
            @click="goToPage(currentPage + 1)"
        >
            Next
        </button>
    </div>
</template>

<style scoped>
.pagination button[disabled]{
    opacity: .4;
}
</style>
