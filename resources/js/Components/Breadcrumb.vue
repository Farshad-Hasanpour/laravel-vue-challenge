<template>
    <div class="flex items-center space-x-3 text-2xl font-semibold text-gray-100">
        <Link :href="route('dashboard')">Dashboard</Link>
        <span>&gt;</span>
        <template v-for="(item, index) in items" :key="index">
            <Link v-if="item.link" :href="item.link">
                {{ item.text }}
            </Link>
            <span v-else>{{ item.text }}</span>
            <span v-if="index !== items.length - 1">&gt;</span>
        </template>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    items: {required: true, type: Array}
})
</script>
