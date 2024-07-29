<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    items: Object,
    filters: Object
});
</script>

<template>
    <div class="pagination flex justify-center items-center my-4">
        <template v-for="(page, index) in items.links" :key="page.label">
            <Component
                :is="page.url ? Link : 'div'"
                :href="!page.url ? undefined : route('tickets.index', {
                    ...Object.fromEntries(
                        Object.entries(filters)
                        .filter(([_, value]) => value)
                    ),
                    page: page.url.split('=')[1]
                })"
                class="py-2 px-4 leading-tight ml-1 bg-gray-800 border border-gray-600 text-gray-400 hover:bg-gray-700 hover:text-white text-center cursor-pointer"
                :class="{
                    'bg-blue-600 text-white': page.active,
                    'mr-auto ml-0 min-w-[120px]': index === 0,
                    'ml-auto mr-0 min-w-[120px]': items.links.length - 1 === index,
                    'opacity-40': !page.url
                }"
                v-html="page.label"
            />
        </template>
    </div>
</template>
